<?php
session_id("payso");
session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $ndstart=$_GET["NDstart"];
	 $ndend=$_GET["NDend"];
	 
	 if($ndstart != ""){
	 $sql = "INSERT INTO ndsetuptable (start,end,value,dataareaid,createdby,createddatetime)
			values 
			(TIME_FORMAT('$ndstart', '%H:%i:%s'), TIME_FORMAT('$ndend', '%H:%i:%s'), '00:00:00', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 //echo $ndstart;
	header('location: nightform.php');
	
}
else if(isset($_GET["update"])) {

	 $recid=$_GET["NDrecid"];
	 $ndstart=$_GET["NDstart"];
	 $ndend=$_GET["NDend"];
	 
	 if($recid != ""){
	 $sql = "UPDATE ndsetuptable SET
				start = TIME_FORMAT('$ndstart', '%H:%i:%s'),
				end = TIME_FORMAT('$ndend', '%H:%i:%s'),
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE recid = '$recid'
				and dataareaid = '$dataareaid'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: nightform.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["locrecid"];

		if($id != ""){
			$sql = "DELETE from ndsetuptable where recid = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: nightform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["BranchId"];
		$name=$_GET["name"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM branch where dataareaid = '$dataareaid' and (branchcode like '%$id%') and (name like '%$name%')";
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
			$output .= '
			<tr id="'.$row["branchcode"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:50%;">'.$row["branchcode"].'</td>
				<td style="width:50%;">'.$row["name"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
?>

<script  type="text/javascript">
		var locname='';
	  	var so='';
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			so = usernum.toString();
			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);	
						  
				});
			});
</script>