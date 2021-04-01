<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $id=$_GET["userno"];
	 $name=$_GET["name"];
	 
	 if($id != ""){
	 $sql = "INSERT INTO usergroups (usergroupid,name,createdby,createddatetime)
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
	 
	header('location: usergroupform.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $id=$_GET["userno"];
	 $name=$_GET["name"];
	 
	 if($id != ""){
	 $sql = "UPDATE usergroups SET
				usergroupid = '$id',
				name = '$name',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE usergroupid = '$id'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: usergroupform.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["userno"];

		if($id != ""){
			$sql = "DELETE from usergroups where usergroupid = '$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: usergroupform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
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
			$output .= '
			<tr id="'.$row["usergroupid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;"><span class="fa fa-adjust"></span></td>
				<td style="width:50%;">'.$row["usergroupid"].'</td>
				<td style="width:50%;">'.$row["name"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
		$result2 = $conn->query($query);
		$row2 = $result2->fetch_assoc();
		$firstresult2 = $row2["usergroupid"];
		echo $output2 = '<tr class="rowA">
							<td hidden><input type="input" id="hide3" value="'.$firstresult2.'"></td>
						</tr>';
	}
}
else if($_GET["action"]=="addpriv"){
	 	
	$id=$_GET["UserGroup"];
	$_SESSION['groupid'] = $id;
	//unset($_SESSION['paynum']);
	header('location: usergroupform.php');
	
}

else if($_GET["action"]=="adduser"){
	 	
	$id=$_GET["UserGroup"];
	$_SESSION['groupid'] = $id;
	//unset($_SESSION['paynum']);
	header('location: usergroupform.php');
	
}

else if($_GET["action"]=="getloc"){
	 	
	$id=$_GET["UserGroup"];
	$_SESSION['groupid'] = $id;
	//unset($_SESSION['paynum']);
	header('location: usergroupform.php');
	
}
?>

<script  type="text/javascript">
		var so='';
	  	var locname='';
	  	var usernum = '';
		if(usernum == '')
		{
			so = document.getElementById("hide").value;
		}
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			so = usernum.toString();
			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);

			var action = "getloc";
				var actionmode = "userform";
				$.ajax({
						type: 'GET',
						url: 'usergroupformprocess.php',
						data:{action:action, actmode:actionmode, UserGroup:so},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							//$('#result').html('<div class="loading"><img src="img/loading.gif" width="300" height="300"></div>');
			
						},
						success: function(data){
							//$('#result').html(data);
						}
					});	
						  
				});
			});
</script>