<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$grpid = $_SESSION['groupid'];
include("dbconn.php");

if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["PriveId"];

		if($id != ""){
			$sql = "DELETE from usergroupsprivileges where usergroupid = '$grpid' and privilegesid = '$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: usergroupprivilegesform.php');
	
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
		$query = "SELECT up.privilegesid,priv.name,priv.module,priv.submodule FROM 

				usergroupsprivileges up
				left join privileges priv on priv.privilegesid = up.privilegesid 

				where usergroupid = '$grpid' and (priv.privilegesid like '%$id%') and (priv.module like '%$module%') and (priv.submodule like '%$sub%') and (priv.name like '%$name%')
		order by priv.module,priv.submodule,up.privilegesid";
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
				<td style="width:20px;"  class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:25%;">'.$row["privilegesid"].'</td>
				<td style="width:25%;">'.$row["name"].'</td>
				<td style="width:25%;">'.$row["module"].'</td>
				<td style="width:25%;">'.$row["submodule"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
else if($_GET["action"]=="addpriv"){
	 	
	$id=$_GET["UserGroup"];
	$_SESSION['selgroupid'] = $id;
	//unset($_SESSION['paynum']);
	header('location: usergroupprivilegesform.php');
	
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