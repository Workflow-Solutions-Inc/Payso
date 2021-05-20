<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

$usrid = $_SESSION['UsrNum'];

 if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["userno"];
		$name=$_GET["name"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM usergroups where (usergroupid like '%$id%') and (name like '%$name%')";
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

				$ugroup = $row['usergroupid'];

				$query2 = "SELECT * FROM usergroupsassignment where usergroupid = '$ugroup' and userid = '$usrid'";
					$result2 = $conn->query($query2);
					$row2 = $result2->fetch_assoc();
					$ugexist = $row2["usergroupid"];

					if(isset($ugexist)) { $tag=1;}
					else {$tag=0;}

			$output .= '
			<tr id="'.$row["usergroupid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;"><span class="fa fa-angle-right"></span></td>
				<td style="width:5%;"><input type="checkbox" id="chkbox" name="chkbox" class="checkbox"
				 	value="'.$row['usergroupid'].'" '.($tag==1 ? 'checked' : '').' '.($tag==1 ? 'disabled' : '').'></td>
				<td style="width:50%;">'.$row["usergroupid"].'</td>
				<td style="width:50%;">'.$row["name"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
		
	}
}
else if($_GET["action"]=="saveUsergroup"){
	 
	 $id=$_GET["uname"];
	 $grpid = $_GET['usergrp'];
	 /*if($id != ""){
	 

			$sql = "INSERT INTO usergroupsassignment (usergroupid,userid,createdby,createddatetime)
			values 
			('$grpid', '$id', '$userlogin', now())";
			if(mysqli_query($conn,$sql))
			{
				echo $sql;
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}



		
	 }*/

	 if($grpid != ""){
	 $query = "SELECT * FROM usergroups where usergroupid in ($grpid)";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$ugid=$row["usergroupid"];

			$sql = "INSERT INTO usergroupsassignment (usergroupid,userid,createdby,createddatetime)
			values 
			('$ugid', '$id', '$userlogin', now())";
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
	 
	//header('location: userselection.php');
	
}

?>

