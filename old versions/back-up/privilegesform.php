<?php 
session_start();
include("dbconn.php");
$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Priviledges</title>

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
			<li><button id="myAddBtn"><span class="fa fa-plus fa-lg"></span> Create Record</button></li>
			<li><button onClick="Delete();"><span class="fa fa-trash-alt fa-lg"></span> Delete Record</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-edit fa-lg"></span> Update Record</button></li>
		</ul>
		
		<!-- extra buttons -->
		<ul class="extrabuttons">
			<li><button><span class="fas fa-arrow-up fa"></span> Move Up</button></li>
			<li><button><span class="fas fa-arrow-down fa"></span> Move Down</button></li>
		</ul>

	</div>
	<!-- end LEFT PANEL -->




	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->


	<!-- begin LEFTPANEL BAR (MINI) -->
	<!--<div id="leftpanel-bar" class="leftpanel-bar">
		<div class="leftpanel-max">
			<span id="leftpanel-maximize-button" class="maximize fa fa-chevron-circle-right"></span>
		</div>
	</div>-->
	<!-- end LEFTPANEL BAR (MINI) -->



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
							<table width="100%" border="0" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowtitle">
										<td style="width:20px;"><span class="fa fa-adjust"></span></td>
										<td style="width:25%;">Privileges Id</td>
										<td style="width:25%;">Module</td>
										<td style="width:25%;">Sub Module</td>
										<td style="width:25%;">Name</td>
										<td style="width: 17px;"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td><span class="fa fa-adjust"></span></td>
									  

										<td><input style="width:100%;height: 20px;" list="SearchPrivilegesid" class="search">
										<?php
											$query = "SELECT distinct privilegesid FROM privileges";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPrivilegesid">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["privilegesid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input style="width:100%;height: 20px;" list="SearchModule" class="search">
										<?php
											$query = "SELECT distinct module FROM privileges";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchModule">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["module"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input style="width:100%;height: 20px;" list="SearchSubmodule" class="search">
										<?php
											$query = "SELECT distinct submodule FROM privileges";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchSubmodule">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["submodule"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM privileges";
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
									$query = "SELECT * FROM privileges";
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
											<td style="width:20px;"><span class="fa fa-adjust"></span></td>
											<td style="width:25%;"><?php echo $row['privilegesid'];?></td>
											<td style="width:25%;"><?php echo $row['module'];?></td>
											<td style="width:25%;"><?php echo $row['submodule'];?></td>
											<td style="width:25%;"><?php echo $row['name'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php }?>
								</tbody>
								<input type="input" id="hide">	
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
				<div class="col-lg-6">add info</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<?php
				/*if(isset($_GET["invalid"])) {
					if($_GET["invalid"] > 1) {
						echo "<div class='login-notify'><span class='fas fa-info-circle'></span> Invalid username or password. Please enter again.</div>";
					}
					else if($_GET["invalid"] == 1) {
						echo "<div class='login-notify'><span class='fas fa-info-circle'></span> Invalid password. Please enter again.</div>";
					}
				}*/
				?>
				<form name="myForm" accept-charset="utf-8" action="privilegesformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Privilege ID:</label>
							<input type="text" value="" placeholder="Privilege Id" id="add-privilege" name ="PriveId" class="modal-textarea" required="required">

							<label>Module:</label>
							<input type="text" value="" placeholder="Module" id="add-module" name ="PrivModule" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Sub Module:</label>
							<input type="text" value="" placeholder="Sub Module" id="add-submodule" name ="PrivSub" class="modal-textarea" required="required">

							<label>Name:</label>
							<input type="text" value="" placeholder="Name" id="add-name" name ="PrivName" class="modal-textarea" required="required">
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

<!-- begin [JAVASCRIPT] -->

<script src="js/ajax.js"></script>
	<script  type="text/javascript">

	  	var so='';
	  	var locPriveId;
		var locPrivModule;
		var locPrivSub;
		var locPrivName;
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locPrivModule = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locPrivSub = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locPrivName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
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
		    $("#add-privilege").prop('readonly', false);
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			    modal.style.display = "block";
			    $("#add-privilege").prop('readonly', true);
				document.getElementById("add-privilege").value = so;
				document.getElementById("add-module").value = locPrivModule.toString();
				document.getElementById("add-submodule").value = locPrivSub.toString();
				document.getElementById("add-name").value = locPrivName.toString();
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
		        Clear();
		        
		    }
		}
		//end modal --------------------------- 

		function validateForm() {
		  var x = document.forms["myForm"]["update"].value;
		  if (x == "update") {
		    if(confirm("Are you sure you want to update this record?")) {
		    	return true;
		    }
		    else
		    {
		    	modal.style.display = "none";
		    	Clear();
		    	return false;
		    }
		  }
		}

		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var PriveId;
			var PrivModule;
			var PrivSub;
			var PrivName;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 PriveId = data[0];
			 PrivModule = data[1];
			 PrivSub = data[2];
			 PrivName = data[3];
			
			

			
			 $.ajax({
						type: 'GET',
						url: 'privilegesformprocess.php',
						data:{action:action, actmode:actionmode, PriveId:PriveId, PrivModule:PrivModule, PrivSub:PrivSub, PrivName:PrivName},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#result').html(data);
				}
			}); 
			 
		  }
		});
		//-----end search-----//

		function Clear()
		{
			if(so != '') {
				//document.getElementById("add-privilege").value = "";
				document.getElementById("add-module").value = "";
				document.getElementById("add-submodule").value = "";
				document.getElementById("add-name").value = "";
			}
			else
			{
				document.getElementById("add-privilege").value = "";
				document.getElementById("add-module").value = "";
				document.getElementById("add-submodule").value = "";
				document.getElementById("add-name").value = "";
			}
		}

		function Save()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var PriveId = $('#add-privilege').val();
			var PrivModule = $('#add-module').val();
			var PrivSub = $('#add-submodule').val();
			var PrivName = $('#add-name').val();
			var action = "save";
			var actionmode = "userform";
			$.ajax({	
					type: 'GET',
					url: 'privilegesformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, actmode:actionmode, PriveId:PriveId, PrivModule:PrivModule, PrivSub:PrivSub, PrivName:PrivName},
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
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var PriveId = $('#add-privilege').val();
			var PrivModule = $('#add-module').val();
			var PrivSub = $('#add-submodule').val();
			var PrivName = $('#add-name').val();
			var action = "update";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'privilegesformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, PriveId:PriveId, PrivModule:PrivModule, PrivSub:PrivSub, PrivName:PrivName},
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
							url: 'privilegesformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, PriveId:so},
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
		}

	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>