<?php

session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$paynum = $_SESSION['paynum'];
$period = $_SESSION['payper'];
$paydate = $_SESSION['paydate'];

if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){

		$id=$_GET["PTContract"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT ct.contractid,
						wk.name,
						format(ct.rate,2) as rate
						,format(ct.ecola,2) as ecola,
						format(ct.transpo,2) transpo,
						format(ct.meal,2) as meal,
						case when ct.contracttype = 0 then 'Regular' 
							when ct.contracttype = 1 then 'Reliever'
							when ct.contracttype = 2 then 'Probationary'
							when ct.contracttype = 3 then 'Contractual' 
							when ct.contracttype = 4 then 'Trainee' else '' end as workertype,

						ct.fromdate as transdate
						FROM contract ct
						left join worker wk on wk.workerid = ct.workerid
						and wk.dataareaid = ct.dataareaid

					where ct.dataareaid = '$dataareaid' and ct.contractid like '%$id%'
					and date_format(ct.fromdate, '%m-%m-%Y') <= date_format(str_to_date('$paydate','%m-%d-%Y'), '%Y-%m-%d')
					and wk.inactive = 0

					order by ct.contractid asc";
		$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		while ($row = $result->fetch_assoc())
		{
			$rowcnt++;
				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
				else { $rowclass = "rowA";}

				$accExist = $row['contractid'];

					$query2 = "SELECT * FROM payrolldetails where dataareaid = '$dataareaid' and payrollid = '$paynum'  and contractid = '$accExist'";
						$result2 = $conn->query($query2);
						$row2 = $result2->fetch_assoc();

						$dtexist = $row2["contractid"];
						//$dtexist = 'rdays';

						if(isset($dtexist)) { $tag=1;}
						else {$tag=0;}
													
			$output .= '
			<tr class="'.$rowclass.'">
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:4%;"><input type="checkbox" id="chkbox" name="chkbox" class="checkbox"
				 	value="'.$row['contractid'].'" '.($tag==1 ? 'checked' : '').' '.($tag==1 ? 'disabled' : '').'></td>
				<td style="width:12%;">'.$row["contractid"].'</td>
				<td style="width:12%;">'.$row["name"].'</td>
				<td style="width:12%;">'.$row["rate"].'</td>
				<td style="width:12%;">'.$row["ecola"].'</td>
				<td style="width:12%;">'.$row["transpo"].'</td>
				<td style="width:12%;">'.$row["meal"].'</td>
				<td style="width:12%;">'.$row["workertype"].'</td>
				<td style="width:12%;">'.$row["transdate"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
else if($_GET["action"]=="save"){
	 
	 
	$id=$_GET["SelectedVal"];
	 
	 if($id != ""){
	 $query = "SELECT ct.contractid,
						ct.workerid,
						ct.rate
						,format(ct.ecola,2) as ecola,
						format(ct.transpo,2) transpo,
						format(ct.meal,2) as meal,
						ct.contracttype workertype,

						ct.fromdate as transdate
						FROM contract ct
						left join worker wk on wk.workerid = ct.workerid
						and wk.dataareaid = ct.dataareaid

					where ct.dataareaid = '$dataareaid' and ct.contractid in ($id)

					order by ct.contractid asc";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$contract=$row["contractid"];
			$workerid=$row["workerid"];
			$rate=$row["rate"];
			$ecola=$row["ecola"];
			$transpo=$row["transpo"];
			$meal=$row["meal"];
			$type=$row["workertype"];
			$trans=$row["transdate"];

			$query2 = "SELECT 
						max(pd.linenum) as linenum
						FROM payrolldetails pd
						where pd.dataareaid = '$dataareaid' and pd.payrollid = '$paynum'";
			$result2 = $conn->query($query2);
			$row2 = $result2->fetch_assoc();
			$lastval = $row2["linenum"];
			$maxval = $lastval + 1;

			//echo $maxval;

			$sql = "INSERT INTO payrolldetails (payrollid,linenum,contractid,workerid,rate,ecola,transpo,meal,workertype,transdate,dataareaid,createdby,createddatetime)
			values 
			('$paynum', '$maxval', '$contract', '$workerid', '$rate', '$ecola', '$transpo', '$meal', '$type', '$trans', '$dataareaid', '$userlogin', now())";
			if(mysqli_query($conn,$sql))
			{
				echo $sql;
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}



		}
		$payrollgroup = '';
		$queryperiod = "SELECT payrollgroup from payrollperiod

					where dataareaid = '$dataareaid' and payrollperiod = '$period' 

					";
		$resultperiod = $conn->query($queryperiod);
		while ($rowperiod = $resultperiod->fetch_assoc())
		{
			$payrollgroup = $rowperiod["payrollgroup"];
		}

		$sqlinsert = "call SP_PayrollDetailsAccountsCreation('$dataareaid','$paynum','$userlogin','$period', '$payrollgroup')";
			//mysqli_query($conn,$sqlinsert);
			//echo $sqlinsert."<br>".$conn->error;
			if(mysqli_query($conn,$sqlinsert))
			{
				echo $sqlinsert."<br>".$conn->error;
			}
			else
			{
				echo "error".$sqlinsert."<br>".$conn->error;
			}

	 }
	 
	//header('location: payrolltransactiondetail.php');
	
}

?>

<script  type="text/javascript">
		var so='';
	  	var payline='';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide3").value);
				//alert(document.getElementById("hide").value);
				//alert(so);
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'payrolltransactionline.php',
					data:{action:action, actmode:actionmode, PayId:so},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						payline='';
						document.getElementById("hide2").value = "";
						$('#lineresult').html(data);
					}
				}); 	
				//-----------get line--------------//	  
			});
		});

	  		/*$(document).ready(function(){
				$('#dataln tbody tr').click(function(){
					$('table tbody tr').css("color","black");
					$(this).css("color","orange");
					$('table tbody tr').removeClass("info");
					$(this).addClass("info");
					var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
					var payline = transnumline.toString();
					document.getElementById("hide2").value = payline;
					//alert(document.getElementById("hide").value);
						
						  
				});
			});*/
		$('[name=chkbox]').change(function(){
	    if($(this).attr('checked'))
	    {
      		//document.getElementById("inchide").value = $(this).val();
      		Add();
	    }
	    else
	    {
			         
	         //document.getElementById("inchide").value=$(this).val();
	         remVals.push("'"+$(this).val()+"'");
	         $('#inchide2').val(remVals);

	         $.each(remVals, function(i, el2){
	         	//alert(el2);	
	    		removeA(allVals, el2);
	    		removeA(uniqueNames, el2);
		    	//$("input[value="+el+"]").prop("checked", true);
		    	//alert(el);
			});
	        Add();

	    }
	 });

	function removeA(arr) 
	{
	    var what, a = arguments, L = a.length, ax;
	    while (L > 1 && arr.length) {
	        what = a[--L];
	        while ((ax= arr.indexOf(what)) !== -1) {
	            arr.splice(ax, 1);
	        }
	    }
	    return arr;
	}
	
	function Add() 
	{  

		
		$('#inchide').val('');
		 $('[name=chkbox]:checked').each(function() {
		   allVals.push("'"+$(this).val()+"'");

		   /*if( $("input[value="+$(this).val()+"]") == 'PCC')
		   {
		   		alert($(this).val());
		   }*/
		   
		 });

		 //remove existing rec start-----------------------
		 $('[name=chkbox]:disabled').each(function() {
		   
		   remValsEx.push("'"+$(this).val()+"'");
	         //$('#inchide2').val(remValsEx);

	         $.each(remValsEx, function(i, el2){
	         		
	    		removeA(allVals, el2);
	    		removeA(uniqueNames, el2);
		    	//"'"+"PCC"+"'"
			});
		   
		 });
		 //remove existing rec end-------------------------

		 

		 
			$.each(allVals, function(i, el){
			    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
			});
		
		 $('#inchide').val(uniqueNames);

	} 
	function CheckedVal()
	{ 
		$.each(uniqueNames, function(i, el){
			    $("input[value="+el+"]").prop("checked", true);
			    //alert(el);
			});
	}
</script>