<?php
session_id("payso");
session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 
	 $period=$_GET["DecPer"];
	 
	 if($period != ""){
	 $sql = "INSERT INTO excempteddeductions (coeffectivity,dataareaid,createdby,createddatetime)
			values 
			('$period', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: deductionform.php');
	
}
else if(isset($_GET["update"])) {

	 $id=$_GET["rec"];
	 $period=$_GET["DecPer"];
	 
	 if($id != ""){
	 $sql = "UPDATE excempteddeductions SET
				coeffectivity = '$period',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE recid = '$id'
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
	 
	header('location: deductionform.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["locrec"];

		if($id != ""){
			$sql = "DELETE from excempteddeductions where recid = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: deductionform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["AccountId"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT accountid,case when coeffectivity = 0 then 'First Half' else 'Second Half' end as coeffectivity,recid,coeffectivity as coeffectivityid 
					FROM excempteddeductions where dataareaid = '$dataareaid' and (accountid like '%$id%')";
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
			<tr id="'.$row["accountid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:50%;">'.$row["accountid"].'</td>
				<td style="width:50%;">'.$row["coeffectivity"].'</td>
				<td style="display:none;width:1%;">'.$row['recid'].'</td>
				<td style="display:none;width:1%;">'.$row['coeffectivityid'].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
else if($_GET["action"]=="addaccount"){
	 	
	$id=$_GET["locrec"];
	$_SESSION['recnum'] = $id;
	//unset($_SESSION['paynum']);
	header('location: dtaccounts.php');
	
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