<?php 
session_start();
include("dbconn.php");
#$user = $_SESSION["user"];
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
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button><span class="far fa-plus-square"></span> Create Record</button></li>
			<li><button><span class="fas fa-edit"></span> Update Record</button></li>
			<li><button><span class="far fa-trash-alt"></span> Delete Record</button></li>
		</ul>

		<!-- extra buttons -->
		<ul class="extrabuttons">
			<div class="leftpanel-title"><b>POSITION</b></div>
			<li><button><span class="fas fa-caret-up"></span> Move Up</button></li>
			<li><button><span class="fas fa-caret-down"></span> Move Down</button></li>
		</ul>

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
					<button class="btn btn-primary"><i class="fas fa-file-alt"></i> Generate Report</button>
				</div>
			</div>




			<!-- ROW 1 -->
			<div class="row">
				<!-- ROW 1 - COLUMN 1 -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- blue -->
					<div class="dashboard-menu dashboard-menu-blue">
						<div class="dashboard-menu-title text-bold">
							Lorem ipsum dolor (January)
						</div>
						<div class="dashboard-menu-content">
							P20,703.00
						</div>
					</div>
				</div>
				
				<!-- ROW 1 - COLUMN 2 -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- green -->
					<div class="dashboard-menu dashboard-menu-green">
						<div class="dashboard-menu-title text-bold">
							Dolor Sit Amet (2020)
						</div>
						<div class="dashboard-menu-content">
							P210,305.00
						</div>
					</div>
				</div>
				
				<!-- ROW 1 - COLUMN 3 -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- orange -->
					<div class="dashboard-menu dashboard-menu-orange">
						<div class="dashboard-menu-title text-bold">
							Consectetur Adipiscing
						</div>
						<div class="dashboard-menu-contentmeter">
							<div class="percent">50%</div>
							<div class="meter meter-color-orange" style="width: 50%">&nbsp;</div>
						</div>
					</div>
				</div>
				
				<!-- ROW 1 - COLUMN 4 -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- grey -->
					<div class="dashboard-menu dashboard-menu-grey">
						<div class="dashboard-menu-title text-bold">
							Laboris Nisi ut Aliquip
						</div>
						<div class="dashboard-menu-content">
							20 / 100
						</div>
					</div>
				</div>
			</div>






			<!-- ROW 2 -->
			<div class="row">
				<!-- ROW 2 - COLUMN 1 -->
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title"><i class="fas fa-file-signature"></i> Lorem Ipsum</div>
						<div class="dashboard-list">
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
						</div>
					</div>
				</div>


				<!-- ROW 2 - COLUMN 2 -->
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title"><i class="fas fa-stream"></i> Dolor Sit Amet</div>
						<div class="dashboard-list-clear">
							<table>
								<tr>
									<td width="35%">Full Name & Position</td>
									<td width="10%" class="valign-top">Absents</td>
									<td width="55%">Meter</td>
								</tr>
							</table>
						</div>
						<div class="dashboard-list-clear">
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
						</div>
						<div class="dashboard-pagination text-right">
							<ul>
								<li><button disabled>Prev</button></li>
								<li><button class="active">1</button></li>
								<li><button>2</button></li>
								<li><button>3</button></li>
								<li><button>Next</button></li>
							</ul>
						</div>
					</div>
				</div>
			</div>





			<!-- ROW 3 -->
			<div class="row">
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
			</div>





			<!-- ROW 4 -->
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title"><i class="far fa-sticky-note"></i> Irure Dolor</div>
						<div>
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
	<!-- end MAINPANEL -->


	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>