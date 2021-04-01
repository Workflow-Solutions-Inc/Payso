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
	<title>Accounts</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body>


	<!-- begin LEFTPANEL -->
	<div class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>
		
		<ul class="subbuttons">
			<li><button id="myAddBtn"><span class="fa fa-home fa-wrench fa-lg"></span> Create Record</button></li>
			<li><button onClick="Delete();"><span class="fa fa-home fa-wrench fa-lg"></span> Delete Record</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-home fa-wrench fa-lg"></span> Update Record</button></li>
		</ul>

		<ul class="extrabuttons">
			<li><button onClick="MoveUp();"><span class="fa fa-home fa-lg"></span> Move Up</button></li>
			<li><button onClick="MoveDown();"><span class="fa fa-home fa-lg"></span> Move Down</button></li>
		</ul>

		
	</div>
	<!-- end LEFTPANEL -->


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
						<table width="100%" border="0" id="datatbl" class="table table-striped mainpanel-table">
							<thead>	
								<tr class="rowB rowtitle">
									<td><span class="fa fa-adjust"></span></td>
									<td style="width:5%;">Auto Include</td>
									<td style="width:8%;">Account Code</td>
									<td style="width:16%;">Name</td>
									<td style="width:16%;">Label</td>
									<td style="width:5%;">UM</td>
									<td style="width:7.5%;">Account Type</td>
									<td style="width:7.5%;">Category</td>
									<td style="width:30%;">Formula</td>
									<td style="width:5%;">Default Value</td>
									
								</tr>
								<tr class="rowsearch">
								  <td><span class="fa fa-adjust"></span></td>
								  

									<td><input style="width:100%;height: 20px;" list="SearchInc" class="search" disabled>
									<?php
										$query = "SELECT distinct autoinclude FROM accounts where dataareaid = '$dataareaid'";
										$result = $conn->query($query);	
											
								  ?>
								  <datalist id="SearchInc">
									
									<?php 
									
										while ($row = $result->fetch_assoc()) {
									?>
										<option value="<?php echo $row["autoinclude"];?>"></option>
										
									<?php } ?>
									</datalist>
								  </td>
								  <td><input style="width:100%;height: 20px;" list="SearchCode" class="search">
									<?php
										$query = "SELECT distinct accountcode FROM accounts where dataareaid = '$dataareaid'";
										$result = $conn->query($query);	
											
								  ?>
								  <datalist id="SearchCode">
									
									<?php 
									
										while ($row = $result->fetch_assoc()) {
									?>
										<option value="<?php echo $row["accountcode"];?>"></option>
										
									<?php } ?>
									</datalist>
								  </td>
								  <td><input style="width:100%;height: 20px;" list="SearchName" class="search">
									<?php
										$query = "SELECT distinct name FROM accounts where dataareaid = '$dataareaid'";
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
								  <td><input style="width:100%;height: 20px;" list="SearchLabel" class="search">
									<?php
										$query = "SELECT distinct label FROM accounts where dataareaid = '$dataareaid'";
										$result = $conn->query($query);	
											
								  ?>
								  <datalist id="SearchLabel">
									
									<?php 
									
										while ($row = $result->fetch_assoc()) {
									?>
										<option value="<?php echo $row["label"];?>"></option>
										
									<?php } ?>
									</datalist>
								  </td>
								  <td><input style="width:100%;height: 20px;" list="SearchUm" class="search">
									<?php
										$query = "SELECT distinct um FROM accounts where dataareaid = '$dataareaid'";
										$result = $conn->query($query);	
											
								  ?>
								  <datalist id="SearchUm">
									
									<?php 
									
										while ($row = $result->fetch_assoc()) {
									?>
										<option value="<?php echo $row["um"];?>"></option>
										
									<?php } ?>
									</datalist>
								  </td>
								  <td><input style="width:100%;height: 20px;" list="SearchType" class="search" disabled>
									<?php
										$query = "SELECT distinct case when accounttype = 0 then 'Entry'
													when accounttype = 1 then 'Computed'
													when accounttype = 2 then 'Condition'
													else 'Total'
													end as accounttype FROM accounts where dataareaid = '$dataareaid'";
										$result = $conn->query($query);	
											
								  ?>
								  <datalist id="SearchType">
									
									<?php 
									
										while ($row = $result->fetch_assoc()) {
									?>
										<option value="<?php echo $row["accounttype"];?>"></option>
										
									<?php } ?>
									</datalist>
								  </td>
								  <td><input style="width:100%;height: 20px;" list="SearchCategory" class="search" disabled>
									<?php
										$query = "SELECT distinct case when category = 0 then 'Lines'
													else 'Header' 
													end as category FROM accounts where dataareaid = '$dataareaid'";
										$result = $conn->query($query);	
											
								  ?>
								  <datalist id="SearchCategory">
									
									<?php 
									
										while ($row = $result->fetch_assoc()) {
									?>
										<option value="<?php echo $row["category"];?>"></option>
										
									<?php } ?>
									</datalist>
								  </td>
								  <td><input style="width:100%;height: 20px;" list="SearchFormula" class="search" disabled>
									<?php
										$query = "SELECT distinct formula FROM accounts where dataareaid = '$dataareaid'";
										$result = $conn->query($query);	
											
								  ?>
								  <datalist id="SearchFormula">
									
									<?php 
									
										while ($row = $result->fetch_assoc()) {
									?>
										<option value="<?php echo $row["formula"];?>"></option>
										
									<?php } ?>
									</datalist>
								  </td>
								  <td><input style="width:100%;height: 20px;" list="SearchValue" class="search" disabled>
									<?php
										$query = "SELECT distinct defaultvalue FROM accounts where dataareaid = '$dataareaid'";
										$result = $conn->query($query);	
											
								  ?>
								  <datalist id="SearchValue">
									
									<?php 
									
										while ($row = $result->fetch_assoc()) {
									?>
										<option value="<?php echo $row["defaultvalue"];?>"></option>
										
									<?php } ?>
									</datalist>
								  </td>
								  
								</tr>
							</thead>
							<tbody id="result">
								<?php					
								$query = "SELECT autoinclude,
													accountcode,
													name,
													label,
													um,
													case when accounttype = 0 then 'Entry'
														when accounttype = 1 then 'Computed'
														when accounttype = 2 then 'Condition'
													else 'Total'
													end as accounttype,
													case when category = 0 then 'Lines'
													else 'Header' 
													end as category,
													formula,
													format(defaultvalue,2) defaultvalue,
													priority
													FROM accounts
													where dataareaid = '$dataareaid'
													order by priority asc";
								$result = $conn->query($query);
								$rowclass = "rowA";
								$rowcnt = 0;
								$lastrec ='';
								while ($row = $result->fetch_assoc())
								{ ?>
									<?php
										$rowcnt++;
										if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
										else { $rowclass = "rowA"; }
									?>
									<tr id="<?php echo $row['accountcode'];?>" class="<?php echo $rowclass; ?>">
										<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
										<td><span class="fa fa-adjust"></span></td>
										<td><input type="checkbox" name="chkbox" style="width:100%;height: 20px;"  value="true" <?php echo ($row['autoinclude']==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['autoinclude'];?></div></td>
										<td><?php echo $row['accountcode'];?></td>
										<td><?php echo $row['name'];?></td>
										<td><?php echo $row['label'];?></td>
										<td><?php echo $row['um'];?></td>
										<td><?php echo $row['accounttype'];?></td>
										<td><?php echo $row['category'];?></td>
										<td><?php echo $row['formula'];?></td>
										<td><?php echo $row['defaultvalue'];?></td>
										
										<?php $lastrec = $row['priority'];?>
										<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
										
									</tr>
								<?php }?>
							</tbody>
							<input type="input" id="hide">
							<input type="input" id="hide2" value="<?php echo $lastrec+1;?>">		
						</table>
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
				<div class="row">

					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<label>Auto Include:</label>
						<input type="checkbox" value="0" id="add-include" class="modal-textarea">

						<label>Account Code:</label>
						<input type="text" value="" placeholder="Account Code" id="add-code" class="modal-textarea">
					</div>

					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<label>Name:</label>
						<input type="text" value="" placeholder="Name" id="add-name" class="modal-textarea" none>

						<label>Label:</label>
						<input type="text" value="" placeholder="Label" id="add-label" class="modal-textarea">
					</div>

					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<label>Account Type:</label>
						<select  value="" placeholder="Account Type" id="add-type" class="modal-textarea" style="width:100%;height: 28px;">
								<option value=""></option>
								<option value="0">Entry</option>
								<option value="1">Computed</option>
								<option value="2">Condition</option>
								<option value="3">Total</option>
						</select>

						<label>UM:</label>
						<input type="text" value="" placeholder="UM" id="add-um" class="modal-textarea">						
					</div>

					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<label>Category:</label>
						<select value="" placeholder="Category" id="add-category" class="modal-textarea" style="width:100%;height: 28px;">
								<option value=""></option>
								<option value="0">Lines</option>
								<option value="1">Header</option>
						</select>

						<label>Default Value:</label>
						<input type="text" value="0.00" placeholder="Default Value" id="add-value" class="modal-textarea">
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
	  	var inc='';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				//$('table tbody tr').css('background-color','');
				//$(this).css('background-color','#ffe6cb');
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				var AcInc = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				inc = AcInc.toString();
				so = usernum.toString();
				document.getElementById("hide").value = so;	
								  
			});
		});

  			//var asd = "TELOAN";
			//$(document).ready(function(){
			//$("#"+asd+"").css("color","red");
			//});

			/*$(document).ready(function(){
			  $("tr:even").css('background-color','white');
			});*/

		 $('#add-include').change(function(){
		    if($(this).attr('checked'))
		    {
          		$(this).val('1');
		    }
		    else
		    {
		         $(this).val('0');
		    }
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
			var ck = false;
			if(so != '') {
			    modal.style.display = "block";
			    $("#add-include").prop('readonly', true);
			    if(inc == 1)
			    {
			    	ck = true;
			    }
			    else
			    {
			    	ck = false;
			    }
				document.getElementById("add-include").checked = ck;
				document.getElementById("add-code").value = so;
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
			var AccInc;
			var AccCode;
			var AccName;
			var AccLabel;
			var AccUm;
			var AccType;
			var AccCat;
			var AccFormula;
			var AccVal;

			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 //AccInc = data[0];
			 AccCode = data[1];
			 AccName = data[2];
			 AccLabel = data[3];
			 AccUm = data[4];
			 AccType = data[5];
			 AccCat = data[6];
			 //AccFormula = data[7];
			 //AccVal = data[8];

			
			 $.ajax({
						type: 'GET',
						url: 'accountformprocess.php',
						data:{action:action, actmode:actionmode, AccInc:AccInc, AccCode:AccCode, AccName:AccName, AccLabel:AccLabel, AccUm:AccUm, AccType:AccType, AccCat:AccCat, AccFormula:AccFormula, AccVal:AccVal},
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
			document.getElementById("add-include").checked = false;
			document.getElementById("add-code").value = "";
			document.getElementById("add-name").value = "";
			document.getElementById("add-label").value = "";
			document.getElementById("add-um").value = "";
			document.getElementById("add-type").value = "";
			document.getElementById("add-category").value = "";
		}

		function Save()
		{
			
			//modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var AccInc = $('#add-include').val();
			var AccCode = $('#add-code').val();
			var AccName = $('#add-name').val();
			var AccLabel = $('#add-label').val();
			var AccUm = $('#add-um').val();
			var AccType = $('#add-type').val();
			var AccCat = $('#add-category').val();
			var AccVal = $('#add-value').val();
			var AccLast = $('#hide2').val();
			var action = "save";
			var actionmode = "userform";
			//alert(document.getElementById("add-include").value);
			$.ajax({	
					type: 'GET',
					url: 'accountformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, actmode:actionmode, AccInc:AccInc, AccCode:AccCode, AccName:AccName, AccLabel:AccLabel, AccUm:AccUm, AccType:AccType, AccCat:AccCat, AccVal:AccVal, AccLast:AccLast},
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
			var NumId = $('#add-id').val();
			var NumPrefix = $('#add-prefix').val();
			var NumFirst = $('#add-first').val();
			var NumLast = $('#add-last').val();
			var NumFormat = $('#add-format').val();
			var NumNext = $('#add-next').val();
			var NumSuffix = $('#add-suffix').val();
			var action = "updatexxx";
			var actionmode = "userform";
			alert(inc);
			/*if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'accountformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, NumId:NumId, NumPrefix:NumPrefix, NumFirst:NumFirst, NumLast:NumLast, NumFormat:NumFormat, NumNext:NumNext, NumSuffix:NumSuffix},
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
			}	*/		
		}

		function Delete()
		{
			
			var action = "delete";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'accountformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, AccCode:so},
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

		function MoveUp()
		{
			var action = "moveup";
			var actionmode = "userform";
			var AccPrio = $('#hide').val();
			//var AccIndex = '';
			//alert(AccPrio);
			if(AccPrio != '') {
				//if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'accountformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, AccCode:AccPrio},
							beforeSend:function(){
									
							//$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							$('#result').html(data);					
							}
					}); 
				/*}
				else 
				{
					return false;
				}*/
			}
			else 
			{
				alert("Please Select a record.");
			}	
		}

		function MoveDown()
		{
			var action = "movedown";
			var actionmode = "userform";
			var AccPrio = $('#hide').val();
			//alert(AccPrio);
			if(AccPrio != '') {
				//if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'accountformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, AccCode:AccPrio},
							beforeSend:function(){
									
							//$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							$('#result').html(data);
							//$('#conttables').html(data);
							//location.reload();					
							}
					}); 
				/*}
				else 
				{
					return false;
				}*/
			}
			else 
			{
				alert("Please Select a record.");
			}
		}

	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>