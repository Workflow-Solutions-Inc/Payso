<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
#$user = $_SESSION["user"];
$_SESSION["Navi"] = 'pr';
$dataareaid = $_SESSION["defaultdataareaid"];
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

	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	
	
	<!-- end HEADER -->


	<!-- begin LEFT PANEL -->
	<div id="leftpanel" class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<!--<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button><span class="far fa-plus-square"></span> Create Record</button></li>
			<li><button><span class="fas fa-edit"></span> Update Record</button></li>
			<li><button><span class="far fa-trash-alt"></span> Delete Record</button></li>
		</ul>-->

		<!-- extra buttons -->
		<!--<ul class="extrabuttons">
			<div class="leftpanel-title"><b>POSITION</b></div>
			<li><button><span class="fas fa-caret-up"></span> Move Up</button></li>
			<li><button><span class="fas fa-caret-down"></span> Move Down</button></li>
		</ul>-->

	</div>
	<!-- end LEFT PANEL -->

	<!-- begin MAINPANEL -->
	<div id="mainpanel" class="mainpanel">
		<div class="container-fluid">
			<div class="row">

				<br>
				<!-- Payroll Module -->
				<div id="PayrollMenu" style="display: none">
					<!-- common forms -->
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
						<div class="mainmenu commonforms">
							<h2></span> Forms</h2>
							<ul>
								
								<li class="PayrollTransactionMaintain PayrollTransactionView" style="display: none;"><a href="payrolltransaction.php"><span class="fas fa-exchange-alt hidden-xs hidden-sm"></span> Payroll Transaction</a></li>
							</ul>
						</div>
					</div>

					<!-- setup -->
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
						<div class="mainmenu setup">
							<h2>Setup</h2>
							<ul>

								<li class="BranchMaintain BranchView" style="display: none;"><a href="branchform.php"><span class="fas fa-building hidden-xs hidden-sm"></span> Branch</a></li>
								<li class="PayrollAccountsMaintain PayrollAccountsView" style="display: none;"><a href="accountform.php"><span class="fas fa-user-circle hidden-xs hidden-sm"></span> Accounts</a></li>
								<li class="PayrollPeriodMaintain PayrollPeriodView" style="display: none;"><a href="payrollperiodform.php"><span class="far fa-calendar-alt hidden-xs hidden-sm"></span> Payroll Period</a></li>
								<li class="LateSetup" style="display: none;"><a href="lateform.php"><span class="far fa-clock hidden-xs hidden-sm"></span> Late Setup</a></li>
								<li class="NightDiffSetup" style="display: none;"><a href="nightform.php"><span class="far fa-clock hidden-xs hidden-sm"></span> Night Differential</a></li>
								<li class="DeductionSetupMaintain" style="display: none;"><a href="deductionform.php"><span class="fas fa-file-invoice-dollar hidden-xs hidden-sm"></span> One Time Account</a></li>
								
							</ul>
						</div>
					</div>

					<!-- reports -->
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
						<div class="mainmenu reports">
							<h2>Reports</h2>
							<ul>

								<li class="ContributionReportPrint" style="display: none;"><a href="#" id="contriReport" name="contriReport"><span class="fas fa-donate hidden-xs hidden-sm"></span> Statutory Report</a></li>
								<li class="ContributionReportPrint" style="display: none;"><a href="#" id="AccDetReport" name="AccDetReport"><span class="fas fa-chart-bar hidden-xs hidden-sm"></span> Accounts Detailed Report</a></li>
								<li class="ContributionReportPrint" style="display: none;"><a href="#" id="AccSumReport" name="AccSumReport"><span class="fas fa-chart-line hidden-xs hidden-sm"></span> Accounts Summary Report</a></li>
								<li class="ContributionReportPrint" style="display: none;"><a href="#" id="AtmReport" name="AtmReport"><span class="fas fa-credit-card hidden-xs hidden-sm"></span> ATM Report</a></li>
								<li class="ContributionReportPrint" style="display: none;"><a href="#" id="LoanReport" name="LoanReport"><span class="fas fa-landmark hidden-xs hidden-sm"></span> Loan Report</a></li>
								
							</ul>
						</div>
					</div>

					<!-- inquiry 
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
						<div class="mainmenu inquiry">
							<h2>Inquiry</h2>
							<ul>
								
								
							</ul>
						</div>
					</div> -->


				</div>
				<!-- Human Resource Module -->
				<div id="HrMenu" style="display: none">
					<!-- common forms -->
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
						<div class="mainmenu commonforms">
							<h2></span> Forms</h2>
							<ul>

								
								<li class="WorkersMaintain WorkersView" style="display: none;"><a href="workerform.php"><span class="fas fa-user-tie hidden-xs hidden-sm"></span> Workers</a></li>
								<li class="DTRMaintain DailyTimeRecord" style="display: none;"><a href="dtrform.php"><span class="far fa-sticky-note hidden-xs hidden-sm"></span> Daily Time Record</a></li>
								<li class="ShiftscheduleMaintain ShiftSchedule" style="display: none;"><a href="shiftschedule.php"><span class="far fa-calendar-alt hidden-xs hidden-sm"></span> Shift Schedule</a></li>
								<li class="AttendanceMonitoring" style="display: none;"><a href="attendance.php"><span class="fas fa-tv hidden-xs hidden-sm"></span> Attendance Monitoring</a></li>
								<li class="LeavePayoutMaintain LeavePayoutView" style="display: none;"><a href="leavepayout.php"><span class="fas fa-sign-out-alt hidden-xs hidden-sm"></span> Leave Payout</a></li>
								<li class="LeavePayoutMaintain LeavePayoutView" style="display: none;"><a href="13thmonthpayout.php"><span class="fas fa-sign-out-alt hidden-xs hidden-sm"></span> 13th Month Payout</a></li>
								<li class="LeavePayoutMaintain LeavePayoutView" style="display: none;"><a href="finalpayout.php"><span class="fas fa-sign-out-alt hidden-xs hidden-sm"></span> Final Payout</a></li>
								<!--
								<li id="UserGroups" style="display: none"><a href="usergroupform.php"><span class="fas fa-user hidden-xs hidden-sm"></span> User Groups</a></li>
								<li><a href="userform.php"><span class="fas fa-users hidden-xs hidden-sm"></span> Users</a></li>
								
								
								
								<li><a href="dataarea.php"><span class="fas fa-user-tie hidden-xs hidden-sm"></span> Data Area</a></li>
								<li><a href="payrollperiodform.php">Payroll Period</a></li>
								<li><a href="payrolltransaction.php">Payroll Transaction</a></li>
								-->
							</ul>
						</div>
					</div>

					<!-- setup -->
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
						<div class="mainmenu setup" >
							<h2>Setup</h2>
							<ul>

								<li class="PositionMaintain PositionView" style="display: none;"><a href="positionform.php"><span class="fas fa-user-plus hidden-xs hidden-sm"></span> Position</a></li>
								<li class="DepartmentMaintain DepartmentView" style="display: none;"><a href="departmentform.php"><span class="fas fa-building hidden-xs hidden-sm"></span> Department</a></li>
								<li class="OrganizationalChartMaintain OrganizationalChartView" style="display: none;"><a href="orgform.php"><span class="far fa-calendar-alt hidden-xs hidden-sm"></span> Organizational Chart</a></li>
								<li class="LoanTypeMaintain LoanTypeView" style="display: none;"><a href="loantypeform.php"><span class="fas fa-landmark hidden-xs hidden-sm"></span> Loan Type</a></li>
								<li class="ShifttypeMaintain ShiftType" style="display: none;"><a href="shiftype.php"><span class="far fa-clock hidden-xs hidden-sm"></span> Shift Type</a></li>
								<li class="LeaveTypeMaintain LeaveTypeView" style="display: none;"><a href="leavetypeform.php"><span class="fas fa-file-export hidden-xs hidden-sm"></span> Leave Type</a></li>
								<li class="Calendar CalendarMaintain" style="display: none;"><a href="calendar.php"><span class="far fa-calendar-alt hidden-xs hidden-sm"></span> Calendar</a></li>
								<!-- <li class="DeductionSetupMaintain" style="display: none;"><a href="deductionform.php"><span class="fas fa-file-invoice-dollar hidden-xs hidden-sm"></span> One Time Account</a></li> -->

								<!--
								<li><a href="accountform.php"><span class="fas fa-user-circle hidden-xs hidden-sm"></span> Accounts</a></li>
								<li><a href="privilegesform.php"><span class="fas fa-star hidden-xs hidden-sm"></span> Privileges</a></li>
								<li><a href="numbersequence.php"><span class="fas fa-list-ol hidden-xs hidden-sm"></span> Number Sequence</a></li>
								<li><a href="branchform.php"><span class="fas fa-building hidden-xs hidden-sm"></span> Branch</a></li>
								
								
								
								
								<li><a href="loanfileform.php">Loan File</a></li>
								
								<li><a href="#">License</a></li>					
								<li><a href="#">Database</a></li>
								-->

							</ul>
						</div>
					</div>

					<!-- reports -->
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
						<div class="mainmenu reports">
							<h2>Reports</h2>
							<ul>
								
								<li class="13thMonthReportPrint" style="display: none;"><a href="#" id="TmonthReport" name="TmonthReport"><span class="far fa-calendar hidden-xs hidden-sm"></span>13th Month Report</a></li>
								<!-- jok Added -->
								<li class="ContributionReportPrint" style="display: none;"><a href="#" id="alphalist" name="alphalist"><span class="far fa-calendar hidden-xs hidden-sm"></span>Alphalist Report</a>
								<li class="ContributionReportPrint" style="display: none;"><a href="#" id="bir" name="bir"><span class="far fa-calendar hidden-xs hidden-sm"></span>BIR Report</a>
								<!-- <li class="ContributionReportPrint" style="display: none;"><a  id="memoRPT" name="memoRPT" onclick=" generateMemo()"><span class="fas fa-landmark hidden-xs hidden-sm"></span>Memo</a></li> -->
								<li class="MemoMaintain" style="display: none;"><a href="memo.php"><span class="fas fa-landmark hidden-xs hidden-sm"></span>Memo</a></li>
								<li class="ContributionReportPrint" style="display: none;"><a href="#" id="1601c" name="1601c"><span class="fas fa-landmark hidden-xs hidden-sm"></span>1601C</a>
								<li class="ContributionReportPrint" style="display: none;"><a href="#" id="1601eq" name="1601eq"><span class="fas fa-landmark hidden-xs hidden-sm"></span>1601-EQ</a>
								<li class="ContributionReportPrint" style="display: none;"><a href="#" id="1601fq" name="1601fq"><span class="fas fa-landmark hidden-xs hidden-sm"></span>1601-FQ</a>
								<!-- <li class="ContributionReportPrint" style="display: none;"><a  id="memoRPT" name="memoRPT" onclick=" generate1601FQ()"><span class="fas fa-landmark hidden-xs hidden-sm"></span>1601-FQ</a></li> -->
								
							</ul>
						</div>
					</div>

					<!-- inquiry -->
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
						<div class="mainmenu inquiry">
							<h2>Inquiry</h2>
							<ul>
								
								<li class="WorkerInquiryView" style="display: none;"><a href="workerinquiry.php"><span class="fas fa-info-circle hidden-xs hidden-sm"></span> Worker Inquiry</a></li>
								
								
							</ul>
						</div>
					</div>

				</div>


				<div id="SaMenu" style="display: none">
					<!-- common forms -->
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
						<div class="mainmenu commonforms">
							<h2></span> Forms</h2>
							<ul>

								<li class="UserGroupsMaintain UserGroupsView" style="display: none;"><a href="usergroupform.php"><span class="fas fa-user hidden-xs hidden-sm"></span> User Groups</a></li>
								<li class="UsersMaintain UsersView" style="display: none;"><a href="userform.php"><span class="fas fa-users hidden-xs hidden-sm"></span> Users</a></li>
								<li class="DataAreaMaintain DataAreaView" style="display: none;"><a href="dataarea.php"><span class="fas fa-user-tie hidden-xs hidden-sm"></span> Data Area</a></li>

							</ul>
						</div>
					</div>

					<!-- setup -->
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
						<div class="mainmenu setup">
							<h2>Setup</h2>
							<ul>

								<li class="PrivilegesMaintain PrivilegesView" style="display: none;"><a href="privilegesform.php"><span class="fas fa-star hidden-xs hidden-sm"></span> Privileges</a></li>
								<li class="NumberSequenceMaintain NumberSequenceView" style="display: none;"><a href="numbersequence.php"><span class="fas fa-list-ol hidden-xs hidden-sm"></span> Number Sequence</a></li>
								<li class="LicenseMaintain LicenseView" style="display: none;"><a href="#"><span class="fas fa-id-card hidden-xs hidden-sm"></span> License</a></li>					
								<li class="DatabaseMaintain DatabaseView" style="display: none;"><a href="#"><span class="fas fa-server hidden-xs hidden-sm"></span> Database</a></li>

							</ul>
						</div>
					</div>

					<!-- reports
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
						<div class="mainmenu reports">
							<h2>Reports</h2>
							<ul>
								
								
							</ul>
						</div>
					</div> -->

					<!-- inquiry
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
						<div class="mainmenu inquiry">
							<h2>Inquiry</h2>
							<ul>
								
							</ul>
						</div>
					</div> -->

				</div>


			</div>
				
		</div>
	</div>
	<!-- end MAINPANEL -->

	<!-- The Modal for alphalist -->
	<div id="myModal-alphalist" class="modal">
		<!-- Modal content -->
		<div class="modal-container">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-lg-6">Alphalists Report</div>
					<div class="col-lg-6"><span class="fas fa-times modal-close-a"></span></div>
				</div>
				
				<div id="container" class="modal-content-container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label>Please select a specific year:</label>
									<select value="" value="" placeholder="Period" name ="OTtype" id="yrselection" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
											<option value=""></option>
											<?php
												foreach(range(2015, (int)date("Y")) as $year) 
												{?>
												  <option value='<?php echo $year;?>'><?php echo $year;?></option>
												<?PHP }
											?>
									</select>
							</div>

						</div>

						<div class="button-container">
							<button id="genAlphalist" name="genAlphalist" value="genAlphalist" class="btn btn-primary" onclick="generateAlphalist()" >Generate</button>
							<button type="button" value="Reset" class="btn btn-danger">Clear</button>
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal-->

	<!-- The Modal for 2317 bir Form -->
	<div id="myModal-bir" class="modal">
		<!-- Modal content -->
		<div class="modal-container">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-lg-6">BIR Report</div>
					<div class="col-lg-6"><span class="fas fa-times modal-close-b"></span></div>
				</div>
				
				<div id="container" class="modal-content-container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label>Please select a specific year:</label>
									<select value="" value="" placeholder="Period" name ="yr2316" id="yrselection2316" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
										<option value=""></option>
										<?php
											foreach(range(2015, (int)date("Y")) as $year) 
											{?>
											  <option value='<?php echo $year;?>'><?php echo $year;?></option>
											<?PHP }
										?>
									</select>
							
								
											<label>Please select a specific Worker:</label>
											
											<select  class="modal-textarea" name ="workername" id="myWorker" style="width:100%;height: 28px;" required="required">
												<option value="" selected="selected"></option>
												<?php
													$query = "SELECT workerid,name FROM worker where dataareaid = '$dataareaid'";
													$result = $conn->query($query);			
													  	
														while ($row = $result->fetch_assoc()) {
														?>
															<option value="<?php echo $row["workerid"];?>"><?php echo $row["name"];?></option>
													<?php } ?>
											</select>
								</div>
							

						</div>


						<div class="button-container">
							<button id="genBir" name="genBir" value="genBir" class="btn btn-primary" onclick="generateBIR()">Generate</button>
							<button id="genBir" name="genBir" value="genBir" class="btn btn-primary btn-danger" onclick="generateALL()">Generate All</button>
							
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal-->
	<!-- The Modal for 2317 bir Form -->
	<div id="myModal-contri" class="modal">
		<!-- Modal content -->
		<div class="modal-container">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-lg-6">Statutory Report</div>
					<div class="col-lg-6"><span class="fas fa-times modal-close-c"></span></div>
				</div>
				
				<div id="container" class="modal-content-container">
						<div class="row">

							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label>Report Type:</label>
									<select name= "rptType" class="modal-textarea" id='rptType' style="width:100%;height: 28px;">
										<option  value='SSSRPT'>SSS Contribution</option>
										<option  value='PHRPT'>PhilHealth Contribution</option>
										<option  value='PGRPT'>Pag-Ibig Contribution</option>
									</select>

								<label>Month:</label>
									<select name="monthcal" id= "monthcal" class="modal-textarea" style="width:100%;height: 28px;">
										<option value='1'>January</option>
										<option  value='2'>February</option>
										<option  value='3'>March</option>
										<option  value='4'>April</option>
										<option  value='5'>May</option>
										<option  value='6'>June</option>
										<option  value='7'>July</option>
										<option  value='8'>August</option>
										<option  value='9'>September</option>
										<option  value='10'>October</option>
										<option  value='11'>November</option>
										<option  value='12'>December</option>
									</select>

								<label>Year:</label>
									<select name= "inputyear" class="modal-textarea" id="inputyear" style="width:100%;height: 28px;">
										<?php
											foreach(range(2015, (int)date("Y")) as $year) 
											{?>
											  <option value='<?php echo $year;?>'><?php echo $year;?></option>
											<?PHP }
										?>
									</select>
								
							<!--	<label>Worker:</label>
									<select id="testdisappear" name= "wokerType" class="modal-textarea" style="width:100%;height: 28px;"> 
										<option  value="0">Not BIR Decalared</option>
										<option  value="1">BIR Decalared</option>
										<option  value="2">All</option>
									</select>-->
									
							</div>
							

						</div>


						<div class="button-container">
							<button id="gencontribRPT" name="gencontribRPT" value="gencontribRPT" class="btn btn-primary" onclick="generateStatutory()">Generate PDF</button>
							<button id="gencontribDB" name="gencontribDB" value="gencontribDB" class="btn btn-danger" onclick="generateStatutorydb()">Generate Disbursement</button>

						
							
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal-->

	<!-- The Modal for Account Detail Report -->
	<div id="myModal-AccDetail" class="modal">
		<!-- Modal content -->
		<div class="modal-container">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-lg-6">Accounts Detailed Report</div>
					<div class="col-lg-6"><span class="fas fa-times modal-close-d"></span></div>
				</div>
				
				<div id="container" class="modal-content-container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label>Worker:</label>
									<select id="workernum" name="workernum" class="modal-textarea" style="width:100%;height: 28px;">
										<option value="" selected="selected"></option>
		                            	<?php
		                                	$query = "SELECT concat(workerid, '-',name) as 'worker' FROM worker where dataareaid = '$dataareaid';";
		                                	$result = $conn->query($query);     
		                              	?>
		                              	<?php 
			                                while ($row = $result->fetch_assoc()) 
			                                    {
			                                      echo "<option id='comp'  name='comp' value='".$row['worker']."' required>".$row['worker']."</option>";
			                                    }
		                              	?>
		                             </select>

		                        <label>Accounts:</label>
		                        	<select id="accnum" name="accnum" class="modal-textarea" style="width:100%;height: 28px;">
		                        		<option value="" selected="selected"></option>
		                            	<?php
		                                	$query = "SELECT concat(accountcode,'-',name) as 'accountnums' from accounts where dataareaid = '$dataareaid';";
		                                	$result = $conn->query($query);     
		                              	?>
		                              	<?php 
			                                while ($row = $result->fetch_assoc()) 
			                                    {
			                                      echo "<option id='comp2'  name='comp2' value='".$row['accountnums']."' required>".$row['accountnums']."</option>";
			                                    }
		                              	?>
		                            </select>

		                            <label>From Date:</label>
		                            <input type="date" id="fromdate" name="fromdate" class="modal-textarea" style="width:100%;height: 28px;" required>

		                            <label>To Date:</label>
		                            <input type="date" id="todate" name="todate" class="modal-textarea" style="width:100%;height: 28px;" required>

							</div>
							

						</div>


						<div class="button-container">
							
							<button id="accdtlreportrun" name="accdtlreportrun" value="accdtlreportrun" class="btn btn-primary" onclick="generateaccountsDetail()">Generate PDF</button>
							<button id="accdtlreportrun" name="accdtlreportrun" value="accdtlreportrun" class="btn btn-primary btn-danger">Download Excel</button>
							
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal-->

	<!-- The Modal for Account Summary Report -->
	<div id="myModal-AccSum" class="modal">
		<!-- Modal content -->
		<div class="modal-container">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-lg-6">Accounts Summary Report</div>
					<div class="col-lg-6"><span class="fas fa-times modal-close-e"></span></div>
				</div>
				
				<div id="container" class="modal-content-container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label>Worker:</label>
									<select id="workernum2" name="workernum2" class="modal-textarea" style="width:100%;height: 28px;">
										<option value="" selected="selected"></option>
		                            	<?php
		                                	$query = "SELECT concat(workerid, '-',name) as 'worker' FROM worker where dataareaid = '$dataareaid';";
		                                	$result = $conn->query($query);     
		                              	?>
		                              	<?php 
			                                while ($row = $result->fetch_assoc()) 
			                                    {
			                                      echo "<option id='comp4'  name='comp4' value='".$row['worker']."' required>".$row['worker']."</option>";
			                                    }
		                              	?>
		                             </select>

		                        <label>Accounts:</label>
		                        	<select id="accnum4" name="accnum4" class="modal-textarea" style="width:100%;height: 28px;">
		                        		<option value="" selected="selected"></option>
		                            	<?php
		                                	$query = "SELECT concat(accountcode,'-',name) as 'accountnums',accountcode from accounts where dataareaid = '$dataareaid';";
		                                	$result = $conn->query($query);     
		                              	?>
		                              	<?php 
			                                while ($row = $result->fetch_assoc()) 
			                                    {
			                                      echo "<option id='comp3'  name='comp3' value='".$row['accountcode']."' required>".$row['accountnums']."</option>";
			                                    }
		                              	?>
		                            </select>

		                            <label>From Date:</label>
		                            <input type="date" id="fromdatesum" name="fromdatesum" class="modal-textarea" style="width:100%;height: 28px;" required>

		                            <label>To Date:</label>
		                            <input type="date" id="todatesum" name="todatesum" class="modal-textarea" style="width:100%;height: 28px;" required>

							</div>
							

						</div>


						<div class="button-container">
							<button id="accsumreportrun" name="accsumreportrun" value="accsumreportrun" class="btn btn-primary" onclick="generateaccountsSummary()">Generate</button>
							
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal-->

	<!-- The Modal for ATM Report -->
	<div id="myModal-ATM" class="modal">
		<!-- Modal content -->
		<div class="modal-container">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-lg-6">ATM Report</div>
					<div class="col-lg-6"><span class="fas fa-times modal-close-f"></span></div>
				</div>
				
				<div id="container" class="modal-content-container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	
								<label>Payroll Date:</label>
									<input type="date" id="payrolldte" name="payrolldte" class="modal-textarea" style="width:100%;height: 28px;" required>
			
							</div>

						</div>


						<div class="button-container">
							<button id="atmreportrun" name="atmreportrun" value="atmreportrun" class="btn btn-primary"  onclick="generateAtm()">Generate PDF</button>
							<button id="atmreportrunexcel" name="atmreportrunexcel" value="atmreportrunexcel" class="btn btn-primary btn-danger" onclick="generateAtmDigibanker()">Download Excel</button>
							
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal-->

	<!-- The Modal for Loan Report -->
	<div id="myModal-Loan" class="modal">
		<!-- Modal content -->
		<div class="modal-container">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-lg-6">Loan Report</div>
					<div class="col-lg-6"><span class="fas fa-times modal-close-g"></span></div>
				</div>
				
				<div id="container" class="modal-content-container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label>Report Type:</label>
									<select name= "loanrptType"  id="loanrptType" class="modal-textarea" style="width:100%;height: 28px;">
										<option  value='SSSRPT'>SSS Loan</option>
										<option  value='PGRPT'>Pag-Ibig Loan</option>
									</select>

								<label>Month:</label>
									<select id= "loanmonthcal" class="modal-textarea" style="width:100%;height: 28px;">
										<option  value='1'>January</option>
										<option  value='2'>February</option>
										<option  value='3'>March</option>
										<option  value='4'>April</option>
										<option  value='5'>May</option>
										<option  value='6'>June</option>
										<option  value='7'>July</option>
										<option  value='8'>August</option>
										<option  value='9'>September</option>
										<option  value='10'>October</option>
										<option  value='11'>November</option>
										<option  value='12'>December</option>
									</select>

								<label>Year:</label>
									<select name= "inputyearloan" id='inputyearloan' class="modal-textarea" style="width:100%;height: 28px;">
										<?php
											foreach(range(2015, (int)date("Y")) as $year) 
											{?>
											  <option value='<?php echo $year;?>'><?php echo $year;?></option>
											<?PHP }
										?>
									</select>
									


								
							</div>
							

						</div>


						<div class="button-container">
							<button id="loanreportrunpdf" name="loanreportrunpdf" value="loanreportrunpdf" class="btn btn-primary" onclick="generateLoan()" >Generate PDF</button>
							<!-- <button id="loanreportrunxls" name="loanreportrunxls" value="loanreportrunxls" class="btn btn-primary btn-danger">Download Excel</button> -->
							
							
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal-->

	<!-- The Modal for Loan Report -->
	<div id="myModal-tmonth" class="modal">
		<!-- Modal content -->
		<div class="modal-container">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-lg-6">13th Month Report</div>
					<div class="col-lg-6"><span class="fas fa-times modal-close-h"></span></div>
				</div>
				
				<div id="container" class="modal-content-container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								
								<label>Year:</label>
									<select name= "inputyear" id="inputyear13" class="modal-textarea" style="width:100%;height: 28px;">
										<?php
											foreach(range(2015, (int)date("Y")) as $year) 
											{?>
											  <option value='<?php echo $year;?>'><?php echo $year;?></option>
											<?PHP }
										?>
									</select>

								<label>Period:</label>
									<select name= "periodType" id="periodType" class="modal-textarea" style="width:100%;height: 28px;"> 
										<option  value="Per Cut-Off">Per Cut-Off</option>
										<option  value="Monthly">Monthly</option>
										<option  value="Quarterly">Quarterly</option>
									</select>
									
							</div>
							

						</div>


						<div class="button-container">
							<button id="generate13month" name="generate13month" value="generate13month" class="btn btn-primary" onclick="generate13month()">Run Report</button>
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal-->


	<!-- The Modal for 1601c bir Form -->
	<div id="myModal-1601c" class="modal">
		<!-- Modal content -->
		<div class="modal-container">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-lg-6">1601C Report</div>
					<div class="col-lg-6"><span class="fas fa-times modal-close-i"></span></div>
				</div>
				
				<div id="container" class="modal-content-container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label>Please select a specific Month:</label>
									<select value="" id="monthBirC" value="" placeholder="Period" name ="monthBirC" id="monthselectionBirC" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
										<option value=""></option>
									  	<option id='monthBirC' value='01'>January</option>
										<option id='monthBirC' value='02'>February</option>
										<option id='monthBirC' value='03'>March</option>
										<option id='monthBirC' value='04'>April</option>
										<option id='monthBirC' value='05'>May</option>
										<option id='monthBirC' value='06'>June</option>
										<option id='monthBirC' value='07'>July</option>
										<option id='monthBirC' value='08'>August</option>
										<option id='monthBirC' value='09'>September</option>
										<option id='monthBirC' value='10'>October</option>
										<option id='monthBirC' value='11'>November</option>
										<option id='monthBirC' value='12'>December</option>
									</select>

								<label>Please select a specific year:</label>
									<select value="" value="" placeholder="Period" name ="yrBirC" id="yrselectionBirC" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
										<option value=""></option>
										<?php
											foreach(range(2015, (int)date("Y")) as $year) 
											{?>
											  <option value='<?php echo $year;?>'><?php echo $year;?></option>
											<?PHP }
										?>
									</select>
									
											<label>Please select a specific Worker:</label>
											
											<select  class="modal-textarea" name ="workername" id="myWorkerBirC" style="width:100%;height: 28px;" required="required">
												<option value="" selected="selected"></option>
												<?php
													$query = "SELECT workerid,name FROM worker where dataareaid = '$dataareaid'";
													$result = $conn->query($query);			
													  	
														while ($row = $result->fetch_assoc()) {
														?>
															<option value="<?php echo $row["workerid"];?>"><?php echo $row["name"];?></option>
													<?php } ?>
											</select>
								</div>
							

						</div>


						<div class="button-container">
							<button id="genBirC" name="genBirC" value="genBirC" class="btn btn-primary" onclick="generate1601C()">Generate</button>
							<!-- <button id="genBir" name="genBir" value="genBir" class="btn btn-primary btn-danger" onclick="generateALL()">Generate All</button> -->
							
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal-->

	<!-- The Modal for 1601EQ bir Form -->
	<div id="myModal-1601eq" class="modal">
		<!-- Modal content -->
		<div class="modal-container">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-lg-6">1601-EQ Report</div>
					<div class="col-lg-6"><span class="fas fa-times modal-close-j"></span></div>
				</div>
				
				<div id="container" class="modal-content-container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label>Please select a specific year:</label>
									<select value="" value="" placeholder="Period" name ="yrBirEQ" id="yrselectionBirEQ" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
										<option value=""></option>s
										<?php
											foreach(range(2015, (int)date("Y")) as $year) 
											{?>
											  <option value='<?php echo $year;?>'><?php echo $year;?></option>
											<?PHP }
										?>
									</select>
								
											<label>Please select a specific Worker:</label>
											
											<select  class="modal-textarea" name ="workername" id="myWorkerBirEQ" style="width:100%;height: 28px;" required="required">
												<option value="" selected="selected"></option>
												<?php
													$query = "SELECT workerid,name FROM worker where dataareaid = '$dataareaid'";
													$result = $conn->query($query);			
													  	
														while ($row = $result->fetch_assoc()) {
														?>
															<option value="<?php echo $row["workerid"];?>"><?php echo $row["name"];?></option>
													<?php } ?>
											</select>
								</div>
							

						</div>


						<div class="button-container">
							<button id="genBirEQ" name="genBirEQ" value="genBirEQ" class="btn btn-primary" onclick="generate1601EQ()">Generate</button>
							<!-- <button id="genBir" name="genBir" value="genBir" class="btn btn-primary btn-danger" onclick="generateALL()">Generate All</button> -->
							
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal-->

	<!-- The Modal for 1601FQ bir Form -->
	<div id="myModal-1601fq" class="modal">
		<!-- Modal content -->
		<div class="modal-container">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-lg-6">1601-FQ Report</div>
					<div class="col-lg-6"><span class="fas fa-times modal-close-k"></span></div>
				</div>
				
				<div id="container" class="modal-content-container">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label>Please select a specific year:</label>
									<select value="" value="" placeholder="Period" name ="yrBirFQ" id="yrselectionBirFQ" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
										<option value=""></option>s
										<?php
											foreach(range(2015, (int)date("Y")) as $year) 
											{?>
											  <option value='<?php echo $year;?>'><?php echo $year;?></option>
											<?PHP }
										?>
									</select>
								
											<label>Please select a specific Worker:</label>
											
											<select  class="modal-textarea" name ="workername" id="myWorkerBirFQ" style="width:100%;height: 28px;" required="required">
												<option value="" selected="selected"></option>
												<?php
													$query = "SELECT workerid,name FROM worker where dataareaid = '$dataareaid'";
													$result = $conn->query($query);			
													  	
														while ($row = $result->fetch_assoc()) {
														?>
															<option value="<?php echo $row["workerid"];?>"><?php echo $row["name"];?></option>
													<?php } ?>
											</select>
								</div>
							

						</div>


						<div class="button-container">
							<button id="genBirFQ" name="genBirFQ" value="genBirFQ" class="btn btn-primary" onclick="generate1601FQ()">Generate</button>
							<!-- <button id="genBir" name="genBir" value="genBir" class="btn btn-primary btn-danger" onclick="generateALL()">Generate All</button> -->
							
						</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal-->

	


	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js"></script>
	 <script  type="text/javascript">

	 	
	 	//var allAccess = [];
	 	$(document).ready(function(){
        	//$("#UserGroups").css("display", "block");
        	//$(".OrganizationalChartView").css("display", "None");
        	/*allAccess.push(document.getElementById("accesslevel").value);

			$.each(allAccess, function(acs, al){
	         	//alert(al);
	         	$("."+al+"").css("display", "block");
	    		
			});*/
        	
    	});

    	$(document).ready(function(){
        	CurMod = document.getElementById("ModuleNav").value;

        	if(CurMod == "pr")
        	{
        		$("#PayrollMenu").css("display", "block");
        	}
        	else if(CurMod == "hr")
        	{
        		$("#HrMenu").css("display", "block");
        	}
        	else
        	{
        		$("#SaMenu").css("display", "block");
        	}

    	});

    	$(document).ready(function(){
    		HL = document.getElementById("ModuleNav").value;
		    $("#"+HL+"").addClass("active");
		    //alert(HL);
		});

		//JOK
		// Get the modal for 1601c -------------------
		var modalbirC = document.getElementById('myModal-1601c');
		// Get the button that opens the modal
		var birCBtn = document.getElementById("1601c");
		// Get the <span> element that closes the modal
		var birCspan = document.getElementsByClassName("modal-close-i")[0];
		// When the user clicks the button, open the modal 
		birCBtn.onclick = function() {
		    $("#myModal-1601c").stop().fadeTo(500,1);
		    document.getElementById("genBirC").style.visibility = "visible";
		}
		// When the user clicks on <span> (x), close the modal
		birCspan.onclick = function() {
		    modalbirC.style.display = "none";
		}

		// Get the modal for 1601eq -------------------
		var modalbirEQ = document.getElementById('myModal-1601eq');
		// Get the button that opens the modal
		var birEQBtn = document.getElementById("1601eq");
		// Get the <span> element that closes the modal
		var birEQspan = document.getElementsByClassName("modal-close-j")[0];
		// When the user clicks the button, open the modal 
		birEQBtn.onclick = function() {
		    $("#myModal-1601eq").stop().fadeTo(500,1);
		    document.getElementById("genBirEQ").style.visibility = "visible";
		}
		// When the user clicks on <span> (x), close the modal
		birEQspan.onclick = function() {
		    modalbirEQ.style.display = "none";
		}

		// Get the modal for 1601fq -------------------
		var modalbirFQ = document.getElementById('myModal-1601fq');
		// Get the button that opens the modal
		var birFQBtn = document.getElementById("1601fq");
		// Get the <span> element that closes the modal
		var birFQspan = document.getElementsByClassName("modal-close-k")[0];
		// When the user clicks the button, open the modal 
		birFQBtn.onclick = function() {
		    $("#myModal-1601fq").stop().fadeTo(500,1);
		    document.getElementById("genBirFQ").style.visibility = "visible";
		}
		// When the user clicks on <span> (x), close the modal
		birFQspan.onclick = function() {
		    modalbirFQ.style.display = "none";
		}



    	// Get the modal for alphalist -------------------
		var modalalphalist = document.getElementById('myModal-alphalist');
		// Get the button that opens the modal
		var alphalistBtn = document.getElementById("alphalist");
		// Get the <span> element that closes the modal
		var alphalistspan = document.getElementsByClassName("modal-close-a")[0];
		// When the user clicks the button, open the modal 
		alphalistBtn.onclick = function() {
		    $("#myModal-alphalist").stop().fadeTo(500,1);
		    document.getElementById("genAlphalist").style.visibility = "visible";
		}
		// When the user clicks on <span> (x), close the modal
		alphalistspan.onclick = function() {
		    modalalphalist.style.display = "none";
		}

		//end modal --------------------------- bir

		// Get the modal for BIR -------------------
		var modalbir = document.getElementById('myModal-bir');
		// Get the button that opens the modal
		var birBtn = document.getElementById("bir");
		// Get the <span> element that closes the modal
		var birtspan = document.getElementsByClassName("modal-close-b")[0];
		// When the user clicks the button, open the modal 
		birBtn.onclick = function() {
		    $("#myModal-bir").stop().fadeTo(500,1);
		    document.getElementById("genBir").style.visibility = "visible";
		}
		// When the user clicks on <span> (x), close the modal
		birtspan.onclick = function() {
		    modalbir.style.display = "none";
		}

		// Get the modal for contribution report -------------------
		var modalcontri = document.getElementById('myModal-contri');
		// Get the button that opens the modal
		var contriBtn = document.getElementById("contriReport");
		// Get the <span> element that closes the modal
		var contrispan = document.getElementsByClassName("modal-close-c")[0];
		// When the user clicks the button, open the modal 
		contriBtn.onclick = function() {
		    $("#myModal-contri").stop().fadeTo(500,1);
		    document.getElementById("genBir").style.visibility = "visible";
		}
		// When the user clicks on <span> (x), close the modal
		contrispan.onclick = function() {
		    modalcontri.style.display = "none";
		}

		// Get the modal for Account Details report -------------------
		var modalAccDetail = document.getElementById('myModal-AccDetail');
		// Get the button that opens the modal
		var AccDetailBtn = document.getElementById("AccDetReport");
		// Get the <span> element that closes the modal
		var AccDetailspan = document.getElementsByClassName("modal-close-d")[0];
		// When the user clicks the button, open the modal 
		AccDetailBtn.onclick = function() {
		    $("#myModal-AccDetail").stop().fadeTo(500,1);
		    document.getElementById("genBir").style.visibility = "visible";
		}
		// When the user clicks on <span> (x), close the modal
		AccDetailspan.onclick = function() {
		    modalAccDetail.style.display = "none";
		}

		// Get the modal for Account Details report -------------------
		var modalAccSum = document.getElementById('myModal-AccSum');
		// Get the button that opens the modal
		var AccSumBtn = document.getElementById("AccSumReport");
		// Get the <span> element that closes the modal
		var AccSumspan = document.getElementsByClassName("modal-close-e")[0];
		// When the user clicks the button, open the modal 
		AccSumBtn.onclick = function() {
		    $("#myModal-AccSum").stop().fadeTo(500,1);
		    document.getElementById("genBir").style.visibility = "visible";
		}
		// When the user clicks on <span> (x), close the modal
		AccSumspan.onclick = function() {
		    modalAccSum.style.display = "none";
		}

		// Get the modal for Account Details report -------------------
		var modalATM= document.getElementById('myModal-ATM');
		// Get the button that opens the modal
		var ATMBtn = document.getElementById("AtmReport");
		// Get the <span> element that closes the modal
		var ATMspan = document.getElementsByClassName("modal-close-f")[0];
		// When the user clicks the button, open the modal 
		ATMBtn.onclick = function() {
		    $("#myModal-ATM").stop().fadeTo(500,1);
		    document.getElementById("genBir").style.visibility = "visible";
		}
		// When the user clicks on <span> (x), close the modal
		ATMspan.onclick = function() {
		    modalATM.style.display = "none";
		}

		// Get the modal for Account Details report -------------------
		var modalLoan= document.getElementById('myModal-Loan');
		// Get the button that opens the modal
		var LoanBtn = document.getElementById("LoanReport");
		// Get the <span> element that closes the modal
		var Loanspan = document.getElementsByClassName("modal-close-g")[0];
		// When the user clicks the button, open the modal 
		LoanBtn.onclick = function() {
		    $("#myModal-Loan").stop().fadeTo(500,1);
		    document.getElementById("genBir").style.visibility = "visible";
		}
		// When the user clicks on <span> (x), close the modal
		Loanspan.onclick = function() {
		    modalLoan.style.display = "none";
		}

		// Get the modal for Account Details report -------------------
		var modalTmonth= document.getElementById('myModal-tmonth');
		// Get the button that opens the modal
		var TmonthBtn = document.getElementById("TmonthReport");
		// Get the <span> element that closes the modal
		var Tmonthspan = document.getElementsByClassName("modal-close-h")[0];
		// When the user clicks the button, open the modal 
		TmonthBtn.onclick = function() {
		    $("#myModal-tmonth").stop().fadeTo(500,1);
		    document.getElementById("genBir").style.visibility = "visible";
		}
		// When the user clicks on <span> (x), close the modal
		Tmonthspan.onclick = function() {
		    modalTmonth.style.display = "none";
		}



		function generateAlphalist()
		{
			var selectedYear = document.getElementById("yrselection").value;
			//alert(selectedYear);
			if(selectedYear)
			{
				window.open('Reports/BIRforms/alphalist.php?selectedyear='+selectedYear, "_blank");
			}
			else
			{
				alert("Please a specific year to proceed.");
			}
			
		}

		function generateBIR()
		{
			var selectedYear = document.getElementById("yrselection2316").value;
			var selectedWorker = document.getElementById("myWorker").value;
			var soc = "<?php echo $dataareaid; ?>";
			if(selectedYear && selectedWorker)
			{
				window.open('Reports/BIRforms/2316form.php?selectedyear='+selectedYear+'&selectedworker='+selectedWorker+'&com='+soc, "_blank");
			}
			else
			{
				alert("Please a specific year and worker to proceed.");
			}
		}
		function generateALL()
		{
			var selectedYear = document.getElementById("yrselection2316").value;
			if(selectedYear)
			{
				  window.open('Reports/BIRforms/Batch2316form.php?selectedyear='+selectedYear, "_blank"); 
			}
			else
			{
				alert("Please a specific year to proceed.");
			}
		}

		

		function generateAtm()
		{
			  window.open("reportprocess.php?atmreportrun&payrolldate="+document.getElementById("payrolldte").value, "_blank"); 
		}

		function generateAtmDigibanker()
		{
			  window.open("reportprocess.php?atmreportrunexcel&payrolldate="+document.getElementById("payrolldte").value, "_blank"); 
		}

		function generateStatutory()
		{
			  window.open("reportprocess.php?gencontribRPT&rptType="+document.getElementById("rptType").value+"&inputyear="+document.getElementById("inputyear").value+"&monthcal="+document.getElementById("monthcal").value, "_blank"); 
		}
		
		function generateStatutorydb()
		{
			window.open("reportprocess.php?gencontribDB&rptType="+document.getElementById("rptType").value+"&inputyear="+document.getElementById("inputyear").value+"&monthcal="+document.getElementById("monthcal").value, "_blank"); 
		}

		function generate13month()
		{
			  window.open("reportprocess.php?generate13month&periodType="+document.getElementById("periodType").value+"&inputyear="+document.getElementById("inputyear13").value,"_blank"); 
		}
    	

    	function generateaccountsDetail()
    	{
    		window.open("reportprocess.php?accdtlreportrun&workernum="+document.getElementById("workernum").value+"&accnum="+document.getElementById("accnum").value+"&fromdate="+document.getElementById("fromdate").value+"&todate="+document.getElementById("todate").value,"_blank");
    	}

    	function generateaccountsSummary()
    	{
    		window.open("reportprocess.php?accsumreportrun&workernum="+document.getElementById("workernum2").value+"&accnum="+document.getElementById("accnum4").value+"&fromdate="+document.getElementById("fromdatesum").value+"&todate="+document.getElementById("todatesum").value,"_blank");
    	}

    	function generateMemo()
    	{
    		 window.open('Reports/Memo/Memo.php', "_blank");
    	}
    	
    	function generate1601C()
    	{
    		var selectedYear = document.getElementById("yrselectionBirC").value;
			var selectedWorker = document.getElementById("myWorkerBirC").value;
			var selectedMonth = document.getElementById("monthBirC").value;
			var soc = "<?php echo $dataareaid; ?>";
			//alert(selectedMonth);
			if(selectedYear && selectedWorker)
			{
				window.open('Reports/BIRforms/1601C.php?selectedyear='+selectedYear+'&selectedworker='+selectedWorker+'&selectedMonth='+selectedMonth+'&com='+soc, "_blank");
			}
			else
			{
				alert("Please a specific year and worker to proceed.");
			}
    		//alert(selectedYear);
    	}
    	function generate1601EQ()
    	{
    		 //window.open('Reports/BIRforms/1601-EQ.php', "_blank");
    		var selectedYear = document.getElementById("yrselectionBirEQ").value;
			var selectedWorker = document.getElementById("myWorkerBirEQ").value;
			var soc = "<?php echo $dataareaid; ?>";
			if(selectedYear && selectedWorker)
			{
				window.open('Reports/BIRforms/1601-EQ.php?selectedyear='+selectedYear+'&selectedworker='+selectedWorker+'&com='+soc, "_blank");
			}
			else
			{
				alert("Please a specific year and worker to proceed.");
			}

    	}
    	function generate1601FQ()
    	{
    		//window.open('Reports/BIRforms/1601-FQ.php', "_blank");
    		var selectedYear = document.getElementById("yrselectionBirFQ").value;
			var selectedWorker = document.getElementById("myWorkerBirFQ").value;
			var soc = "<?php echo $dataareaid; ?>";
			if(selectedYear && selectedWorker)
			{
				window.open('Reports/BIRforms/1601-FQ.php?selectedyear='+selectedYear+'&selectedworker='+selectedWorker+'&com='+soc, "_blank");
			}
			else
			{
				alert("Please a specific year and worker to proceed.");
			}
    	}


    	function generateLoan()
		{
			  //alert(document.getElementById("inputyearloan").value);
			  window.open("reportprocess.php?loanreportrunpdf&loanrptType="+document.getElementById("loanrptType").value+"&inputyear="+document.getElementById("inputyearloan").value+"&monthcal="+document.getElementById("loanmonthcal").value, "_blank"); 
			  
		}
	 </script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>