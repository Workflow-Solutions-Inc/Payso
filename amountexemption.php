<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
//$EXpaynum = 'ADMOPY0000003';

if(isset($_SESSION['EXpaynum']))
{
	$EXpaynum = $_SESSION['EXpaynum'];
}
else
{
	header('location: payrolltransaction.php');
}

$firstresult = '';
$AEpayid = '';


//$paydate = $_SESSION['paydate'];
//$paytype = $_SESSION['paytype'];

//unset($_SESSION['paynum']);
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Amount Exemption</title>

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
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button onClick="Excluded();"><span class="fa fa-minus fa-lg"></span> Excluded to Payroll</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-edit fa-lg"></span> Update Excluded Value</button></li>
			<li><button onClick="Included();"><span class="fas fa-plus fa-lg"></span> Include to Payroll</button></li>
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
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>


	</div>
	<!-- end LEFT PANEL -->

	<!-- begin MAINPANEL -->
	<div id="mainpanel" class="mainpanel">
		<div class="container-fluid">
			<div class="row">

				<!-- start TABLE AREA -->
				<div id="tablearea1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area" style="height: 32vh;">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<?php
							$query2 = "SELECT bh.name as branch from payrollheader ph 
												left join branch bh on ph.branchcode = bh.branchcode and ph.dataareaid = bh.dataareaid

												where ph.dataareaid = '$dataareaid' and ph.payrollid = '$EXpaynum'";
								$result2 = $conn->query($query2);
								$row2 = $result2->fetch_assoc();
								$usrname = $row2["branch"];

							?>
							<span class="fa fa-archive"></span> <?php echo $EXpaynum.' - '.$usrname; ?>
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
							</div>
							<div class="mainpanel-sub-cmd">
								<input type="text" id="SampleLoad" value="ADMOPY0000003">
								<button onClick="Load();"><span class="fas fa-sync fa-spin"></span> Load</button>
							</div>-->
						</div>
						<!-- tableheader -->
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;"><span class="fa fa-adjust"></span></td>
										<td style="width:19%;">Payroll No.</td>
										<td style="width:19%;">Worker ID</td>
										<td style="width:22%;">Worker Name</td>
										<td style="width:20%;">Total Deduction</td>
										<td style="width:20%;">Net Pay</td>
										<td style="width: 17px;"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td><span class="fa fa-adjust"></span></td>
									  

										<td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchWorker" class="search" disabled>
										<?php
											$query = "SELECT 
														wk.name,
														wk.workerid
														FROM payrolldetails pd
														left join worker wk on wk.workerid = pd.workerid
														and wk.dataareaid = pd.dataareaid

												where pd.dataareaid = '$dataareaid' and pd.payrollid = '$EXpaynum' 
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
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									</tr>
								
								</thead>
								<tbody id="result" style="height: 17vh;">
										<?php	
										$query = "CALL SP_CheckNetPay('$EXpaynum','$dataareaid');";
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
												<td style="width:19%;"><?php echo $row['payrollid'];?></td>
												<td style="width:19%;"><?php echo $row['workerid'];?></td>
												<td style="width:22%;"><?php echo $row['name'];?></td>
												<td style="width:20%;"><?php echo $row['TDED'];?></td>
												<td style="width:20%;"><?php echo $row['NPAY'];?></td>

												<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
												
											</tr>

										<?php 
											if(isset($row["workerid"]))
											{
												$firstresult = $row["workerid"];
												$AEpayid = $row['payrollid'];
											}
										}
										$conn->close();
										include("dbconn.php");
										/*$result2 = $conn->query($query);
											$row2 = $result2->fetch_assoc();
											$firstresult = $row2["workerid"];*/
										?>
											
								</tbody>
								<input type="hidden" id="hide" value="<?php echo $firstresult;?>">
								<input type="hidden" id="hidefocus" value="<?php echo $AEpayid;?>">		
							</table>
						</div>
					</div>
				</div>
				<!-- end TABLE AREA -->
				<!-- start TABLE AREA -->
				<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area"  style="height: 32vh;">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> Payroll Details Accounts(Account to be Excluded)
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

							<div class="mainpanel-sub-cmd">

							</div>
							Payment Date:
								<input type="date" id="PaymetDate" class="modal-textarea">
						</div>

						<!-- table -->
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="dataln" class="table table-striped mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;"><span class="fa fa-adjust"></span></td>
										<td style="width:8%;">Exclude</td>
										<td style="width:15%;">Account Code</td>
										<td style="width:15%;">Account Name</td>
										<td style="width:15%;">UM</td>
										<td style="width:16%;">Value</td>
										<td style="width:16%;">Excluded Value</td>
										<td style="width:16%;">Payment Date</td>
										<td style="width: 17px;"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
								
								</thead>

								<tbody id="lineresult" style="height: 17vh;">
										<?php	
										if($firstresult !='')
										{
											$query = "SELECT pa.accountcode,pa.accountname,um as 'UM',format(value,2) value,'0.00' as 'ExcludedValue',0 as 'Exclude All Values','1900-01-01' as 'PaymentDate' 
													 from payrolldetails pd 
													 left join payrolldetailsaccounts pa on pd.payrollid = pa.payrollid and pd.linenum = pa.reflinenum and pd.dataareaid = pa.dataareaid
													 where pd.payrollid = '$EXpaynum' and pd.dataareaid = '$dataareaid' and pd.workerid = '$firstresult' 
													 #and pa.accountcode not in (select accountcode from excludedpayment where refpayrollid = pd.payrollid and workerid = pd.workerid and dataareaid = pd.dataareaid)
													 order by pa.priority asc ";
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
													<!-- <td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td> -->
													<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
													
													<td style="width:8%;"><input type='checkbox' id="chkbox" name="chkbox" class="checkbox" 
													value="<?php echo $row['accountcode'];?>"></td>
													<td style="width:15%;"><?php echo $row['accountcode'];?></td>
													<td style="width:15%;"><?php echo $row['accountname'];?></td>
													<td style="width:15%;"><?php echo $row['UM'];?></td>
													<td style="width:16%;"><?php echo $row['value'];?></td>
													<td style="width:16%;"><?php echo $row['ExcludedValue'];?></td>
													<td style="width:16%;"><?php echo $row['PaymentDate'];?></td>
													<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
													
												</tr>

											<?php }

										}?>
								</tbody>

								<input type="hidden" id="HDincAcc">	
								<input class="hidden" type="input" id="IncAccId">
								<input class="hidden" type="input" id="ExAccId">

							</table>
						</div>


					</div>
				</div>
				<!-- end TABLE AREA -->

				<!-- start TABLE AREA -->
				<div id="tablearea3" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area"  style="height: 27vh;">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> Exempted Account Amount
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
							<table width="100%" style="border: 1px solid #d9d9d9;" id="dataexln" class="table table-striped mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;"><span class="fa fa-adjust"></span></td>
										<td style="width:8%;">Select</td>
										<td style="width:30%;">Account Code</td>
										<td style="width:31%;">Amount</td>
										<td style="width:31%;">Payment Date</td>
										<td style="width:17px;"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
								
								</thead>
								<tbody id="exlineresult" style="height: 17vh;">
										<?php
										if($firstresult != '')
										{	
											$query = "SELECT accountcode,format(amount,2) amount,paymentdate FROM excludedpayment where refpayrollid = '$EXpaynum' and workerid = '$firstresult' and dataareaid = '$dataareaid'; ";
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
													<!-- <td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td> -->
													<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
													<td style="width:8%;"><input type='checkbox' id="chkbox-inc" name="chkbox-inc" class="checkbox" 
													value="<?php echo $row['accountcode'];?>"></td>
													<td style="width:30%;"><?php echo $row['accountcode'];?></td>
													<td style="width:31%;"><?php echo $row['amount'];?></td>
													<td style="width:31%;"><?php echo $row['paymentdate'];?></td>
													<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
													
												</tr>

											<?php }
										}?>
								</tbody>
								<input type="hidden" id="HDincAcc-EX">	
								<input class="hidden" type="input" id="IncAccId-EX">
								<input class="hidden" type="input" id="ExAccId-EX">
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
				<div class="col-lg-6">Exclude Partial Amount</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<!--<form name="myForm" accept-charset="utf-8" action="amountexemptionprocess.php" method="get">-->
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Account Code:</label>
							<input type="text" value="" placeholder="Account Code" name ="AccoundCode" id="add-code" class="modal-textarea" required="required">

							<label>UM:</label>
							<input type="text" value="" placeholder="Account Code" name ="UM" id="add-um" class="modal-textarea" required="required">

							<label>Excluded:</label>
							<input type="number" value="" placeholder="Excluded Amount" name ="Excluded" id="add-excluded" class="modal-textarea" required="required">

							<input type="hidden"  name ="PTline" id="add-line" class="modal-textarea">
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Account Name:</label>
							<input type="text" value="" placeholder="Account Code" name ="AccountName" id="add-name" class="modal-textarea" required="required">

							<label>Value:</label>
							<input type="number" step="1.00" min="0" value="" placeholder="Value" name ="PTvalue" id="add-value" class="modal-textarea" required="required">

							<label>Date:</label>
							<input type="date" value="" placeholder="Date" name ="Date" id="add-date" class="modal-textarea" required="required">


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
	  	var locName='';
	  	var locUM='';
	  	var locValue='';
	  	var locExcluded='';
	  	var locDate='';
	  	var exline='';
	  	var AEpayId = '';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				AEpayId = document.getElementById("hidefocus").value;
				//alert(AEpayId);
				//alert(document.getElementById("hide").value);
				//alert(so);
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'amountincluded.php',
					data:{action:action, actmode:actionmode, WorkID:so, AEpayId:AEpayId},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						document.getElementById("HDincAcc").value = "";
						$('#lineresult').html(data);
					}
				}); 	
				//-----------get line--------------//

				//-----------get exline--------------//
				var action = "getexline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'amountexcluded.php',
					data:{action:action, actmode:actionmode, WorkID:so, AEpayId:AEpayId},
					beforeSend:function(){
					
						$("#exlineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						document.getElementById("HDincAcc").value = "";
						$('#exlineresult').html(data);
					}
				}); 	
				//-----------get exline--------------//

				document.getElementById("HDincAcc").value = '';
				document.getElementById("IncAccId").value = '';
				document.getElementById("ExAccId").value = '';

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
					var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();
					locName = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(3)").text();
					locUM = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(4)").text();
					locValue = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(5)").text();
					locExcluded = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(6)").text();
					locDate = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(7)").text();
					payline = transnumline.toString();
					document.getElementById("HDincAcc").value = payline;
					//alert(document.getElementById("hide").value);
						
					flaglocation = false;
					//alert(payline);
					loc = document.getElementById("hide").value;
		            $("#myUpdateBtn").prop("disabled", false);
		             var pos = $("#"+loc+"").attr("tabindex");
					    $("tr[tabindex="+pos+"]").focus();
					    $("tr[tabindex="+pos+"]").css("color","red");
					    $("tr[tabindex="+pos+"]").addClass("info");
					//document.getElementById("myUpdateBtn").style.disabled = disabled;
						  
				});
			});

			$(document).ready(function(){
				$('#dataexln tbody tr').click(function(){
					$('table tbody tr').css("color","black");
					$(this).css("color","green");
					$('table tbody tr').removeClass("info");
					$(this).addClass("info");
					var exemptedline = $("#dataexln tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();
					exline = exemptedline.toString();
					document.getElementById("HDincAcc-EX").value = exline;
					//alert(document.getElementById("hide").value);
						
					flaglocation = false;
					//alert(payline);
					loc = document.getElementById("hide").value;
		            $("#myUpdateBtn").prop("disabled", false);
		             var pos = $("#"+loc+"").attr("tabindex");
					    $("tr[tabindex="+pos+"]").focus();
					    $("tr[tabindex="+pos+"]").css("color","red");
					    $("tr[tabindex="+pos+"]").addClass("info");
					//document.getElementById("myUpdateBtn").style.disabled = disabled;
						  
				});
			});

	  	function Load(){
	  			//-----------get Header--------------//
	  			var headerid='';
	  			headerid = document.getElementById("SampleLoad").value;
				var action = "getheader";
				$.ajax({
					type: 'POST',
					url: 'amountexempthead.php',
					data:{action:action, headerid:headerid},
					beforeSend:function(){
					
						$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide").value = "1";
						$('#result').html(data);
						var hdPayID = $('#hdPayID').val();
						var hdWorkID = $('#hdWorkID').val();
						//alert(firstval);
							document.getElementById("hide").value = hdWorkID;
							so = document.getElementById("hide").value;
				            //$("#myUpdateBtn").prop("disabled", false);
				             var pos = $("#"+so+"").attr("tabindex");
							    $("tr[tabindex="+pos+"]").focus();
							    $("tr[tabindex="+pos+"]").css("color","red");
							    $("tr[tabindex="+pos+"]").addClass("info");

							    //-----------get Included Accounts--------------//
							    WorkID = hdWorkID;
							    AEpayId = hdPayID;
							    var action = "getline";
								var actionmode = "userform";
								$.ajax({
									type: 'POST',
									url: 'amountincluded.php',
									data:{action:action, actmode:actionmode, WorkID:so, AEpayId:AEpayId},
									beforeSend:function(){
									
										$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
									},
									success: function(data){
										//payline='';
										document.getElementById("HDincAcc").value = "";
										$('#lineresult').html(data);
									}
								}); 
					}
				}); 	
				


	  	}

		$(document).ready(function() {
			var loc = document.getElementById("hide").value;
			var pos = $("#"+loc+"").attr("tabindex");
			//alert(pos);
		    
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

					$("#myModal").stop().fadeTo(500,1);
				    $("#add-code").prop('readonly', true);
				    $("#add-name").prop('readonly', true);
				    $("#add-um").prop('readonly', true);
				    $("#add-value").prop('readonly', true);
				    var conlocValue = locValue.replace(/[A-Za-z!@#$%^&*(),]/g, '');


				    document.getElementById("add-code").value = payline;
				    document.getElementById("add-name").value = locName;
				    document.getElementById("add-um").value = locUM;
					document.getElementById("add-value").value = conlocValue;
					document.getElementById("add-excluded").value = locExcluded;
					//document.getElementById("add-date").value = locDate;
					document.getElementById("add-line").value = document.getElementById("hide").value;
				    document.getElementById("addbt").style.visibility = "hidden";
				    document.getElementById("upbt").style.visibility = "visible";
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
/*		$( ".search" ).on( "keydown", function(event) {
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
				url: 'amountexemptionprocess.php',
				data:{action:action, actmode:actionmode, PTWorker:PTWorker},
				//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
				beforeSend:function(){
				
					$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
	
				},
				success: function(data){
					$('#result').html(data);
					so='';
					document.getElementById("hide").value = so;
					var firstval = $('#HDincAcc-EX').val();
					//alert(document.getElementById("HDincAcc-EX").value);
					//-----------get line--------------//
						var action = "getline";
						var actionmode = "userform";
						$.ajax({
							type: 'POST',
							url: 'amountexemptionline.php',
							data:{action:action, actmode:actionmode, PayId:firstval},
							beforeSend:function(){
							
								$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							},
							success: function(data){
								payline='';
								document.getElementById("HDincAcc").value = "";
								$('#lineresult').html(data);
							}
						}); 
					//-----------get line--------------//	
				}
			}); 
			 
		  }
		});*/
		//-----end search-----//
	function Excluded()
	{
		//modal.style.display = "none";PaymetDate
		var PayDate = $('#PaymetDate').val();

		var d = new Date();
		var x = new Date(document.getElementById("PaymetDate").value.toLowerCase());
		d.setDate(d.getDate());

		var SelworkId = $('#hide').val();
		var SelectedAcc = $('#IncAccId').val();
		AEpayId = $('#hidefocus').val();
		var action = "exclude";
		//alert(PayDate);
		if(SelectedAcc != '') {

			if(PayDate != '')
			{
				if(d > x)
	 			{
	 				alert("Date must be future date");
	 				
	 			}
	 			else
	 			{
	 				if(confirm("Are you sure you want to exclude all this record?")) {
						$.ajax({	
								type: 'GET',
								url: 'amountexemptionprocess.php',
								//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
								data:{action:action, SelworkId:SelworkId, SelectedAcc:SelectedAcc, PayDate:PayDate},
								beforeSend:function(){
										
								//$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
									
								},
								success: function(data){
								//$('#lineresult').html(data);
								//$('#exlineresult').html('Select Worker ID');

								//location.reload();

								//-----------get Included Line--------------//
								var action = "getline";
								var actionmode = "userform";
								$.ajax({
									type: 'POST',
									url: 'amountincluded.php',
									data:{action:action, actmode:actionmode, WorkID:SelworkId, AEpayId:AEpayId},
									beforeSend:function(){
									
										$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
									},
									success: function(data){
										//payline='';
										//document.getElementById("HDincAcc").value = "";
										$('#lineresult').html(data);
									}
								}); 	
								//-----------get Included Line--------------//

								//-----------get Excluded Line--------------//
								var action = "getexline";
								var actionmode = "userform";
								$.ajax({
									type: 'POST',
									url: 'amountexcluded.php',
									data:{action:action, actmode:actionmode, WorkID:SelworkId, AEpayId:AEpayId},
									beforeSend:function(){
									
										$("#exlineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
									},
									success: function(data){
										//payline='';
										//document.getElementById("HDincAcc").value = "";
										$('#exlineresult').html(data);
									}
								}); 	
								//-----------get Excluded Line--------------//

								document.getElementById("HDincAcc").value = '';
								document.getElementById("IncAccId").value = '';
								document.getElementById("ExAccId").value = '';					
								}
						}); 
					}
					else 
					{
						return false;
					}

	 			}

	 		}
	 		else
	 		{
	 			alert("Please Select a Payment Date.");
	 		}
			
		}
		else 
		{
			alert("Please Check the Accounts you want to exclude.");
		}
	}

	function Update()
	{
		
		/*var UId = document.getElementById("add-UserId");
		var UPass = document.getElementById("add-pass");
		var NM = document.getElementById("add-name");
		var DT = document.getElementById("add-dataareaid");*/
		

		var d = new Date();
		var x = new Date(document.getElementById("add-date").value.toLowerCase());
		d.setDate(d.getDate());
		

		
		var evalue = $('#add-value').val();
		//var SelectedVal = $('#hide').val();
		

		AEpayId = document.getElementById("hidefocus").value;
		var SelworkId = $('#hide').val();
		var SelectedAcc = $('#HDincAcc').val();
		var excludenum = $('#add-excluded').val();
		var edate = $('#add-date').val();
		//alert(exlude);
		//alert(edate);
		if(SelectedAcc != '') {
			if(evalue > excludenum){
				if(excludenum <= 0)
				{
					alert("Exclude Amount Must be greater then 0");
				}
				else
				{
					if(edate != '')
					{
						if(d > x)
			 			{
			 				alert("Date must be future date");
			 				
			 			}
			 			else
			 			{
			 				if(confirm("Are you sure you want to update this record?")) {
								var action = "update";
								$.ajax({	
										type: 'GET',
										url: 'amountexemptionprocess.php',
										//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
										data:{action:action, SelworkId:SelworkId, SelectedAcc:SelectedAcc, edate:edate, excludenum:excludenum, evalue:evalue, AEpayId:AEpayId},
										beforeSend:function(){
												
										//$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
											
										},
										success: function(data){
										//$('#lineresult').html(data);						
										//$('#exlineresult').html('Select Worker ID');

										//-----------get Included Line--------------//
										var action = "getline";
										var actionmode = "userform";
										$.ajax({
											type: 'POST',
											url: 'amountincluded.php',
											data:{action:action, actmode:actionmode, WorkID:SelworkId, AEpayId:AEpayId},
											beforeSend:function(){
											
												$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
											},
											success: function(data){
												//payline='';
												//document.getElementById("HDincAcc").value = "";
												$('#lineresult').html(data);
											}
										}); 	
										//-----------get Included Line--------------//

										//-----------get Excluded Line--------------//
										var action = "getexline";
										var actionmode = "userform";
										$.ajax({
											type: 'POST',
											url: 'amountexcluded.php',
											data:{action:action, actmode:actionmode, WorkID:SelworkId, AEpayId:AEpayId},
											beforeSend:function(){
											
												$("#exlineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
											},
											success: function(data){
												//payline='';
												//document.getElementById("HDincAcc").value = "";
												$('#exlineresult').html(data);
											}
										}); 	
										//-----------get Excluded Line--------------//
										$('#HDincAcc').val() = '';

										//location.reload();					
										}
								}); 

							}
							else 
							{
								return false;
							}
							modal.style.display = "none";
			 			}

					}
					else
					{
						alert("Please Select a Date.");
					}

				}
			} 
			else
			{
				alert("Exclude amount should be less than the value.");
			}

		}
		else 
		{
			alert("Please Select a record you want to update.");
		}
		
		
		/*if(SelectedAcc != '') {
			if(evalue > excludenum){
				if(confirm("Are you sure you want to update this record?")) {
					var action = "update";
					$.ajax({	
							type: 'GET',
							url: 'amountexemptionprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, SelworkId:SelworkId, SelectedAcc:SelectedAcc, edate:edate, excludenum:excludenum, evalue:evalue, AEpayId:AEpayId},
							beforeSend:function(){
									
							$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							$('#lineresult').html(data);						
							$('#exlineresult').html('Select Worker ID');


							//location.reload();					
							}
					}); 

				}
				else 
				{
					return false;
				}
			}
			else{
				alert("The excluded amount should be less than the value.");
			}
				
		}
		else 
		{
			alert("Please Select a record you want to update.");
		}	*/		

	}

	function Included()
	{
		//modal.style.display = "none";
		//var SelectedVal = $('#hide').val();
		var SelworkId = $('#hide').val();
		var SelectedAcc = $('#IncAccId-EX').val();
		AEpayId = $('#hidefocus').val();
		//var accountcode = $('#HDincAcc-EX').val();

		//alert(SelectedAcc);

		var action = "include";
		if(SelectedAcc != '') {
			if(confirm("Are you sure you want to include this record?")) {
				$.ajax({	
						type: 'GET',
						url: 'amountexemptionprocess.php',
						//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
						data:{action:action, SelworkId:SelworkId, SelectedAcc:SelectedAcc},
						beforeSend:function(){
								
						//$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							
						},
						success: function(data){
						//$('#lineresult').html(data);
						//$('#exlineresult').html(data);
						//location.reload();
						//-----------get Included Line--------------//
						var action = "getline";
						var actionmode = "userform";
						$.ajax({
							type: 'POST',
							url: 'amountincluded.php',
							data:{action:action, actmode:actionmode, WorkID:SelworkId, AEpayId:AEpayId},
							beforeSend:function(){
							
								$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							},
							success: function(data){
								//payline='';
								//document.getElementById("HDincAcc").value = "";
								$('#lineresult').html(data);
							}
						}); 	
						//-----------get Included Line--------------//

						//-----------get Excluded Line--------------//
						var action = "getexline";
						var actionmode = "userform";
						$.ajax({
							type: 'POST',
							url: 'amountexcluded.php',
							data:{action:action, actmode:actionmode, WorkID:SelworkId, AEpayId:AEpayId},
							beforeSend:function(){
							
								$("#exlineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							},
							success: function(data){
								//payline='';
								//document.getElementById("HDincAcc").value = "";
								$('#exlineresult').html(data);
							}
						}); 	
						//-----------get Excluded Line--------------//

						document.getElementById("HDincAcc-EX").value = '';
						document.getElementById("IncAccId-EX").value = '';
						document.getElementById("ExAccId-EX").value = '';		
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
			alert("Please Check the Accounts you want to include.");
		}	
	}

	//--------------------Exclude Checkmark-------------------------//

	function removeA(arr) 
		{
		    var what, a = arguments, L = a.length, ax;
		    while (L > 1 && arr.length) {
		        what = a[--L];
		        while ((ax= arr.indexOf(what)) !== -1) {
		            arr.splice(ax, 1);
		        }
		    }
		    return arr;
		}

		var allVals = [];
		var uniqueNames = [];
		var remVals = [];
		var remValsEx = [];
		$('[name=chkbox]').change(function(){
			
		    if($(this).attr('checked'))
		    {
	      		//document.getElementById("IncAccId").value = $(this).val();
	      		Add();
		    }
		    else
		    {
					         
		         //document.getElementById("IncAccId").value=$(this).val();
		         remVals.push("'"+$(this).val()+"'");
		         $('#ExAccId').val(remVals);

		         $.each(remVals, function(i, el2){

		    		removeA(allVals, el2);
		    		removeA(uniqueNames, el2);
			    	//$("input[value="+el+"]").prop("checked", true);
			    	//alert(el);
				});
		        Add();

		    }
		 });

		/*$("#selectAll").change(function(){  //"select all" change 
   			 

   			 if(false == $(this).prop("checked")){ //if this item is unchecked
			        $('[name=chkbox]').prop('checked', false); //change "select all" checked status to false
			         allVals = [];
					 uniqueNames = [];
					 remVals = [];
					 remValsEx = [];
			        document.getElementById('IncAccId').value = '';
			        document.getElementById('ExAccId').value = '';
			        //alert('sample');

			    }
			    else
			    {
			    	$(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
			    	Add();
			    }

			});*/


		
		function Add() 
		{  

			
			$('#IncAccId').val('');
			 $('[name=chkbox]:checked').each(function() {
			   allVals.push("'"+$(this).val()+"'");
			 });

			  //remove existing rec start-----------------------
			 $('[name=chkbox]:disabled').each(function() {
			   
			   remValsEx.push("'"+$(this).val()+"'");
		         //$('#ExAccId').val(remValsEx);

		         $.each(remValsEx, function(i, el2){
		         		
		    		removeA(allVals, el2);
		    		removeA(uniqueNames, el2);
			    	//"'"+"PCC"+"'"
				});
			   
			 });
			 //remove existing rec end-

			 
				$.each(allVals, function(i, el){
				    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
				});
			
			 $('#IncAccId').val(uniqueNames);
			 
		} 
		function CheckedVal()
		{ 
			$.each(uniqueNames, function(i, el){
				    $("input[value="+el+"]").prop("checked", true);
				    //alert(el);
				});
		}

		function Cancel()
		{
			//alert(so);
			//window.location.href='workerform.php';
			var action = "unload";
			$.ajax({
				type: 'GET',
				url: 'amountexemptionprocess.php',
				data:{action:action},
				success: function(data) {
				    window.location.href='payrolltransaction.php';
			    }
			});  
		}
		//--------------------Exclude Checkmark end-------------------------//

		//--------------------Include Checkmark-------------------------//

		function INCremoveA(arr) 
		{
		    var what, a = arguments, L = a.length, ax;
		    while (L > 1 && arr.length) {
		        what = a[--L];
		        while ((ax= arr.indexOf(what)) !== -1) {
		            arr.splice(ax, 1);
		        }
		    }
		    return arr;
		}

		var INCallVals = [];
		var INCuniqueNames = [];
		var INCremVals = [];
		var INCremValsEx = [];
		$('[name=chkbox-inc]').change(function(){
			
		    if($(this).attr('checked'))
		    {
	      		//document.getElementById("IncAccId").value = $(this).val();
	      		INCAdd();
		    }
		    else
		    {
					         
		         //document.getElementById("IncAccId").value=$(this).val();
		         INCremVals.push("'"+$(this).val()+"'");
		         $('#ExAccId-EX').val(INCremVals);

		         $.each(INCremVals, function(i, el2){

		    		INCremoveA(INCallVals, el2);
		    		INCremoveA(INCuniqueNames, el2);
			    	//$("input[value="+el+"]").prop("checked", true);
			    	//alert(el);
				});
		        INCAdd();

		    }
		 });

		/*$("#selectAll").change(function(){  //"select all" change 
   			 

   			 if(false == $(this).prop("checked")){ //if this item is unchecked
			        $('[name=chkbox-inc]').prop('checked', false); //change "select all" checked status to false
			         INCallVals = [];
					 INCuniqueNames = [];
					 INCremVals = [];
					 INCremValsEx = [];
			        document.getElementById('IncAccId-EX').value = '';
			        document.getElementById('ExAccId-EX').value = '';
			        //alert('sample');

			    }
			    else
			    {
			    	$(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
			    	INCAdd();
			    }

			});*/


		
		function INCAdd() 
		{  

			
			$('#IncAccId-EX').val('');
			 $('[name=chkbox-inc]:checked').each(function() {
			   INCallVals.push("'"+$(this).val()+"'");
			 });

			  //remove existing rec start-----------------------
			 $('[name=chkbox-inc]:disabled').each(function() {
			   
			   INCremValsEx.push("'"+$(this).val()+"'");
		         //$('#ExAccId').val(remValsEx);

		         $.each(INCremValsEx, function(i, el2){
		         		
		    		INCremoveA(INCallVals, el2);
		    		INCremoveA(INCuniqueNames, el2);
			    	//"'"+"PCC"+"'"
				});
			   
			 });
			 //remove existing rec end-

			 
				$.each(INCallVals, function(i, el){
				    if($.inArray(el, INCuniqueNames) === -1) INCuniqueNames.push(el);
				});
			
			 $('#IncAccId-EX').val(INCuniqueNames);
			 

		} 
		function INCCheckedVal()
		{ 
			$.each(INCuniqueNames, function(i, el){
				    $("input[value="+el+"]").prop("checked", true);
				    //alert(el);
				});
		}

		function Cancel()
		{
			//alert(so);
			//window.location.href='workerform.php';
			var action = "unload";
			$.ajax({
				type: 'GET',
				url: 'amountexemptionprocess.php',
				data:{action:action},
				success: function(data) {
				    window.location.href='payrolltransaction.php';
			    }
			});  
		}

</script>
	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js">
		


	</script>
	<!-- end [JAVASCRIPT] -->

	

</body>
</html>