<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
#$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>S : MENU</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body>



	<!-- begin LEFT PANEL -->
	<div class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<!--
		<ul class="subbuttons">
			<li><button><span class="fas fa-home fa"></span> Inquiry</button></li>
			<li><button><span class="fas fa-home fa"></span> Inquiry</button></li>
			<li><button><span class="fas fa-home fa"></span> Inquiry</button></li>
			<li><button><span class="fas fa-home fa"></span> Inquiry</button></li>
		</ul>
		-->

		<!-- extra buttons -->
		<!--
		<ul class="extrabuttons">
			<li><button><span class="fas fa-check fa"></span> Accept</button></li>
			<li><button><span class="fas fa-times fa"></span> Cancel</button></li>
		</ul>
		-->

	</div>
	<!-- end LEFT PANEL -->




	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->




	<!-- begin MAINPANEL -->
	<div id="mainpanel" class="mainpanel">
		<div class="container-fluid">
			<div class="row">


				<!-- common forms -->
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<div class="mainmenu">
						<h2><span class="fa fa-list"></span> Common Forms</h2>
						<ul>
							<li><a href="usergroupform.php">User Groups</a>
							<li><a href="userform.php">Users</a>
							<li><a href="#">Leave Payout</a>
							<li><a href="workerform.php">Workers</a>
							<li><a href="dataarea.php">Data Area</a>
							<li><a href="payrollperiodform.php">Payroll Period</a>
							<li><a href="payrolltransaction.php">Payroll Transaction</a>
						</ul>
					</div>
				</div>

				<!-- setup -->
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<div class="mainmenu">
						<h2><span class="fa fa-cog"></span> Setup</h2>
						<ul>
							<li><a href="accountform.php">Accounts</a>
							<li><a href="privilegesform.php">Privileges</a>
							<li><a href="numbersequence.php">Number Sequence</a>
							<li><a href="branchform.php">Branch</a>
							<li><a href="positionform.php">Position</a>
							<li><a href="departmentform.php">Department</a>
							<li><a href="loantypeform.php">Loan Type</a>
							<li><a href="loanfileform.php">Loan File</a>
							<li><a href="leavetypeform.php">Leave Type</a>
							<li><a href="#">License</a>							
							<li><a href="#">Database</a>
							
						</ul>
					</div>
				</div>

				<!-- reports -->
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<div class="mainmenu">
						<h2><span class="fa fa-edit"></span> Reports</h2>
						<ul>
							<li><a href="#">Contribution Report</a>
							<li><a href="#">Accounts Detailed Report</a>
							<li><a href="#">Accounts Summary Report</a>
							<li><a href="#">13th Month Report</a>
							<li><a href="#">Other Payslip Report</a>
							<li><a href="#">Leave Payout Report</a>
							<li><a href="#">Loan Report</a>
							<li><a href="#">Other Billing Report</a>
							<li><a href="#">ATM Report</a>
							<li><a href="#">Other Payroll Reports</a>
						</ul>
					</div>
				</div>

				<!-- inquiry -->
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
					<div class="mainmenu">
						<h2><span class="fa fa-info"></span> Inquiry</h2>
						<ul>
							<li><a href="#">Worker Inquiry</a>
							<li><a href="#">Shift Schedule</a>
							<li><a href="#">Shift Type</a>
							<li><a href="#">DTR</a>
						</ul>
					</div>
				</div>


			</div>
		</div>
	</div>
	<!-- end MAINPANEL -->


	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>