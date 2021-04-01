<?php
$currentDateTime = date('y-M-d h:i a');
date_default_timezone_set('Asia/Manila');
/*
$host="cloudservernewsoft.cyaggyha3ec8.us-east-1.rds.amazonaws.com";
$port=3306;
$socket="";
$user="newsoftcloud";
$password="newsoft2019";
$dbname="paysys2019_dev";
*/


/*$host="216.218.206.54";
$port=3306;
$socket="";
$user="ticketce_ticketc";
$password="newsoft2019";
$dbname="ticketce_paysys2019_dev2";*/


$host="SERVER";
$port=3306;
$socket="";
$user="root";
$password="newsoft";
$dbname="paysys2019_dev";

$conn = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//$conn->close();

							
?>