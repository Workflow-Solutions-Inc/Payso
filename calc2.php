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
	<title>Accounts Calculator</title>

	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body>-->





	<!-- begin LEFT PANEL -->
	<div id="leftpanel" class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<!--
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button><span class="fas fa-key"></span> Change Password</button></li>
			<li><button><span class="fas fa-sign-out-alt"></span> Logout</button></li>
		</ul>
		-->

	</div>
	<!-- end LEFT PANEL -->




	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->




	<!-- begin DASHBOARD -->
	<div class="mainpanel dashboard">


		<div class="container-fluid">


			<!-- TITLE -->
			<div class="row">
				<div class="col=lg-8 col-md-8 col-sm-12 col-xs-12">
					<div class="dashboard-maintitle"><i class="far fa-id-card color-orange"></i> Juan Dela Cruz</div>
				</div>
			</div>



			<!-- ROW 2 -->
			<div class="row">
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title"><i class="far fa-user-circle"></i> Computation</div>
						<hr>
						<div>
							<!-- calculator -->
							<div class="calculator card">

								<textarea class="calculator-screen z-depth-1" >1.0</textarea>
								<div class="calculator-keys">
									<button type="button" class="operator btn btn-info" value="btn1">btn1</button>
									<button type="button" class="operator btn btn-info" value="btn2">btn2</button>
									<button type="button" class="operator btn btn-info" value="btn3">btn3</button>
									<button type="button" class="operator btn btn-info" value="btn4">btn4</button>
								</div>

								<div class="calculator-keys">
									<button type="button" class="operator btn btn-info" value="+">+</button>
									<button type="button" class="operator btn btn-info" value="-">-</button>
									<button type="button" class="operator btn btn-info" value="/">/</button>
									<button type="button" class="operator btn btn-info" value="*">&times;</button>

									<button type="button" value="7" class="btn btn-light waves-effect">7</button>
									<button type="button" value="8" class="btn btn-light waves-effect">8</button>
									<button type="button" value="9" class="btn btn-light waves-effect">9</button>


									<button type="button" value="4" class="btn btn-light waves-effect">4</button>
									<button type="button" value="5" class="btn btn-light waves-effect">5</button>
									<button type="button" value="6" class="btn btn-light waves-effect">6</button>


									<button type="button" value="1" class="btn btn-light waves-effect">1</button>
									<button type="button" value="2" class="btn btn-light waves-effect">2</button>
									<button type="button" value="3" class="btn btn-light waves-effect">3</button>


									<button type="button" value="0" class="btn btn-light waves-effect">0</button>
									<button type="button" class="decimal function btn btn-secondary" value=".">.</button>
									<button type="button" class="all-clear function btn btn-danger btn-sm" value="all-clear">AC</button>

									<button type="button" class="equal-sign operator btn btn-warning" value="=">=</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title"><i class="far fa-user-circle"></i> Title</div>
						<hr>
						<div>
							Lorem Ipsum dolor sit amet
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