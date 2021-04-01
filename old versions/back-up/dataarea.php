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
	<title>S : Data Area</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body>



	<!-- begin LEFT PANEL -->
	<div class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<li><button><span class="fas fa-home fa"></span> Inquiry</button></li>
			<li><button><span class="fas fa-home fa"></span> Inquiry</button></li>
			<li><button><span class="fas fa-home fa"></span> Inquiry</button></li>
			<li><button><span class="fas fa-home fa"></span> Inquiry</button></li>
		</ul>

		<!-- extra buttons -->
		<ul class="extrabuttons">
			<li><button><span class="fas fa-arrow-up"></span> Move Up</button></li>
			<li><button><span class="fas fa-arrow-down"></span> Move Down</button></li>
			<li>
				<!-- TOGGLE POSITION -->
				
				<div class="hidden-sm hidden-xs">
					<button id="changeposition-6-button" class=""><span class="fas fa-window-restore"></span> Change Position</button>
					<button id="changeposition-12-button" class="hide"><span class="fas fa-window-restore fa-rotate-270"></span> Change Position</button>
				</div>
			
			</li>
		</ul>

	</div>
	<!-- end LEFT PANEL -->



	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->




	<!-- begin MAINPANEL -->
	<div id="mainpanel" class="mainpanel">
		<div class="container-fluid">
			<div class="row">


				
				<!-- start TABLE AREA -->
				<div id="tablearea1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> Overview
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
						</div>
						<!-- tableheader -->
						<div id="container1" class="full">
							<table width="100%" border="0" id="datatbl" class="table mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;"><span class="fa fa-adjust"></span></td>
										<td style="width:48%;">Dataarea id</td>
										<td style="width:48%;">Name</td>
										<td style="width: 17px;"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
										<td><span class="fa fa-adjust"></span></td>
										<td><input list="SearchDataareaid">
										<?php
											$query = "SELECT distinct dataareaid FROM dataarea";
											$result = $conn->query($query);
									  	?>
									  <datalist id="SearchDataareaid">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["dataareaid"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchName">
										<?php
											$query = "SELECT distinct name FROM dataarea";
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
									$query = "SELECT * FROM dataarea";
									$result = $conn->query($query);
									$rowclass = "rowA";
									$rowcnt = 0;
									while ($row = $result->fetch_assoc())
									{ ?>
										<?php
											$rowcnt++;
											if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
											else { $rowclass = "rowA"; }
										?>
										<tr class=<?php echo $rowclass; ?>>
											<td style="width:20px;"><span class="fa fa-adjust"></span></td>
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:50%;"><?php echo $row['dataareaid'];?></td>
											<td style="width:50%;"><?php echo $row['name'];?></td>
										</tr>
									<?php }?>
								</tbody>
								<input type="input" id="hide">	
							</table>
						</div>
					</div>
				</div>
				<!-- end TABLE HERE -->



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

					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<label>User ID:</label>
						<input type="text" value="" placeholder="User Id" id="add-UserId" class="modal-textarea">

						<label>Name:</label>
						<input type="text" value="" placeholder="Name" id="add-name" class="modal-textarea">
					</div>

					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<label>Dataarea ID:</label>
						<input type="text" value="" placeholder="Default Dataarea Id" id="add-dataareaid"  list="DefaultDataarea" class="modal-textarea">
							<?php
								$query = "SELECT distinct dataareaid FROM dataarea";
								$result = $conn->query($query);			
						  	?>
						<datalist id="DefaultDataarea">
							<?php 
								while ($row = $result->fetch_assoc()) {
							?>
								<option value="<?php echo $row["dataareaid"];?>"></option>
							<?php } ?>
						</datalist>
						<!--<input type="text" value="" placeholder="Default Dataarea Id" id="add-dataareaid" class="modal-textarea">-->

						<label>Password:</label>
						<input type="password" value="" placeholder="Password" id="add-pass" class="modal-textarea">
					</div>

				</div>

				<div class="button-container">
					<button id="addbt" onClick="Save();" class="btn btn-primary btn-action">Save</button>
					<button id="upbt" onClick="Update();" class="btn btn-success btn-action">Update</button>
					<button onClick="Clear();" class="btn btn-danger">Clear</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end modal-->


<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	<script  type="text/javascript">

		var so='';
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			so = usernum.toString();
			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);	
						  
				});
			});

		// Get the modal -------------------
		var modal = document.getElementById('myModal');
		// Get the button that opens the modal
		var CreateBtn = document.getElementById("myAddBtn");
		var UpdateBtn = document.getElementById("myUpdateBtn");
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("modal-close")[0];
		// When the user clicks the button, open the modal 
		CreateBtn.onclick = function() {
		    modal.style.display = "block";
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			    modal.style.display = "block";
			    $("#add-UserId").prop('readonly', true);
				document.getElementById("add-UserId").value = document.getElementById("hide").value;
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
		    Clear();
		}
		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
		    if (event.target == modal || event.target == modal2) {
		        modal.style.display = "none";
		        Clear()
		        
		    }
		}
		//end modal --------------------------- 
		function Clear()
		{
			document.getElementById("add-UserId").value = "";
			document.getElementById("add-pass").value = "";
			document.getElementById("add-name").value = "";
			document.getElementById("add-dataareaid").value = "";
		}
	</script>
	
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->
</body>
</html>