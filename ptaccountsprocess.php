<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$paynum = $_SESSION['paynum'];
$reflinenum = $_SESSION['linenum'];
if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["AccCode"];
		$accname=$_GET["AccName"];

		$accum=$_GET["AccUm"];
		$acctype=$_GET["AccType"];




		$output='';
		//$output .= '<tbody>';
		$query = "SELECT autoinclude,
					accountcode,
					name,
					label,
					um,
					case when accounttype = 0 then 'Entry'
						when accounttype = 1 then 'Computed'
						when accounttype = 2 then 'Condition'
					else 'Total'
					end as accounttype,
					case when category = 0 then 'Lines'
					else 'Header' 
					end as category,
					formula,
					format(defaultvalue,2) defaultvalue,
					priority
			FROM accounts where (accountcode like '%$id%') and (name like '%$accname%') 
			and (um like '%$accum%') and dataareaid = '$dataareaid' and category = 0
			order by priority asc";
		$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		$rowcnt2 = 0;
		$lastrec ='';
		while ($row = $result->fetch_assoc())
		{
			$rowcnt++;
			$rowcnt2++;
				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
				else { $rowclass = "rowA";}

				$accExist = $row['accountcode'];

				$query2 = "SELECT * FROM payrolldetailsaccounts where dataareaid = '$dataareaid' and payrollid = '$paynum' and reflinenum = '$reflinenum' and accountcode = '$accExist'";
					$result2 = $conn->query($query2);
					$row2 = $result2->fetch_assoc();

					$dtexist = $row2["accountcode"];
					//$dtexist = 'rdays';

					if(isset($dtexist)) { $tag=1;}
					else {$tag=0;}
			$output .= '
			<tr id="'.$row["accountcode"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'">
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:5%;"><input type="checkbox" id="chkbox" name="chkbox" class="checkbox"
				 	value="'.$row['accountcode'].'" '.($tag==1 ? 'checked' : '').' '.($tag==1 ? 'disabled' : '').'></td>
				<td style="width:23%;">'.$row["accountcode"].'</td>
				<td style="width:28%;">'.$row["name"].'</td>
				<td style="width:20%;">'.$row["um"].'</td>
				<td style="width:24%;">'.$row["accounttype"].'</td>
				'.$lastrec = $row["priority"].'
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
	 $query = "SELECT priority,
					accountcode,
					name,
					um,
					accounttype,
					ifnull(format(defaultvalue,2),0.00) defaultvalue

					FROM accounts

					where dataareaid = '$dataareaid' and accountcode in ($id)";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$priority=$row["priority"];
			$accountcode=$row["accountcode"];
			$accountname=$row["name"];
			$um=$row["um"];
			$accounttype=$row["accounttype"];
			$value=$row["defaultvalue"];


		

			$sql = "INSERT INTO payrolldetailsaccounts (payrollid,reflinenum,priority,accountcode,accountname,um,accounttype,value,dataareaid,createdby,createddatetime)
			values 
			('$paynum', '$reflinenum', '$priority', '$accountcode', '$accountname', '$um', '$accounttype', '$value', '$dataareaid', '$userlogin', now())";
			if(mysqli_query($conn,$sql))
			{
				echo $sql;
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}



		}

		$PayQuery = "SELECT * from payrollheader where payrollid = '$paynum' and dataareaid = '$dataareaid'";
		$Payresult = $conn->query($PayQuery);
		while ($Payrow = $Payresult->fetch_assoc())
		{
			$VarPayPeriod = $Payrow["payrollperiod"];

		}

		$sqlloan = "call SP_LoanTrans('','$dataareaid','$paynum','$userlogin' ,'$VarPayPeriod','2')";
			
			if(mysqli_query($conn,$sqlloan))
					{
						echo $sqlloan."<br>".$conn->error;
					}
					else
					{
						echo "error".$sqlloan."<br>".$conn->error;
					}

	 }
	 
	header('location: payrolltransactiondetail.php');
	
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