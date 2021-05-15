<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$grpid = $_SESSION['groupid'];
include("dbconn.php");

if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["UsrId"];

		if($id != ""){
			$sql = "DELETE from usergroupsassignment where usergroupid = '$grpid' and userid = '$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		//header('location: usergroupprivilegesform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["UsrId"];
		$name=$_GET["name"];
		
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT  uf.userid,uf.name
					FROM usergroupsassignment uga
					left join userfile uf on uf.userid = uga.userid

					where uga.usergroupid = '$grpid'
					and (uf.userid like '%$id%') and (uf.name like '%$name%')";
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
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:50%;">'.$row["userid"].'</td>
				<td style="width:50%;">'.$row["name"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
else if($_GET["action"]=="adduser"){
	 	
	$id=$_GET["UserGroup"];
	$_SESSION['selgroupid'] = $id;
	//unset($_SESSION['paynum']);
	header('location: usergroupsassignment.php');
	
}
?>

<script  type="text/javascript">
		var so='';
	  	var locPriveId;
		var locPrivModule;
		var locPrivSub;
		var locPrivName;
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locPrivName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locPrivModule = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locPrivSub = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);	
					  
			});
		});
</script>