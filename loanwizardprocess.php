<?php
session_id("payso");
session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if($_GET["action"]=="add-CA"){
	 $output='';
	 $sequence='';
	 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='CADV'";
	 $result = $conn->query($query);
	 $row = $result->fetch_assoc();
	 $prefix = $row["prefix"];
	 $first = $row["first"];
	 $last = $row["last"];
	 $format = $row["format"];
	 $next = $row["next"];
	 $suffix = $row["suffix"];
	 if($last >= $next)
	 {
	 	$sequence = $prefix.substr($format,0,strlen($next)*-1).$next.$suffix;
	 }
	 else if ($last < $next)
	 {
	 	$sequence = $prefix.$next.$suffix;
	 }
	 $increment=$next+1;
	 $sql = "UPDATE numbersequence SET
				next = '$increment',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE id = 'CADV'
				and dataareaid = '$dataareaid'";
	 //mysqli_query($conn,$sql);	
		/*if(mysqli_query($conn,$sql))
		{
			$output .= '
				 <input type="textbox" name ="loan-voucher" id="loan-voucher" value="'.$sequence.'"  class="textbox width-full">
				 ';
		}
		else
		{
			$output .= "error".$sql."<br>".$conn->error;
		}*/
	 
	 $output .= '
				 <input type="textbox" name ="loan-voucher" id="loan-voucher" value="'.$sequence.'"  class="textbox width-full">
				 ';
	 echo $output;
	
}

else if($_GET["action"]=="add-EL"){
	 $output='';
	 $sequence='';
	 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='ELOAN'";
	 $result = $conn->query($query);
	 $row = $result->fetch_assoc();
	 $prefix = $row["prefix"];
	 $first = $row["first"];
	 $last = $row["last"];
	 $format = $row["format"];
	 $next = $row["next"];
	 $suffix = $row["suffix"];
	 if($last >= $next)
	 {
	 	$sequence = $prefix.substr($format,0,strlen($next)*-1).$next.$suffix;
	 }
	 else if ($last < $next)
	 {
	 	$sequence = $prefix.$next.$suffix;
	 }
	 $increment=$next+1;
	 $sql = "UPDATE numbersequence SET
				next = '$increment',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE id = 'ELOAN'
				and dataareaid = '$dataareaid'";
	 //mysqli_query($conn,$sql);	
		/*if(mysqli_query($conn,$sql))
		{
			$output .= '
				 <input type="textbox" name ="loan-voucher" id="loan-voucher" value="'.$sequence.'"  class="textbox width-full">
				 ';
		}
		else
		{
			$output .= "error".$sql."<br>".$conn->error;
		}*/
	 
	 $output .= '
				 <input type="textbox" name ="loan-voucher" id="loan-voucher" value="'.$sequence.'"  class="textbox width-full">
				 ';
	 echo $output;
	
}
else if($_GET["action"]=="finish"){

	$LoanWorker = $_GET["locWorkerid"];
	$LoanFromDate = $_GET["locFromdate"];
	$LoanToDate = $_GET["locToDate"];
	$LoanVoucher = $_GET["locVoucher"];
	$LoanSubType = $_GET["locSubType"];
	$LoanType = $_GET["locLoanType"];
	$LoanAccountid = $_GET["locLoanAccount"];
	$LoanAmort = $_GET["locAmort"];
	$LoanBalance = $_GET["locBalance"];
	$LoanDate = $_GET["locLoanDate"];
	$LoanAmount = $_GET["locLoanAmount"];

	$sql = "INSERT INTO loanfile (workerid,voucher,loantype,subtype,loandate,loanamount,amortization,balance,fromdate,todate,accountid,dataareaid,createdby,createddatetime)
			values 
			('$LoanWorker','$LoanVoucher','$LoanType','$LoanSubType','$LoanDate','$LoanAmount','$LoanAmort','$LoanBalance','$LoanFromDate','$LoanToDate','$LoanAccountid', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}



	$CreateLoan = "call SP_LoanCalendarV2('$LoanWorker','$LoanFromDate', '$LoanToDate','$dataareaid','$LoanVoucher','$LoanSubType','$LoanType','$LoanAccountid','$userlogin','$LoanAmort',0,'$LoanBalance')";
			//mysqli_query($conn,$sqlinsert);
			//echo $sqlinsert."<br>".$conn->error;
			if(mysqli_query($conn,$CreateLoan))
			{
				echo $CreateLoan."<br>".$conn->error;
			}
			else
			{
				echo "error".$CreateLoan."<br>".$conn->error;
			}
//echo $sql;
//echo $CreateLoan;
//	header('location: loanwizard.php');
}
?>

<script  type="text/javascript">

</script>