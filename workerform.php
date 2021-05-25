<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Worker</title>

	<!--
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body>
-->
	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->


	<!-- begin LEFT PANEL -->
	<div id="leftpanel" class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<!--<li><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>-->
			<li class="WorkersMaintain" style="display: none;"><button id="modaltableBtn1"><span class="fa fa-plus"></span> Create Record</button>
			<!-- <li class="WorkersMaintain" style="display: none;"><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li> -->
			<li class="WorkersMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
			
			<!-- <li ><a href="uploaderformprocess.php?file_id=<?php echo 'Payso_Worker.csv' ?>"><span class="far fa-clock hidden-xs hidden-sm"></span> Night Differencial</a></li> -->
			
		</ul>

		<!-- extra buttons -->
		<ul class="mainbuttons">
			<li>
				<div class="btn-group dropright mainbuttons-dropdown-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="far fa-file-alt fa"></span> Certificates <span class="fas fa-angle-right right"></span>
					</button>
					<div class="dropdown-menu mainbuttons-dropdown-menu">
						<!-- sub link -->
						<ul>
							<li class="WorkersMaintain" style="display: none;"><button onClick="generateCOE()"><span class="fa fa-plus"></span> COE</button></li>
							<li class="LoanFileMaintain LoanFileView" style="display: none;"><button onClick="generateHDMFCert()"><span class="fa fa-plus"></span> HDMF</button></li>
							<li class="LeaveFileMaintain LeaveFileView" style="display: none;"><button onClick="generateSSSCert()"><span class="fa fa-plus"></span> SSS</button></li>
							<li class="WorkersMaintain" style="display: none;"><button onClick="generatePHICCert()"><span class="fa fa-plus"></span> PHIC</button></li>

						</ul>
					</div>
				</div>
			</li>

			<li>
				<div class="btn-group dropright mainbuttons-dropdown-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="far fa-file-alt fa"></span> Upload/Export <span class="fas fa-angle-right right"></span>
					</button>
					<div class="dropdown-menu mainbuttons-dropdown-menu">
						<!-- sub link -->
						<ul>
							<li class="WorkersMaintain" style="display: none;"><button onClick="Upload()"><span class="fa fa-plus"></span> Documents</button></li>
							<li><button onClick="generateMemo();"><span class="fa fa-plus fa-lg"></span> Memo</button></li>
							<li><button onClick="Export();"><span class="fa fa-plus fa-lg"></span> Generate Template</button></li>
							<li><button id="myUploadBtn"><span class="fa fa-plus"></span> Upload Record</button></li>

						</ul>
					</div>
				</div>
			</li>
		</ul>


		<ul class="extrabuttons WorkersMaintain" style="display: none;">
			<div class="leftpanel-title"><b>SET</b></div>
			<li class="WorkersMaintain" style="display: none;"><button onClick="SetContract()"><span class="fa fa-plus"></span> Set Contracts</button></li>
			<li class="LoanFileMaintain LoanFileView" style="display: none;"><button onClick="SetLoan()"><span class="fa fa-plus"></span> Set Loan File</button></li>
			<li class="LeaveFileMaintain LeaveFileView" style="display: none;"><button onClick="SetLeave()"><span class="fa fa-plus"></span> Set Leave File</button></li>
			<li class="WorkersMaintain" style="display: none;"><button onClick="Enroll()"><span class="fa fa-plus"></span> Enroll To Portal</button></li>
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
							<span class="fa fa-archive"></span> Worker
						</div>
						<div class="mainpanel-sub">
							<!-- cmd 
							<div class="mainpanel-sub-cmd">
								<a href="" class="cmd-create"><span class="far fa-plus-square"></a>
								<a href="" class="cmd-update"><span class="fas fa-edit"></a>
								<a href="" class="cmd-delete"><span class="far fa-trash-alt"></a>
									<span class="mainpanel-sub-space">|</span>
								<a href="" class="cmd-others"><span class="fas fa-caret-up"></a>
								<a href="" class="cmd-others"><span class="fas fa-caret-down"></a>
									<span class="mainpanel-sub-space">|</span>
								<a href="" class="cmd-print"><span class="fas fa-print"></a>
							</div>-->
						</div>
						<!-- tableheader -->
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowB rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:19%;">Worker ID</td>
										<td style="width:19%;">Name</td>
										<td style="width:19%;">Position</td>
										<td style="width:19%;">Branch</td>
										
										<td style="width: 17px;"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

									  <td><input style="width:100%;height: 20px;" list="SearchWorker" class="search">
										<?php
											$query = "SELECT distinct workerid FROM worker where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchWorker">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["workerid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM worker where dataareaid = '$dataareaid'";
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
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct name FROM department where dataareaid = '$dataareaid'";
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
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct name FROM department where dataareaid = '$dataareaid'";
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
									 
									  <td><span></span></td>
									  
									</tr>
								</thead>
								
								<tbody id="result">
									<?php
									$query = "SELECT wk.workerid,wk.Name,pos.name as 'position',format(wk.serviceincentiveleave,2) as serviceincentiveleave,
													format(wk.birthdayleave,2) as birthdayleave,wk.birdeclared,
												lastname,firstname,middlename,STR_TO_DATE(birthdate, '%Y-%m-%d') birthdate,STR_TO_DATE(regularizationdate, '%Y-%m-%d') regularizationdate,STR_TO_DATE(inactivedate, '%Y-%m-%d') inactivedate,bankaccountnum,address,contactnum
													,STR_TO_DATE(datehired, '%Y-%m-%d') as datehired,phnum,pagibignum,tinnum,sssnum
													,case when wk.employmentstatus = 0 then 'Normal' 
													when wk.employmentstatus = 1 then 'New'
													when wk.employmentstatus = 2 then 'Separated'
													else '' end as employmentstatus
													,wk.employmentstatus as employmentstatusid
													,wk.inactive
													,wk.position as posid
													,wk.branch
													,wk.BioId
													,wk.internalId
													,wk.activeonetimeded
													,bra.name as branchname
													,wk.payrollgroup

													FROM worker wk
													left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid
													left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
													where wk.dataareaid = '$dataareaid' order by wk.name asc";
									$result = $conn->query($query);
									$rowclass = "rowA";
									$rowcnt = 0;
									while ($row = $result->fetch_assoc())
									{ 
										$rowcnt++;
											if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
											else { $rowclass = "rowA";}
										?>
										<tr class="<?php echo $rowclass; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:19%;"><?php echo $row['workerid'];?></td>
											<td style="width:19%;"><?php echo $row['Name'];?></td>
											<td style="width:19%;"><?php echo $row['position'];?></td>
											<td style="width:19%;"><?php echo $row['branchname'];?></td>
											
											<td style="display:none;width:1%;"><?php echo $row['birthdayleave'];?></td>
											<td style="display:none;width:1%;"><input type="checkbox" name="chkbox" class="checkbox"  value="true" <?php echo ($row['birdeclared']==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['birdeclared'];?></div></td>
											<td style="display:none;width:1%;"><?php echo $row['firstname'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['middlename'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['lastname'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['birthdate'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['inactivedate'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['regularizationdate'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['bankaccountnum'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['address'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['contactnum'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['datehired'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['phnum'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['pagibignum'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['tinnum'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['sssnum'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['employmentstatus'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['inactive'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['posid'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['employmentstatusid'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['branch'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['BioId'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['internalId'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['activeonetimeded'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['payrollgroup'];?></td>
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">	
								</span>
							</table>
						</div>
						<div class="spacer">&nbsp;</div>
					</div>
				</div>
				<!-- end TABLE AREA -->


				
				<!-- start FORM -->
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- tableheader -->
						<form id="ViewForm" action="workerform_submit" method="get" accept-charset="utf-8">
							<div class="half">
								<div class="row">
									<div class="formset">

										<!-- left -->
										<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
											
											<div class="formpic">
												<img src="images/pic.jpg">
											</div>
											<div class="formitem">
												<div class="text-center">Worker ID:</div>
												<input type="textbox" name ="view-Wid" id="view-wid"  class="textbox text-center width-full">
											</div>

										</div>

										<!-- middle -->
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
											<div class="mainpanel-title">
												<span class="fa fa-archive"></span> Personal Info
											</div>
											
											<div class="formitem">
												<br><br>Full Name:<br>
												<input type="text" class="textbox width-xs" placeholder="First Name" name ="view-Fname" id="view-fname">
												<input type="text" class="textbox width-xs" placeholder="Middle Name" name ="view-Mname" id="view-mname">
												<input type="text" class="textbox width-xs" placeholder="Last Name" name ="view-Lname" id="view-lname">
											</div>
											<div class="formitem">
												<span class="label-xl">Birthdate:</span>
												<input type="date" name ="view-Bday" id="view-bday" class="textbox" style="width: 185px;">
											</div>
											<div class="formitem">
												<span class="label-xl">Inactive date:</span>
												<input type="date" name ="view-Incdate" id="view-incdate" class="textbox" style="width: 185px;">

												<span class="label-xs">Inactive:</span>
												<input type="checkbox" value="1" name ="view-Inc" id="view-inc" style="width: 50px;height: 25px;position: absolute;" onclick="return false;">
											</div>
											<div class="formitem">
												<span class="label-xl">Regularization:</span>
												<input type="date" name ="view-Regdate" id="view-regdate" class="textbox" style="width: 185px;">
											</div>
											<div class="formitem">
												<span class="label-xl">Bank Account:</span>
												<input type="text" name ="view-BankAcc" id="view-bankacc" class="textbox" style="width: 185px;">
											</div>
											<div class="formitem">
												Address:<br>
												<input type="text" name ="view-Address" id="view-address" class="textbox width-full">
											</div>
											<div class="formitem">
												<span class="label-xl">Phone No.:</span>
												<input type="text" class="textboxsmall" name ="view-Pref" id="view-pref" value="+63" readonly  style="width: 35px;">
												<input type="text" class="textbox" name ="view-Contact" id="view-contact" class="width-lg" style="width: 155px;">
											</div>
											<div class="formitem">
													<span class="label-lg">Internal ID:</span>
													<input type="text" name ="view-internalid" id="view-internalid" class="textbox" style="margin-left: 25px;width: 188px;">
												
													<span class="label-lg" style="margin-left: 25px;width: 50px;">Bio ID:</span>
													<input type="text" name ="view-bioid" id="view-bioid" class="textbox" style="margin-left: 5px;width: 200px;">
											</div>
											<div class="formitem">
													Payroll Group:
													<input type="text" name ="view-PayGroup" id="view-paygroup" class="textbox" style="margin-left: 18px;width: 185px;">
														
											</div>
										</div>

										<!-- right -->
										<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
											<div class="mainpanel-title">
												<span class="fa fa-archive"></span> General Info
											</div>

											<div class="formitem">
												<br><br><span class="label-lg">Position:</span>
												<input type="text" class="textbox" name ="view-Position" id="view-position" class="width-lg">
											</div>

											
											<div class="formitem">
												<span class="label-lg">Date Hired:</span>
												<input type="date" name ="view-Hiredate" id="view-hiredate" class="textbox" style="width: 185px;">
											</div>
											<div class="formitem">
												<span class="label-lg">Status:</span>
												<input type="text" name ="view-Empstatus" id="view-empstatus" class="textbox">
												<!--<select class="formitem width-sm" name ="view-Empstatus" id="view-empstatus" class="textbox">
													<option value="0" selected="selected">Regular</option>
													<option value="1">Reliever</option>
													<option value="2">Probationary</option>
													<option value="3">Contractual</option>
													<option value="4">Trainee</option>
												</select>-->
											</div>
											<div class="formitem">
												<span class="label-lg">PhilHealth:</span>
												<input type="text" name ="view-Philnum" id="view-philnum" class="textbox">
											</div>
											<div class="formitem">
												<span class="label-lg">Pag-ibig:</span>
												<input type="text" name ="view-Pibig" id="view-pibig" class="textbox">
											</div>
											<div class="formitem">
												<span class="label-lg">TIN:</span>
												<input type="text" name ="view-Tin" id="view-tin" class="textbox" >
											</div>
											<div class="formitem">
												<span class="label-lg">SSS:</span>
												<input type="text" name ="view-SSS" id="view-sss" class="textbox">
											</div>
											<div class="formitem">
												<span class="label-lg">One Time Deduction:</span>
												<input type="checkbox" value="1" name ="view-dec" id="view-dec" style="width: 35px;height: 25px;position: absolute;" onclick="return false;">
											</div>

										</div>



									</div>
								</div>
							</div>
							<br>
							<!--<hr>
							<div class="text-center">
								<input type="reset" class="btn btn-danger" value="Reset">
								<input type="button" class="btn btn-primary" value="Save Changes">
							</div>-->
						</form>	
					</div>
				</div>
				<!-- end FORM -->



				<!-- start TABLE AREA -->
				<!-- end TABLE AREA -->
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
				<div class="col-lg-6">add info</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<div class="row">

				

				</div>

				<div class="button-container">
					
				</div>
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
				<div class="col-lg-6">Worker Info</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close-1"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<!-- begin MAINPANEL -->
				<div class="row">

					<!-- start FORM -->
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
						<div class="mainpanel-content">
							<!-- tableheader -->
							<form name="addForm" action="workerprocess.php" method="get" accept-charset="utf-8">
								<div class="half">
									<div class="row">
										<div class="formset">

											<!-- left -->
											<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
												
												<div class="formpic">
													<img src="images/pic.jpg">
												</div>
												<div class="formitem">
													<div class="text-center">Worker ID:</div>
													<div id="resultid">
														<input type="text" placeholder="Worker Id" name ="Wid" id="add-wid"  class="textbox text-center width-full" required="required">
													</div>
												</div>

											</div>

											<!-- middle -->
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<div class="mainpanel-title">
													<span class="fa fa-archive"></span> Personal Info
												</div>
												
												<div class="formitem">
													*Full Name:<br>
													<input type="text" class="textbox width-xs" placeholder="First Name" name ="Fname" id="add-fname" required="required">
													<input type="text" class="textbox width-xs" placeholder="Middle Name" name ="Mname" id="add-mname" required="required">
													<input type="text" class="textbox width-xs" placeholder="Last Name" name ="Lname" id="add-lname" required="required">
												</div>
												<div class="formitem">
													<span class="label-xl">Birthdate:</span>
													<input type="date" name ="Bday" id="add-bday" class="textbox">
												</div>
												<div class="formitem">
													<span class="label-xl">Inactive date:</span>
													<input type="date" name ="Incdate" id="add-incdate" class="textbox">

													<span class="label-xs">Inactive:</span>
													<input type="checkbox" name ="Inc" id="add-inc" style="width: 50px;height: 25px;position: absolute;">
												</div>
												<div class="formitem">
													<span class="label-xl">Regularization:</span>
													<input type="date" name ="Regdate" id="add-regdate" class="textbox">
												</div>
												<div class="formitem">
													<span class="label-xl">Bank Account:</span>
													<input type="text" name ="BankAcc" id="add-bankacc" class="textbox">
												</div>
												<div class="formitem">
													Address:<br>
													<input type="text" name ="Address" id="add-address" class="textbox width-full">
												</div>
												<div class="formitem">
													<span class="label-xl">Phone No.:</span>
													<input type="text" class="textboxsmall" name ="Pref" id="add-pref" value="+63" readonly style="width: 35px;">
													<input type="text" class="textbox" name ="Contact" id="add-contact" class="width-lg">
												</div>
												<div class="formitem">
													<span class="label-lg">*Internal ID:</span>
													<input type="text" name ="InternalID" id="add-internalid" class="textbox" style="margin-left: 25px;width: 200px;" required="required">
												
													<span class="label-lg" style="margin-left: 25px;width: 70px;">*Bio ID:</span>
													<input type="text" name ="BioId" id="add-bioid" class="textbox" style="margin-left: 5px;width: 200px;" required="required">
												</div>
												<div class="formitem">
													*Payroll Group:
													<select class="formitem width-sm" name ="PayGroup" id="add-paygroup" class="textbox" style="width:200px;margin-left: 20px;" required="required">
														<option value="" selected="selected"></option>
														<option value="0">Weekly</option>
														<option value="1">Semi-Monthly</option>
														</select>
												</div>
												<input type="hidden" name ="AccInc" id="inchide" value="" class="modal-textarea">
												
											</div>

											<!-- right -->
											<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
												<div class="mainpanel-title">
													<span class="fa fa-archive"></span> General Info
												</div>

												<div class="formitem">
													Position:
													<select class="formitem width-lg" class="textbox" name ="Position" id="add-position" style="margin-left: 30px;width: 200px;">
														<option value="" selected="selected"></option>
														<?php
															$query = "SELECT distinct positionid,name FROM position where dataareaid = '$dataareaid'";
															$result = $conn->query($query);			
															  	
																while ($row = $result->fetch_assoc()) {
																?>
																	<option value="<?php echo $row["positionid"];?>"><?php echo $row["name"];?></option>
															<?php } ?>
													</select>
												</div>
												<div class="formitem">
													*Branch:
													<select class="formitem width-lg" class="textbox" name ="Branch" id="add-branch" style="margin-left: 38px;width: 200px;" required="required">
														<option value="" selected="selected"></option>
														<?php
															$query = "SELECT distinct branchcode,name FROM branch where dataareaid = '$dataareaid'";
															$result = $conn->query($query);			
															  	
																while ($row = $result->fetch_assoc()) {
																?>
																	<option value="<?php echo $row["branchcode"];?>"><?php echo $row["name"];?></option>
															<?php } ?>
													</select>
												</div>
												<div class="formitem">
													<span class="label-lg">Date Hired:</span>
													<input type="date" name ="Hiredate" id="add-hiredate" class="textbox">
												</div>
												<div class="formitem">
													Status:
													<select class="formitem width-sm" name ="Empstatus" id="add-empstatus" class="textbox" style="width:200px;margin-left: 43px;">
														<option value="0" selected="selected">Normal</option>
														<option value="1">New</option>
														<option value="2">Separeted</option>
														</select>
												</div>
												<div class="formitem">
													<span class="label-lg">PhilHealth:</span>
													<input type="text" name ="Philnum" id="add-philnum" class="textbox">
												</div>
												<div class="formitem">
													<span class="label-lg">Pag-ibig:</span>
													<input type="text" name ="Pibig" id="add-pibig" class="textbox">
												</div>
												<div class="formitem">
													<span class="label-lg">*TIN:</span>
													<input type="text" name ="Tin" id="add-tin" class="textbox" required="required">
												</div>
												<div class="formitem">
													<span class="label-lg">SSS:</span>
													<input type="text" name ="SSS" id="add-sss" class="textbox">
												</div>
												<div class="formitem">
													<span class="label-lg">One Time Deduction:</span>
													<input type="checkbox" value="0" name ="add-dec" id="add-dec" style="width: 35px;height: 25px;position: absolute;">
												</div>
												<input type="hidden" name ="dec" id="dechide" value="0" class="modal-textarea">
											</div>

										</div>
									</div>
								</div>
								<br>
								<hr>
								<div class="text-center" class="button-container">
									<!--<input type="reset" class="btn btn-danger" value="Reset">
									<input type="button" class="btn btn-primary" value="Save Changes">-->
									<button id="addbt" name="save" value="save" class="btn btn-primary btn-action">Save</button>
									<button id="upbt" name="update" value="update" class="btn btn-success btn-action" onclick="return validateForm()">Update</button>
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

<!-- The Modal -->
<div id="myModalUpload" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">File Uploader</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close-i"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm"  action="workerupload.php" method="post" enctype="multipart/form-data">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<!-- <label>File Type:</label>
							<input type="text" value="" placeholder="File Type" name ="filetype" id="add-filetype" class="modal-textarea" required="required"> -->

							<label>Chose CSV File:</label><br>
							<input type="file" name="myfile" id="myfile">

							<p class="help-block">Only CSV File is accepted to Import.</p>
						</div>
						
						

					</div>

					<div class="button-container">
						<button type="submit" id="addbtUpload" name="saveUpload" value="saveUpload" class="btn btn-primary btn-action">Upload</button>
						
						<button onClick="test()" type="button" value="Reset" class="btn btn-danger" >Clear</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end modal-->


<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	 <script  type="text/javascript">

	  	var so='';
	  	var mname;
	  	var lname;
	  	var fname;
	  	var bdate;
	  	var indate;
	  	var inc;
	  	var regdate;
	  	var bankacc;
	  	var addr;
	  	var cont;
	  	var position;
	  	var hiredate;
	  	var empstatus;
	  	var phnum;
	  	var pibignum;
	  	var tinnum;
	  	var sssnum;
	  	var posid;
	  	var empstatusid;
	  	var branch;
	  	var ck;
	  	var internalid;
	  	var bioid;
	  	var dec;
	  	var locbranch;
	  	var locpaygroup;
	  	var locpaygroupVal;
	  	var fullname;

		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			fullname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			position = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
			locbranch = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
			fname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
			mname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
			lname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
			bdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
			indate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
			regdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
			bankacc = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
			addr = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(14)").text();
			cont = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(15)").text();
			hiredate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(16)").text();
			phnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(17)").text();
			pibignum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(18)").text();
			tinnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(19)").text();
			sssnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(20)").text();
			empstatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(21)").text();
			inc = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(22)").text();
			posid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(23)").text();
			empstatusid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(24)").text();
			branch = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(25)").text();
			bioid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(26)").text();
			internalid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(27)").text();
			dec = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(28)").text();
			locpaygroup = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(29)").text();
			if(inc == 1)
			    {
			    	ck = true;
			    }
			    else
			    {
			    	ck = false;
			    }

			 if(locpaygroup == 0)
			 {
			 	locpaygroupVal = "Weekly";
			 }
			 else
			 {
			 	locpaygroupVal = "Semi-Monthly";
			 }
			    
			so = usernum.toString();
			document.getElementById("hide").value = so;
			document.getElementById("view-wid").value = so.toString();
			document.getElementById("view-fname").value = fname.toString();
			document.getElementById("view-mname").value = mname.toString();
			document.getElementById("view-lname").value = lname.toString();

			
			$('#view-bday').val(bdate.toString());
			$('#view-incdate').val(indate.toString());
			document.getElementById("view-inc").checked = ck;
			$('#view-regdate').val(regdate.toString());
			document.getElementById("view-bankacc").value = bankacc.toString();
			document.getElementById("view-address").value = addr.toString();
			document.getElementById("view-contact").value = cont.toString();
			document.getElementById("view-bioid").value = bioid.toString();
			document.getElementById("view-internalid").value = internalid.toString();
			document.getElementById("view-paygroup").value = locpaygroupVal.toString();

			
			document.getElementById("view-position").value = position.toString();
			$('#view-hiredate').val(hiredate.toString());
			document.getElementById("view-empstatus").value = empstatus.toString();
			document.getElementById("view-philnum").value = phnum.toString();
			document.getElementById("view-pibig").value = pibignum.toString();
			document.getElementById("view-tin").value = tinnum.toString();
			document.getElementById("view-sss").value = sssnum.toString();
			if(dec == 1)
			{
				document.getElementById("view-dec").checked = true;
			}
			else
			{
				document.getElementById("view-dec").checked = false;
			}
			
			
			
			//alert(document.getElementById("hide").value);
			//alert(so);	
						  
				});
			});

		$(document).ready(function(){
        	$("#ViewForm :input").prop("disabled", true);
        	$("#view-inc").prop("disabled", false);
        	$("#view-dec").prop("disabled", false);

    	});

    	$('#add-inc').change(function(){
		    if($(this).attr('checked'))
		    {
          		$(this).val('1');
          		document.getElementById("inchide").value =1;
		    }
		    else
		    {
		         $(this).val('0');
		         document.getElementById("inchide").value=0;
		    }
		 });

    	$('#add-dec').change(function(){
		    if($(this).attr('checked'))
		    {
          		$(this).val('1');
          		document.getElementById("dechide").value =1;
		    }
		    else
		    {
		         $(this).val('0');
		         document.getElementById("dechide").value=0;
		    }
		 });



		// Get the modal -------------------
		var modal = document.getElementById('myModal');
		// Get the button that opens the modal
		//var CreateBtn = document.getElementById("myAddBtn");
		
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("modal-close")[0];
		// When the user clicks the button, open the modal 
		/*CreateBtn.onclick = function() {
		    modal.style.display = "block";
		    document.getElementById("upbt").style.visibility = "visible";

		    document.getElementById("addbt").style.visibility = "visible";
		}*/
		
		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
		    modal.style.display = "none";
		    Clear();
		}
		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
		    if (event.target == modal || event.target == modal2) {
		        modal.style.display = "none";
		        Clear()
		        
		    }
		}

		// modal table 1
		var modal1 = document.getElementById('myModal1');
		// Get the button that opens the modal
		var openBtn1 = document.getElementById("modaltableBtn1");
		var UpdateBtn = document.getElementById("myUpdateBtn");
		// Get the <span> element that closes the modal
		var span1 = document.getElementsByClassName("modal-close-1")[0];
		// When the user clicks the button, open the modal 
		openBtn1.onclick = function() {
		    $("#myModal1").stop().fadeTo(500,1);
		    //modal1.style.display = "block";
		    document.getElementById("upbt").style.visibility = "visible";
		    document.getElementById("upbt").disabled = true;
		    document.getElementById("addbt").disabled = false;
		    document.getElementById("addbt").style.visibility = "visible";

		    document.getElementById("add-inc").disabled = true;
		    document.getElementById("add-incdate").disabled = true;
		    var action = "add";
		    $.ajax({
						type: 'GET',
						url: 'workerprocess.php',
						data:{action:action},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							//$("#result").html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#resultid').html(data);
							$("#add-wid").prop('readonly', true); 
				}
			});
		    
		}

		UpdateBtn.onclick = function() {
			if(so != '') {
			    $("#myModal1").stop().fadeTo(500,1);

			    if(ck == true)
				    {
		          		
		          		document.getElementById("inchide").value =1;
				    }
				    else
				    {
				         
				         document.getElementById("inchide").value=0;
				    }


			    document.getElementById("upbt").style.visibility = "visible";
			    document.getElementById("addbt").style.visibility = "visible";
		   		document.getElementById("addbt").disabled = true;
		   		document.getElementById("upbt").disabled = false;

		   		document.getElementById("add-inc").disabled = false;
		   		document.getElementById("add-incdate").disabled = false;
		   		

			    document.getElementById("add-wid").value = so.toString();
				document.getElementById("add-fname").value = fname.toString();
				document.getElementById("add-mname").value = mname.toString();
				document.getElementById("add-lname").value = lname.toString();

				
				$('#add-bday').val(bdate.toString());
				$('#add-incdate').val(indate.toString());
				//document.getElementById("add-inc").checked 
				document.getElementById("add-inc").checked = ck;
				$('#add-regdate').val(regdate.toString());
				document.getElementById("add-bankacc").value = bankacc.toString();
				document.getElementById("add-address").value = addr.toString();
				document.getElementById("add-contact").value = cont.toString();
				document.getElementById("add-bioid").value = bioid.toString();
				document.getElementById("add-internalid").value = internalid.toString();
				document.getElementById("add-paygroup").value = locpaygroup.toString();

				
				document.getElementById("add-position").value = posid.toString();
				document.getElementById("add-branch").value = branch.toString();
				$('#add-hiredate').val(hiredate.toString());
				document.getElementById("add-empstatus").value = empstatusid.toString();
				document.getElementById("add-philnum").value = phnum.toString();
				document.getElementById("add-pibig").value = pibignum.toString();
				document.getElementById("add-tin").value = tinnum.toString();
				document.getElementById("add-sss").value = sssnum.toString();
				document.getElementById("dechide").value = dec;
				if(dec == 1)
				{
					document.getElementById("add-dec").checked = true;
				}
				else
				{
					document.getElementById("add-dec").checked = false;
				}
			    
			}
			else 
			{
				alert("Please Select a record you want to update.");
			}
		}
		// When the user clicks on <span> (x), close the modal
		span1.onclick = function() {
		    modal1.style.display = "none";
		    //$("#myModal1").stop().fadeTo(500,0);
		    Clear();
		}
		//end modal --------------------------- 

		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var DeptId;
			var name;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 WorkerId = data[0];
			 name = data[1];

			 $.ajax({
						type: 'GET',
						url: 'workerprocess.php',
						data:{action:action, actmode:actionmode, WorkerId:WorkerId, name:name},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#result').html(data);
							$(document).ready(function(){
							$('#datatbl tbody tr').click(function(){
								$('table tbody tr').css("color","black");
								$(this).css("color","red");
								$('table tbody tr').removeClass("info");
								$(this).addClass("info");
								var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
								fullname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
								position = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
								locbranch = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
								fname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
								mname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
								lname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
								bdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
								indate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
								regdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
								bankacc = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
								addr = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(14)").text();
								cont = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(15)").text();
								hiredate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(16)").text();
								phnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(17)").text();
								pibignum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(18)").text();
								tinnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(19)").text();
								sssnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(20)").text();
								empstatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(21)").text();
								inc = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(22)").text();
								posid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(23)").text();
								empstatusid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(24)").text();
								branch = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(25)").text();
								bioid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(26)").text();
								internalid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(27)").text();
								dec = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(28)").text();
								locpaygroup = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(29)").text();
								if(inc == 1)
								    {
								    	ck = true;
								    }
								    else
								    {
								    	ck = false;
								    }

								 if(locpaygroup == 0)
								 {
								 	locpaygroupVal = "Weekly";
								 }
								 else
								 {
								 	locpaygroupVal = "Semi-Monthly";
								 }
								    
								so = usernum.toString();
								document.getElementById("hide").value = so;
								document.getElementById("view-wid").value = so.toString();
								document.getElementById("view-fname").value = fname.toString();
								document.getElementById("view-mname").value = mname.toString();
								document.getElementById("view-lname").value = lname.toString();

								
								$('#view-bday').val(bdate.toString());
								$('#view-incdate').val(indate.toString());
								document.getElementById("view-inc").checked = ck;
								$('#view-regdate').val(regdate.toString());
								document.getElementById("view-bankacc").value = bankacc.toString();
								document.getElementById("view-address").value = addr.toString();
								document.getElementById("view-contact").value = cont.toString();
								document.getElementById("view-bioid").value = bioid.toString();
								document.getElementById("view-internalid").value = internalid.toString();
								document.getElementById("view-paygroup").value = locpaygroupVal.toString();

								
								document.getElementById("view-position").value = position.toString();
								$('#view-hiredate').val(hiredate.toString());
								document.getElementById("view-empstatus").value = empstatus.toString();
								document.getElementById("view-philnum").value = phnum.toString();
								document.getElementById("view-pibig").value = pibignum.toString();
								document.getElementById("view-tin").value = tinnum.toString();
								document.getElementById("view-sss").value = sssnum.toString();
								if(dec == 1)
								{
									document.getElementById("view-dec").checked = true;
								}
								else
								{
									document.getElementById("view-dec").checked = false;
								}
								
								
								
								//alert(document.getElementById("hide").value);
								//alert(so);	
											  
									});
								});
				}
			}); 
			 
		  }
		});
		//-----end search-----//

		function Clear()
		{
			//document.getElementById("add-wid").value = '';
			document.getElementById("add-fname").value = '';
			document.getElementById("add-mname").value = '';
			document.getElementById("add-lname").value = '';

			
			$('#add-bday').val('');
			$('#add-incdate').val('');
			document.getElementById("add-inc").checked = 0;
			document.getElementById("add-dec").checked = 0;
			$('#add-regdate').val('');
			document.getElementById("add-bankacc").value = '';
			document.getElementById("add-address").value = '';
			document.getElementById("add-contact").value = '';

			
			document.getElementById("add-position").value = '';
			document.getElementById("add-branch").value = '';
			$('#add-hiredate').val('');
			document.getElementById("add-empstatus").value = '';
			document.getElementById("add-philnum").value = '';
			document.getElementById("add-pibig").value = '';
			document.getElementById("add-tin").value = '';
			document.getElementById("add-sss").value = '';
		}

		/*function Save()
		{
			
			modal.style.display = "none";
			var DeptId = $('#add-department').val();
			var name = $('#add-name').val();
			var action = "save";
			var actionmode = "userform";
			$.ajax({	
					type: 'GET',
					url: 'departmentformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, actmode:actionmode, DeptId:DeptId, name:name},
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
			var DeptId = $('#add-department').val();
			var name = $('#add-name').val();
			var action = "update";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'departmentformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, DeptId:DeptId, name:name},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#datatbl').html(data);
							location.reload();					
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

		function Delete()
		{
			
			var action = "delete";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'departmentformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, DeptId:so},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#conttables').html(data);
							location.reload();					
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
				alert("Please Select a record you want to delete.");
			}			
		}*/

		function SetContract()
		{
			if(so != ''){
				var action = "contract";
				$.ajax({
					type: 'GET',
					url: 'workerprocess.php',
					data:{action:action, ConId:so},
					success: function(data) {
						so='';
					    window.location.href='contractform.php';
				    }
				});
			}
			else {
				alert("Please Select Worker.");
			}
		}

		function SetLoan()
		{
			if(so != ''){
				var action = "loan";
				$.ajax({
					type: 'GET',
					url: 'workerprocess.php',
					data:{action:action, workID:so},
					success: function(data) {
						so='';
					    window.location.href='loanfileform.php';
				    }
				});
			}
			else {
				alert("Please Select Worker.");
			}
		}

		function SetLeave()
		{
			if(so != ''){
				var action = "leave";
				$.ajax({
					type: 'GET',
					url: 'workerprocess.php',
					data:{action:action, workID:so},
					success: function(data) {
						so='';
					    window.location.href='leavefileform.php';
				    }
				});
			}
			else {
				alert("Please Select Worker.");
			}
		}

		function Enroll()
		{
			if(so != ''){
				var action = "enroll";
				$.ajax({
					type: 'GET',
					url: 'workerprocess.php',
					data:{action:action, workID:so},
					success: function(data) {
						//so='';
						alert("Successfully enrolled "+ fullname +". to portal.\nUsername:"+so+"\nPassword:"+so);
						//$('#datatbl').html(data);
					    //window.location.href='leavefileform.php';
				    }
				});

				//alert(so);
			}
			else {
				alert("Please Select Worker.");
			}
		}

		function Upload()
		{
			if(so != ''){
				var action = "upload";
				$.ajax({
					type: 'GET',
					url: 'workerprocess.php',
					data:{action:action, workID:so},
					success: function(data) {
						so='';
					    window.location.href='uploaderform.php';
				    }
				});
			}
			else {
				alert("Please Select Worker.");
			}
		}
		function Cancel()
		{
			window.location.href='menu.php?list='+ActiveMode;
		}

		function generateCOE()
    	{
    		if (so != "")
    		{
    			  window.open("Reports/Certificates/COE.php?worker="+so, "_blank"); 
    		}
    		else
    		{
    			alert("Please select a specific worker to generate.");
    		}
    		//alert(so);
    	}

    	function generateHDMFCert()
    	{
    		if (so != "")
    		{
    			  window.open("Reports/Certificates/HDMF.php?worker="+so, "_blank"); 
    		}
    		else
    		{
    			alert("Please select a specific worker to generate.");
    		}
    	}


    	function generateSSSCert()
    	{
    		if (so != "")
    		{
    			  window.open("Reports/Certificates/SSS.php?worker="+so, "_blank"); 
    		}
    		else
    		{
    			alert("Please select a specific worker to generate.");
    		}
    	}


    	function generatePHICCert()
    	{
    		if (so != "")
    		{
    			  window.open("Reports/Certificates/PHIC.php?worker="+so, "_blank"); 
    		}
    		else
    		{
    			alert("Please select a specific worker to generate.");
    		}
    	}
    	function generateMemo()
		{
			if(so != ''){
				var action = "memo";
				$.ajax({
					type: 'GET',
					url: 'workerprocess.php',
					data:{action:action, workID:so},
					success: function(data) {
						so='';
					    window.location.href='memoworker.php';
				    }
				});
			}
			else {
				alert("Please Select Worker.");
			}
		}

		// Get the modal -------------------
		var modalUpload = document.getElementById('myModalUpload');
		// Get the button that opens the modal
		var UploadBtn = document.getElementById("myUploadBtn");
		// Get the <span> element that closes the modal
		var Uploadspan = document.getElementsByClassName("modal-close-i")[0];
		// When the user clicks the button, open the modal 
		UploadBtn.onclick = function() {
		    //modal.style.display = "block";
		    $("#myModalUpload").stop().fadeTo(500,1);
		   
		    document.getElementById("add-filetype").value = '';
		    document.getElementById("myfile").value = '';
		    
		    document.getElementById("addbtUpload").style.visibility = "visible";
		}
		
		// When the user clicks on <span> (x), close the modal
		Uploadspan.onclick = function() {
		    modalUpload.style.display = "none";
		   // Clear();
		}
		
		//end modal --------------------------- 

		function Export()
		{
			alert(1);

			const rows = [
			    ["Employee No", "First Name", "Middle Name", "Last Name", "Birthdate", "Address", "Contact No",
			     "SSS No", "PhilHealth No", "PAG-IBIG No", "TIN No", "Bank Account", "Branch Code", "Position Code", 
			     "Date Hired", "Employement Status", "Regularization Date", "Bio ID", "Payroll Type"]
			];

			let csvContent = "data:text/csv;charset=utf-8,";

			rows.forEach(function(rowArray) {
			    let row = rowArray.join(",");
			    csvContent += row + "\r\n";
			});

			var encodedUri = encodeURI(csvContent);
			var link = document.createElement("a");
			link.setAttribute("href", encodedUri);
			link.setAttribute("download", "Payso_Worker.csv");
			document.body.appendChild(link); // Required for FF

			link.click(); // This will download the data file named "my_data.csv".

		}
    	
</script>
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>
