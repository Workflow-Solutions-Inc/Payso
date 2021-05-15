<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
//unset($_SESSION['AccFocus']);
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Accounts</title>

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
			<li class="PayrollAccountsMaintain" style="display: none;"><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>
			<li class="PayrollAccountsMaintain" style="display: none;"><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li class="PayrollAccountsMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>
		
		<!-- extra buttons -->
		<ul class="extrabuttons PayrollAccountsMaintain" style="display: none;">
			<div class="leftpanel-title"><b>SET</b></div>
			<li><button onClick="SetFormula();"><span class="fas fa-calculator fa"></span> Set Formula</button></li>
			<li><button onClick="SetCondition();"><span class="fas fa-list-alt fa"></span> Set Condition</button></li>
		</ul>

		<!-- extra buttons -->
		<ul class="extrabuttons PayrollAccountsMaintain" style="display: none;">
			<div class="leftpanel-title"><b>MOVE</b></div>
			<li><button onClick="MoveUp();"><span class="fas fa-arrow-up fa"></span> Move Up</button></li>
			<li><button onClick="MoveDown();"><span class="fas fa-arrow-down fa"></span> Move Down</button></li>
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
							<span class="fa fa-archive"></span> Accounts
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
						<!-- tableheader -->
						<div id="container1" class="full">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowB rowtitle">
										<td style="width:20px;"><span class="fa fa-adjust"></span></td>
										<td style="width:5%;">Include</td>
										<td style="width:8%;">Account Code</td>
										<td style="width:16%;">Name</td>
										<td style="width:16%;">Label</td>
										<td style="width:5%;">UM</td>
										<td style="width:7.5%;">Account Type</td>
										<td style="width:7.5%;">Category</td>
										<td style="width:23%;">Formula</td>
										<td style="width:5%;">Values</td>
										<td style="width:7%;">Group</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td><input list="SearchInc" class="search" disabled>
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
									  <td><input list="SearchCode" class="search">
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
									  <td><input list="SearchLabel" class="search">
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
									  <td><input list="SearchUm" class="search">
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
									  <td><input list="SearchType" class="search" disabled>
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
									  <td><input list="SearchCategory" class="search" disabled>
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
									  <td><input list="SearchFormula" class="search" disabled>
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
									  <td><input list="SearchValue" class="search" disabled>
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
									  <td><span></span></td>
									  <td><span></span></td>
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
														priority,
														case when payrollgroup = 0 then 'Weekly'
															when payrollgroup = 1 then 'Semi-Monthly'
															when payrollgroup = 2 then 'Both'
														end as payrollgroup
														FROM accounts
														where dataareaid = '$dataareaid'
														order by priority asc";
									$result = $conn->query($query);
									$rowclass = "rowA";
									$rowcnt = 0;
									$rowcnt2 = 0;
									$lastrec ='';
									$collection = '';
									while ($row = $result->fetch_assoc())
									{ ?>
										<?php
											$rowcnt++;
											$rowcnt2++;
											if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
											else { $rowclass = "rowA"; }
											$collection = $collection.','.$row['accountcode'];
										?>
										<tr id="<?php echo $row['accountcode'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:5%;"><input type="checkbox" name="chkbox" class="checkbox" value="true" <?php echo ($row['autoinclude']==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['autoinclude'];?></div></td>
											<td style="width:8%;"><?php echo $row['accountcode'];?></td>
											<td style="width:16%;"><?php echo $row['name'];?></td>
											<td style="width:16%;"><?php echo $row['label'];?></td>
											<td style="width:5%;"><?php echo $row['um'];?></td>
											<td style="width:7.5%;"><?php echo $row['accounttype'];?></td>
											<td style="width:7.5%;"><?php echo $row['category'];?></td>
											<td style="width:23%;"><?php echo $row['formula'];?></td>
											<td style="width:5%;"><?php echo $row['defaultvalue'];?></td>
											<td style="width:7%;"><?php echo $row['payrollgroup'];?></td>
											<?php $lastrec = $row['priority'];?>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
										</tr>
									<?php 
									$firstresult = $row["accountcode"];
									}
										$result2 = $conn->query($query);
										$row2 = $result2->fetch_assoc();
										
									?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php echo $firstresult; ?>">
									<input type="hidden" id="hide2" value="<?php echo $lastrec+1;?>">
									<input type="hidden" id="hidefocus" value="<?php echo $rowcnt2;?>">
									<div style="display:none;width:1%;"><textarea id="t2" value = "<?php echo substr($collection,1);?>"><?php echo substr($collection,1);?></textarea></div>
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

<!-- The Modal -->
<div id="myModal" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">Accounts</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="accountformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Auto Include:</label>
							<span><input type="checkbox" value="0" id="add-include" class="modal-textarea" >
								
							

							<label>Account Code:</label>
							<input type="text" value="" placeholder="Account Code" name ="AccCode" id="add-code" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Name:</label>
							<input type="text" value="" placeholder="Name" name ="AccName" id="add-name" class="modal-textarea" required="required">

							<label>Label:</label>
							<input type="text" value="" placeholder="Label" name ="AccLabel" id="add-label" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Account Type:</label>
							<select  value="" placeholder="Account Type" name ="AccType" id="add-type" class="modal-textarea" style="width:100%;height: 28px;" required="required">
									<option value=""></option>
									<option value="0">Entry</option>
									<option value="1">Computed</option>
									<option value="2">Condition</option>
									<option value="3">Total</option>
							</select>

							<label>UM:</label>
							<input type="text" value="" placeholder="UM" name ="AccUm" id="add-um" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Category:</label>
							<select value="" placeholder="Category" name ="AccCat" id="add-category" class="modal-textarea" style="width:100%;height: 28px;" required="required">
									<option value=""></option>
									<option value="0">Lines</option>
									<option value="1">Header</option>
							</select>

							<label>Default Value:</label>
							<input type="text" value="0.00" name ="AccVal" placeholder="Default Value" id="add-value" class="modal-textarea">

							<label>Group:</label>
							<select value="" placeholder="Payroll Group" name ="PayGrp" id="add-paygrp" class="modal-textarea" style="width:100%;height: 28px;" required="required">
									<option value=""></option>
									<option value="0">Weekly</option>
									<option value="1">Semi-Monthly</option>
									<option value="2">Both</option>
							</select>

							<input type="hidden" value="<?php echo $lastrec+1;?>" name ="AccLast" placeholder="Default Value" id="add-value" class="modal-textarea">
							<input type="hidden" name ="AccInc" id="inchide" value="" class="modal-textarea">
						</div>

					</div>

					<div class="button-container">
						<button id="addbt" name="save" value="save" class="btn btn-primary btn-action" onclick="return checkExistForm()">Save</button>
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
	  	var inc='';
	  	var HL='';
		var locAccName;
		var locAccLabel;
		var locAccUm;
		var locAccType;
		var locAccCat;
		var locAccFormula;
		var locAccVal;
		var locPayGroup;
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
				locAccName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locAccLabel = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locAccUm = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locAccType = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(6)").text();
				locAccCat = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				locAccFormula = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locAccVal = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locPayGroup = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
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
		$(document).ready(function() {
			loc = document.getElementById("hide").value;
	        if(loc != '')
	        {
	        	var pos = $("#"+loc+"").attr("tabindex");
	        }
	        else
	        {
	        	var pos = 1;
	        }
		    $("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").css("color","red");
		    $("tr[tabindex="+pos+"]").addClass("info");

		});

		 $('#add-include').change(function(){
		    if($(this).attr('checked'))
		    {
          		$(this).val('1');
          		document.getElementById("inchide").value =1;
		    }
		    else
		    {
		         $(this).val('0');
		         document.getElementById("inchide").value=0;
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
		    
		    //$("#myModal").delay("slow").fadeIn();
		    $("#myModal").stop().fadeTo(500,1);
		    //modal.style.display = "block";
		    $("#add-code").prop('readonly', false);
		    document.getElementById("add-code").value ='';
		    document.getElementById("inchide").value = 0;
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			var ck = false;
			var typeval;
			var catval;
			var pygrp;
			if(so != '') {
			    modal.style.display = "block";
			    $("#add-code").prop('readonly', true);
			    if(inc == 1)
			    {
			    	ck = true;
			    }
			    else
			    {
			    	ck = false;
			    }

			    if(locAccType.toString() == "Entry")
			    {
			    	typeval = 0;
			    }
			    else if(locAccType.toString() == "Computed")
			    {
			    	typeval = 1;
			    }
			    else if(locAccType.toString() == "Condition")
			    {
			    	typeval = 2;
			    }
			    else
			    {
			    	typeval = 3;
			    }

			    if(locAccCat.toString() == "Lines")
			    {
			    	catval = 0;
			    }
			    else
			    {
			    	catval = 1;
			    }
			    
				 if(locPayGroup.toString() == "Weekly")
			    {
			    	pygrp = 0;
			    }
			    else if(locPayGroup.toString() == "Semi-Monthly")
			    {
			    	pygrp = 1;
			    }
			    else
			    {
			    	pygrp = 2;
			    }

			    
			   
			    document.getElementById("inchide").value = inc;
				document.getElementById("add-include").checked = ck;
				document.getElementById("add-code").value = so;
				document.getElementById("add-name").value = locAccName;
				document.getElementById("add-label").value = locAccLabel;
				document.getElementById("add-um").value = locAccUm;
				document.getElementById("add-type").value = typeval;
				document.getElementById("add-category").value = catval;
				document.getElementById("add-paygrp").value = pygrp;
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
		    //$("#myModal").stop().fadeTo(500,0);
		    Clear();
		}
		// When the user clicks anywhere outside of the modal, close it
		/*window.onclick = function(event) {
		    if (event.target == modal || event.target == modal2) {
		        modal.style.display = "none";
		        //$("#myModal").stop().fadeTo(500,0);
		        Clear();
		        
		    }
		}*/
		//end modal ---------------------------
		var myId = [];
		function checkExistForm()
		{
			var cont = document.getElementById("t2").value;
			myId = cont.toLowerCase().split(",");
			//myId.push("Kiwi","Lemon","Pineapple",'asd');
			/*$.each(myId, function(i, el2){
		    	alert(el2);
			});*/
			//alert(myId.length);
			var n = myId.includes(document.getElementById("add-code").value.toLowerCase());
			//alert(n);
			if(n == true){
				alert("Account Code already Exist!");
				return false;
			}
			else
			{
				//alert("Continue Saving...");
				return true;
			}
			
		}
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
							//HL='';
							//so='';
							//document.getElementById("hide").value = '';
					
						},
						success: function(data){
							$('#result').html(data);
							var firstval = $('#hide3').val();
							document.getElementById("hide").value = firstval;
							so = document.getElementById("hide").value;
				            //$("#myUpdateBtn").prop("disabled", false);
				            //$('table tbody tr').removeClass("info");
				             //$('table tbody tr').css("color","black");
				             var pos = $("#"+so+"").attr("tabindex");
							    $("tr[tabindex="+pos+"]").focus();
							    $("tr[tabindex="+pos+"]").css("color","red");
							    $("tr[tabindex="+pos+"]").addClass("info");
							//document.getElementById("hide").value = '';
							//$("#"+HL+"").removeClass("info");
							//alert(so);
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

		function SetFormula()
		{
			//alert(1);
			if(so != ''){
				var action = "Formula";
				$.ajax({
					type: 'GET',
					url: 'accountformprocess.php',
					data:{action:action, accId:so},
					success: function(data) {
					    window.location.href='calc.php';
				    }
				});
			}
			else {
				alert("Please Select Account.");
			}
		}

		function SetCondition()
		{
			//alert(1);
			if(so != ''){
				var action = "Condition";
				$.ajax({
					type: 'GET',
					url: 'accountformprocess.php',
					data:{action:action, accId:so},
					success: function(data) {
					    window.location.href='accountcondition.php';
				    }
				});
			}
			else {
				alert("Please Select Account.");
			}
		}
		function Cancel()
		{
			window.location.href='menu.php?list='+ActiveMode;
		}


	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>