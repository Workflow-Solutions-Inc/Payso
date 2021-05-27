<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];
$payrollperiod = '';
if(isset($_SESSION['DTRPeriod']))
{
	$payrollperiod = $_SESSION['DTRPeriod'];
}

$dataareaid = $_SESSION["defaultdataareaid"];
$workerid= $_POST['transval'];
$_SESSION['DTRWorker'] = $_POST['transval'];

$daysworked = 0;
$hoursworked = 0;
$othours = 0;
$ndhours = 0;
$leave = 0;
$absent = 0;
$late = 0;
$undertime = 0;
$break = 0;
$sphol = 0;
$spholot = 0;
$spholnd = 0;
$sun = 0;
$sunot = 0;
$sunnd = 0;
$hol = 0;
$holot = 0;
$holnd = 0;
$dtrpayrollid = '';

	$query = "SELECT format(daysworked,2) daysworked,
										format(hoursworked,2) hoursworked,
										format(overtimehours,2) overtimehours,
										format(nightdifhours,2) nightdifhours,
										format(leaves,2) leaves,
										format(absent,2) absent,
										format(late,2) late,
										format(break,2) break,
										format(undertime,2) undertime,
										format(specialholiday,2) specialholiday,
										format(specialholidayot,2) specialholidayot,
										format(specialholidaynd,2) specialholidaynd,
										format(sunday,2) sunday,
										format(sundayot,2) sundayot,
										format(sundaynd,2) sundaynd,
										format(ifnull(holiday,0),2) holiday,
										format(holidayot,2) holidayot,
										format(holidaynd,2) holidaynd,
										payrollid

					FROM dailytimerecordheader 
					where dataareaid = '$dataareaid' and workerid = '$workerid'
					and payrollperiod = '$payrollperiod'";
	$result = $conn->query($query);
	$rowclass = "rowA";
	$rowcnt = 0;
	while ($row = $result->fetch_assoc())
	{ 
			$daysworked = $row['daysworked'];
			$hoursworked = $row['hoursworked'];
			$othours = $row['overtimehours'];
			$ndhours = $row['nightdifhours'];
			$leave = $row['leaves'];
			$absent = $row['absent'];
			$late = $row['late'];
			$undertime = $row['undertime'];
			$break = $row['break'];
			$sphol = $row['specialholiday'];
			$spholot = $row['specialholidayot'];
			$spholnd = $row['specialholidaynd'];
			$sun = $row['sunday'];
			$sunot = $row['sundayot'];
			$sunnd = $row['sundaynd'];
			$hol = $row['holiday'];
			$holot = $row['holidayot'];
			$holnd = $row['holidaynd'];
			//$dtrpayrollid = $row['payrollid'];
			

}?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
	<div class="mainpanel-content">
		<!-- tableheader -->
		<form id="ViewForm" action="workerform_submit" method="get" accept-charset="utf-8">
			<div class="half">
				<div class="row">
					<div class="formset">

						<!-- left -->
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="mainpanel-title">
								<span class="fa fa-archive"></span> Regular Work Summary
							</div>
							<br><br>
							<div class="formitem" style="margin-left: 150px;">
								<span class="label-xl" style="width: 140px;">Days Worked:</span>
								<input type="textbox" name ="view-daysWork" id="view-daysWork" value="<?php echo $daysworked;?>"  class="textbox">
							</div>

							<div class="formitem" style="margin-left: 150px;">
								<span class="label-xl" style="width: 140px;">Hours Worked:</span>
								<input type="textbox" name ="view-hourWork" id="view-hourWork" value="<?php echo $hoursworked;?>" class="textbox">
							</div>

							<div class="formitem" style="margin-left: 150px;">
								<span class="label-xl" style="width: 140px;">Overtime Hours:</span>
								<input type="textbox" name ="view-OTHours" id="view-OTHours" value="<?php echo $othours;?>" class="textbox">
							</div>

							<div class="formitem" style="margin-left: 150px;">
								<span class="label-xl" style="width: 140px;">Night Dif Hours:</span>
								<input type="textbox" name ="view-NDhour" id="view-NDhour" value="<?php echo $ndhours;?>" class="textbox">
							</div>

							<!--<div class="formitem" style="margin-left: 150px;">
								<span class="label-xl" style="width: 140px;">Hours Worked:</span>
								<input type="textbox" name ="view-hourWork" id="view-hourWork"  class="textbox text-center">
							</div>-->

						</div>

						<!-- middle -->
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							
							<br><br>
							<div class="formitem">
								<span class="label-xl" style="width: 140px;">Leaves:</span>
								<input type="textbox" name ="view-leaves" id="view-leaves" value="<?php echo $leave;?>" class="textbox">
							</div>

							<div class="formitem">
								<span class="label-xl" style="width: 140px;">Absents:</span>
								<input type="textbox" name ="view-absent" id="view-absent" value="<?php echo $absent;?>"  class="textbox">
							</div>

							<div class="formitem">
								<span class="label-xl" style="width: 140px;">Late (Hrs):</span>
								<input type="textbox" name ="view-late" id="view-late" value="<?php echo $late;?>" class="textbox">
							</div>

							<div class="formitem">
								<span class="label-xl" style="width: 140px;">Undertime (Hrs):</span>
								<input type="textbox" name ="view-undertime" id="view-undertime" value="<?php echo $undertime;?>" class="textbox">
							</div>

							<div class="formitem">
								<span class="label-xl" style="width: 140px;">Over Break:</span>
								<input type="textbox" name ="view-break" id="view-break" value="<?php echo ($break =='' ? '0.00' : $break); ?>" class="textbox">
							</div>

						</div>

					</div>
				</div>

				<hr>

				<div class="row">
					<div class="formset">

						<!-- left -->
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="mainpanel-title">
								<span class="fa fa-archive"></span> Holiday and Rest Day Work Summary
							</div>
							<br><br>
							<div class="formitem" style="margin-left: 150px;">
								<span class="label-xl" style="width: 140px;">Special Holiday:</span>
								<input type="textbox" name ="view-sphol" id="view-sphol" value="<?php echo $sphol;?>" class="textbox">
							</div>

							<div class="formitem" style="margin-left: 150px;">
								<span class="label-xl" style="width: 140px;">Special Holiday OT:</span>
								<input type="textbox" name ="view-spholOT" id="view-spholOT" value="<?php echo $spholot;?>" class="textbox">
							</div>

							<div class="formitem" style="margin-left: 150px;">
								<span class="label-xl" style="width: 140px;">Special Holiday ND:</span>
								<input type="textbox" name ="view-spholND" id="view-spholND" value="<?php echo $spholnd;?>" class="textbox">
							</div>

							<div class="formitem" style="margin-left: 150px;">
								<span class="label-xl" style="width: 140px;">Restday:</span>
								<input type="textbox" name ="view-sunday" id="view-sunday" value="<?php echo $sun;?>" class="textbox">
							</div>

							<div class="formitem" style="margin-left: 150px;">
								<span class="label-xl" style="width: 140px;">Restday OT:</span>
								<input type="textbox" name ="view-sundayOT" id="view-sundayOT" value="<?php echo $sunot;?>" class="textbox">
							</div>

						</div>

						<!-- middle -->
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							
							<br><br>
							<div class="formitem">
								<span class="label-xl" style="width: 140px;">Restday ND:</span>
								<input type="textbox" name ="view-sundayND" id="view-sundayND" value="<?php echo $sunnd;?>" class="textbox">
							</div>

							<div class="formitem">
								<span class="label-xl" style="width: 140px;">Holiday:</span>
								<input type="textbox" name ="view-hol" id="view-hol" value="<?php echo $hol;?>" class="textbox">
							</div>

							<div class="formitem">
								<span class="label-xl" style="width: 140px;">Holiday OT:</span>
								<input type="textbox" name ="view-holOT" id="view-holOT" value="<?php echo $holot;?>" class="textbox">
							</div>

							<div class="formitem">
								<span class="label-xl" style="width: 140px;">Holiday ND:</span>
								<input type="textbox" name ="view-holND" id="view-holND" value="<?php echo $holnd;?>" class="textbox">
							</div>

							

						</div>

					</div>
				</div>

			</div>
			<h2>&nbsp;&nbsp;&nbsp;</h2>
			
			<!--<hr>
			<div class="text-center">
				<input type="reset" class="btn btn-danger" value="Reset">
				<input type="button" class="btn btn-primary" value="Save Changes">
			</div>-->
		</form>	
	</div>
</div>
<!-- end FORM -->


<script  type="text/javascript">

$(document).ready(function(){
        	$("#ViewForm :input").prop("disabled", true);
    	});
</script>