<?php

session_start();
$userlogin = $_SESSION["user"];
#$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if($_GET["action"]=="save"){
	 
	if($_GET["actmode"]=="userform"){
		 $uno=$_GET["userno"];
		 $upass=$_GET["pass"];
		 $ul=$_GET["lname"];
		 $dtarea=$_GET["darea"];
		 
		 if($uno != ""){
		 $sql = "INSERT INTO userfile (userid,name,defaultdataareaid,password,createdby,createddatetime)
				values 
				('$uno', '$ul', '$dtarea', aes_encrypt('$upass','password'), '$userlogin', now())";
			if(mysqli_query($conn,$sql))
			{
				echo "New Rec Created";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		 }
		 
		header('location: userform.php');
	}
	
}
else if($_GET["action"]=="update"){
	 
	if($_GET["actmode"]=="userform"){
		 $uno=$_GET["userno"];
		 $upass=$_GET["pass"];
		 $ul=$_GET["lname"];
		 $dtarea=$_GET["darea"];
		 
		 if($uno != ""){
		 $sql = "UPDATE userfile SET
					userid = '$uno',
					name = '$ul',
					defaultdataareaid = '$dtarea',
					password = aes_encrypt('$upass','password'),
					modifiedby = '$userlogin',
					modifieddatetime = now()
					WHERE userid = '$uno'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Updated";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		 }
		 
		header('location: userform.php');
	}
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$uno=$_GET["userno"];

		if($uno != ""){
			$sql = "DELETE from userfile where userid = '$uno'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: userform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$uno=$_GET["userno"];
		$ul=$_GET["lname"];
		$dtarea=$_GET["darea"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM userfile where (userid like '%$uno%') and (name like '%$ul%') and (defaultdataareaid like '%$dtarea%')";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$output .= '
			<tr class="rowA">
				<td><span class="fa fa-adjust"></span></td>
				<td>'.$row["userid"].'</td>
				<td>'.$row["name"].'</td>
				<td>'.$row["defaultdataareaid"].'</td>
				<td>'.$row["password"].'</td>
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