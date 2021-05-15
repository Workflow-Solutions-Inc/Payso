<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
echo $dataareaid;

$query = "select name as 'socname' from dataarea where dataareaid = '$dataareaid'";
    $result = $conn->query($query);
        while ($row = $result->fetch_assoc())
        	{
        		$compname = $row["socname"];
        	}

$queryName = "SELECT * FROM userfile where userid = '$userlogin'";
   
 $resultname = $conn->query($queryName);
        while ($row = $resultname->fetch_assoc())
        	{
        		$usrname = $row["name"];
        	}
	

#$action =  $_GET["act"];

//-----------------13Month Report Process
if(isset($_GET["generate13month"])) {
	 
	$selectedYr = $_GET["inputyear"];
	$rptType = $_GET["periodType"];

	
	/*$query = "select name as 'socname' from dataarea where dataareaid = '$dataareaid'";
    $result = $conn->query($query);
        while ($row = $result->fetch_assoc())
        	{
        		$compname = $row["socname"];
        	}*/
	//echo $rptType;
	if ($rptType == "Per Cut-Off")
	{
		header('location: Reports/13monthCutOff.php?yr='.$selectedYr.'&usr='.$userlogin.'&comp='.$compname.'');
		//echo "CO";
	}
	if ($rptType == "Monthly")
	{
		header('location: Reports/13monthMonthly.php?yr='.$selectedYr.'&usr='.$userlogin.'&comp='.$compname.'');
		//echo "MO";
	}
	if ($rptType == "Quarterly")
	{
		header('location: Reports/13monthQTR.php?yr='.$selectedYr.'&usr='.$userlogin.'&comp='.$compname.'');
		//echo "QTR";
	}
	/*echo $rptType;
	echo $selectedYr;*/
	 
	
	
}
//-----------------Contribution Report Process
if(isset($_GET["gencontribRPT"])) {
	 
	$selectedYr = $_GET["inputyear"];
	$wokerType = 2;
	$monthcal = $_GET["monthcal"];
	$rptType = $_GET["rptType"];

	
	/*$query = "select name as 'socname' from dataarea where dataareaid = '$dataareaid'";
    $result = $conn->query($query);
        while ($row = $result->fetch_assoc())
        	{
        		$compname = $row["socname"];
        	}*/
	//echo $rptType;
	if ($rptType == "SSSRPT")
	{
		header('location: Reports/ssscontribreport.php?monthcal='.$monthcal.'&yr='.$selectedYr.'&usr='.$userlogin.'&comp='.$compname.'&wkType='.$wokerType.'');
		//echo "CO";
	}
	if ($rptType == "PHRPT")
	{
		header('location: Reports/phcontribreport.php?monthcal='.$monthcal.'&yr='.$selectedYr.'&usr='.$userlogin.'&comp='.$compname.'&wkType='.$wokerType.'');
		//echo "MO";
	}
	if ($rptType == "PGRPT")
	{
		header('location: Reports/picontribreport.php?monthcal='.$monthcal.'&yr='.$selectedYr.'&usr='.$userlogin.'&comp='.$compname.'&wkType='.$wokerType.'');
		//echo "QTR";
	}	
}
//-----------------Accounts Detailed Report Process
if(isset($_GET["accdtlreportrun"])) {
	 
	$workernum = $_GET["workernum"];
	$accnum = $_GET["accnum"];
	$fromdate = $_GET["fromdate"];
	$todate = $_GET["todate"];

	
	

	$queryName = "SELECT * FROM userfile where userid = '$userlogin'";
    $resultname = $conn->query($queryName);
        while ($row = $resultname->fetch_assoc())
        	{
        		$usrname = $row["name"];
        	}
	

	
		header('location: Reports/accountsdetailedreport.php?workernum='.$workernum.'&accnum='.$accnum.'&usr='.$userlogin.'&usrname='.$usrname.'&fromdate='.$fromdate.'&todate='.$todate.'&comp='.$compname.'');
		//echo "CO";
	
	
}

if(isset($_GET["accsumreportrun"])) {
	 
	$workernum = $_GET["workernum"];
	$accnum = $_GET["accnum"];
	$fromdate = $_GET["fromdate"];
	$todate = $_GET["todate"];

	
	

	$queryName = "SELECT * FROM userfile where userid = '$userlogin'";
    $resultname = $conn->query($queryName);
        while ($row = $resultname->fetch_assoc())
        	{
        		$usrname = $row["name"];
        	}
	

	
		header('location: Reports/accountsummaryreport.php?workernum='.$workernum.'&accnum='.$accnum.'&usr='.$userlogin.'&usrname='.$usrname.'&fromdate='.$fromdate.'&todate='.$todate.'&comp='.$compname.'');
		//echo "CO";
	
	
}

//-----------------ATM Report Process
if(isset($_GET["atmreportrun"])) {
	 
	$paydate = $_GET["payrolldate"];
	header('location: Reports/atmreport.php?paydate='.$paydate.'&usrname='.$usrname.'&comp='.$compname.'&reporttype=PDF&usr='.$userlogin.'');
	
}

if(isset($_GET["atmreportrunexcel"])) {
	 
	$paydate = $_GET["payrolldate"];
	echo $paydate;
	//header('location: reports/atmreport.php?paydate='.$paydate.'&usrname='.$usrname.'&comp='.$compname.'&reporttype=EXCEL&usr='.$userlogin.'');
	
}

//-----------------Loan Report Process
if(isset($_GET["loanreportrunpdf"])) {
	 
	$selectedYr = $_GET["inputyear"];
	$monthcal = $_GET["monthcal"];
	$rptType = $_GET["loanrptType"];

	
	if ($rptType == "SSSRPT")
	{
		header('location: Reports/sssloanreport.php?monthcal='.$monthcal.'&yr='.$selectedYr.'&usr='.$userlogin.'&comp='.$compname.'&usrname='.$usrname.'&runrpt=PDF');
	}
	
	if ($rptType == "PGRPT")
	{
		header('location: Reports/pgibigloanreport.php?monthcal='.$monthcal.'&yr='.$selectedYr.'&usr='.$userlogin.'&comp='.$compname.'&usrname='.$usrname.'&runrpt=PDF');
	}	
	
}

if(isset($_GET["loanreportrunxls"])) {
	 
	$selectedYr = $_GET["inputyear"];
	$monthcal = $_GET["monthcal"];
	$rptType = $_GET["rptType"];
	
	if ($rptType == "SSSRPT")
	{
		header('location: Reports/sssloanreport.php?monthcal='.$monthcal.'&yr='.$selectedYr.'&usr='.$userlogin.'&comp='.$compname.'&usrname='.$usrname.'&runrpt=XLS');
	}
	
	if ($rptType == "PGRPT")
	{
		header('location: Reports/pgibigloanreport.php?monthcal='.$monthcal.'&yr='.$selectedYr.'&usr='.$userlogin.'&comp='.$compname.'&usrname='.$usrname.'&runrpt=XLS');
	}	
	
}
	

?>