<?php
session_id("payso");
session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");


if(isset($_GET["changepass"])) {
	 
	 $upass=$_GET["newpass"];
	 
	 if($upass != ""){
	 $sql = "UPDATE userfile SET
				password = aes_encrypt('$upass','password'),
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE userid = '$userlogin'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
			$_SESSION['userpass'] = $upass;
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	
	header('location: menu.php');
	
}