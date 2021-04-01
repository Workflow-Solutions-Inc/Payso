<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if($_GET["action"]=="save"){
	 
	if($_GET["actmode"]=="userform"){
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
	
}
else if($_GET["action"]=="update"){
	 
	if($_GET["actmode"]=="userform"){
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
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["PayId"];

		if($id != ""){
			$sql = "DELETE FROM payrollperiod where dataareaid = '$dataareaid' 
					and payrollperiod = '$id'";
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
		$id=$_GET["PayId"];
		//$module=$_GET["PrivModule"];
		//$sub=$_GET["PrivSub"];
		//$name=$_GET["PrivName"];
		
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT case when period = 0 then 'First Half' else 'Second Half' end as period,
					payrollperiod,
					date_format(startdate, '%Y-%m-%d') startdate,
					date_format(enddate, '%Y-%m-%d') enddate,
					date_format(payrolldate, '%Y-%m-%d') payrolldate 
					FROM payrollperiod where dataareaid = '$dataareaid' 
					and (payrollperiod like '%$id%')";
					//and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$output .= '
			<tr class="rowA">
				<td><span class="fa fa-adjust"></span></td>
				<td>'.$row["period"].'</td>
				<td>'.$row["payrollperiod"].'</td>
				<td>'.$row["startdate"].'</td>
				<td>'.$row["enddate"].'</td>
				<td>'.$row["payrolldate"].'</td>
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