<?php
	//code added by jonald
	//session_start();
		include("dbconn.php");
		$proof = $_POST['proof'];
		$id = $_POST["so"];
		//$decodeproof = base64_decode($proof);
	//echo $proof;
	$sql = "update dataarea set dataarealogo = '$proof' where dataareaid = '$id'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";

			
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}
	//echo $sql;

	//end of edit
  ?>