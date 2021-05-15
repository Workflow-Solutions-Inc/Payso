<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
#$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

$payrollperiod = '';
if(isset($_SESSION['DTRPeriod']))
{
	$payrollperiod = $_SESSION['DTRPeriod'];
}

if(isset($_SESSION['DTRWorker']))
{
	$workerid = $_SESSION['DTRWorker'];
}
/*if(isset($_GET["loaddtr"])) {
	$payrollperiod = 'ADMOPP00006';
}
else
{
	$payrollperiod = '';
}*/
/*else
{
	header('location: userform.php');
}*/
$firstresult = '';
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Daily Time Record</title>

	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body>-->
<style>


/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  color: #656565;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #fff;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>

	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->


	<!-- begin LEFT PANEL -->
	<div id="leftpanel" class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button onClick="LoadDtr();"><span class="fa fa-plus"></span> Load DTR</button></li>
			<li class="DTRMaintain" style="display: none;"><button onClick="ImportDtr();"><span class="fa fa-plus"></span> Import DTR</button></li>
			
			<div id="WSbtn">
				<li class="DTRMaintain" style="display: none;"><button id="modaltableBtn1"><span class="fa fa-edit"></span> Update Work Summary</button></li>
			</div>
			<div id="SSbtn" style="display: none">
				<li class="DTRMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Schedule</button></li>
			</div>
			
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>

		<ul class="subbuttons">
			<li class="DTRMaintain" style="display: none;"><div class="leftpanel-title"><b>Process</b></div></li>
			<li class="DTRMaintain" style="display: none;"><button onClick="Proceed();"><span class="fa fa-paper-plane"></span> Proceed to Payroll</button></li>
			<li class="DTRMaintain" style="display: none;"><button onClick="PrintDtr();"><span class="fa fa-paper-plane"></span> Print DTR</button></li>
		</ul>
		
		

	</div>
	<!-- end LEFT PANEL -->


	<!-- begin MAINPANEL -->
	<div id="mainpanel" class="mainpanel">
		<div class="container-fluid">
			<div class="row">

				<!-- start TABLE AREA -->
				<div id="tablearea1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> Daily Time Record  <?php //echo $payrollperiod; ?>
						</div>
						
						<div class="mainpanel-sub">
							<!-- cmd -->
							<div class="mainpanel-sub-cmd">
								<!--<label style="width: 90px;">Shift Type:</label>
								<select class="modal-textarea" name ="ShedType" id="add-type" style="margin-left: 0px;width: 150px;height: 25px;">
									<option value="Normal" selected="selected">Normal</option>
									<?php
										$query = "SELECT distinct shifttype FROM shifttype where dataareaid = '$dataareaid'";
										$result = $conn->query($query);			
										  	
											while ($row = $result->fetch_assoc()) {
											?>
												<option value="<?php echo $row["shifttype"];?>"><?php echo $row["shifttype"];?></option>
										<?php } ?>
								</select>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

								<label style="width: 90px;">Shift Type:</label>
								<select class="modal-textarea" name ="ShedType" id="add-type" style="margin-left: 0px;width: 150px;height: 25px;">
									<option value="Normal" selected="selected">Normal</option>
									<?php
										$query = "SELECT distinct shifttype FROM shifttype where dataareaid = '$dataareaid'";
										$result = $conn->query($query);			
										  	
											while ($row = $result->fetch_assoc()) {
											?>
												<option value="<?php echo $row["shifttype"];?>"><?php echo $row["shifttype"];?></option>
										<?php } ?>
								</select>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
								<span class="fa fa-calendar-alt" style="font-size: 22px;"> Payroll Period: <?php echo $payrollperiod; ?></span>
								<!--<a href="" class="cmd-create"><span class="far fa-plus-square"></a>
								<a href="" class="cmd-update"><span class="fas fa-edit"></a>
								<a href="" class="cmd-delete"><span class="far fa-trash-alt"></a>
									<span class="mainpanel-sub-space">|</span>
								<a href="" class="cmd-others"><span class="fas fa-caret-up"></a>
								<a href="" class="cmd-others"><span class="fas fa-caret-down"></a>
									<span class="mainpanel-sub-space">|</span>
								<a href="" class="cmd-print"><span class="fas fa-print"></a>-->
							</div>
						</div>
						<!-- tableheader -->
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:10%;">Invalid</td>
										<td style="width:10%;">Absent</td>
										<td style="width:25%;">Worker ID</td>
										<td style="width:25%;">Name</td>
										<td style="width:25%;">Position</td>
										<td style="width:25%;">Rate</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>										
									</tr>
								
								
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
										<td><span></span></td>
										<td><span></span></td>

										<td><input list="SearchUserid" class="search" disabled>
										<?php
											$query = "SELECT distinct workerid FROM worker where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchUserid">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["workerid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct name FROM userfile";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchName">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["name"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchDataarea" class="search" disabled>
										<?php
											$query = "SELECT distinct defaultdataareaid FROM userfile";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchDataarea">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["defaultdataareaid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchPass" class="search" disabled>
										<?php
											$query = "SELECT distinct password FROM userfile";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPass">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["password"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><span></span></td>
									</tr>
								</thead>
								
								<tbody id="result">
									<?php
									if($payrollperiod != '')
									{
										$query = "SELECT wk.workerid,wk.name as 'name',ifnull(pos.name,'') as 'position', 
													case when rhist.status = 1 then ifnull(truncate(rhist.rate, 2), '0.00') else '0.00' end as rate,
													case when 
						                                ifnull(dtrdtl.Invalid,0) > 0 then 1 
														else 0 
														end as 'invalidrec' ,
														case when 
														ifnull(dtrdtl2.Absent,0) > 0 then 1 
														else 0 
														end as 'absent'
													                    
													FROM worker wk left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
													left join contract con on wk.workerid = con.workerid and wk.dataareaid = con.dataareaid
													left join ratehistory rhist on con.contractid = rhist.contractid and con.dataareaid = rhist.dataareaid

													left join(SELECT count(*) as 'Invalid', workerid, dataareaid FROM dailytimerecorddetail
													where payrollperiod = '$payrollperiod' 
													and (timein is null and timeout is not null) or (timeout is null and timein is not null)
													group by workerid, dataareaid) dtrdtl on dtrdtl.workerid = wk.workerid and dtrdtl.dataareaid = wk.dataareaid

													left join(SELECT count(*) as 'Absent', workerid, dataareaid FROM dailytimerecorddetail
													where payrollperiod = '$payrollperiod'
													and timein is null and  timeout is null
													group by workerid, dataareaid) 
													dtrdtl2 on dtrdtl2.workerid = wk.workerid and dtrdtl2.dataareaid = wk.dataareaid

													left join dailytimerecordheader dtrdtl3 on 
                                                    dtrdtl3.workerid = wk.workerid and dtrdtl3.dataareaid = wk.dataareaid 

													where wk.dataareaid = '$dataareaid'   and wk.inactive = '0' and rhist.status = 1   
													and dtrdtl3.payrollperiod = '$payrollperiod'

													order by wk.workerid";
										$result = $conn->query($query);
										$rowclass = "rowA";
										$rowcnt = 0;
										$rowcnt2 = 0;
										
											while ($row = $result->fetch_assoc())
											{ 
												$rowcnt++;
												$rowcnt2++;
													if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
													else { $rowclass = "rowA";}
													
												?>
												<tr id="<?php echo $row['workerid'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
												<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
												<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
												<td style="width:10%;"><input type="checkbox" name="chkbox" class="checkbox"  value="true" <?php echo ($row['invalidrec']==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['invalidrec'];?></div></td>
												<td style="width:10%;"><input type="checkbox" name="chkbox" class="checkbox"  value="true" <?php echo ($row['absent']==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['absent'];?></div></td>
												<td style="width:25%;"><?php echo $row['workerid'];?></td>
												<td style="width:25%;"><?php echo $row['name'];?></td>
												<td style="width:25%;"><?php echo $row['position'];?></td>
												<td style="width:25%;"><?php echo $row['rate'];?></td>
												<td style="display:none;width:1%;"><?php echo $rowcnt2;?></td>
												<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly' style="width:100%;"></td>-->
											</tr>

										<?php 
										//$firstresult = $row["userid"];
										}
											$result2 = $conn->query($query);
											$row2 = $result2->fetch_assoc();
											$firstresult = $row2["workerid"];
										}
									

									?>
								
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php if(isset($_SESSION['DTRWorker'])){ echo $workerid; } else { echo $firstresult; } ?>">
									<input type="hidden" id="hidefocus" value="<?php echo $payrollperiod;?>">
									
								</span>
							</table>
						</div>
					</div>
					<br><br>
				</div>
				<!-- end TABLE AREA -->

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					
					<div  style="border: 5px solid gray; width: 340px;  padding: 10px;">
						<table>
							<tr >
								<td style="background-color: #ffff66 ;  border: 1px solid black; width:50px;height:50px;" ></td>
								<td>&nbsp;Invalid Record&nbsp;</td>
								<td style="background-color: #668cff ;  border: 1px solid black; width:50px;height:50px;" ></td>
								<td>&nbsp;No In</td>
							</tr>
							<tr>
								<td style="background-color: #ffbf80 ;  border: 1px solid black; width:50px;height:50px;" ></td>
								<td>&nbsp;Modified&nbsp;</td>
								<td style="background-color: #00b359 ;  border: 1px solid black; width:50px;height:50px;" ></td>
								<td>&nbsp;No Out</td>
							</tr>
						</table>

					</div>
					<br>
				</div>
				<!-- end DTR Content-->

				<!--<div class="body">
					<div class="body-content">

						<div class="body-nav">
								<ul>
									<li id="pla" onClick="reply_click(this.id)"><a href="fieldworkform.php?list=pla"><span class="fas fa-hourglass"></span>  Pending Field Work Application</a></li>
									<li id="ala" onClick="reply_click(this.id)"><a href="#?list=ala"><span class="fas fa fa-check"></span>  Posted Field Work Application</a></li>
								</ul>
						</div>

					</div>
				</div>-->
				<!--<div class="mainpanel-content">
						<div class="mainpanel-title">
							&nbsp;<span class="fa fa-archive"></span> 
							Details
						</div>
				</div>
				<h2>&nbsp;&nbsp;&nbsp;</h2>-->
				
				<hr><hr>
				<div class="tab">
				  <button class="tablinks" id="OverView" value="0" onclick="Activate(this.value);"><span class="fas fa-briefcase">&nbsp;</span> Work Summary</button>
				  <button class="tablinks" id="Summary" value="1" onclick="Activate(this.value);"><span class="fas fa-calendar-alt">&nbsp;</span> Schedule Summary</button>
				 
				</div>

				<!-- start DTR Content -->
				<?php 
				//if(isset($_SESSION['DTRWorker'])){ echo $workerid; } else { echo $firstresult; }
				if(isset($_SESSION['DTRWorker']))
				{ 
					$firstresult = $workerid; 
				}
				else
				{
					$firstresult = $firstresult; 
				}
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
										format(holiday,2) holiday,
										format(holidayot,2) holidayot,
										format(holidaynd,2) holidaynd,
										payrollid

									FROM dailytimerecordheader 
									where dataareaid = '$dataareaid' and workerid = '$firstresult'
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
							$dtrpayrollid = $row['payrollid'];
							

				}
				$distPayPer = "NoRec";
				$query = "SELECT distinct payrollperiod

									FROM dailytimerecordheader 
									where dataareaid = '$dataareaid' and workerid = '$firstresult'
									and payrollperiod = '$payrollperiod'";
					$result = $conn->query($query);
					$rowclass = "rowA";
					$rowcnt = 0;
					while ($row = $result->fetch_assoc())
					{ 
							$distPayPer = $row['payrollperiod'];
							
					}
				$distPayStatus = "Cancelled";
				$distPayId = '';
				$query = "SELECT
						case when payrollstatus = 0 then 'Created' 
							when payrollstatus = 1 then 'Submitted' 
							when payrollstatus = 2 then 'Canceled' 
							when payrollstatus = 3 then 'Approved' 
							when payrollstatus = 4 then 'Disapproved' 
						else '' end as 'status',
						payrollstatus,
						payrollid

						from payrollheader ph 
						left join branch bh on ph.branchcode = bh.branchcode and ph.dataareaid = bh.dataareaid

						where ph.dataareaid = '$dataareaid'
						and ph.payrollperiod = '$payrollperiod'
						and payrollstatus !=2

						order by ph.payrollid asc";
					$result = $conn->query($query);
					$rowclass = "rowA";
					$rowcnt = 0;
					while ($row = $result->fetch_assoc())
					{ 
							$distPayStatus = $row['status'];
							$distPayId = $row['payrollid'];
							
					}


				?>
				<input type="hidden" name ="view-payrollid" id="view-payrollid"  value="<?php echo $distPayId;?>" class="textbox text-center">
				<input type="hidden" name ="view-payperiod" id="view-payperiod"  value="<?php echo $distPayPer;?>" class="textbox text-center">
				<input type="hidden" name ="view-paystatus" id="view-paystatus"  value="<?php echo $distPayStatus;?>" class="textbox text-center">
				<div id='dtrContent'>
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
				</div>
				<!-- end DTR Content-->
				
			</div>
		</div>
	</div>
	<!-- end MAINPANEL -->
<!-- The Modal -->
<div id="myModal" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">User</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<!--<form name="myForm" accept-charset="utf-8" action="dtrformprocess.php" method="get">-->
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div id="shiftCount">
								<label>Start Time:</label>
								<input type="time" value="00:00" placeholder="start time" name ="starttime" id="add-starttime" class="modal-textarea" required="required">
								<label>End Time:</label>
								<input type="time" value="00:00" placeholder="end time" name ="endtime" id="add-endtime" class="modal-textarea" required="required">	
								<label>Break Out:</label>
								<input type="time" value="12:00" placeholder="bout" name ="breakout" id="add-breakout" class="modal-textarea" required="required">
								<label>Break In:</label>
								<input type="time" value="13:00" placeholder="bin" name ="breakin" id="add-breakin" class="modal-textarea" required="required">	
							</div>
						</div>

						

					</div>

					<div class="button-container">
						<button id="addbt" name="save" value="save" class="btn btn-primary btn-action" onclick="return checkExistForm()">Save</button>
						<button id="upbt" name="update" value="update" class="btn btn-success btn-action" onclick="Update()">Update</button>
						<button onClick="Clear();" type="button" value="Reset" class="btn btn-danger">Clear</button>
					</div>
				<!--</form>-->
			</div>
		</div>
	</div>
</div>
<!-- end modal-->

<!-- begin modal table 1 -->
<div id="myModal1" class="modal">
	<!-- Modal content -->
	<div class="modal-container modal-continer-table">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">Worker Summary</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close-1"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<!-- begin MAINPANEL -->
				<div class="row">

					<!-- start FORM -->
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
						<div class="mainpanel-content">
							<!-- tableheader -->
							<form name="addForm" action="dtrformprocess.php" method="get" accept-charset="utf-8">
								<div class="half">
									<div class="row">
										<div class="formset">

											<!-- left -->
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<div class="mainpanel-title">
													<span class="fa fa-archive"></span> Regular Work Summary
												</div>
												
												<div class="formitem" style="margin-left: 150px;">
													<span class="label-xl" style="width: 140px;">Days Worked:</span>
													<input type="number" step="0.01" name ="add-daysWork" id="add-daysWork"  class="textbox">
												</div>

												<div class="formitem" style="margin-left: 150px;">
													<span class="label-xl" style="width: 140px;">Hours Worked:</span>
													<input type="number" step="0.01" name ="add-hourWork" id="add-hourWork"  class="textbox">
												</div>

												<div class="formitem" style="margin-left: 150px;">
													<span class="label-xl" style="width: 140px;">Overtime Hours:</span>
													<input type="number" step="0.01" name ="add-OTHours" id="add-OTHours"  class="textbox">
												</div>

												<div class="formitem" style="margin-left: 150px;">
													<span class="label-xl" style="width: 140px;">Night Dif Hours:</span>
													<input type="number" step="0.01" name ="add-NDhour" id="add-NDhour"  class="textbox">
												</div>

												<input type="hidden" name ="add-workerid" id="add-workerid"  class="textbox text-center">
												<!--<div class="formitem" style="margin-left: 150px;">
													<span class="label-xl" style="width: 140px;">Hours Worked:</span>
													<input type="textbox" name ="view-hourWork" id="view-hourWork"  class="textbox text-center">
												</div>-->

											</div>

											<!-- middle -->
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												
												
												<div class="formitem">
													<span class="label-xl" style="width: 140px;">Leaves:</span>
													<input type="number" step="0.01" name ="add-leaves" id="add-leaves"  class="textbox">
												</div>

												<div class="formitem">
													<span class="label-xl" style="width: 140px;">Absents:</span>
													<input type="number" step="0.01" name ="add-absent" id="add-absent"  class="textbox">
												</div>

												<div class="formitem">
													<span class="label-xl" style="width: 140px;">Late (Hrs):</span>
													<input type="number" step="0.01"  name ="add-late" id="add-late" class="textbox">
												</div>

												<div class="formitem">
													<span class="label-xl" style="width: 140px;">Undertime (Hrs):</span>
													<input type="number" step="0.01" name ="add-undertime" id="add-undertime"  class="textbox">
												</div>

												<div class="formitem">
													<span class="label-xl" style="width: 140px;">Break:</span>
													<input type="number" step="0.01" name ="add-break" id="add-break"  class="textbox">
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
												
												<div class="formitem" style="margin-left: 150px;">
													<span class="label-xl" style="width: 140px;">Special Holiday:</span>
													<input type="number" step="0.01" name ="add-sphol" id="add-sphol"  class="textbox">
												</div>

												<div class="formitem" style="margin-left: 150px;">
													<span class="label-xl" style="width: 140px;">Special Holiday OT:</span>
													<input type="number" step="0.01" name ="add-spholOT" id="add-spholOT"  class="textbox">
												</div>

												<div class="formitem" style="margin-left: 150px;">
													<span class="label-xl" style="width: 140px;">Special Holiday ND:</span>
													<input type="number" step="0.01" name ="add-spholND" id="add-spholND"  class="textbox">
												</div>

												<div class="formitem" style="margin-left: 150px;">
													<span class="label-xl" style="width: 140px;">Restday:</span>
													<input type="number" step="0.01" name ="add-sunday" id="add-sunday"  class="textbox">
												</div>

												<div class="formitem" style="margin-left: 150px;">
													<span class="label-xl" style="width: 140px;">Restday OT:</span>
													<input type="number" step="0.01" name ="add-sundayOT" id="add-sundayOT"  class="textbox">
												</div>

											</div>

											<!-- middle -->
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												
												
												<div class="formitem">
													<span class="label-xl" style="width: 140px;">Restday ND:</span>
													<input type="number" step="0.01" name ="add-sundayND" id="add-sundayND"  class="textbox">
												</div>

												<div class="formitem">
													<span class="label-xl" style="width: 140px;">Holiday:</span>
													<input type="number" step="0.01" name ="add-hol" id="add-hol"  class="textbox">
												</div>

												<div class="formitem">
													<span class="label-xl" style="width: 140px;">Holiday OT:</span>
													<input type="number" step="0.01" name ="add-holOT" id="add-holOT"  class="textbox">
												</div>

												<div class="formitem">
													<span class="label-xl" style="width: 140px;">Holiday ND:</span>
													<input type="number" step="0.01" name ="add-holND" id="add-holND"  class="textbox">
												</div>

												

											</div>

										</div>
									</div>

								</div>
								
								<hr>
								<div class="text-center" class="button-container">
									<!--<input type="reset" class="btn btn-danger" value="Reset">
									<input type="button" class="btn btn-primary" value="Save Changes">
									<button id="addbt" name="save" value="save" class="btn btn-primary btn-action">Save</button>-->
									<button id="upbt" name="updatews" value="updatews" class="btn btn-success btn-action" onclick="return validateForm()">Update</button>
									<button onClick="Clear();" type="button" value="Reset" class="btn btn-danger">Clear</button>
								</div>
							</form>	
						</div>
					</div>
					<!-- end FORM -->
				</div>
				
				<!-- end MAINPANEL -->
			</div>
		</div>
	</div>
</div>
<!-- end modal table 1-->

<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	 <script  type="text/javascript">
	 	var flaglocation='workSummary';
		var so='';
		var usernum = '';
		var myId = [];
		if(usernum == '')
		{
			so = document.getElementById("hide").value;
		}
		//var locIndex = '';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				
				
				so = usernum.toString();
				document.getElementById("hide").value = so;
				document.getElementById("add-workerid").value = document.getElementById("hide").value;
				if(flaglocation == 'workSummary')
				{
					//-----------get line--------------//
					var action = "getline";
					var actionmode = "userform";
					$.ajax({
						type: 'POST',
						url: 'dtrwork.php',
						data:{action:action, actmode:actionmode, transval:so},
						beforeSend:function(){
						
							$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						},
						success: function(data){
							//payline='';
							//document.getElementById("hide2").value = "";
							$('#dtrContent').html(data);
						}
					}); 
					//-----------get line--------------//
				}
				else if(flaglocation == 'schedSummary')
				{
					//-----------get line--------------//
					var action = "getline";
					var actionmode = "userform";
					$.ajax({
						type: 'POST',
						url: 'dtrsummary.php',
						data:{action:action, actmode:actionmode, transval:so},
						beforeSend:function(){
						
							$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						},
						success: function(data){
							//payline='';
							//document.getElementById("hide2").value = "";
							$('#dtrContent').html(data);
						}
					}); 
					//-----------get line--------------//
				}
				//flaglocation = true;
				//alert(flaglocation);
		        $("#myUpdateBtn").prop("disabled", false);	
					  
			});
		});

  		


		$(document).ready(function() {
			loc = document.getElementById("hide").value;
	            //$("#myUpdateBtn").prop("disabled", false);
	        if(loc != '')
	        {
	        	var pos = $("#"+loc+"").attr("tabindex");
	        }
	        else
	        {
	        	var pos = 1;
	        }
			//var pos = 1;
			//document.getElementById("hide").value;
		    //$("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").css("color","red");
		    $("tr[tabindex="+pos+"]").addClass("info");
		    //$("tr[tabindex=0]").focus();
		    //$("tr[tabindex="+pos+"]").css("color","red");  
		    //var idx = $("tr:focus").attr("tabindex");
		    //alert(idx);
		    //document.onkeydown = checkKey;
		    $('#OverView').addClass("active");
		    document.getElementById("add-workerid").value = document.getElementById("hide").value;
		});

		$(document).ready(function(){
        	$("#ViewForm :input").prop("disabled", true);
    	});



		function Activate(val)
		{
			
			so = document.getElementById("hide").value;
			if(val == "0")
			{
				flaglocation = 'workSummary';
				$('#SSbtn').css("display", "None");
				$('#WSbtn').css("display", "Block");
				$('#OverView').addClass("active");
				$('#Summary').removeClass("active");

				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'dtrwork.php',
					data:{action:action, actmode:actionmode, transval:so},
					beforeSend:function(){
					
						$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide2").value = "";
						$('#dtrContent').html(data);
					}
				}); 
				//-----------get line--------------//
				
			}

			else
			{
				flaglocation = 'schedSummary';
				$('#SSbtn').css("display", "Block");
				$('#WSbtn').css("display", "None");
				$('#Summary').addClass("active");
				$('#OverView').removeClass("active");

				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'dtrsummary.php',
					data:{action:action, actmode:actionmode, transval:so},
					beforeSend:function(){
					
						$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide2").value = "";
						$('#dtrContent').html(data);
					}
				}); 
				//-----------get line--------------//

			}
			
			
			
			
		}

		// Get the modal -------------------
		var modal = document.getElementById('myModal');
		// Get the button that opens the modal
		var UpdateBtn = document.getElementById("myUpdateBtn");
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("modal-close")[0];
		// When the user clicks the button, open the modal 
		UpdateBtn.onclick = function() {
			if(locDate != '')
			{
				modal.style.display = "block";
			    //$("#add-UserId").prop('readonly', false);
			    //alert(stimer);
			    document.getElementById("addbt").style.visibility = "hidden";
				document.getElementById("upbt").style.visibility = "visible";

			    document.getElementById("add-starttime").value = stimer;
				document.getElementById("add-endtime").value = etimer;
				document.getElementById("add-breakout").value = bkout.toString();
				document.getElementById("add-breakin").value = bkin.toString();
			}
			else 
			{
				alert("Please Select a record you want to update.");
			}
		    
		}
		
		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
		    modal.style.display = "none";
		    //Clear();
		}
		// When the user clicks anywhere outside of the modal, close it
		/*window.onclick = function(event) {
		    if (event.target == modal || event.target == modal2) {
		        modal.style.display = "none";
		        Clear();
		        
		    }
		}*/
		//end modal --------------------------- 

		// modal table 1
		var modal1 = document.getElementById('myModal1');
		// Get the button that opens the modal
		var openBtn1 = document.getElementById("modaltableBtn1");
		//var UpdateBtn = document.getElementById("myUpdateBtn");
		// Get the <span> element that closes the modal
		var span1 = document.getElementsByClassName("modal-close-1")[0];
		// When the user clicks the button, open the modal 
		openBtn1.onclick = function() {
		    $("#myModal1").stop().fadeTo(500,1);
		    //modal1.style.display = "block";
		    //document.getElementById("upbt").style.visibility = "visible";
		    //document.getElementById("upbt").disabled = true;
		    //document.getElementById("addbt").disabled = false;
		    //document.getElementById("addbt").style.visibility = "visible";

		    document.getElementById("add-hourWork").value = document.getElementById("view-hourWork").value;
		    document.getElementById("add-daysWork").value = document.getElementById("view-daysWork").value;
		    document.getElementById("add-OTHours").value = document.getElementById("view-OTHours").value;
		    document.getElementById("add-NDhour").value = document.getElementById("view-NDhour").value;
		    document.getElementById("add-leaves").value = document.getElementById("view-leaves").value;
		    document.getElementById("add-absent").value = document.getElementById("view-absent").value;
		    document.getElementById("add-late").value = document.getElementById("view-late").value;
		    document.getElementById("add-undertime").value = document.getElementById("view-undertime").value;
		    document.getElementById("add-break").value = document.getElementById("view-break").value;

		    document.getElementById("add-sphol").value = document.getElementById("view-sphol").value;
		    document.getElementById("add-spholOT").value = document.getElementById("view-spholOT").value;
		    document.getElementById("add-spholND").value = document.getElementById("view-spholND").value;
		    document.getElementById("add-sunday").value = document.getElementById("view-sunday").value;
		    document.getElementById("add-sundayOT").value = document.getElementById("view-sundayOT").value;
		    document.getElementById("add-sundayND").value = document.getElementById("view-sundayND").value;
		    document.getElementById("add-hol").value = document.getElementById("view-hol").value;
		    document.getElementById("add-holOT").value = document.getElementById("view-holOT").value;
		    document.getElementById("add-holND").value = document.getElementById("view-holND").value;
		}

		
		// When the user clicks on <span> (x), close the modal
		span1.onclick = function() {
		    modal1.style.display = "none";
		    //$("#myModal1").stop().fadeTo(500,0);
		   // Clear();
		}
		//end modal --------------------------- 



		function checkExistForm()
		{
			var cont = document.getElementById("t2").value;
			myId = cont.toLowerCase().split(",");
			//myId.push("Kiwi","Lemon","Pineapple",'asd');
			/*$.each(myId, function(i, el2){
		    	alert(el2);
			});*/
			//alert(myId.length);
			var n = myId.includes(document.getElementById("add-UserId").value.toLowerCase());
			//alert(n);
			if(n == true){
				alert("User ID already Exist!");
				return false;
			}
			else
			{
				alert("Continue Saving...");
				return false;
			}
			
		}

		function validateForm() {
		  var x = document.forms["addForm"]["updatews"].value;
		  if (x == "updatews") {
		    if(confirm("Are you sure you want to update this record?")) {
		    	return true;
		    }
		    else
		    {
		    	modal.style.display = "none";
		    	//Clear();
		    	return false;
		    }
		  }
		}			
				
		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var UId;
			var UPass;
			var NM;
			var DT;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 UId = data[0];
			 NM = data[1];
			 DT = data[2];
			 UPass = data[3];
			
			

			
			 $.ajax({
						type: 'GET',
						url: 'userformprocess.php',
						data:{action:action, actmode:actionmode, userno:UId, pass:UPass, lname:NM, darea:DT},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$('#result').html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#result').html(data);
							//-----------get line--------------//
							var action = "getline";
							var actionmode = "userform";
							var firstval = $('#hide3').val();
							document.getElementById("hide").value = firstval;
							so = document.getElementById("hide").value;
				            //$("#myUpdateBtn").prop("disabled", false);
				             var pos = $("#"+so+"").attr("tabindex");
							    $("tr[tabindex="+pos+"]").focus();
							    $("tr[tabindex="+pos+"]").css("color","red");
							    $("tr[tabindex="+pos+"]").addClass("info");
							$.ajax({
								type: 'POST',
								url: 'userformline.php',
								data:{action:action, actmode:actionmode, userId:firstval},
								beforeSend:function(){
								
									$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								},
								success: function(data){
									//payline='';
									document.getElementById("hide2").value = "";
									$('#lineresult').html(data);
								}
							}); 
							//-----------get line--------------//	
				}
			}); 
			 
		  }
		});
		//-----end search-----//
		function Clear()
		{
			if(so != '')
			{				
				//document.getElementById("add-UserId").value = "";
				//document.getElementById("add-pass").value = "";
				document.getElementById("add-name").value = "";
				document.getElementById("add-dataareaid").value = "";
			}
			else
			{
				document.getElementById("add-UserId").value = "";
				document.getElementById("add-pass").value = "";
				document.getElementById("add-name").value = "";
				document.getElementById("add-dataareaid").value = "";
			}
		}

		function Save()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var UId = $('#add-UserId').val();
			var UPass = $('#add-pass').val();
			var NM = $('#add-name').val();
			var DT = $('#add-dataareaid').val();
			var action = "save";
			var actionmode = "userform";
			$.ajax({	
					type: 'GET',
					url: 'userformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, actmode:actionmode, userno:UId, pass:UPass, lname:NM, darea:DT},
					beforeSend:function(){
							
					$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						
					},
					success: function(data){
					//$('#datatbl').html(data);
					location.reload();					
					}
			}); 
						
		}

		function Update()
		{
			
			modal.style.display = "none";
			
			var starttime = $('#add-starttime').val();
			var endtime = $('#add-endtime').val();
			var breakout = $('#add-breakout').val();
			var breakin = $('#add-breakin').val();
			
			var action = "update";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'dtrformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, starttime:starttime, endtime:endtime, breakout:breakout, breakin:breakin, locDate:locDate},
							beforeSend:function(){
									
							$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#dtrContent').html(data);
							//location.reload();
							//-----------get line--------------//
							var action = "getline";
							var actionmode = "userform";
							$.ajax({
								type: 'POST',
								url: 'dtrsummary.php',
								data:{action:action, actmode:actionmode, transval:so},
								beforeSend:function(){
								
									$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								},
								success: function(data){
									//payline='';
									//document.getElementById("hide2").value = "";
									//$('#dtrContent').html(data);
									$('#dtrContent').html(data);
								}
							}); 
							//-----------get line--------------//				
							}
					}); 
				}
				else 
				{
					return false;
				}
			}
			else 
			{
				alert("Please Select a record you want to update.");
			}			
		}

		
		

		function Proceed()
		{
			PayPeriod=document.getElementById("hidefocus").value;
			CheckPeriod=document.getElementById("view-payperiod").value;
			PayStatus = document.getElementById("view-paystatus").value;
			PayId = document.getElementById("view-payrollid").value;
			//alert(PayPeriod);
			if(CheckPeriod != 'NoRec')
			{
				
				if(PayStatus == "Approved")
				{
					alert("Payroll Period has Payroll Transaction with Approved Status! Denied!");
				}
				else if(PayStatus == "Created" || PayStatus == "Submitted")
				{
					alert("Payroll Period has Payroll Transaction Please Cancel the transcation: "+PayId );
				}
				else
				{
					var action = "proceed";
					$.ajax({
						type: 'GET',
						url: 'dtrformprocess.php',
						data:{action:action, PayPeriod:PayPeriod},
						beforeSend:function(){
									
							$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						},
						success: function(data) {
						    //window.location.href='daselection.php';
						    //$('#dtrContent').html(data);
						    //$('#dtrContent').html(data);
						    alert("Payroll Created.");
						    location.reload();
						    /*if(confirm("Do You want to redirect to payroll transaction?")) {
								window.location.href='payrolltransaction.php';
							}
							else 
							{
								return false;
								//alert("Payroll Created.");
								location.reload();
							}*/
					    }
					});
				}
				
			}
			else
			{
				alert("Please Import Period.");
			}
			
		}
		function ImportDtr()
		{
			//window.location.href='dtrperiodform.php';
			var action = "import";
			$.ajax({
				type: 'GET',
				url: 'dtrformprocess.php',
				data:{action:action, PayId:so},
				success: function(data) {
				    window.location.href='dtrperiodform.php';
				    //$('#result').html(data);
			    }
			});
		}

		function LoadDtr()
		{
			//window.location.href='dtrperiodform.php';
			var action = "load";
			$.ajax({
				type: 'GET',
				url: 'dtrformprocess.php',
				data:{action:action, PayId:so},
				success: function(data) {
				    window.location.href='dtrperiodform.php';
			    }
			});
		}

		function Cancel()
		{
			var action = "unload";
			$.ajax({
				type: 'GET',
				url: 'dtrformprocess.php',
				data:{action:action, PayId:so},
				success: function(data) {
				    window.location.href='menu.php?list='+ActiveMode;
			    }
			});
		}

		function PrintDtr(){
		
		 var soc = "<?php echo $dataareaid; ?>"; 
		 var so = "<?php echo $payrollperiod; ?>"; 
		 if(so==""){
		 	alert("No Selected Payroll");
		 }else{
		 	
		 	window.open('Reports/payslip/dtrreport.php?payroll='+so+'&soc='+soc+'', "_blank"); 
		 }
		 
		
		}

	</script>
	
	<script type="text/javascript" src="js/custom.js">
	</script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>