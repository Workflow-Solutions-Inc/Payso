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

/*web hosting*/
/*$host="216.218.206.54";
$port=3306;
$socket="";
$user="ticketce_ticketc";
$password="newsoft2019";
$dbname="ticketce_paysys2019_dev2";*/


/*AWS*/
/*$host="newsoftcloudserver2019.cyaggyha3ec8.us-east-1.rds.amazonaws.com";
$port=3306;
$socket="";
$user="newsoftmaster";
$password="newsoft2019";
$dbname="ticketce_paysys2019_dev2";*/

//$host="newsoftcloud-t3large-asia.cfeynnhvh6kn.ap-northeast-1.rds.amazonaws.com";
/*$host="newsoftcloud-t3-xl-asia.cfeynnhvh6kn.ap-northeast-1.rds.amazonaws.com";
$port=3306;
$socket="";
$user="rootmaster";
$password="newsoft2019";
$dbname="paysys2019_dev";*/



/*$host="SERVER";
$port=3306;
$socket="";
$user="root";
$password="newsoft2019!";
$dbname="mgc_paysys_live";*/

//live database

/*
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="local";
$dbname="skpc_mgxpaysys_2016_dev";*/

//live database

$host="156.67.217.132";
$port=3306;
$socket="";
$user="wfsiadmin";
$password="wfsi2021admin";
$dbname="payso_dev";


$conn = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//$conn->close();

							
?>