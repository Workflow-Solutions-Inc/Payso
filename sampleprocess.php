<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $id=$_GET["BranchId"];
	 $name=$_GET["name"];
	 
	 if($id != ""){
	 $sql = "INSERT INTO branch (branchcode,name,dataareaid,createdby,createddatetime)
			values 
			('$id', '$name', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: sample.php');
	
}
else if(isset($_GET["update"])) {

	 $id=$_GET["BranchId"];
	 $name=$_GET["name"];
	 
	 if($id != ""){
	 $sql = "UPDATE branch SET
				branchcode = '$id',
				name = '$name',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE branchcode = '$id'
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
	 
	header('location: sample.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["BranchId"];

		if($id != ""){
			$sql = "DELETE from branch where branchcode = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: sample.php');
	
	}
}
else if($_GET["action"]=="saved"){
	 
	 $id=$_GET["BranchId"];
	 $name=$_GET["name"];
	 
	 if($id != ""){
	 $sql = "INSERT INTO branch (branchcode,name,dataareaid,createdby,createddatetime)
			values 
			('$id', '$name', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: sample.php');
	
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
		while ($row = $result->fetch_assoc())
		{
			$rowcnt++;
				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
				else { $rowclass = "rowA";}
			$output .= '
			<tr class="'.$rowclass.'">
				<td style="width:20px;"><span class="fa fa-adjust"></span></td>
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