<?php
session_id("payso");
session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$headid = $_SESSION['HeadId'];
include("dbconn.php");

if($_GET["action"]=="save"){
	 
	 $id=$_GET["SelectedVal"];
	
	 if($id != ""){
	 $query = "SELECT * FROM worker

				where workerid in ($id)";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$userid=$row["workerid"];

			$sql = "INSERT INTO organizationalchart (workerid,repotingid,dataareaid)
			values 
			('$userid', '$headid', '$dataareaid')";
			if(mysqli_query($conn,$sql))
			{
				echo $sql;
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}



		}

	 }
	 
	header('location: orgselection.php');
	
}

else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["sLocId"];
		$name=$_GET["slocName"];
		$postion=$_GET["slocPosition"];
		$department=$_GET["sLocDepartment"];
		$branch=$_GET["slocbranch"];
		$output='';

		//$output .= '<tbody>';
		$query = "SELECT wk.workerid,wk.Name,pos.name as 'position',dep.name as 'department',bra.name	as 'branch'

				FROM worker wk
				left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
				left join contract con on con.workerid = wk.workerid and con.dataareaid = wk.dataareaid
				left join ratehistory rt on con.contractid = rt.contractid and con.dataareaid = rt.dataareaid 
				left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid
				left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
				where  rt.status = 1 and (wk.workerid like '%$id%') and (wk.name like '%$name%') and (pos.name like '%$postion%') and (dep.name like '%$department%') and (bra.name like '%$branch%') 
				and wk.dataareaid = '$dataareaid'
				order by wk.workerid";
				
		$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		$rowcnt2 = 0;
		while ($row = $result->fetch_assoc())
		{ 
			$rowcnt++;
			$rowcnt2++;
				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
				else { $rowclass = "rowA";}

				$subid = $row['workerid'];

				$query2 = "SELECT * FROM organizationalchart where repotingid = '$headid' and workerid = '$subid' and dataareaid = '$dataareaid'";
					$result2 = $conn->query($query2);
					$row2 = $result2->fetch_assoc();
					$dtexist = $row2["workerid"];

					if(isset($dtexist)) { $tag=1;}
					else {$tag=0;}
			
			$output .= '
			<tr id="'.$row["workerid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:5%;"><input type="checkbox" id="chkbox" name="chkbox" class="checkbox"
				 	value="'.$row['workerid'].'" '.($tag==1 ? 'checked' : '').' '.($tag==1 ? 'disabled' : '').'></td>
				<td style="width:19%;">'.$row["workerid"].'</td>
				<td style="width:19%;">'.$row["Name"].'</td>
				<td style="width:19%;">'.$row["position"].'</td>
				<td style="width:19%;">'.$row["department"].'</td>
				<td style="width:19%;">'.$row["branch"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}

?>

<!-- <script  type="text/javascript">
	var so='';
	var locAccName;

		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			//$('table tbody tr').css('background-color','');
			//$(this).css('background-color','#ffe6cb');
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			var AcInc = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			locAccName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();

			so = usernum.toString();
			document.getElementById("hide").value = so;				  
		});
	});

	
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

</script> -->