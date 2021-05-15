<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $id=$_GET["PosCode"];
	 $name=$_GET["name"];
	 $period=$_GET["period"];
	 $approver=$_GET["approver"];
	 
	 if($id != ""){
	 $sql = "INSERT INTO position (positionid,name,graceperiod,isapprover,dataareaid,createdby,createddatetime)
			values 
			('$id', '$name', '$period', '$approver', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: positionform.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $id=$_GET["PosCode"];
	 $name=$_GET["name"];
	 $period=$_GET["period"];
	 $approver=$_GET["approver"];
	 
	 if($id != ""){
	 $sql = "UPDATE position SET
				positionid = '$id',
				name = '$name',
				graceperiod = '$period',
				isapprover = '$approver',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE positionid = '$id'
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
	 
	header('location: positionform.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["PosCode"];

		if($id != ""){
			$sql = "DELETE from position where positionid = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: positionform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["PosCode"];
		$name=$_GET["name"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM position where dataareaid = '$dataareaid' and (positionid like '%$id%') and (name like '%$name%')";
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
			<tr id="'.$row["positionid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:42%;">'.$row["positionid"].'</td>
				<td style="width:42%;">'.$row["name"].'</td>
				<td style="width:8%;"><input type="checkbox" name="chkbox" class="checkbox" value="true"'.($row["graceperiod"]==1 ? "checked" : "").' onclick="return false;"><div style="visibility:hidden;height: 1px;">'.$row["graceperiod"].'</div></td>
				<td style="width:8%;"><input type="checkbox" name="chkbox" class="checkbox" value="true"'.($row["isapprover"]==1 ? "checked" : "").' onclick="return false;"><div style="visibility:hidden;height: 1px;">'.$row["isapprover"].'</div></td>
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
</script> -->