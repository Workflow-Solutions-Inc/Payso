<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
#$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>S : Dashboard</title>

	<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="https://cdn.anychart.com/releases/8.0.0/js/anychart-base.min.js"></script>
	<style type="text/css">
		

	html, body, #barcontainer {
	  width: 100%;
	  height: 1000px;
	  margin: 0;
	  padding: 0;
	}
	</style> 

</head>
<body> -->

	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->

	<!-- begin LEFT PANEL -->
	<div id="leftpanel" class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<!-- <ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button><span class="far fa-plus-square"></span> Create Record</button></li>
			<li><button><span class="fas fa-edit"></span> Update Record</button></li>
			<li><button><span class="far fa-trash-alt"></span> Delete Record</button></li>
		</ul> -->

		<!-- extra buttons -->
		<!-- <ul class="extrabuttons">
			<div class="leftpanel-title"><b>POSITION</b></div>
			<li><button><span class="fas fa-caret-up"></span> Move Up</button></li>
			<li><button><span class="fas fa-caret-down"></span> Move Down</button></li>
		</ul> -->

	</div>
	<!-- end LEFT PANEL -->

	<!-- begin DASHBOARD -->
	<div class="mainpanel dashboard">
		<div class="container-fluid">


			<!-- TITLE -->
			<div class="row">
				<div class="col=lg-8 col-md-8 col-sm-12 col-xs-12">
					<div class="dashboard-maintitle"><i class="fas fa-tachometer-alt"></i> Dashboard</div>
				</div>
				<div class="col=lg-4 col-md-4 col-sm-12 col-xs-12 text-right">
					<!-- <button class="btn btn-primary" onclick="test()"><i class="fas fa-file-alt"></i> Generate Report</button> -->
				</div>
			</div>
			<?php 
				$query = "SELECT format(ifnull(sum(value),0),2) as totalnet,DATE_FORMAT(pp.payrolldate, '%b') as month

							from payrollheader ph
							left join payrollheaderaccounts pha on pha.payrollid = ph.payrollid and pha.dataareaid = ph.dataareaid
							left join payrollperiod pp on pp.payrollperiod = ph.payrollperiod and pp.dataareaid = ph.dataareaid

							where accountcode = 'TNPAY'
							and (month(pp.payrolldate) = month(now()) and year(pp.payrolldate) = year(now()))
							and ph.payrollstatus = '3'
							and ph.dataareaid = '$dataareaid'
							group by DATE_FORMAT(pp.payrolldate, '%b')
							";

				$result = $conn->query($query);
				$rowclass = "rowA";
				$totalpayrollmon = 0;
				$month = '';
				
				while ($row = $result->fetch_assoc())
				{ 
						$totalpayrollmon = $row['totalnet'];
						$month = $row['month'];
				}
				?>



			<!-- ROW 1 -->
			<div class="row">
				<!-- ROW 1 - COLUMN 1 -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- blue -->
					<div class="dashboard-menu dashboard-menu-blue">
						<div class="dashboard-menu-title text-bold">
							Total Payroll For Month of (<?php echo $month;?>)
						</div>
						<div class="dashboard-menu-content">
							<b class="dashboard-menu-content-sm">₱ <?php echo $totalpayrollmon;?> </b>
						</div>
					</div>
				</div>

				<!-- Query -->
				<?php 
					$query = "SELECT format(sum(value),2) as totalnet,year(now()) as yr

								from payrollheader ph
								left join payrollheaderaccounts pha on pha.payrollid = ph.payrollid and pha.dataareaid = ph.dataareaid
								left join payrollperiod pp on pp.payrollperiod = ph.payrollperiod and pp.dataareaid = ph.dataareaid

								where accountcode = 'TNPAY'
								and pp.payrolldate >= concat(year(now()),'-01-01') and pp.payrolldate <= concat(year(now()),'-12-31')
								and ph.payrollstatus = '3'
								and ph.dataareaid = '$dataareaid'
								";

					$result = $conn->query($query);
					$rowclass = "rowA";
					$totalpayrollyr = 0;
					$yr = '';
					
					while ($row = $result->fetch_assoc())
					{ 
							$totalpayrollyr = $row['totalnet'];
							$yr = $row['yr'];
					}
					?>
				
				<!-- ROW 1 - COLUMN 2 -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- green -->
					<div class="dashboard-menu dashboard-menu-green">
						<div class="dashboard-menu-title text-bold">
							Total Payroll For Year of (<?php echo $yr;?>)
						</div>
						<div class="dashboard-menu-content">
							<b class="dashboard-menu-content-sm">₱ <?php echo $totalpayrollyr;?> </b>
						</div>
					</div>
				</div>

				<!-- Query -->
				<?php 
					$query = "SELECT 
								format(sum(pda.value),2) as thamount
								from payrollheader ph
								inner join payrolldetailsaccounts pda on pda.payrollid = ph.payrollid and
											
								pda.dataareaid = ph.dataareaid 
								left join payrollperiod pp on pp.payrollperiod = ph.payrollperiod and pp.dataareaid = ph.dataareaid

								where pda.accountcode = 'TMTH'
								and pp.payrolldate >= concat(year(now()),'-01-01') and pp.payrolldate <= concat(year(now()),'-12-31')
								and ph.payrollstatus = '3'
								and ph.dataareaid = '$dataareaid'
								";

					$result = $conn->query($query);
					$rowclass = "rowA";
					$runningbal = 0;
					
					while ($row = $result->fetch_assoc())
					{ 
							$runningbal = $row['thamount'];
					}
					?>
				
				<!-- ROW 1 - COLUMN 3 -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- orange -->
					<div class="dashboard-menu dashboard-menu-orange">
						<div class="dashboard-menu-title text-bold">
							Running 13th Month
						</div>
						<div class="dashboard-menu-content">
							<b class="dashboard-menu-content-sm">₱ <?php echo $runningbal;?> </b>
						</div>
					</div>
				</div>

				<!-- Query -->
				<?php 
					$query = "SELECT count(workerid) as activeworker from worker 

								where inactive = 0
								and dataareaid = '$dataareaid'";

					$result = $conn->query($query);
					$rowclass = "rowA";
					$totalactiveworker = 0;
					
					while ($row = $result->fetch_assoc())
					{ 
							$totalactiveworker = $row['activeworker'];
							

					}
					?>
				
				<!-- ROW 1 - COLUMN 4 -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- grey -->
					<div class="dashboard-menu dashboard-menu-grey">
						<div class="dashboard-menu-title text-bold">
							Total Active Worker
						</div>
						<div class="dashboard-menu-content">
							
							<b class="dashboard-menu-content-sm">Worker: <?php echo $totalactiveworker;?> </b>
						</div>
					</div>
				</div>
			</div>






			<!-- ROW 2 -->
			<div class="row">
				<!-- ROW 2 - COLUMN 1 -->
				<div id="tablearea1" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mainpanel-area">
					<div class="dashboard-content">
						<div class="dashboard-title"><i class="fas fa-file-signature"></i> Top Employee In terms of Salary</div>
						
							<div id="container1" class="half">
								<table border="1" class="dashboard-table table table-striped mainpanel-table">
									<thead>	
										<tr class="rowtitle">
											<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
											<td style="width:33%;">Name</td>
											<td style="width:33%;" class="green">Position</td>
											<td style="width:33%;" class="green">Department</td>
											<td style="width:33%;" class="green">Branch</td>
											<td style="width:33%;" class="red">Total Gross</td>
											<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
										</tr>
									</thead>
									<tbody id="result2">

										<?php					
										$query = "SELECT 
													wk.name
													,pos.name as pos
													,dep.name as dept
													,bra.name as 'branch'
													,format(sum(value),2) GPAY
													                
																	from payrollheader ph
													                
													                left join payrolldetails pd on pd.payrollid = ph.payrollid and pd.dataareaid = ph.dataareaid 
													                
																	inner join payrolldetailsaccounts pda on pda.payrollid = ph.payrollid and
																		pda.dataareaid = ph.dataareaid and pda.reflinenum = pd.linenum
													                
																	left join payrollperiod pp on pp.payrollperiod = ph.payrollperiod and pp.dataareaid = ph.dataareaid
													                
													                left join worker wk on wk.workerid = pd.workerid and wk.dataareaid = ph.dataareaid
													                
													                left join contract con on con.workerid = pd.workerid and con.dataareaid = ph.dataareaid
													                left join ratehistory rh  on 
																		rh.contractid = con.contractid and rh.dataareaid = con.dataareaid
													                    
													                left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
																	left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid
																	left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid

																	where pda.accountcode = 'NPAY'
																	and DATE_FORMAT(pp.payrolldate,'%Y-%m') >= DATE_FORMAT(now() - INTERVAL 12 month,'%Y-%m')
																	#and DATE_FORMAT(pp.payrolldate,'%Y-%m') != DATE_FORMAT(now(),'%Y-%m')
																	and ph.payrollstatus = '3'
																	and ph.dataareaid = '$dataareaid'
													                and wk.inactive = 0 
																	and rh.status = 1
																	
																	group by wk.name,pos.name,dep.name,bra.name
													                
													                order by sum(value) desc";

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
											<tr class="<?php echo $rowclass; ?>">
												<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
												<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
												<td style="width:33%;"><?php echo $row['name'];?></td>
												<td style="width:33%;"><?php echo $row['pos'];?></td>
												<td style="width:33%;"><?php echo $row['dept'];?></td>
												<td style="width:33%;"><?php echo $row['branch'];?></td>
												<td style="width:33%;"><?php echo $row['GPAY'];?></td>
												<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
												
											</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						
						
						<!-- <div class="dashboard-list">
							<table>
								<tr>
									<td width="45%">Juan Dela Cruz</td>
									<td width="40%">Position or Business Name</td>
									<td width="15%" class="text-right">
										<button class="dashboard-button-ok"><i class="fas fa-check"></i></button>
										<button class="dashboard-button-cancel"><i class="fas fa-times"></i></button>
									</td>
								</tr>
							</table>
						</div>
						<div class="dashboard-list">
							<table>
								<tr>
									<td width="45%">Lorem ipsum dolor</td>
									<td width="40%">Dolor sit amet</td>
									<td width="15%" class="text-right">
										<button class="dashboard-button-ok"><i class="fas fa-check"></i></button>
										<button class="dashboard-button-cancel"><i class="fas fa-times"></i></button>
									</td>
								</tr>
							</table>
						</div>
						<div class="dashboard-list">
							<table>
								<tr>
									<td width="45%">Deserunt Mollit Anim</td>
									<td width="40%">Duis aute irure dolor</td>
									<td width="15%" class="text-right">
										<button class="dashboard-button-ok"><i class="fas fa-check"></i></button>
										<button class="dashboard-button-cancel"><i class="fas fa-times"></i></button>
									</td>
								</tr>
							</table>
						</div>
						<div class="dashboard-list">
							<table>
								<tr>
									<td width="45%">Consectetur Adipiscing Elit</td>
									<td width="40%">Dolore Magna</td>
									<td width="15%" class="text-right">
										<button class="dashboard-button-ok"><i class="fas fa-check"></i></button>
										<button class="dashboard-button-cancel"><i class="fas fa-times"></i></button>
									</td>
								</tr>
							</table>
						</div>
						<div class="dashboard-list">
							<table>
								<tr>
									<td width="45%">Voluptate Velit Esse</td>
									<td width="40%">Business Name or Position</td>
									<td width="15%" class="text-right">
										<button class="dashboard-button-ok"><i class="fas fa-check"></i></button>
										<button class="dashboard-button-cancel"><i class="fas fa-times"></i></button>
									</td>
								</tr>
							</table>
						</div>
						<div class="dashboard-pagination text-right">
							<ul>
								<li><button disabled>Prev</button></li>
								<li><button class="active">1</button></li>
								<li><button>2</button></li>
								<li><button>3</button></li>
								<li><button>4</button></li>
								<li><button>5</button></li>
								<li><button>Next</button></li>
							</ul>
						</div> -->
					</div>
				</div>
				<!-- <div id="tablearea1" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mainpanel-area">
					<div class="dashboard-content">
						<div class="dashboard-title"><i class="fas fa-file-signature"></i> Top Employee In terms of Salary</div>
						
							<div id="container1" class="half">
								
							</div>
						
						
						
					</div>
				</div> -->

				<!-- ROW 2 - COLUMN 2 -->
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="dashboard-content">

						<div class="dashboard-title"><i class="fas fa-stream"></i> Month By Month Payroll Amount
								
								<div style="float:right;">
									<b><label style="width: 90px;color:red;font-size:20px;">Branch:</label></b>
									<select class="modal-textarea" name ="brpayroll" id="branchfilter" style="width: 200px;height: 30px; color:black;font-size:18px;">
									<option value="" selected="selected"></option>
									<?php
										$querys = "SELECT branchcode,name from branch where dataareaid = '$dataareaid'";
										$results = $conn->query($querys);			
										  	
											while ($rows = $results->fetch_assoc()) {
											?>
												<option value="<?php echo $rows["branchcode"];?>"><?php echo $rows["name"];?></option>
										<?php } 

										$branchresult = $conn->query($querys);
										$branchrow = $branchresult->fetch_assoc();
										$firstbranch = $branchrow["branchcode"];

										?>
								</select>
								</div>	
						</div>
						<!-- <div id="barcontainer" style="width: 100%; height: 250px;"></div> -->
						<div id="container1" class="half">
						 	<div id="payrollchart" style="width: 100%; height: 100%;" ></div>
						 </div>
						 <!-- <div class="dashboard-list-clear">
							<table>
								<tr>
									<td width="35%">Full Name & Position</td>
									<td width="10%" class="valign-top">Absents</td>
									<td width="55%">Meter</td>
								</tr>
							</table>
						</div> -->
						<!-- <div class="dashboard-list-clear">
							<table>
								<tr>
									<td width="35%">
										<b class="dashboard-font-l">Voluptate Velit Esse</b><br>
										Business Name or Position
									</td>
									<td width="10%" class="valign-top">
										<span class="dashboard-font-xxl">5</span>/10
									</td>
									<td width="55%">
										<div class="dashboard-meter dashboard-meter-lg">
											<div class="percent">50%</div>
											<div class="meter meter-color-orange" style="width: 50%">&nbsp;</div>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="dashboard-list-clear">
							<table>
								<tr>
									<td width="35%">
										<b class="dashboard-font-l">Lorem Ipsum Dolor</b><br>
										Sit Amet Consectetur
									</td>
									<td width="10%" class="valign-top">
										<span class="dashboard-font-xxl">2</span>/10
									</td>
									<td width="55%">
										<div class="dashboard-meter dashboard-meter-lg">
											<div class="percent">20%</div>
											<div class="meter meter-color-blue" style="width: 20%">&nbsp;</div>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="dashboard-list-clear">
							<table>
								<tr>
									<td width="35%">
										<b class="dashboard-font-l">Occaecat Cupidatat</b><br>
										Mollit Anim
									</td>
									<td width="10%" class="valign-top">
										<span class="dashboard-font-xxl">8</span>/10
									</td>
									<td width="55%">
										<div class="dashboard-meter dashboard-meter-lg">
											<div class="percent">80%</div>
											<div class="meter meter-color-red" style="width: 80%">&nbsp;</div>
										</div>
									</td>
								</tr>
							</table>
						</div> -->
						<!-- <div class="dashboard-pagination text-right">
							<ul>
								<li><button disabled>Prev</button></li>
								<li><button class="active">1</button></li>
								<li><button>2</button></li>
								<li><button>3</button></li>
								<li><button>Next</button></li>
							</ul>
						</div> -->
					</div> 
				</div>
			</div>

			<!-- ROW 2 -->
			<div class="row">
				<!-- ROW 2 - COLUMN 1 -->
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title"><i class="fas fa-stream"></i> Month By Month Tax Amount
							<div style="float:right;">
									<b><label style="width: 90px;color:red;font-size:20px;">Branch:</label></b>
									<select class="modal-textarea" name ="brTax" id="branchTaxfilter" style="width: 200px;height: 30px; color:black;font-size:18px;">
									<option value="" selected="selected"></option>
									<?php
										$querys = "SELECT branchcode,name from branch where dataareaid = '$dataareaid'";
										$results = $conn->query($querys);			
										  	
											while ($rows = $results->fetch_assoc()) {
											?>
												<option value="<?php echo $rows["branchcode"];?>"><?php echo $rows["name"];?></option>
										<?php } 

										$branchresult = $conn->query($querys);
										$branchrow = $branchresult->fetch_assoc();
										$firstbranch = $branchrow["branchcode"];

										?>
								</select>
							</div>	
						</div>
						<div id="taxchart" style="width: 100%; height: 320px;"></div>	
					</div>
				</div>


				<!-- ROW 2 - COLUMN 2 -->
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="dashboard-content">

						<div class="dashboard-title"><i class="fas fa-stream"></i> Month By Month Contribution Amount
								
								<div style="float:right;">
									<b><label style="width: 90px;color:red;font-size:20px;">Branch:</label></b>
									<select class="modal-textarea" name ="brContri" id="branchContributionfilter" style="width: 200px;height: 30px; color:black;font-size:18px;">
									<option value="" selected="selected"></option>
									<?php
										$querys = "SELECT branchcode,name from branch where dataareaid = '$dataareaid'";
										$results = $conn->query($querys);			
										  	
											while ($rows = $results->fetch_assoc()) {
											?>
												<option value="<?php echo $rows["branchcode"];?>"><?php echo $rows["name"];?></option>
										<?php } 

										$branchresult = $conn->query($querys);
										$branchrow = $branchresult->fetch_assoc();
										$firstbranch = $branchrow["branchcode"];

										?>
								</select>
								</div>	
						</div>
						 <div id="contributionchart" style="width: 100%; height: 320px;"></div>
					</div> 
				</div>
			</div>




			<!-- ROW 3 -->
			<!-- <div class="row">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title">Duis Aute</div>
						<div>
							Irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.
						</div>
						<hr>
						<div><button class="btn btn-primary">Dolor Sit Amet</button></div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title">Reprehenderit in Voluptate</div>
						<div>
							Velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa.
						</div>
						<hr>
						<div>
							<button class="btn btn-success"><i class="fas fa-check"></i> Accept</button>
							<button class="btn btn-danger"><i class="fas fa-times"></i> Decline</button>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title">Consectetur Adipiscing Elit</div>
						<div>
							Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
						</div>
						<hr>
						<div><button class="btn btn-warning">Lorem Ipsum</button></div>
					</div>
				</div>
			</div> -->





			<!-- ROW 4 -->
			<!-- <div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title"><i class="far fa-sticky-note"></i> Irure Dolor</div>
						<div>
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</div>
					</div>
				</div>
			</div>


		</div> -->
	</div>
	<!-- end MAINPANEL -->


	
	<!-- <script>
      anychart.onDocumentReady(function() {
 
        // set the data
        var data = {
            header: ["Name", "Death toll"],
            rows: [
              ["San-Francisco (1906)", 1500],
              ["Messina (1908)", 87000],
              ["Ashgabat (1948)", 175000],
              ["Chile (1960)", 10000],
              ["Tian Shan (1976)", 242000],
              ["Armenia (1988)", 25000],
              ["Iran (1990)", 50000]
        ]};
 
        // create the chart
        var chart = anychart.column();
 
        // add the data
        chart.data(data);
 
        // set the chart title
        chart.title("The deadliest earthquakes in the XXth century");
 
        // draw
        chart.container("barcontainer");
        chart.draw();
      });
    </script> -->
    <!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js">
	</script>
	<script type="text/javascript" src="js/loader.js"></script>
	<script type="text/javascript">
	window.onload = function()
	 {
	 	 
	 	 load_month_payroll('', 'Monthly Payroll');
	 	 load_month_contribution('', 'Monthly Contribution');
	 	 load_month_tax('', 'Monthly Tax');
	           // alert(1);
	 }

	 function test()
	 {
	 	
	 	load_month_contribution('2021', 'Monthly Contribution');
	 }

	google.charts.load('current', {packages:['corechart', 'bar']});
	google.charts.setOnLoadCallback();

	function load_month_payroll(year, title)
	{
		
		var attbranch='';
	  			attbranch = document.getElementById("branchfilter").value;
	  	//alert(attbranch);
		var action = "getMonthlyPayroll";
	    var temp_title = title + ' ' + year;
	    $.ajax({
	        url: 'dashboardprocess.php',
	        method:"POST",
	        data:{action:action, attbranch:attbranch},
	        dataType:"JSON",
	        success:function(data)
	        {
	            drawPayrollChart(data, temp_title);
	        }
	    });
	}

	function drawPayrollChart(chart_data, chart_main_title)
	{
	    var jsonData = chart_data;
	    var data = new google.visualization.DataTable();
	    data.addColumn('string', 'Month');
	    data.addColumn('number', 'Basic Pay');
	    data.addColumn('number', 'Gross Pay');
	    data.addColumn('number', 'Net Pay');

	    $.each(jsonData, function(i, jsonData){
	        var month = jsonData.month;
	        var BPAY = parseFloat($.trim(jsonData.BPAY));
	        var GPAY = parseFloat($.trim(jsonData.GPAY));
	        var NPAY = parseFloat($.trim(jsonData.NPAY));
	        data.addRows([[month, BPAY, GPAY, NPAY]]);
	    });

	    var options = {
	        title:chart_main_title,
	        hAxis: {
	            title: "Months"
	        },
	        vAxis: {
	            title: 'Total Net Pay'
	        },
	        chartArea:{width:'70%',height:'50%'}
	    }

	    var payrollchart = new google.visualization.ColumnChart(document.getElementById('payrollchart'));
	    

	    payrollchart.draw(data, options);
	}

	function load_month_contribution(year, title)
	{
		
		var attbranch='';
	  			attbranch = document.getElementById("branchContributionfilter").value;
	  
		var action = "getMonthlyContribution";
	    var temp_title = title + ' ' + year;
	    $.ajax({
	        url: 'dashboardprocess.php',
	        method:"POST",
	        data:{action:action, attbranch:attbranch},
	        dataType:"JSON",
	        success:function(data)
	        {
	            drawContributionChart(data, temp_title);
	            
	        }
	    });
	}

	function drawContributionChart(chart_data, chart_main_title)
	{
	    var jsonData = chart_data;
	    var data = new google.visualization.DataTable();
	    data.addColumn('string', 'Month');
	    data.addColumn('number', 'SSS');
	    data.addColumn('number', 'PHIC');
	    data.addColumn('number', 'HDMF');

	    $.each(jsonData, function(i, jsonData){
	        var month = jsonData.month;
	        var SSS = parseFloat($.trim(jsonData.SSS));
	        var PHIC = parseFloat($.trim(jsonData.PHIC));
	        var HDMF = parseFloat($.trim(jsonData.HDMF));
	        data.addRows([[month, SSS, PHIC, HDMF]]);
	    });

	    var options = {
	        title:chart_main_title,
	        hAxis: {
	            title: "Months"
	        },
	        vAxis: {
	            title: 'Contribution'
	        },
	        chartArea:{width:'70%',height:'50%'}
	    }

	    
	    var contributionchart = new google.visualization.ColumnChart(document.getElementById('contributionchart'));

	    
	    contributionchart.draw(data, options);
	}

	function load_month_tax(year, title)
	{
		
		var attbranch='';
	  			attbranch = document.getElementById("branchTaxfilter").value;
	  
		var action = "getMonthlyTax";
	    var temp_title = title + ' ' + year;
	    $.ajax({
	        url: 'dashboardprocess.php',
	        method:"POST",
	        data:{action:action, attbranch:attbranch},
	        dataType:"JSON",
	        success:function(data)
	        {
	            drawtaxChart(data, temp_title);
	            
	        }
	    });
	}

	function drawtaxChart(chart_data, chart_main_title)
	{
	    var jsonData = chart_data;
	    var data = new google.visualization.DataTable();
	    data.addColumn('string', 'Month');
	    data.addColumn('number', 'TAX');

	    $.each(jsonData, function(i, jsonData){
	        var month = jsonData.month;
	        var TAX = parseFloat($.trim(jsonData.TAX));
	        data.addRows([[month, TAX]]);
	    });

	    var options = {
	        title:chart_main_title,
	        hAxis: {
	            title: "Months"
	        },
	        vAxis: {
	            title: 'Contribution'
	        },
	        chartArea:{width:'70%',height:'50%'}
	    }

	    
	    var taxchart = new google.visualization.ColumnChart(document.getElementById('taxchart'));

	    
	    taxchart.draw(data, options);
	}

	$(document).ready(function(){
	    $('#branchfilter').change(function(){
	        load_month_payroll('', 'Monthly Payroll');
	        //alert(1);
	    });
	});

	$(document).ready(function(){
	    $('#branchContributionfilter').change(function(){
	        load_month_contribution('', 'Monthly Contribution');
	        //alert(1);
	    });
	});

	$(document).ready(function(){
	    $('#branchTaxfilter').change(function(){
	        load_month_tax('', 'Monthly Tax');
	        //alert(1);
	    });
	});

	</script>

	<!-- end [JAVASCRIPT] -->

</body>
</html>