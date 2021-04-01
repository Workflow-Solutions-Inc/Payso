<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>S : LOGIN</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body>


	<!-- begin LOGIN -->
	<div class="login" id="conttables">
		<div class="login-container">
			<div class="login-head">SIGN IN</div>

			<div class="login-innercontainer">
				<?php
				if(isset($_GET["invalid"])) {
					if($_GET["invalid"] > 1) {
						echo "<div class='login-notify'><span class='fas fa-info-circle'></span> Invalid username or password. Please enter again.</div>";
					}
					else if($_GET["invalid"] == 1) {
						echo "<div class='login-notify'><span class='fas fa-info-circle'></span> Invalid password. Please enter again.</div>";
					}
				}
				?>
				<form accept-charset="utf-8" action="loginprocess.php" method="post">
					<div><input type="text" class="logintext" value="" minlength="2" maxlength="30" placeholder="Username" id="login-name" name="username" required="required" pattern="[^()/><\][\\\x22,;|]+"></div>
					<div><input type="password" class="logintext" value="" minlength="2" maxlength="30" placeholder="Password" id="login-pass" name="password" required="required" pattern="[^()/><\][\\\x22,;|]+"></div>
					<br>
					<div class="loginbtn">
						<!--<a class="btn btn-primary btn-lg" href="#"onClick="logIn()">login</a>-->
						<input type="submit" name="submit" value="Sign in" class="btn btn-primary btn-lg">
						<input type="reset" value="Clear" class="btn btn-warning btn-lg">
					</div>
				</form>

			</div>
		</div>
	</div>
	<!-- end LOGIN -->





	<!-- begin [JAVASCRIPT] -->
	<script src="js/ajax.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>