<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
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
else if(isset($_GET["update"])) {
	 
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
			<tr id="'.$row["loantypeid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:50%;">'.$row["loantypeid"].'</td>
				<td style="width:50%;">'.$row["description"].'</td>
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
	  	var locname='';
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