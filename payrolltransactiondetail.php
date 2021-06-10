<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$paynum = $_SESSION['paynum'];
$paydate = $_SESSION['paydate'];
$paytype = $_SESSION['paytype'];
$period = $_SESSION['payper'];
$cutoff = $_SESSION['paycut'];
$paystatus = $_SESSION['paystatus'];
$firstresult='';
$linefocus = '';

if(isset($_SESSION['linefocus']))
{ 
	$linefocus = $_SESSION['linefocus'];
}
//unset($_SESSION['paynum']);
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
<body>-->

	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->

	<!-- begin LEFT PANEL -->
	<div id="leftpanel" class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>HEADER COMMANDS</b></div>
			<li class="PayrollTransactionMaintain" style="display: none;"><button name='CtrStatus' onClick="AddWorker();"><span class="fa fa-plus fa-lg"></span> Add Worker</button></li>
			<li class="PayrollTransactionMaintain" style="display: none;"><button name='CtrStatus' onClick="DeleteWk();"><span class="fa fa-trash-alt fa-lg"></span> Remove Worker</button></li>
			<li class="PayrollTransactionMaintain" style="display: none;"><button name='CtrStatus' onClick="Recompute();"><span class="fas fa-calculator fa"></span> Recompute</button></li>
			<li class="PayrollTransactionMaintain" style="display: none;"><button name='CtrStatus' onClick="RecomputeAll();"><span class="fas fa-calculator fa"></span> Recompute All</button></li>
			<li class="PayrollTransactionMaintain" style="display: none;"><button name='CtrStatus' onClick="LastPay();"><span class="fa fa-tag fa-lg"></span> Tag/Untag as Last Pay</button></li>
			<li><button onClick="HeaderTrans();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>
		
		<!-- extra buttons -->
		<ul class="extrabuttons">
			<!--<li><button><span class="fas fa-arrow-up fa"></span> Move Up</button></li>
			<li><button><span class="fas fa-arrow-down fa"></span> Move Down</button></li>-->
			<li>
				<!-- TOGGLE POSITION -->
				
				<!--<div class="hidden-sm hidden-xs">
					<button id="changeposition-6-button" class=""><span class="fas fa-window-restore"></span> Change Position</button>
					<button id="changeposition-12-button" class="hide"><span class="fas fa-window-restore fa-rotate-270"></span> Change Position</button>
				</div>-->
			
			</li>
			<!--<li><button id="modaltableBtn1"><span class="fa fa-cog"></span> Modal Table 1</button>
			<li><button id="modaltableBtn2"><span class="fa fa-cog"></span> Modal Table 2</button>-->
			
		</ul>

		<ul class="subbuttons PayrollTransactionMaintain" style="display: none;">
			<div class="leftpanel-title"><b>LINE COMMANDS</b></div>
			<li><button name='CtrStatus' onClick="AddAccount();"><span class="fa fa-plus fa-lg"></span> Add Account</button></li>
			<li><button name='CtrStatus' onClick="DeleteAcc();"><span class="fa fa-trash-alt fa-lg"></span> Remove Account</button></li>
			<li><button name='CtrStatus' id="myUpdateBtn"><span class="fa fa-edit fa-lg"></span> Update Account</button></li>
			<!--<li><button onClick="checkpos();"><span class="fa fa-trash-alt fa-lg"></span> check pos</button></li>-->
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
							<?php
							$query2 = "SELECT bh.name as branch from payrollheader ph 
												left join branch bh on ph.branchcode = bh.branchcode and ph.dataareaid = bh.dataareaid

												where ph.dataareaid = '$dataareaid' and ph.payrollid = '$paynum'";
								$result2 = $conn->query($query2);
								$row2 = $result2->fetch_assoc();
								$usrname = $row2["branch"];

							?>
							<span class="fa fa-archive"></span> <?php echo $paynum.' - '.$usrname; ?>
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
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:25%;">Worker</td>
										<td style="width:10%;">Rate</td>
										<td style="width:15%;">Ecola</td>
										<td style="width:15%;">Transportation</td>
										<td style="width:15%;">Meal</td>
										<td style="width:15%;">Type</td>
										<td style="width:5%;">Last Pay</td>
										<td style="width: 17px;"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchWorker" class="search">
										<?php
											$query = "SELECT 
														wk.name,
														wk.workerid
														FROM payrolldetails pd
														left join worker wk on wk.workerid = pd.workerid
														and wk.dataareaid = pd.dataareaid

												where pd.dataareaid = '$dataareaid' and pd.payrollid = '$paynum' 
														order by wk.workerid asc";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchWorker">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["name"];?>"><?php echo $row["workerid"];?></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td style="width:14%;"><input style="width:100%;height: 20px;" id="SPayment" list="SearchPayment" class="search" disabled>
										<?php
											$query = "SELECT distinct distinct ph.payrollid from payrollheader ph where ph.dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPayment">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["payrollid"];?>"></option>
											
										<?php } ?>
										</datalist>		
										
									  </td>
									  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchId" class="search" disabled>
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
									  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchPeriod" class="search" disabled>
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
									  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchFromDate" class="search" disabled>
										<?php
											$query = "SELECT distinct ph.fromdate from payrollheader ph where ph.dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchFromDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["fromdate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchToDate" class="search" disabled>
										<?php
											$query = "SELECT distinct ph.todate from payrollheader ph where ph.dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchToDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["todate"];?>"></option>
											
										<?php } ?>
										</datalist>
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
										$query = "SELECT pd.payrollid,
														wk.name,
														format(pd.rate,2) as rate
														,format(pd.ecola,2) as ecola,
														format(pd.transpo,2) transpo,
														format(pd.meal,2) as meal,
														case when pd.workertype = 0 then 'Regular' 
															when pd.workertype = 1 then 'Reliever'
															when pd.workertype = 2 then 'Probationary'
															when pd.workertype = 3 then 'Contractual' 
															when pd.workertype = 4 then 'Trainee' 
															when pd.workertype = 5 then 'Project-Based'
															else '' end as workertype,

														pd.transdate,
														pd.linenum,
														pd.contractid,
														pd.islastpay
														FROM payrolldetails pd
														left join worker wk on wk.workerid = pd.workerid
														and wk.dataareaid = pd.dataareaid

												where pd.dataareaid = '$dataareaid' and pd.payrollid = '$paynum'

												order by pd.linenum asc
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
											<tr id="<?php echo $row['linenum'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
												<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
												<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
												<td style="width:25%;"><?php echo $row['name'];?></td>
												<td style="width:10%;"><?php echo $row['rate'];?></td>
												<td style="width:15%;"><?php echo $row['ecola'];?></td>
												<td style="width:15%;"><?php echo $row['transpo'];?></td>
												<td style="width:15%;"><?php echo $row['meal'];?></td>
												<td style="width:15%;"><?php echo $row['workertype'];?></td>
												<td style="width:5%;"><input type="checkbox" name="chkbox" class="checkbox" value="true" <?php echo ($row['islastpay'] ==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['islastpay'];?></div></td>

												<td style="display:none;width:1%;"><?php echo $row['linenum'];?></td>
												<td style="display:none;width:1%;"><?php echo $row['contractid'];?></td>
												<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
												
											</tr>

										<?php 
										$firstresult = $row["linenum"];
										$contract = $row['contractid'];
										}
										/*$result2 = $conn->query($query);
											$row2 = $result2->fetch_assoc();
											$firstresult = $row2["payrollid"];*/
										?>
											
								</tbody>
								<input type="hidden" id="hide" value="<?php echo $firstresult;?>">
								<input type="hidden" id="hidefocus" value="<?php if($linefocus != ''){ echo $linefocus; } else { echo $rowcnt2; };?>">
								<input type="hidden" id="hidecontract" value="<?php echo $contract;?>">
								<input type="hidden" id="hidecutoff" value="<?php echo $cutoff;?>">
								<input type="hidden" id="hidestatus" value="<?php echo $paystatus;?>">
								<!--<input id="file" type="file" accept="image/*">-->		
							</table>
						</div>
					</div>
					<br>
				</div>
				<!-- end TABLE AREA -->

				<!-- start TABLE AREA -->
				<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> Overview
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
										<td style="width: 17px;"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
								
								</thead>

								<tbody id="lineresult">
										<?php	
										if($linefocus != '')
										{
											$linenumresult = $linefocus;
										}
										else
										{
											$linenumresult = $firstresult;
										}
										$query = "SELECT accountcode,
													accountname,
													um,
													case when accounttype = 0 then 'Entry'
													when accounttype = 1 then 'Computed'
													when accounttype = 2 then 'Condition'
													else 'Total'
													end as accounttype,
													format(value,2) value
													FROM payrolldetailsaccounts
													where payrollid = '$paynum'
													and reflinenum = '$linenumresult'
													and dataareaid = '$dataareaid'
													order by priority";
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
								<input type="hidden" id="hide2">	
								<input type="hidden" id="linenumresult" value="<?php echo $linenumresult;?>">
							</table>
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
				<div class="col-lg-6">Account Details</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<!--<form name="myForm" accept-charset="utf-8" action="payrolltransactiondetailprocess.php" method="get">-->
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Account Code:</label>
							<input type="text" value="" placeholder="Account Code" name ="PTcode" id="add-code" class="modal-textarea" required="required">
							
							<label>Value:</label>
							<input type="number" step="1.00" min="0" value="" placeholder="Value" name ="PTvalue" id="add-value" class="modal-textarea" required="required">
							<input type="hidden"  value="" placeholder="Value" name ="PTline" id="add-line" class="modal-textarea">
							<input type="hidden"  value="" placeholder="Value" name ="PTContract" id="add-contract" class="modal-textarea">
						</div>

					</div>

					<div class="button-container">
						<button id="addbt" name="save" value="save" class="btn btn-primary btn-action">Save</button>
						<button onClick="Update();" id="upbt" name="update" value="update" class="btn btn-success btn-action" onclick="return validateForm()">Update</button>
						<button onClick="Clear();" type="button" value="Reset" class="btn btn-danger">Clear</button>
					</div>
				<!--</form>-->
			</div>
		</div>
	</div>
</div>
<!-- end modal-->

<script src="js/ajax.js"></script>
	  	<script  type="text/javascript">
	  	var flaglocation=true;
	  	var so='';
	  	var payline='';
	  	var locValue='';
	  	var locType='';
	  	var locContract='';
	  	var locPay='';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locContract = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locPay = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				document.getElementById("hidecontract").value = locContract;

				//alert(document.getElementById("hide").value);
				//alert(so);
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'payrolltransactiondetailline.php',
					data:{action:action, actmode:actionmode, PayId:so},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						document.getElementById("hide2").value = "";
						document.getElementById("hidefocus").value = so;
						document.getElementById("linenumresult").value = so;
						var action = "setsession";
						$.ajax({
							type: 'GET',
							url: 'payrolltransactiondetailprocess.php',
							data:{action:action, sess:so},
							beforeSend:function(){
								//$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							},
							success: function(data){
								//$('#lineresult').html(data);
								//document.getElementById("linenumresult").value = so;
							}
						});
						$('#lineresult').html(data);
					}
				}); 	
				//-----------get line--------------//
				flaglocation = true;
				//alert(flaglocation);
		        $("#myUpdateBtn").prop("disabled", true);
		            
				//document.getElementById("myUpdateBtn").style.visibility = "visible";
					  
			});
			//$("#myUpdateBtn").prop('disabled', false);
		});

	  		$(document).ready(function(){
				$('#dataln tbody tr').click(function(){
					$('table tbody tr').css("color","black");
					$(this).css("color","orange");
					$('table tbody tr').removeClass("info");
					$(this).addClass("info");
					var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
					locValue = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(5)").text();
					locType = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(4)").text();
					payline = transnumline.toString();
					document.getElementById("hide2").value = payline;
					//alert(document.getElementById("hide").value);
						
					flaglocation = false;
					//alert(payline);
					loc = document.getElementById("hidefocus").value;
		            $("#myUpdateBtn").prop("disabled", false);
		            var pos = $("#"+loc+"").attr("tabindex");
		            // var pos = document.getElementById("hidefocus").value;
					    //$("tr[tabindex="+pos+"]").focus();
					    $("tr[tabindex="+pos+"]").css("color","red");
					    $("tr[tabindex="+pos+"]").addClass("info");
					//document.getElementById("myUpdateBtn").style.disabled = disabled;
						  
				});

				//alert(document.getElementById("hidestatus").value);
				var crtControl = document.getElementById("hidestatus").value;
				if (crtControl == '0') 
				{
					$('[name=CtrStatus]').prop("disabled", false);
				}
				else
				{
					$('[name=CtrStatus]').prop("disabled", true);
				}
				
			});

	  	function checkpos(){
	  		alert(flaglocation);
	  	}

		$(document).ready(function() {
			var hidefocus = document.getElementById("hidefocus").value;
			var pos = $("#"+hidefocus+"").attr("tabindex");
			//var pos = document.getElementById("hidefocus").value;
			//alert(pos);
		    $("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").css("color","red");
		    $("tr[tabindex="+pos+"]").addClass("info");
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
		var UpdateBtn = document.getElementById("myUpdateBtn");
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("modal-close")[0];
		// When the user clicks the button, open the modal 

		UpdateBtn.onclick = function() {
			var ck = false;
			var typeval;
			var catval;
			if( payline != '') {
				if(locType == 'Entry'){
					$("#myModal").stop().fadeTo(500,1);
				    $("#add-code").prop('readonly', true);
				    var locValueDec = locValue.replace(/[A-Za-z!@#$%^&*(),]/g, '');

				    document.getElementById("add-code").value = payline;
					document.getElementById("add-value").value = locValueDec;
					document.getElementById("add-line").value = document.getElementById("hide").value;
					document.getElementById("add-contract").value = document.getElementById("hidecontract").value;
				    document.getElementById("addbt").style.visibility = "hidden";
				    document.getElementById("upbt").style.visibility = "visible";
				}
				else
				{
					alert("Only entry type Accounts are allowed to update.");
				}
			    
			}
			else 
			{
				alert("Please Select a record you want to update.");
			}
		}
		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
		    modal.style.display = "none";
		    //$("#myModal").stop().fadeTo(100,0);
		    Clear();
		}
		// When the user clicks anywhere outside of the modal, close it
		/*window.onclick = function(event) {
		    if (event.target == modal || event.target == modal2) {
		        modal.style.display = "none";
		        Clear();
		        
		    }
		}*/
		//end modal ---------------------------

		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var PTWorker;

			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 PTWorker = data[0];

			
			 $.ajax({
				type: 'GET',
				url: 'payrolltransactiondetailprocess.php',
				data:{action:action, actmode:actionmode, PTWorker:PTWorker},
				//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
				beforeSend:function(){
				
					$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
	
				},
				success: function(data){
					$('#result').html(data);
					so='';
					
					var firstval = $('#hide3').val();
					document.getElementById("hide").value = firstval;
					document.getElementById("hidefocus").value = firstval;

					loc = firstval;
		            //alert(loc);
		             var pos = $("#"+loc+"").attr("tabindex");
					    //$("tr[tabindex="+pos+"]").focus();
					    $("tr[tabindex="+pos+"]").css("color","red");
					    $("tr[tabindex="+pos+"]").addClass("info");
					//alert(document.getElementById("hide3").value);
					//-----------get line--------------//
						var action = "getline";
						var actionmode = "userform";
						$.ajax({
							type: 'POST',
							url: 'payrolltransactiondetailline.php',
							data:{action:action, actmode:actionmode, PayId:firstval},
							beforeSend:function(){
							
								$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							},
							success: function(data){
								payline='';
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
	function Update()
	{
		modal.style.display = "none";
		/*var UId = document.getElementById("add-UserId");
		var UPass = document.getElementById("add-pass");
		var NM = document.getElementById("add-name");
		var DT = document.getElementById("add-dataareaid");*/
		var PTcode = $('#add-code').val();
		var PTvalue = $('#add-value').val();
		var PTline = $('#add-line').val();
		var PTcontract = document.getElementById("hidecontract").value;
		var action = "update";
		if(payline != '') {
			if(confirm("Are you sure you want to update this record?")) {
				$.ajax({	
						type: 'GET',
						url: 'payrolltransactiondetailprocess.php',
						//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
						data:{action:action, PTcode:PTcode, PTvalue:PTvalue, PTline:PTline, PTcontract:PTcontract},
						beforeSend:function(){
								
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							
						},
						success: function(data){
						//$('#lineresult').html(data);
						//location.reload();	
						//$('#lineresult').html(data);
						//location.reload();	
						//alert("Computed");
						//-----------get line--------------//
							var action = "getline";
							var actionmode = "userform";
							$.ajax({
								type: 'POST',
								url: 'payrolltransactiondetailline.php',
								data:{action:action, actmode:actionmode, PayId:so},
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
						url: 'payrolltransactiondetailprocess.php',
						//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
						data:{action:action, PTline:so, locContract:locContract},
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
								url: 'payrolltransactiondetailline.php',
								data:{action:action, actmode:actionmode, PayId:so},
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

	function RecomputeAll()
	{
		modal.style.display = "none";
		/*var UId = document.getElementById("add-UserId");
		var UPass = document.getElementById("add-pass");
		var NM = document.getElementById("add-name");
		var DT = document.getElementById("add-dataareaid");*/
		
		var action = "recomputeAll";
		
			if(confirm("Are you sure you want to Recompute all record?")) {
				$.ajax({	
						type: 'GET',
						url: 'payrolltransactiondetailprocess.php',
						//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
						data:{action:action},
						beforeSend:function(){
								
						//$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							
						},
						success: function(data){
						//$('#lineresult').html(data);
						location.reload();					
						}
				}); 
			}
			else 
			{
				return false;
			}
					
	}

	function HeaderTrans()
	{
		var action = "payhead";
		$.ajax({
			type: 'GET',
			url: 'payrolltransactiondetailprocess.php',
			data:{action:action, PayId:so},
			success: function(data) {
			    window.location.href='payrolltransaction.php';
		    }
		});
	}
	function AddWorker()
	{
		var action = "addworker";
		$.ajax({
			type: 'GET',
			url: 'payrolltransactiondetailprocess.php',
			data:{action:action, PayId:so},
			success: function(data) {
			    window.location.href='ptworker.php';
		    }
		});
	}

	function AddAccount()
	{
		alert(so);
		if(so != '') {
			var action = "addaccount";
			$.ajax({
				type: 'GET',
				url: 'payrolltransactiondetailprocess.php',
				data:{action:action, PayId:so},
				success: function(data) {
				    window.location.href='ptaccounts.php';
			    }
			});
		}
		else 
		{
			alert("Please Select Worker.");
		}
	}

	function DeleteAcc()
	{
		delACC = document.getElementById("hide2").value;
		delLinenum = document.getElementById("hide").value;
		//alert(delLinenum);
		var action = "remAccount";
		
		$.ajax({	
			type: 'GET',
			url: 'payrolltransactiondetailprocess.php',
			//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
			data:{action:action, delACC:delACC, delLinenum:delLinenum},
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
								url: 'payrolltransactiondetailline.php',
								data:{action:action, actmode:actionmode, PayId:so},
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

	function DeleteWk()
	{
		var action = "deleteWK";
		
			if(so != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'payrolltransactiondetailprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, delHeadnum:so},
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
				alert("Please Select a record you want to delete.");
			}
	}
	function LastPay()
	{
		
		//alert(so);
		if(so != '') {
			if(locPay == 0)
			{
				var action = "Tag";
				$.ajax({	
							type: 'GET',
							url: 'payrolltransactiondetailprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, PTline:so, locContract:locContract},
							beforeSend:function(){
									
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#result').html(data);
							location.reload();					
							}
					});
			}
			else
			{
				var action = "Untag";
				$.ajax({	
							type: 'GET',
							url: 'payrolltransactiondetailprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, PTline:so, locContract:locContract},
							beforeSend:function(){
									
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#result').html(data);
							location.reload();					
							}
					});
			}
		}
		else 
		{
			alert("Please Select a record you want to tag/untag.");
		}
		
		
	}

</script>
	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js">
		


	</script>
	<!-- end [JAVASCRIPT] -->

	

</body>
</html>