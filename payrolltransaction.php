<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$firstresult = '';
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Payroll Transaction</title>

	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body oncontextmenu="return false">-->



	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->



	<!-- begin LEFT PANEL -->
	<div id="leftpanel" class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li class="PayrollTransactionMaintain" style="display: none;"><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>
			<!--<li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>-->
			<!-- <li><button onClick="AmountExempt();"><span class="fa fa-arrow-circle-left fa-lg"></span> Amount Exemption</button></li> -->
			<li class="PayrollTransactionMaintain" style="display: none;"><button id='RecomputeBtn' onClick="Recompute();"><span class="fas fa-calculator fa"></span> Recompute</button></li>
			<li><button onClick="Back();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>
		
		<!-- extra buttons -->
		<ul class="extrabuttons">
		
			<!-- TOGGLE POSITION -->
			<!--
			<li>
				
				<div class="hidden-sm hidden-xs">
					<button id="changeposition-6-button" class=""><span class="fas fa-window-restore"></span> Change Position</button>
					<button id="changeposition-12-button" class="hide"><span class="fas fa-window-restore fa-rotate-270"></span> Change Position</button>
				</div>
			
			</li>
			-->

			
			<div class="leftpanel-title"><b>Line Details</b></div>
			<li><button onClick="linedetails()"><span class="fa fa-edit"></span>Lines</button></li>
			<!--<li><button onClick="loadNet()"><span class="fa fa-edit"></span>samp</button></li>
			<li><button id="modaltableBtn1"><span class="fa fa-cog"></span> Modal Table 1</button>
			<li><button id="modaltableBtn2"><span class="fa fa-cog"></span> Modal Table 2</button>-->

		</ul>

		<ul class="mainbuttons">
			<li>
				<div class="btn-group dropright mainbuttons-dropdown-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="far fa-file-alt fa"></span> Print Options <span class="fas fa-angle-right right"></span>
					</button>
					<div class="dropdown-menu mainbuttons-dropdown-menu">
						<!-- sub link -->
						<ul>
							<li><button onClick="printPayrollDraft()"><span class="fa fa-edit"></span>Payroll - Draft</button></li>
							<li><button onClick="printPayroll()"><span class="fa fa-edit"></span>Payroll</button></li>
							<li><button onClick="printPayslip()"><span class="fa fa-edit"></span>Payslip</button></li>

						</ul>
					</div>
				</div>
			</li>
		</ul>

		<ul class="subbuttons PayrollTransactionMaintain" style="display: none;">
			<div class="leftpanel-title"><b>PROCESS</b></div>
			<li><button name='CtrStatus' id='SubmitBtn' onClick="Submit();"><span class="fa fa-paper-plane"></span> Submit</button></li>
			<li class="PayrollTransactionApprove" style="display: none;"><button name='CtrStatus' id='ApproveBtn' onClick="Approve();"><span class="fa fa-thumbs-up"></span> Approve</button></li>
			<li class="PayrollTransactionApprove" style="display: none;"><button name='CtrStatus'><span class="fa fa-thumbs-down"></span> Disapprove</button></li>
			<li><button name='CtrStatus' id='CancelBtn' onClick="Cancel();"><span class="fa fa-ban"></span> Cancel</button></li>
			<li><button name='CtrStatus' id='RevertBtn' onClick="Revert();"><span class="fa fa-history"></span> Revert</button></li>
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
							<span class="fa fa-archive"></span> Payroll Transaction
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
							</div> -->
						</div>
						<!-- tableheader -->
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:20%;">Branch</td>
										<td style="width:10%;">Payment Type</td>
										<td style="width:15%;">Payroll ID</td>
										<td style="width:15%;">Payroll Period</td>
										<td style="width:15%;">From Date</td>
										<td style="width:15%;">To Date</td>
										<td style="width:15%;">Status</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchBranch" class="search">
										<?php
											$query = "SELECT distinct bh.name as branch
														from payrollheader ph 
														left join branch bh on ph.branchcode = bh.branchcode and ph.dataareaid = bh.dataareaid
														where ph.dataareaid = '$dataareaid' 
														";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchBranch">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["branch"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchPayment" class="search" >
										
										<?php
											$query = "SELECT distinct case              
															when paymenttype = 0 then 'Cash' 
															when paymenttype = 1 then 'ATM' 
														else '' end as 'Payment' 
														from payrollheader ph 
														left join branch bh on ph.branchcode = bh.branchcode and ph.dataareaid = bh.dataareaid
														where ph.dataareaid = '$dataareaid' 
														";
											$result = $conn->query($query);	
												
										  ?>
										<datalist id="SearchPayment">
											
											<?php 
											
												while ($row = $result->fetch_assoc()) {
											?>
												<option value="<?php echo $row["Payment"];?>"></option>
												
										<?php } ?>
										</datalist>		
										
									  </td>
									  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchId" class="search">
										<?php
											$query = "SELECT distinct distinct ph.payrollid from payrollheader ph where ph.dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchId">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["payrollid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchPeriod" class="search">
										<?php
											$query = "SELECT distinct ph.payrollperiod from payrollheader ph where ph.dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPeriod">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["payrollperiod"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td style="width:14%;"><input type="date" style="width:100%;height: 20px;" list="SearchFromDate" class="search">
										
									  </td>
									  <td style="width:14%;"><input type="date" style="width:100%;height: 20px;" list="SearchToDate" class="search">
										
										
									  </td>
									  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchStatus" class="search" disabled>
										<?php
											$query = "SELECT distinct case when payrollstatus = 0 then 'Created' 
														when payrollstatus = 1 then 'Submitted' 
														when payrollstatus = 2 then 'Canceled' 
														when payrollstatus = 3 then 'Approved' 
														when payrollstatus = 4 then 'Disapproved' 
													else '' end as 'status' from payrollheader ph where ph.dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchStatus">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["status"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><span></span></td>
									</tr>
								
								</thead>
								<tbody id="result">
										<?php	
										$query = "SELECT
												bh.name as branch,  
												case              
													when paymenttype = 0 then 'Cash' 
													when paymenttype = 1 then 'ATM' 
												else '' end as 'Payment',
												paymenttype,
												ph.payrollid, 
												ph.payrollperiod,
												date_format(fromdate, '%m-%d-%Y') fromdate, 
												date_format(todate, '%m-%d-%Y') todate,
												case when payrollstatus = 0 then 'Created' 
													when payrollstatus = 1 then 'Submitted' 
													when payrollstatus = 2 then 'Canceled' 
													when payrollstatus = 3 then 'Approved' 
													when payrollstatus = 4 then 'Disapproved' 
												else '' end as 'status',
												payrollstatus

												from payrollheader ph 
												left join branch bh on ph.branchcode = bh.branchcode and ph.dataareaid = bh.dataareaid

												where ph.dataareaid = '$dataareaid' 

												order by ph.payrollid asc
												";
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
											<tr id="<?php echo $rowcnt2?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
												<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
												<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
												<td style="width:20%;"><?php echo $row['branch'];?></td>
												<td style="width:10%;"><?php echo $row['Payment'];?></td>
												<td style="width:15%;"><?php echo $row['payrollid'];?></td>
												<td style="width:15%;"><?php echo $row['payrollperiod'];?></td>
												<td style="width:15%;"><?php echo $row['fromdate'];?></td>
												<td style="width:15%;"><?php echo $row['todate'];?></td>
												<td style="width:15%;"><?php echo $row['status'];?></td>
												<td style="display:none;width:1%;"><?php echo $row['paymenttype'];?></td>
												<td style="display:none;width:1%;"><?php echo $row['payrollstatus'];?></td>
												<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
												
											</tr>

										<?php 
										$firstresult = $row["payrollid"];
										}
										/*$result2 = $conn->query($query);
											$row2 = $result2->fetch_assoc();
											$firstresult = $row2["payrollid"];*/
										?>
											
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
									<input type="hidden" id="hidefocus" value="<?php echo $rowcnt2;?>">
								</span>
							</table>
						</div>
					</div>
					<br>
				</div>
				<!-- end TABLE AREA -->

				<!-- start TABLE AREA -->
			<div id='dtrContent'>
				<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> Account Summary
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
							</div> -->
						</div>

						<!-- table -->
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="dataln" class="table table-striped mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:20%;">Account Code</td>
										<td style="width:20%;">Name</td>
										<td style="width:20%;">UM</td>
										<td style="width:20%;">Type</td>
										<td style="width:20%;">Value</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
								
								</thead>

								<tbody id="lineresult">
										<?php	
										$query = "SELECT accountcode,
													accountname,
													um,
													case when accounttype = 0 then 'Entry'
													when accounttype = 1 then 'Computed'
													when accounttype = 2 then 'Condition'
													else 'Total'
													end as accounttype,
													format(value,2) value
													FROM payrollheaderaccounts
													where payrollid = '$firstresult'
													and dataareaid = '$dataareaid'
													order by um";
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
												<td style="width:20%;"><?php echo $row['accountcode'];?></td>
												<td style="width:20%;"><?php echo $row['accountname'];?></td>
												<td style="width:20%;"><?php echo $row['um'];?></td>
												<td style="width:20%;"><?php echo $row['accounttype'];?></td>
												<td style="width:20%;"><?php echo $row['value'];?></td>
												<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
												
											</tr>

										<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide2">
								</span>	
							</table>
						</div>
					</div>
				</div>
			</div>
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
				<div class="col-lg-6">Create Payroll Transaction</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="payrolltransactionprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Branch:</label>
							<input type="text" value="" placeholder="Branch" id="add-branch" name ="PTBranch"  list="BranchList" class="modal-textarea" required="required">
								<?php
									$query = "SELECT distinct name,branchcode FROM branch where dataareaid = '$dataareaid'";
									$result = $conn->query($query);			
							  	?>
							<datalist id="BranchList">
								<?php 
									while ($row = $result->fetch_assoc()) {
								?>
									<option value="<?php echo $row["branchcode"];?>"><?php echo $row['name'];?></option>
								<?php } ?>
							</datalist>

							<label>Payment Type:</label>
							<select  value="" placeholder="Account Type" name ="PTType" id="add-type" class="modal-textarea" style="width:100%;height: 28px;" required="required">
									<option value=""></option>
									<option value="0">Cash</option>
									<option value="1">ATM</option>
							</select>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Payroll ID:</label>
							<div id="resultid">
								<input type="text" value="" placeholder="Payroll ID" name ="PTid" id="add-id" class="modal-textarea" required="required">
							</div>
							<label>Payroll Period:</label>

							<input type="text" value="" placeholder="Payroll Period" id="add-period" name ="PTPeriod"  list="PeriodList" class="modal-textarea" required="required">

								<?php
									$query = "SELECT distinct payrollperiod,date_format(startdate, '%m-%d-%Y') startdate,date_format(enddate, '%m-%d-%Y') enddate FROM payrollperiod where dataareaid = '$dataareaid' order by payrollperiod desc";
									$result = $conn->query($query);			
							  	?>
							<datalist id="PeriodList">
								<?php 
									while ($row = $result->fetch_assoc()) {
								?>
									<option value="<?php echo $row["payrollperiod"];?>"><?php echo 'Cutoff ('.$row["startdate"].' - '.$row["enddate"].')';?></option>
								<?php } ?>
							</datalist>
						</div>

						

					</div>

					<div class="button-container">
						<button id="addbt" name="save" value="save" class="btn btn-primary btn-action">Save</button>
						<button id="upbt" name="update" value="update" class="btn btn-success btn-action" onclick="return validateForm()">Update</button>
						<button onClick="Clear();" type="button" value="Reset" class="btn btn-danger">Clear</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end modal-->



<script src="js/ajax.js"></script>
	  	<script  type="text/javascript">

	  	var so='';
	  	var payline='';
	  	var locBranch = '';
	  	var locPaymentType = '';
	  	var locPayrollPeriod = '';
	  	var locFromdate = '';
	  	var locTodate = '';
	  	var locStatus = '';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locPayrollPeriod = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locBranch = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locFromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locPaymentType = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locStatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;

				if(locStatus == 3)
				{
					$('[name=CtrStatus]').prop("disabled", true);
					$("#RecomputeBtn").prop('disabled', true); 

				}
				else if(locStatus == 2)
				{
					$('[name=CtrStatus]').prop("disabled", true);
					$("#RecomputeBtn").prop('disabled', true); 
				}
				else
				{
					$('[name=CtrStatus]').prop("disabled", false);
					$("#RecomputeBtn").prop('disabled', false);
				}
				//alert(document.getElementById("hide").value);
				//alert(locStatus);
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'payrolltransactionline2.php',
					data:{action:action, actmode:actionmode, PayId:so},
					beforeSend:function(){
					
						$("#dtrContent").html('<br><br><center><br><br><br><img src="img/loading.gif" width="400" height="300"></center>');
						
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide2").value = "";
						$('#dtrContent').html(data);
						//alert(1);

					}
				});
				//-----------get line--------------//	  
			});
		});

		function loadNet() 
		{
		  
		  
			var array = $('#hide0net').val().split(",");
			if(array != '')
		 	{
			 	$.each(array,function(i){
					alert(array[i] + ' has 0 or below 0 netpay');
				});
			}
			else
			{
				alert('Go');
		 	}
		
		  
		}

	  		$(document).ready(function(){
				$('#dataln tbody tr').click(function(){
					$('table tbody tr').css("color","black");
					$(this).css("color","orange");
					$('table tbody tr').removeClass("info");
					$(this).addClass("info");
					var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
					payline = transnumline.toString();
					document.getElementById("hide2").value = payline;
					//alert(document.getElementById("hide").value);

						loc = document.getElementById("hidefocus").value;
		            //alert(loc);
		             var pos = $("#"+loc+"").attr("tabindex");
					    $("tr[tabindex="+pos+"]").focus();
					    $("tr[tabindex="+pos+"]").css("color","red");
					    $("tr[tabindex="+pos+"]").addClass("info");
						
						  
				});
			});

		$(document).ready(function() {
			var pos = document.getElementById("hidefocus").value;
		    $("tr[tabindex="+pos+"]").focus();
		    //$("tr[tabindex=0]").focus();
		    //$("tr[tabindex="+pos+"]").css("color","red");  
		    //var idx = $("tr:focus").attr("tabindex");
		    //alert(idx);
		    //document.onkeydown = checkKey;
		});

		




	  	// Get the modal -------------------
		var modal = document.getElementById('myModal');
		// Get the button that opens the modal
		var CreateBtn = document.getElementById("myAddBtn");
		//var UpdateBtn = document.getElementById("myUpdateBtn");
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("modal-close")[0];
		// When the user clicks the button, open the modal 
		CreateBtn.onclick = function() {
		    //modal.style.display = "block";
		    $("#myModal").stop().fadeTo(500,1);
		    //$("#add-code").prop('readonly', false);
		    //document.getElementById("add-code").value ='';
		    //document.getElementById("inchide").value = 0;
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		    var action = "add";
		    $.ajax({
						type: 'GET',
						url: 'payrolltransactionprocess.php',
						data:{action:action},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							//$("#result").html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#resultid').html(data);
							$("#add-id").prop('readonly', true); 
				}
			});
		}
		/*UpdateBtn.onclick = function() {
			
			if(so != '') {
				$("#myModal").stop().fadeTo(500,1);
				//$("#add-id").prop('readonly', true);
				//document.getElementById("add-id").value = so;
				//document.getElementById("add-branch").value = locBranch;
			    document.getElementById("addbt").style.visibility = "hidden";
			    document.getElementById("upbt").style.visibility = "visible";
			}
			else 
			{
				alert("Please Select a record you want to update.");
			}
		}*/
		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
		    modal.style.display = "none";
		    //$("#myModal").stop().fadeTo(500,0);
		    Clear();
		}
		// When the user clicks anywhere outside of the modal, close it
		
		window.onclick = function(event) {
		    if (event.target == modal || event.target == modal2) {
		        modal.style.display = "none";
		        Clear();
		        
		    }
		}
		
		//end modal ---------------------------






		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var PTBranch;
			var PTPayment;
			var PTId;
			var PTPeriod;
			var PTFromDt;
			var PTToDt;
			var PTStatus;

			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 PTBranch = data[0];
			 PTPayment = data[1];
			 PTId = data[2];
			 PTPeriod = data[3];
			 PTFromDt = data[4];
			 PTToDt = data[5];
			 PTStatus = data[6];
			
			 $.ajax({
				type: 'GET',
				url: 'payrolltransactionprocess.php',
				data:{action:action, actmode:actionmode, PTPayment:PTPayment, PTBranch:PTBranch, PTId:PTId, PTPeriod:PTPeriod, PTFromDt:PTFromDt, PTToDt:PTToDt},
				//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
				beforeSend:function(){
				
					$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
	
				},
				success: function(data){
					$('#result').html(data);
					so='';
					document.getElementById("hide").value = so;
					var firstval = $('#hide3').val();
					//alert(document.getElementById("hidecount").value);
					loc = document.getElementById("hidecount").value;
		            //alert(firstval);
		             var pos = 1;
					    $("tr[tabindex="+pos+"]").focus();
					    $("tr[tabindex="+pos+"]").css("color","red");
					    $("tr[tabindex="+pos+"]").addClass("info");
					//-----------get line--------------//
						var action = "getline";
						var actionmode = "userform";
						$.ajax({
							type: 'POST',
							url: 'payrolltransactionline2.php',
							data:{action:action, actmode:actionmode, PayId:firstval},
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
					$(document).ready(function(){
						$('#datatbl tbody tr').click(function(){
							$('table tbody tr').css("color","black");
							$(this).css("color","red");
							$('table tbody tr').removeClass("info");
							$(this).addClass("info");
							var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
							locPayrollPeriod = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
							locBranch = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
							locFromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
							locPaymentType = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
							locStatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
							so = usernum.toString();
							document.getElementById("hide").value = so;

							if(locStatus == 3)
							{
								$('[name=CtrStatus]').prop("disabled", true);
								$("#RecomputeBtn").prop('disabled', true); 

							}
							else if(locStatus == 2)
							{
								$('[name=CtrStatus]').prop("disabled", true);
								$("#RecomputeBtn").prop('disabled', true); 
							}
							else
							{
								$('[name=CtrStatus]').prop("disabled", false);
								$("#RecomputeBtn").prop('disabled', false);
							}
							//alert(document.getElementById("hide").value);
							//alert(locStatus);
							//-----------get line--------------//
							var action = "getline";
							var actionmode = "userform";
							$.ajax({
								type: 'POST',
								url: 'payrolltransactionline2.php',
								data:{action:action, actmode:actionmode, PayId:so},
								beforeSend:function(){
								
									$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								},
								success: function(data){
									//payline='';
									//document.getElementById("hide2").value = "";
									$('#dtrContent').html(data);
									//alert(1);

								}
							});
							//-----------get line--------------//	  
						});
					});
				}
			}); 
			 
		  }
		});
		//-----end search-----//

		function linedetails()
		{
			if(so != ''){
				var action = "payline";
				$.ajax({
					type: 'GET',
					url: 'payrolltransactionprocess.php',
					data:{action:action, PayId:so, PayFrom:locFromdate, PayType:locPaymentType, PayPeriod:locPayrollPeriod, locStatus:locStatus},
					success: function(data) {
						so='';
					    window.location.href='payrolltransactiondetail.php';
				    }
				});
			}
			else {
				alert("Please Select Payroll ID.");
			}

		}

		function AmountExempt()
		{
			if(so != ''){
				var action = "exempt";
				$.ajax({
					type: 'GET',
					url: 'payrolltransactionprocess.php',
					data:{action:action, PayId:so},
					success: function(data) {
						so='';
					    window.location.href='amountexemption.php';
				    }
				});
			}
			else {
				alert("Please Select Payroll ID.");
			}

		}

		function Recompute()
		{
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			
			var action = "recompute";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'payrolltransactionprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, PTid:so},
							beforeSend:function(){
									
							$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#lineresult').html(data);
							//location.reload();
							//-----------get line--------------//
							var action = "getline";
							var actionmode = "userform";
							$.ajax({
								type: 'POST',
								url: 'payrolltransactionline2.php',
								data:{action:action, actmode:actionmode, PayId:so},
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
		function Submit()
		{

			//var SelectedVal = $('#inchide').val();
			var array = $('#hide0net').val().split(",")
			var action = "submit";
			if(so != '') {
				//alert(so);
				//alert(document.getElementById("add-include").value);
				if(locStatus == 0)
				{

					;
					if(array != '')
				 	{
					 	$.each(array,function(i){
							alert(array[i] + ' has 0 or Negative Netpay. Please review the Payroll Details before proceeding.');
						});
					}
					else
					{
						$.ajax({	
							type: 'GET',
							url: 'payrolltransactionprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, PayId:so},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//window.location.href='approverovertimeform.php';	
							//$('#datatbl').html(data);
							location.reload();					
							}
						});
				 	}
					
				}
				else
				{
					alert('Payroll Status must be created only!');
				}
				
			}
			else 
			{
				alert("Please Select a record you want to submit.");
			}
							
		}
		function Approve()
		{

			//var SelectedVal = $('#inchide').val();
			var action = "approve";
			if(so != '') {
				//alert(so);
				//alert(document.getElementById("add-include").value);
				if(locStatus == 1)
				{
					
					$.ajax({	
						type: 'GET',
						url: 'payrolltransactionprocess.php',
						//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
						data:{action:action, PayId:so, PayPeriod:locPayrollPeriod},
						beforeSend:function(){
								
						$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							
						},
						success: function(data){
						//window.location.href='approverovertimeform.php';	
						//$('#datatbl').html(data);
						location.reload();					
						}
					});
				}
				else
				{
					alert('Payroll Status must be submitted!');
				}
			}
			else 
			{
				alert("Please Select a record you want to approve.");
			}
							
		}
		function DisApprove()
		{

			//var SelectedVal = $('#inchide').val();
			var action = "disapprove";
			if(so != '') {
				//alert(so);
				//alert(document.getElementById("add-include").value);
				if(locStatus == 1)
				{
					$.ajax({	
						type: 'GET',
						url: 'payrolltransactionprocess.php',
						//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
						data:{action:action, PayId:so},
						beforeSend:function(){
								
						$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							
						},
						success: function(data){
						//window.location.href='approverovertimeform.php';	
						//$('#datatbl').html(data);
						location.reload();					
						}
					});
				}
				else
				{
					alert('Payroll Status must be submitted!');
				}
			}
			else 
			{
				alert("Please Select a record you want to approve.");
			}
							
		}
		function Revert()
		{

			//var SelectedVal = $('#inchide').val();
			var action = "revert";
			if(so != '') {
				//alert(so);
				//alert(document.getElementById("add-include").value);
				if(locStatus == 1)
				{
					$.ajax({	
						type: 'GET',
						url: 'payrolltransactionprocess.php',
						//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
						data:{action:action, PayId:so},
						beforeSend:function(){
								
						$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							
						},
						success: function(data){
						//window.location.href='approverovertimeform.php';	
						//$('#datatbl').html(data);
						location.reload();					
						}
					});
				}
				else
				{
					alert('Payroll Status must be submitted only!');
				}
			}
			else 
			{
				alert("Please Select a record you want to Revert.");
			}
							
		}
		function Cancel()
		{

			//var SelectedVal = $('#inchide').val();
			var action = "cancel";
			if(so != '') {
				//alert(so);
				//alert(document.getElementById("add-include").value);
				$.ajax({	
						type: 'GET',
						url: 'payrolltransactionprocess.php',
						//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
						data:{action:action, PayId:so},
						beforeSend:function(){
								
						$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							
						},
						success: function(data){
						//window.location.href='approverovertimeform.php';	
						//$('#datatbl').html(data);
						location.reload();					
						}
				});
			}
			else 
			{
				alert("Please Select a record you want to Cancel.");
			}
							
		}
		function Back()
		{
			window.location.href='menu.php?list='+ActiveMode;
		}
</script>
	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js">
		


	</script>
	<!-- end [JAVASCRIPT] -->






<!-- begin modal table 1 -->
<div id="myModal1" class="modal">
	<!-- Modal content -->
	<div class="modal-container modal-continer-table">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">Table 1</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close-1"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<!-- begin MAINPANEL -->
				<div id="mainpanel" class="mainpanel">
					<div class="container-fluid">
						<div class="row">

							<!-- start TABLE AREA -->
							<div id="tablearea3" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
								<div class="mainpanel-content">
									<!-- title & search -->
									<div class="mainpanel-title">
										<span class="fa fa-archive"></span> Accounts
									</div>
									

									<!-- table -->
									<div id="container3" class="half">
										<table width="100%" border="0" id="dataln" class="table table-striped mainpanel-table">
											<thead>
												<tr class="rowtitle">
													<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
													<td style="width:20%;">Account Code</td>
													<td style="width:20%;">Name</td>
													<td style="width:20%;">UM</td>
													<td style="width:20%;">Type</td>
													<td style="width:20%;">Value</td>
													<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
												</tr>
											
											</thead>

											<tbody id="lineresult">
													<?php	
													$query = "SELECT accountcode,
																accountname,
																um,
																case when accounttype = 0 then 'Entry'
																when accounttype = 1 then 'Computed'
																when accounttype = 2 then 'Condition'
																else 'Total'
																end as accounttype,
																format(value,2) value
																FROM payrollheaderaccounts
																where payrollid = '$firstresult'
																and dataareaid = '$dataareaid'
																order by um";
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
															<td style="width:20%;"><?php echo $row['accountcode'];?></td>
															<td style="width:20%;"><?php echo $row['accountname'];?></td>
															<td style="width:20%;"><?php echo $row['um'];?></td>
															<td style="width:20%;"><?php echo $row['accounttype'];?></td>
															<td style="width:20%;"><?php echo $row['value'];?></td>
															<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
															
														</tr>

													<?php }?>
											</tbody>
											<span class="temporary-container-input">
												<input type="input" id="hide22">
											</span>	
										</table>
									</div>
								</div>
							</div>
							<!-- end TABLE AREA -->
						</div>
					</div>
				</div>
				<!-- end MAINPANEL -->
			</div>
		</div>
	</div>
</div>
<!-- end modal table 1-->

<!-- begin modal table 2 -->
<div id="myModal2" class="modal">
	<!-- Modal content -->
	<div class="modal-container modal-continer-table">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">Table 2</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close-2"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				Table 2
			</div>
		</div>
	</div>
</div>
<!-- end modal table 2-->


<script>
		// modal table 1
		var modal1 = document.getElementById('myModal1');
		// Get the button that opens the modal
		var openBtn1 = document.getElementById("modaltableBtn1");
		// Get the <span> element that closes the modal
		var span1 = document.getElementsByClassName("modal-close-1")[0];
		// When the user clicks the button, open the modal 
		openBtn1.onclick = function() {
		    $("#myModal1").stop().fadeTo(500,1);
		    //modal1.style.display = "block";
		}
		// When the user clicks on <span> (x), close the modal
		span1.onclick = function() {
		    modal1.style.display = "none";
		    //$("#myModal1").stop().fadeTo(500,0);
		    Clear();
		}



		// modal table 2
		var modal2 = document.getElementById('myModal2');
		// Get the button that opens the modal
		var openBtn2 = document.getElementById("modaltableBtn2");
		// Get the <span> element that closes the modal
		var span2 = document.getElementsByClassName("modal-close-2")[0];
		// When the user clicks the button, open the modal 
		openBtn2.onclick = function() {
		    $("#myModal2").stop().fadeTo(500,1);
		}
		// When the user clicks on <span> (x), close the modal
		span2.onclick = function() {
		    modal2.style.display = "none";
		    //$("#myModal1").stop().fadeTo(500,0);
		    Clear();
		}




		// When the user clicks anywhere outside of the modal, close it
		/*window.onclick = function(event) {
		    if (event.target == modal) {
		        modal.style.display = "none";
		        Clear();
		    }
		    else if (event.target == modal1) {
		        modal1.style.display = "none";
		        Clear();
		    }
		    else if (event.target == modal2) {
		        modal2.style.display = "none";
		        Clear();
		    }
		}*/


</script>

<script type="text/javascript">
	function printPayrollDraft()
	{
		if (so)
		{
			var soc = "<?php echo $dataareaid; ?>";
		/*	window.location.href='Reports/PayrollReports/draftpayrollreport.php?payroll='+so+'&soc='+soc+'';*/
		 window.open('Reports/PayrollReports/draftpayrollreport.php?payroll='+so+'&soc='+soc+'', "_blank"); 
		}
		else
		{
			alert('Please select a specific payroll to print.');
		}
	}

	function printPayroll()
	{
		if(locStatus == 3)
		{
			if (so)
			{
				var soc = "<?php echo $dataareaid; ?>";
			/*	window.location.href='Reports/PayrollReports/payrollreport.php?payroll='+so+'&soc='+soc+'';*/
			 window.open('Reports/PayrollReports/payrollreport.php?payroll='+so+'&soc='+soc+'', "_blank"); 
			}
			else
			{
				alert('Please select a specific payroll to print.');
			}
		}
		else
		{
			alert('Payroll Must be Approved Status.');
		}
	}

	function printPayslip()
	{
		
		if(locStatus == 3)
		{
			if (so)
			{
				var soc = "<?php echo $dataareaid; ?>";
			/*	window.location.href='Reports/payslip/Payslip.php?payroll='+so+'&soc='+soc+'';*/
			 window.open('Reports/payslip/Payslip.php?payroll='+so+'&soc='+soc+'', "_blank"); 
			}
			else
			{
				alert('Please select a specific payroll to print.');
			}
		}
		else
		{
			alert('Payroll Must be Approved Status.');
		}

	}
</script>



</body>
</html>