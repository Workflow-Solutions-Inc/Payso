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
	<title>Department</title>

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
	<div class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<li><button id="myAddBtn"><span class="fa fa-home fa-wrench fa-lg"></span> Create Record</button></li>
			<li><button onClick="Delete();"><span class="fa fa-home fa-wrench fa-lg"></span> Delete Record</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-home fa-wrench fa-lg"></span> Update Record</button></li>
			<li><button><span class="fas fa-home fa"></span> Inquiry</button></li>
		</ul>

		<!-- extra buttons -->
		<ul class="extrabuttons">
			<li><button><span class="fas fa-arrow-up"></span> Move Up</button></li>
			<li><button><span class="fas fa-arrow-down"></span> Move Down</button></li>
			<li><button><span class="fas fa-window-restore"></span> Change</button></li>
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
							<span class="fa fa-archive"></span> Overview
						</div>
						<div class="mainpanel-sub">
							<!-- cmd -->
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
						</div>
						<!-- tableheader -->
						<div id="container1" class="half">
							<table width="100%" border="0" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowB rowtitle">
										<td style="width:20px;"><span class="fa fa-adjust"></span></td>
										<td style="width:19%;">Worker ID</td>
										<td style="width:19%;">Name</td>
										<td style="width:19%;">Position</td>
										<td style="width:19%;">Service Incentive Leave</td>
										<td style="width:19%;">Birthday Leave</td>
										<td style="width:5%;">BIR</td>
										<td style="width: 17px;"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td><span class="fa fa-adjust"></span></td>
									  

									  <td><input style="width:100%;height: 20px;" list="SearchDepartment" class="search">
										<?php
											$query = "SELECT distinct departmentid FROM department where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchDepartment">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["departmentid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM department where dataareaid = '$dataareaid'";
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
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM department where dataareaid = '$dataareaid'";
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
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM department where dataareaid = '$dataareaid'";
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
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM department where dataareaid = '$dataareaid'";
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
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM department where dataareaid = '$dataareaid'";
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
									$query = "SELECT wk.workerid,wk.Name,pos.name as 'position',wk.serviceincentiveleave,wk.birthdayleave,wk.birdeclared FROM worker wk
													left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
													where wk.dataareaid = '$dataareaid'";
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
											<td style="width:20px;"><span class="fa fa-angle-right"></span></td>
											<td style="width:19%;"><?php echo $row['workerid'];?></td>
											<td style="width:19%;"><?php echo $row['Name'];?></td>
											<td style="width:19%;"><?php echo $row['position'];?></td>
											<td style="width:19%;"><?php echo $row['serviceincentiveleave'];?></td>
											<td style="width:19%;"><?php echo $row['birthdayleave'];?></td>
											<td style="width:5%;"><input type="checkbox" name="chkbox" class="checkbox"  value="true" <?php echo ($row['birdeclared']==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['birdeclared'];?></div></td>
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="input" id="hide">	
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






	<!-- start FORM -->
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- tableheader -->
						<div class="half">
							<div class="row">
								<div class="formset">

									<!-- left -->
									<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
										
										<div class="formpic">
											<img src="images/pic.jpg">
										</div>
										<div class="formitem">
											<div class="text-center">Worker ID:</div>
											<input type="textbox" class="textbox text-center width-full">
										</div>

									</div>

									<!-- middle -->
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="mainpanel-title">
											<span class="fa fa-archive"></span> Personal Info
										</div>
										
										<div class="formitem">
											Full Name:<br>
											<input type="text" class="textbox" placeholder="First Name" class="width-xs">
											<input type="text" class="textbox" placeholder="Middle Name" class="width-xs">
											<input type="text" class="textbox" placeholder="Last Name" class="width-xs">
										</div>
										<div class="formitem">
											<span class="label-lg">Birthdate:</span>
											<input type="date" class="textbox">
										</div>
										<div class="formitem">
											<span class="label-lg">Inactive:</span>
											<input type="checkbox" style="width: 30px">
											<input type="date" class="textbox">
										</div>
										<div class="formitem">
											<span class="label-lg">Regularization:</span>
											<input type="date" class="textbox">
										</div>
										<div class="formitem">
											Address:<br>
											<input type="text" class="textbox width-full">
										</div>
										<div class="formitem">
											<span class="label-lg">Phone No.:</span>
											<input type="text" class="textboxsmall" value="+63" readonly>
											<input type="text" class="textbox" class="width-lg">
										</div>
									</div>

									<!-- right -->
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<div class="mainpanel-title">
											<span class="fa fa-archive"></span> General Info
										</div>

										<div class="formitem">
											<span class="label-lg">Bank Account:</span><br>
											<input type="text" class="textbox width-full">
										</div>
										<div class="formitem">
											<span class="label-lg">Date Hired:</span>
											<input type="date" class="textbox">
										</div>
										<div class="formitem">
											Employment Status:
											<select class="formitem">
												<option value="Normal" selected="selected">Normal</option>
												<option value="Lorem Ipsum">Lorem Ipsum</option>
												<option value="Dolor Sit Amet">Dolor Sit Amet</option>
											</select>
										</div>
										<div class="formitem">
											<span class="label-lg">PhilHealth:</span>
											<input type="text" class="textbox">
										</div>
										<div class="formitem">
											<span class="label-lg">Pag-ibig:</span>
											<input type="text" class="textbox">
										</div>
										<div class="formitem">
											<span class="label-lg">TIN:</span>
											<input type="text" class="textbox">
										</div>

									</div>



								</div>
							</div>
						</div>
						<hr>

						<div class="text-center">
							<input type="reset" class="btn btn-danger" value="Reset">
							<input type="button" class="btn btn-primary" value="Save Changes">
						</div>
					</div>
				</div>
				<!-- end FORM -->


			</div>
		</div>
	</div>
	<!-- end FORM -->








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
						<label>Department ID:</label>
						<input type="text" value="" placeholder="Department ID" id="add-department" class="modal-textarea">

						<label>Name:</label>
						<input type="text" value="" placeholder="Name" id="add-name" class="modal-textarea">
					</div>

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
			    $("#add-department").prop('readonly', true);
				document.getElementById("add-department").value = so;
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

		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var DeptId;
			var name;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 DeptId = data[0];
			 name = data[1];

			 $.ajax({
						type: 'GET',
						url: 'departmentformprocess.php',
						data:{action:action, actmode:actionmode, DeptId:DeptId, name:name},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
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
			document.getElementById("add-department").value = "";
			document.getElementById("add-name").value = "";
		}

		function Save()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var DeptId = $('#add-department').val();
			var name = $('#add-name').val();
			var action = "save";
			var actionmode = "userform";
			$.ajax({	
					type: 'GET',
					url: 'departmentformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, actmode:actionmode, DeptId:DeptId, name:name},
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
			var DeptId = $('#add-department').val();
			var name = $('#add-name').val();
			var action = "update";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'departmentformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, DeptId:DeptId, name:name},
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
							url: 'departmentformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, DeptId:so},
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