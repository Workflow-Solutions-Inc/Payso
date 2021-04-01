<?php 
session_start();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Payroll Transaction</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>

</head>
<body>


	<!-- begin LEFTPANEL -->
	<div id="leftpanel" class="leftpanel hidden-sm hidden-xs">
		<div class="leftpanel-admin">
			<div class="admin-icon"><img src="images/admin-icon.png"></div>
			<div class="admin-text">
				<div><b>Admin Name</b></div>
				<div><?php echo $user;?> / <?php echo $currentDateTime;?></div>
			</div>
		</div>
		<ul class="leftpanel-nav">
			<li><button id="myAddBtn"><span class="fa fa-home fa-wrench fa-lg"></span> Create Record</button></li>
			<li><button onClick="Delete();"><span class="fa fa-home fa-wrench fa-lg"></span> Delete Record</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-home fa-wrench fa-lg"></span> Update Record</button></li>
		</ul>
		<ul class="leftpanel-nav leftpanel-dark">
			<li><a href="#"><span class="fa fa-cog fa-lg"></span> hyperlink 1</a></li>
			<li><a href="#"><span class="fa fa-home fa-lg"></span> hyperlink 2</a></li>
			<li><a href="#"><span class="fa fa-home fa-lg"></span> hyperlink 3</a></li>
		</ul>
		<ul class="leftpanel-nav leftpanel-darker">
			<li><button><span class="fa fa-home fa-lg"></span> button 1</button></li>
			<li><button><span class="fa fa-home fa-lg"></span> button 2</button></li>
			<li><button><span class="fa fa-home fa-lg"></span> button 3</button></li>
		</ul>
		<div class="leftpanel-min">
			<span id="leftpanel-minimize-button" class="minimize fa fa-chevron-circle-left"></span>
		</div>
	</div>
	<!-- end LEFTPANEL -->


	<!-- begin LEFTPANEL BAR (MINI) -->
	<div id="leftpanel-bar" class="leftpanel-bar">
		<div class="leftpanel-max">
			<span id="leftpanel-maximize-button" class="maximize fa fa-chevron-circle-right"></span>
		</div>
	</div>
	<!-- end LEFTPANEL BAR (MINI) -->



	<!-- begin MAINPANEL -->
	<div id="mainpanel" class="mainpanel">

		<!-- HEADER -->
		<div class="header">
			<div class="togglepos hidden-sm hidden-xs">
				<button id="changeposition-6-button" class="btn"><span class="fa fa-columns fa-lg"></span></button>
				<button id="changeposition-12-button" class="btn hide"><span class="fa fa-columns fa-lg fa-rotate-270"></span></button>
			</div>

			<div class="header-container">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 item active"><a href="menu.php">
							<span class="fa fa-list"></span> <span class="hidden-xs hidden-sm">Common Forms</span></a></div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 item"><a href="#">
							<span class="fa fa-cog"></span> <span class="hidden-xs hidden-sm">Setup</span></a></div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 item"><a href="#">
							<span class="fa fa-edit"></span> <span class="hidden-xs hidden-sm">Reports</span></a></div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 item"><a href="#">
							<span class="fa fa-info"></span> <span class="hidden-xs hidden-sm">Inquiry</a></div>
					</div>
				</div>
			</div>
		</div>



		<div class="container-fluid">
			<div class="row">
				<!-- start TABLE AREA -->
				<div id="tablearea1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-table">
						<!-- title & search -->
						<div class="mainpanel-title">
							
							<form action="dosomething.php" target="_self">
								<div class="mainpanel-sub-search">Search: <input type="text"> <input type="submit" value="Find"></div>
							</form>

							<div class="mainpanel-title-text"><span class="fa fa-archive"></span> Overview</div>
						</div>
						<div class="mainpanel-sub">
							<!-- cmd -->
							<div class="mainpanel-sub-cmd">
								<a href=""><span class="fa fa-cog"></a>
								<a href=""><span class="fa fa-cog"></a>
								<a href=""><span class="fa fa-cog"></a>
									|
								<a href=""><span class="fa fa-cog"></a>
								<a href=""><span class="fa fa-cog"></a>
							</div>
							<!-- nav -->
							<div class="mainpanel-sub-nav">
								<a href="#"><span class="fa fa-angle-double-left"></a>
								<a href="#"><span class="fa fa-angle-left"></a>
								<span> [ 1 of 10 ] </span>
								<a href="#"><span class="fa fa-angle-right"></a>
								<a href="#"><span class="fa fa-angle-double-right"></a>
							</div>
						</div>
						<!-- tableheader -->
						<table width="100%" border="0" id="datatbl">
							<thead>
								<tr class="rowB rowactive">
									<td><span class="fa fa-adjust"></span></td>
									<td style="width:14%;">Branch</td>
									<td style="width:14%;">Payment Type</td>
									<td style="width:14%;">Payroll ID</td>
									<td style="width:14%;">Payroll Period</td>
									<td style="width:14%;">From Date</td>
									<td style="width:14%;">To Date</td>
									<td style="width:14%;">Status</td>
									
								</tr>
								<tr class="rowA">
								  <td><span class="fa fa-adjust"></span></td>
								  

									<td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchBranch" class="search">
									<?php
										$query = "SELECT distinct bh.name as branch
													from payrollheader ph 
													left join branch bh on ph.branchcode = bh.branchcode and ph.dataareaid = bh.dataareaid
													where ph.dataareaid = '$dataareaid' 
													order by ph.payrollid asc";
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
								  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchPayment" class="search" disabled>
									<?php
										$query = "SELECT distinct case when paymenttype = 0 then 'Cash' when paymenttype = 1 then 'ATM' 
													else '' end as 'Payment' from payrollheader ph 
													where ph.dataareaid = '$dataareaid'";
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
								  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchFromDate" class="search">
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
								  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchToDate" class="search">
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
													ph.payrollid, 
													ph.payrollperiod,
													fromdate, 
													todate,
													case when payrollstatus = 0 then 'Created' 
														when payrollstatus = 1 then 'Submitted' 
														when payrollstatus = 2 then 'Canceled' 
														when payrollstatus = 3 then 'Approved' 
														when payrollstatus = 4 then 'Disapproved' 
													else '' end as 'status'

													from payrollheader ph 
													left join branch bh on ph.branchcode = bh.branchcode and ph.dataareaid = bh.dataareaid

													where ph.dataareaid = '$dataareaid' 

													order by ph.payrollid asc
													";
									$result = $conn->query($query);
									while ($row = $result->fetch_assoc())
									{ ?>
										<tr class="rowA">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td><span class="fa fa-adjust"></span></td>
											<td><?php echo $row['branch'];?></td>
											<td><?php echo $row['Payment'];?></td>
											<td><?php echo $row['payrollid'];?></td>
											<td><?php echo $row['payrollperiod'];?></td>
											<td><?php echo $row['fromdate'];?></td>
											<td><?php echo $row['todate'];?></td>
											<td><?php echo $row['status'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>

									<?php }
									$result2 = $conn->query($query);
										$row2 = $result2->fetch_assoc();
										$firstresult = $row2["payrollid"];
									?>
										
							</tbody>
							<input type="input" id="hide">							
						</table>
					</div>
				</div>
				<!-- end TABLE AREA -->

				<!-- start TABLE AREA -->
				<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-table">
						<!-- title & search -->
						<div class="mainpanel-title">
							
							<form action="dosomething.php" target="_self">
								<div class="mainpanel-sub-search">Search: <input type="text"> <input type="submit" value="Find"></div>
							</form>
							
							<div class="mainpanel-title-text"><span class="fa fa-archive"></span> Overview</div>
						</div>
						<div class="mainpanel-sub">
							<!-- cmd -->
							<div class="mainpanel-sub-cmd">
								<a href=""><span class="fa fa-cog"></a>
								<a href=""><span class="fa fa-cog"></a>
								<a href=""><span class="fa fa-cog"></a>
									|
								<a href=""><span class="fa fa-cog"></a>
								<a href=""><span class="fa fa-cog"></a>
							</div>
							<!-- nav -->
							<div class="mainpanel-sub-nav">
								<a href="#"><span class="fa fa-angle-double-left"></a>
								<a href="#"><span class="fa fa-angle-left"></a>
								<span> [ 1 of 10 ] </span>
								<a href="#"><span class="fa fa-angle-right"></a>
								<a href="#"><span class="fa fa-angle-double-right"></a>
							</div>
						</div>

						<!-- table -->
						<table width="100%" border="0" id="dataln">
							<thead>
								<tr class="rowB rowactive">
									<td><span class="fa fa-adjust"></span></td>
									<td style="width:20%;">Account Code</td>
									<td style="width:20%;">Name</td>
									<td style="width:20%;">UM</td>
									<td style="width:20%;">Type</td>
									<td style="width:20%;">Value</td>
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
									while ($row = $result->fetch_assoc())
									{ ?>
										<tr class="rowA">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td><span class="fa fa-adjust"></span></td>
											<td><?php echo $row['accountcode'];?></td>
											<td><?php echo $row['accountname'];?></td>
											<td><?php echo $row['um'];?></td>
											<td><?php echo $row['accounttype'];?></td>
											<td><?php echo $row['value'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>

									<?php }?>
							</tbody>
							<input type="input" id="hide2">	
						</table>
					</div>
				</div>
				<!-- end TABLE AREA -->
			</div>
		</div>
	</div>
	<!-- end MAINPANEL -->

<script src="js/ajax.js"></script>
	  	<script  type="text/javascript">

	  	var so='';
	  	var payline='';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'payrolltransactionline.php',
					data:{action:action, actmode:actionmode, PayId:so},
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
			});
		});

	  		$(document).ready(function(){
				$('#dataln tbody tr').click(function(){
					$('table tbody tr').css("color","black");
					$(this).css("color","orange");
					$('table tbody tr').removeClass("info");
					$(this).addClass("info");
					var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
					var payline = transnumline.toString();
					document.getElementById("hide2").value = payline;
					//alert(document.getElementById("hide").value);
						
						  
				});
			});

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
				data:{action:action, actmode:actionmode, PTBranch:PTBranch, PTId:PTId, PTPeriod:PTPeriod, PTFromDt:PTFromDt, PTToDt:PTToDt},
				//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
				beforeSend:function(){
				
					$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
	
				},
				success: function(data){
					$('#result').html(data);
					so='';
					document.getElementById("hide").value = so;
					var firstval = $('#hide3').val();
					//alert(document.getElementById("hide3").value);
					//-----------get line--------------//
						var action = "getline";
						var actionmode = "userform";
						$.ajax({
							type: 'POST',
							url: 'payrolltransactionline.php',
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


</script>
	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js">
		


	</script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>