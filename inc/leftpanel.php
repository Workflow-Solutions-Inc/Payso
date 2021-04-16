<?php
	$CurModule = '';
	
	  function runMyFunction() {
	    echo 'I just ran a php function';
	  }

	  if (isset($_GET['list'])) {

	    
	    	if($_GET['list'] == "pr")
	    	{
	    		$CurModule = "pr";
	    		$_SESSION["Navi"] = $CurModule;
	 		}
	 		if($_GET['list'] == "hr")
	    	{
	    		$CurModule = "hr";
	    		$_SESSION["Navi"] = $CurModule;
	 		}
	 		if($_GET['list'] == "sa")
	    	{
	    		$CurModule = "sa";
	    		$_SESSION["Navi"] = $CurModule;
	 		}
	}
	else
	{
		//$CurModule = "pr";
		$CurModule = $_SESSION["Navi"] ;
	}
	?>

<input type="hidden" id="ModuleNav" value="<?php echo $_SESSION["Navi"];?>">	
<!-- begin LEFT PANEL -->
<style type="text/css" media="screen">
	.dropright:hover>.dropdown-menu { display: block !important; }
</style>
	<!-- head -->
	<div class="head">
		<img src="images/logo-white.png">
		<button id="mobile-hide-nav" class="fas fa-bars btn-danger visible-xs"></button>
	</div>


	<!-- main buttons -->
	<ul class="mainbuttons">
		<div class="leftpanel-title"><b>MAIN MENU</b></div>
		<li>
			<a href="dashboard.php"><span class="fas fa-tachometer-alt"></span> Dashboard</a>
		</li>
		<div class="LNavPayroll" style="display: none">
			<li>
				<div class="btn-group dropright mainbuttons-dropdown-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="far fa-file-alt fa"></span> Forms <span class="fas fa-angle-right right"></span>
					</button>
					<div class="dropdown-menu mainbuttons-dropdown-menu">
						<!-- sub link -->
						<ul>
							<li class="PayrollTransactionMaintain PayrollTransactionView" style="display: none;"><a href="payrolltransaction.php"><span class="fas fa-exchange-alt hidden-xs hidden-sm"></span> Payroll Transaction</a></li>

						</ul>
					</div>
				</div>
			</li>

			<li>
				<div class="btn-group dropright mainbuttons-dropdown-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="fas fa-cog fa"></span> Setup <span class="fas fa-angle-right right"></span>
					</button>
					<div class="dropdown-menu mainbuttons-dropdown-menu">
						<!-- sub link -->
						<ul>
							<li class="BranchMaintain BranchView" style="display: none;"><a href="branchform.php"><span class="fas fa-building hidden-xs hidden-sm"></span> Branch</a></li>
							<li class="PayrollAccountsMaintain PayrollAccountsView" style="display: none;"><a href="accountform.php"><span class="fas fa-user-circle hidden-xs hidden-sm"></span> Accounts</a></li>
							<li class="PayrollPeriodMaintain PayrollPeriodView" style="display: none;"><a href="payrollperiodform.php"><span class="far fa-calendar-alt hidden-xs hidden-sm"></span> Payroll Period</a></li>
							<li class="LateSetup" style="display: none;"><a href="lateform.php"><span class="far fa-clock hidden-xs hidden-sm"></span> Late Setup</a></li>
							<li class="NightDiffSetup" style="display: none;"><a href="nightform.php"><span class="far fa-clock hidden-xs hidden-sm"></span> Night Differencial</a></li>
							<li class="OnetimeAccountMaintain" style="display: none;"><a href="deductionform.php"><span class="fas fa-file-invoice-dollar hidden-xs hidden-sm"></span> One Time Account</a></li>
						</ul>
					</div>
				</div>
			</li>

			<!--<li class="LNavReport" style="display: block">
				<div class="btn-group dropright mainbuttons-dropdown-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="fas fa-chart-pie fa"></span> Reports <span class="fas fa-angle-right right"></span>
					</button>
					<div class="dropdown-menu mainbuttons-dropdown-menu">-->
						<!-- sub link -->
						<!--<ul>
							<li class="ContributionReportPrint" style="display: none;"><a href="#"><span class="fas fa-donate hidden-xs hidden-sm"></span> Contribution Report</a></li>
							<li class="ContributionReportPrint" style="display: none;"><a href="#"><span class="fas fa-chart-bar hidden-xs hidden-sm"></span> Accounts Detailed Report</a></li>
							<li class="ContributionReportPrint" style="display: none;"><a href="#"><span class="fas fa-chart-line hidden-xs hidden-sm"></span> Accounts Summary Report</a></li>
							<li class="ContributionReportPrint" style="display: none;"><a href="#"><span class="fas fa-credit-card hidden-xs hidden-sm"></span> ATM Report</a></li>
							<li class="ContributionReportPrint" style="display: none;"><a href="#"><span class="fas fa-landmark hidden-xs hidden-sm"></span> Loan Report</a></li>-->

							<!--<li><a href="#">Other Payslip Report</a></li>
							<li><a href="#">Leave Payout Report</a></li>
							
							<li><a href="#">Other Billing Report</a></li>
							
							<li><a href="#">Other Payroll Reports</a></li>-->
						<!--</ul>
					</div>
				</div>
			</li>-->

		</div>

		<div  class="LNavHR" style="display: none">
			<li>
				<div class="btn-group dropright mainbuttons-dropdown-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="far fa-file-alt fa"></span> Forms <span class="fas fa-angle-right right"></span>
					</button>
					<div class="dropdown-menu mainbuttons-dropdown-menu">
						<!-- sub link -->
						<ul>
							
							<li class="WorkersMaintain WorkersView" style="display: none;"><a href="workerform.php"><span class="fas fa-user-tie hidden-xs hidden-sm"></span> Workers</a></li>
							<li class="DTRMaintain DailyTimeRecord" style="display: none;"><a href="dtrform.php"><span class="far fa-sticky-note hidden-xs hidden-sm"></span>  Daily Time Record</a></li>
							<li class="ShiftscheduleMaintain ShiftSchedule" style="display: none;"><a href="shiftschedule.php"><span class="far fa-calendar-alt hidden-xs hidden-sm"></span> Shift Schedule</a></li>
							<li class="AttendanceMonitoring" style="display: none;"><a href="attendance.php"><span class="fas fa-tv hidden-xs hidden-sm"></span> Attendance Monitoring</a></li>
							<li class="LeavePayoutMaintain LeavePayoutView" style="display: none;"><a href="leavepayout.php"><span class="fas fa-sign-out-alt hidden-xs hidden-sm"></span> Leave Payout</a></li>

						</ul>
					</div>
				</div>
			</li>

			<li>
				<div class="btn-group dropright mainbuttons-dropdown-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="fas fa-cog fa"></span> Setup <span class="fas fa-angle-right right"></span>
					</button>
					<div class="dropdown-menu mainbuttons-dropdown-menu">
						<!-- sub link -->
						<ul>
							<li class="PositionMaintain PositionView" style="display: none;"><a href="positionform.php"><span class="fas fa-user-plus hidden-xs hidden-sm"></span> Position</a></li>
							<li class="DepartmentMaintain DepartmentView" style="display: none;"><a href="departmentform.php"><span class="fas fa-building hidden-xs hidden-sm"></span> Department</a></li>
							<li class="OrganizationalChartMaintain OrganizationalChartView" style="display: none;"><a href="orgform.php"><span class="far fa-calendar-alt hidden-xs hidden-sm"></span> Organizational Chart</a></li>
							<li class="LoanTypeMaintain LoanTypeView" style="display: none;"><a href="loantypeform.php"><span class="fas fa-landmark hidden-xs hidden-sm"></span> Loan Type</a></li>
							<li class="ShifttypeMaintain ShiftType" style="display: none;"><a href="shiftype.php"><span class="far fa-clock hidden-xs hidden-sm"></span> Shift Type</a></li>
							<li class="LeaveTypeMaintain LeaveTypeView" style="display: none;"><a href="leavetypeform.php"><span class="fas fa-file-export hidden-xs hidden-sm"></span> Leave Type</a></li>
							<li class="Calendar CalendarMaintain" style="display: none;"><a href="calendar.php"><span class="far fa-calendar-alt hidden-xs hidden-sm"></span> Calendar</a></li>
						</ul>
					</div>
				</div>
			</li>

			<!--<li class="LNavReport" style="display: block">
				<div class="btn-group dropright mainbuttons-dropdown-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="fas fa-chart-pie fa"></span> Reports <span class="fas fa-angle-right right"></span>
					</button>
					<div class="dropdown-menu mainbuttons-dropdown-menu">-->
						<!-- sub link -->
						<!--<ul>
							<li class="13thMonthReportPrint" style="display: none;"><a href="#"><span class="far fa-calendar hidden-xs hidden-sm"></span>13th Month Report</a></li>

						</ul>
					</div>
				</div>
			</li>-->

			<li class="LNavHR" style="display: none">
				<div class="btn-group dropright mainbuttons-dropdown-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="fas fa-info-circle fa"></span> Inquiry <span class="fas fa-angle-right right"></span>
					</button>
					<div class="dropdown-menu mainbuttons-dropdown-menu">
						<!-- sub link -->
						<ul>
							<li class="WorkerInquiryView" style="display: none;"><a href="workerinquiry.php"><span class="fas fa-info-circle hidden-xs hidden-sm"></span> Worker Inquiry</a></li>
							
							
						</ul>
					</div>
				</div>
			</li>
		</div>

		<div  class="LNavSysAdd" style="display: none">
			<li>
				<div class="btn-group dropright mainbuttons-dropdown-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="far fa-file-alt fa"></span> Forms <span class="fas fa-angle-right right"></span>
					</button>
					<div class="dropdown-menu mainbuttons-dropdown-menu">
						<!-- sub link -->
						<ul>
							<li class="UserGroupsMaintain UserGroupsView" style="display: none;"><a href="usergroupform.php"><span class="fas fa-user hidden-xs hidden-sm"></span> User Groups</a></li>
							<li class="UsersMaintain UsersView" style="display: none;"><a href="userform.php"><span class="fas fa-users hidden-xs hidden-sm"></span> Users</a></li>
							<li class="DataAreaMaintain DataAreaView" style="display: none;"><a href="dataarea.php"><span class="fas fa-user-tie hidden-xs hidden-sm"></span> Data Area</a></li>

						</ul>
					</div>
				</div>
			</li>

			<li>
				<div class="btn-group dropright mainbuttons-dropdown-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="fas fa-cog fa"></span> Setup <span class="fas fa-angle-right right"></span>
					</button>
					<div class="dropdown-menu mainbuttons-dropdown-menu">
						<!-- sub link -->
						<ul>
							<li class="PrivilegesMaintain PrivilegesView" style="display: none;"><a href="privilegesform.php"><span class="fas fa-star hidden-xs hidden-sm"></span> Privileges</a></li>
							<li class="NumberSequenceMaintain NumberSequenceView" style="display: none;"><a href="numbersequence.php"><span class="fas fa-list-ol hidden-xs hidden-sm"></span> Number Sequence</a></li>
							<li class="LicenseMaintain LicenseView" style="display: none;"><a href="#"><span class="fas fa-id-card hidden-xs hidden-sm"></span> License</a></li>					
							<li class="DatabaseMaintain DatabaseView" style="display: none;"><a href="#"><span class="fas fa-server hidden-xs hidden-sm"></span> Database</a></li>
						</ul>
					</div>
				</div>
			</li>

		</div>
	</ul>

	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js"></script>
	 <script  type="text/javascript">

	 	

    	$(document).ready(function(){
        	LeftCurMod = document.getElementById("ModuleNav").value;

        	if(LeftCurMod == "pr")
        	{
        		$(".LNavPayroll").css("display", "Block");
        	}
        	else if(LeftCurMod == "hr")
        	{
        		$(".LNavHR").css("display", "Block");
        	}
        	else
        	{
        		$(".LNavSysAdd").css("display", "Block");
        		$(".LNavReport").css("display", "None");
        	}

    	});

    	$(document).ready(function(){
    		ActiveMode = document.getElementById("ModuleNav").value;
		    $("#"+ActiveMode+"").addClass("active");
		    //alert(ActiveMode);
		});
	 </script>
	<!-- end [JAVASCRIPT] -->