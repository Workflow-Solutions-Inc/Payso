<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if($_GET["action"]=="save"){
	 
	if($_GET["actmode"]=="userform"){
		 $id=$_GET["LeaveId"];
		 $name=$_GET["name"];
		 
		 if($id != ""){
		 $sql = "INSERT INTO leavetype (leavetypeid,description,createdby,createddatetime)
				values 
				('$id', '$name', '$userlogin', now())";
			if(mysqli_query($conn,$sql))
			{
				echo "New Rec Created";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		 }
		 
		header('location: leavetypeform.php');
	}
	
}
else if($_GET["action"]=="update"){
	 
	if($_GET["actmode"]=="userform"){
		 $id=$_GET["LeaveId"];
		 $name=$_GET["name"];
		 
		 if($id != ""){
		 $sql = "UPDATE leavetype SET
					leavetypeid = '$id',
					description = '$name',
					modifiedby = '$userlogin',
					modifieddatetime = now()
					WHERE leavetypeid = '$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Updated";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		 }
		 
		header('location: leavetypeform.php');
	}
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["LeaveId"];

		if($id != ""){
			$sql = "DELETE from leavetype where leavetypeid = '$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: leavetypeform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["LeaveId"];
		$name=$_GET["name"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM leavetype where (leavetypeid like '%$id%') and (description like '%$name%')";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$output .= '
			<tr class="rowA">
				<td><span class="fa fa-adjust"></span></td>
				<td>'.$row["leavetypeid"].'</td>
				<td>'.$row["description"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
?>

<script  type="text/javascript">
		var so='';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);	
					  
			});
		});
</script>