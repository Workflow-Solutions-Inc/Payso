<?php
$currentDateTime = date('y-M-d h:i a');
date_default_timezone_set('Asia/Manila');

/*$host="cloudservernewsoft.cyaggyha3ec8.us-east-1.rds.amazonaws.com";
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

/*$host="newsoftcloud-t3medium-asia-hk.cxhly8drtukq.ap-east-1.rds.amazonaws.com";
$port=3306;
$socket="";
$user="rootmaster";
$password="newsoft2019";
$dbname="MGC_paysys_dev";*/


/*$host="SERVER";
$port=3306;
$socket="";
$user="root";
$password="newsoft2019!";
$dbname="paysys2019_dev";*/


/*$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="local";
$dbname="mgc_paysys_live";*/

/* Current */

/*$host="newsoftcloud-t3medium-asia-hk.cxhly8drtukq.ap-east-1.rds.amazonaws.com";
$port=3306;
$socket="";
$user="rootmaster";
$password="newsoft2019";
//$dbname="MGC_new_payso_live";
//$dbname="std_payso_live";
$dbname="std_payso_dev";*/
//$dbname="MGC_new_payso_live";

/* Current end */

/* Pre-upgrade */

/*$host="wfsicloud-hk-m5-large.cxhly8drtukq.ap-east-1.rds.amazonaws.com";
$port=3306;
$socket="";
$user="rootmaster";
$password="wfsi2020";
$dbname="std_payso_dev";*/

/* Pre-upgrade */

/* Hostinger */
/*$host="151.106.114.6";
$port=3306;
$socket="";
$user="u481683305_DEVUSER";
$password="Dynamics1056";
$dbname="u481683305_paysodev";*/

/* Hostinger */

$host="156.67.217.132";
$port=3306;
$socket="";
$user="wfsiadmin";
$password="wfsi2021admin";
$dbname="global_payso_TEST";

/* Hostinger local*/
/*$host="156.67.214.218";
$port=3306;
$socket="";
$user="wfsi21";
$password="Dynamics1056!";
$dbname="u481683305_paysodev";*/
/* Hostinger */


$conn = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//$conn->close();

							
?>