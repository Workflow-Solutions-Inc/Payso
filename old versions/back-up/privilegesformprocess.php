<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	$id=$_GET["PriveId"];
	$module=$_GET["PrivModule"];
	$sub=$_GET["PrivSub"];
	$name=$_GET["PrivName"];
	 
	 if($id != ""){
	 $sql = "INSERT INTO privileges (privilegesid,module,submodule,name,createdby,createddatetime)
			values 
			('$id', '$module', '$sub', '$name', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: privilegesform.php');

}
else if(isset($_GET["update"])) {
	
	$id=$_GET["PriveId"];
	$module=$_GET["PrivModule"];
	$sub=$_GET["PrivSub"];
	$name=$_GET["PrivName"];
	 
	 if($id != ""){
	 $sql = "UPDATE privileges SET
				privilegesid = '$id',
				module = '$module',
				submodule = '$sub',
				name = '$name',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE privilegesid = '$id'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: privilegesform.php');
		
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["PriveId"];

		if($id != ""){
			$sql = "DELETE from privileges where privilegesid = '$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: privilegesform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["PriveId"];
		$module=$_GET["PrivModule"];
		$sub=$_GET["PrivSub"];
		$name=$_GET["PrivName"];
		
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM privileges where (privilegesid like '%$id%') and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
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
				<td style="width:25%;">'.$row["privilegesid"].'</td>
				<td style="width:25%;">'.$row["module"].'</td>
				<td style="width:25%;">'.$row["submodule"].'</td>
				<td style="width:25%;">'.$row["name"].'</td>
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