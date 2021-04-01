<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if($_GET["action"]=="save"){
	 
	if($_GET["actmode"]=="userform"){
		 $id=$_GET["LoanId"];
		 $name=$_GET["name"];
		 
		 if($id != ""){
		 $sql = "INSERT INTO loantype (loantypeid,description,createdby,createddatetime)
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
		 
		header('location: loantypeform.php');
	}
	
}
else if($_GET["action"]=="update"){
	 
	if($_GET["actmode"]=="userform"){
		 $id=$_GET["LoanId"];
		 $name=$_GET["name"];
		 
		 if($id != ""){
		 $sql = "UPDATE loantype SET
					loantypeid = '$id',
					description = '$name',
					modifiedby = '$userlogin',
					modifieddatetime = now()
					WHERE loantypeid = '$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Updated";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		 }
		 
		header('location: loantypeform.php');
	}
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["LoanId"];

		if($id != ""){
			$sql = "DELETE from loantype where loantypeid = '$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: loantypeform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["LoanId"];
		$name=$_GET["name"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM loantype where (loantypeid like '%$id%') and (description like '%$name%')";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$output .= '
			<tr class="rowA">
				<td><span class="fa fa-adjust"></span></td>
				<td>'.$row["loantypeid"].'</td>
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