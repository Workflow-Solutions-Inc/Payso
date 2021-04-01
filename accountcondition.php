<?php 

session_start();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if(isset($_SESSION['accnt']))
{
	$accnt = $_SESSION["accnt"];
}
else
{
	header('location: accountform.php');
}
//$selectAcct = $_SESSION['selectAcct'];
$firstresult='';

if(isset($_SESSION['AccFocus']))
{
	$AccId = $_SESSION['AccFocus'];
}

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Account Condition</title>

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
			<div class="leftpanel-title"><b>Command</b></div>
			<li><button onClick="Create()"><span class="fa fa-plus"></span> Create Record</button></li>
			<li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li><button onClick="SetResult();"><span class="fas fa-calculator fa"></span> Set Result Formula</button></li>

			<!-- <li><button id="myAssessBtn" onClick="Assess();"><span class="fa fa-edit"></span> Assess Application</button></li>
			<li><button id="myAssessBtn" onClick="sendSMS();"><span class="fa fa-edit"></span> Send Message</button></li>-->
		</ul>

		
		<!-- extra buttons -->
		
		<!--
		<ul class="extrabuttons">
			<li><button><span class="fas fa-arrow-up fa"></span> Move Up</button></li>
			<li><button><span class="fas fa-arrow-down fa"></span> Move Down</button></li>
		</ul>
		-->
		<!-- extra buttons -->
		<!-- <ul class="extrabuttons"> -->
			<!-- <li><button id="btn2"><span class="fas fa-arrow-down fa"></span> Insert</button></li> -->
			<!-- <li><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update</button></li> -->
			<!-- <li><button id="btn1"><span class="fas fa-arrow-up fa"></span> Save</button></li> -->
			<!-- <li><button id="updatebtn1"><span class="fas fa-arrow-up fa"></span> Update Save</button></li> -->
			<!-- <li><button id="Update()"><span class="fa fa-edit"></span> Update</button></li> -->
		<!-- </ul> -->

		<ul class="extrabuttons">
			<div class="leftpanel-title"><b>Line Command</b></div>
			<li><button id="myAddBtn"><span class="fa fa-plus fa-lg"></span> Create</button></li>
			<li><button id="myUpdateBtns"><span class="fa fa-edit fa-lg"></span> Update</button></li>
			<li><button onClick="DeleteLine();"><span class="fa fa-trash-alt fa-lg"></span> Delete</button></li>
			<li><button onClick="SetReference();"><span class="fas fa-calculator fa"></span> Set Reference Formula</button></li>
			<li><button onClick="SetCondition();"><span class="fas fa-list-alt fa"></span> Set Condition Formula</button></li>

		</ul>

		<ul class="extrabuttons">
			<li><a href="accountform.php"><button><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></a></li>
		</ul>


	</div>
	<!-- end LEFT PANEL -->


	<!-- begin MAINPANEL -->
	<div id="mainpanel dashboard" class="mainpanel">
		<div class="container-fluid">
			<div class="row">

				<!-- start TABLE AREA -->
				<div id="tablearea1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> Account Condition for <?php echo $accnt; ?>
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
						<!-- tableheader -->
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:50%;">Condition Code</td>
										<td style="width:50%;">Result Formula</td>
										<td style="width:17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
										<td class="text-center"><span class="fas fa-search fa-xs"></span></td>
										<td><span></span></td>
										<td><span></span></td>
										<td><span></span></td>
										<td><span></span></td>
										<td><span></span></td>
									</tr>	
									
								</thead>
								
								<tbody id="result">
									<?php
									$query =
									"SELECT * FROM accountconditionheader where dataareaid = '$dataareaid' 
									and accountcode = '$accnt' order by priority ";

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
											<tr id="<?php echo $row['accountconditioncode'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center" ><span class="fa fa-angle-right"></span></td>
											<td style="width:50%;"><?php echo $row['accountconditioncode'];?></td>
											<td style="width:50%;"><?php echo $row['resultformula'];?></td>

											
										</tr>
										

									<?php 
										$firstresult = $row["accountconditioncode"];
										}
										/*$result2 = $conn->query($query);
											$row2 = $result2->fetch_assoc();
											$firstresult = $row2["accountconditioncode"];*/
										?>
								</tbody>
								<span class="temporary-container-input">
									<!--<input type="input" id="hide" value="<?php echo $firstresult; ?>">-->

									<input type="hidden" id="hide" value="<?php if(isset($_SESSION['AccFocus'])){ echo $AccId; } else { echo $firstresult; } ?>">
									
									<input type="hidden" id="inchide" value="<?php echo $accnt; ?>">								
								</span>
							</table>
						</div>	
					</div>
					<br><br>
				</div>
				<!-- end TABLE AREA -->

				<!-- start TABLE AREA -->
				<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> Account Summary
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

						<!-- table -->
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="dataln" class="table table-striped mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:34%;">Reference Formula</td>
										<td style="width:34%;">Condition</td>
										<td style="width:34%;">Condition Formula</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
								
								</thead>

								<tbody id="lineresult">
									<?php

									if(isset($_SESSION['AccFocus']))
										{ 
											$VarAccId = $AccId; 
										}
										else
										{
											$VarAccId = $firstresult; 
										}

									$query = "SELECT * FROM accountconditionheader ah left join accountconditiondetail ad 
											on ah.accountconditioncode = ad.accountconditioncode and ah.dataareaid = ad.dataareaid
											where ah.accountconditioncode = '$VarAccId' and ah.accountcode = '$accnt' and ah.dataareaid = '$dataareaid'";

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
											<td style="width:20px;" class="text-center" ><span class="fa fa-angle-right"></span></td>
											<td style="width:34%;"><?php echo $row['referenceformula'];?></td>
											<td style="width:34%;"><?php echo $row['condition'];?></td>
											<td style="width:34%;"><?php echo $row['conditionformula'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['linenum'];?></td>
										</tr>
										

									<?php }?>

								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="inchides">
									<input type="hidden" id="inchides2">
									<input type="hidden" id="inchides3">
									<input type="hidden" id="inchides4">
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
				<div class="col-lg-6">Condition</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<!-- <form name="myForm" accept-charset="utf-8" action="accountconditionprocess.php" method="get"> -->
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Condition:</label>
							<select  placeholder='' type='textbox' name ="add-condition" id='add-condition' value='' class="modal-textarea" required="required">
								<option value='=' selected='selected'>=</option>
								<option value='!=' selected=''>!=</option>
				              	<option value='>=' selected=''>>=</option>
				              	<option value='<=' selected=''><=</option>
				              	<option value='>' selected=''>></option>
				              	<option value='<' selected=''><</option>
							</select>
							<input class="hide" type="text" value="" name ="SelectedVal" id="SelectedVal">
							<input class="hide" type="text" value="" name ="linenum" id="linenum">
							

						</div>

						</div>

					</div>

					<div class="button-container">
						<button onClick="saveline();" id="addbt" name="saveline" value="saveline" class="btn btn-primary btn-action">Save</button>
						<button onClick="updateline();" id="upbt" name="update" value="update" class="btn btn-success btn-action" onclick="return validateForm()">Update</button>
						<button onClick="Clear();" type="button" value="Reset" class="btn btn-danger">Clear</button>
					</div>
				<!-- </form> -->
			</div>
		</div>
	</div>
</div>
<!-- end modal-->


<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	 <script  type="text/javascript">

		var locname='';
	  	var so='';
	  	var payline = '';
	  	var hellos = '';
	  	var gl_stimer= '';
	  	var gl_etimer= '';
	  	var accountcode = '';
	  	var cndtntst = '';
	  	var lnnmline = '';
		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			// var stimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
			// var etimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
			//locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			so = usernum.toString();
			//gl_stimer = stimer;
			//gl_etimer = etimer.toString();
			document.getElementById("hide").value = so;

			//alert(document.getElementById("hide").value);
			//alert(so);	
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'accountconditionline.php',
					data:{action:action, actmode:actionmode, accountcode:so},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						lnnmline='';
						document.getElementById("inchides").value = "";
						$('#lineresult').html(data);
					}
				}); 	
				//-----------get line--------------//	
						  
				});
			});
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

		$(document).ready(function(){
			$('#dataln tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","orange");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var linenumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(4)").text();
				lnnmline = linenumline.toString();
				document.getElementById("inchides").value = linenumline.toString();
				//alert(document.getElementById("hide").value);
				var conditiontest = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();
				cndtntst = conditiontest.toString();
				document.getElementById("inchides2").value = cndtntst.toString();


				var rformula = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
				document.getElementById("inchides3").value = rformula.toString();

				var cformula = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(3)").text();
				document.getElementById("inchides4").value = cformula.toString();

					//alert(payline);
					loc = document.getElementById("hide").value;
		            $("#myUpdateBtn").prop("disabled", false);
		             var pos = $("#"+loc+"").attr("tabindex");
					    $("tr[tabindex="+pos+"]").focus();
					    $("tr[tabindex="+pos+"]").css("color","red");
					    $("tr[tabindex="+pos+"]").addClass("info");
					//document.getElementById("myUpdateBtn").style.disabled = disabled;
						  
						  
			});
		});

		// Get the modal -------------------
		var modal = document.getElementById('myModal');
		// Get the button that opens the modal
		var CreateBtn = document.getElementById("myAddBtn");
		var UpdateBtn = document.getElementById("myUpdateBtns");
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("modal-close")[0];
		// When the user clicks the button, open the modal 
		CreateBtn.onclick = function() {
			if(so != '') {
			    modal.style.display = "block";
			    //$("#add-branch").prop('readonly', false);
			    //document.getElementById("add-branch").value = '';
			    $("#add-branch").prop('readonly', false);
			    document.getElementById("add-condition").value = '';
			    document.getElementById("SelectedVal").value = so;
			    document.getElementById("upbt").style.visibility = "hidden";
			    document.getElementById("addbt").style.visibility = "visible";
			}
			else 
			{
				alert("Please Select a record you want to create.");
			}
		}
		UpdateBtn.onclick = function() {
			if(lnnmline != '') {
			    modal.style.display = "block";
			    $("#add-branch").prop('readonly', true);
			    document.getElementById("linenum").value = lnnmline;
			    document.getElementById("add-condition").value = cndtntst;
			    document.getElementById("SelectedVal").value = so;
			    document.getElementById("addbt").style.visibility = "hidden";
			    document.getElementById("upbt").style.visibility = "visible";
			}
			else 
			{
				alert("Please Select a record you want to create.");
			}

		}
		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
		    modal.style.display = "none";
		    Clear();
		}
		// When the user clicks anywhere outside of the modal, close it
		/*window.onclick = function(event) {
		    if (event.target == modal || event.target == modal2) {
		        modal.style.display = "none";
		        Clear();
		        
		    }
		}
		//end modal --------------------------- */

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
		

// Insert using append
/*		var flag=0;
		$(document).ready(function(){
			document.getElementById("updatebtn1").style.visibility = "hidden";
			document.getElementById("btn1").style.visibility = "hidden";
		  $("#btn1").click(function(){
		    //alert(document.getElementById("hide").value);
		    var condition = $('#condition').val();
			var SelectedVal = $('#hide').val();
			var accountcode = $('#inchide').val();

			//alert(accountcode);
			var action = "saveline";
			//alert(BranchId);
			$.ajax({	
					type: 'GET',
					url: 'accountconditionprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action,  SelectedVal:SelectedVal, accountcode:accountcode, condition:condition},
					beforeSend:function(){
							
					$("#dataln").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						
					},
					success: function(data){
					//$('#dataln').html(data);
					location.reload();					
					}
			});
		    flag=0;
		    //location.reload();
		  });
		  

		  $("#btn2").click(function(){

		  	if(flag == 0 && so != ''){
		    	$("#lineresult").append("<tr>"+
		              "<td style='width:20px;'><span class='fa fa-angle-right'></span></td>"+
		              "<td style='width:34%;'><input style='width:100%;height: 20px;' placeholder='' type='textbox' id='rFormula' value='' disabled></td>"+
		              "<td style='width:34%;'><select style='width:100%;height: 20px;' placeholder='Branch Code' type='textbox' id='condition' value=''>"+
		              	"<option value='=' selected='selected'>=</option>"+
		              	"<option value='!=' selected=''>!=</option>"+
		              	"<option value='>=' selected=''>>=</option>"+
		              	"<option value='<=' selected=''><=</option>"+
		              	"<option value='>' selected=''>></option>"+
		              	"<option value='<' selected=''><</option>"+
		              	"</select></td>"+
		              "<td style='width:34%;'><input style='width:100%;height: 20px;' placeholder='' type='textbox' id='cformula' value='' disabled></td>"+
					  "</tr>");
		              flag=1;
		        document.getElementById("myUpdateBtn").style.visibility = "hidden";
			  	document.getElementById("updatebtn1").style.visibility = "hidden";
			    document.getElementById("btn1").style.visibility = "visible";
		    }
		    else{
		    	alert("You Must Save Before Adding New Record");
		        }
		    //$("#result").append("<tr>"+
		    //          "<td style='width:20px;'><span class='fa fa-angle-right'></span></td>"+
		    //          "<td style='width:50%;'><input style='width:100%;height: 20px;' placeholder='Branch Code' type='textbox' id='asd1' value=''></td>"+
		    //          "<td style='width:50%;'><input style='width:100%;height: 20px;' placeholder='Name' type='textbox' id='asd2' value=''></td>"+
			//		  "</tr>");

		  });

		  $("#myUpdateBtn").click(function(){
		    
		  	var lineflag = $('#inchides').val();
		  	var conditionflag = $('#inchides2').val();
		  	var rformulaflag = $('#inchides3').val();
		  	var cformulaflag = $('#inchides4').val();


		  	if(flag == 0 && lineflag != ''){
		    	$("#lineresult").append("<tr><td style='background: #ffb400;text-align: center; font-weight: bold;'>THIS IS THE UPDATE FOR THE SELECTED LINE</td></tr><tr>"+
		              "<td style='width:20px;'><span class='fa fa-angle-right'></span></td>"+
		              "<td style='width:34%;'><input style='width:100%;height: 20px;' placeholder='' type='textbox' id='rFormula' value='"+rformulaflag+"' disabled></td>"+
		              "<td style='width:34%;'><select style='width:100%;height: 20px;' placeholder='"+conditionflag+"' type='textbox' id='condition' value=''>"+

		              	"<option value='=' selected=''>=</option>"+
		              	"<option value='!=' selected=''>!=</option>"+
		              	"<option value='>=' selected=''>>=</option>"+
		              	"<option value='<=' selected=''><=</option>"+
		              	"<option value='>' selected=''>></option>"+
		              	"<option value='<' selected=''><</option>"+

		              	"</select></td>"+
		              "<td style='width:34%;'><input style='width:100%;height: 20px;' placeholder='' type='textbox' id='cFormula' value='"+cformulaflag+"' disabled></td>"+
					  "</tr>");
		              flag=1;
		        document.getElementById("btn2").style.visibility = "hidden";
			  	document.getElementById("btn1").style.visibility = "hidden";
			    document.getElementById("updatebtn1").style.visibility = "visible";
		    }
		    else{
		    	alert("You Must Select Line Before Update Record");
		        }
		    //$("#result").append("<tr>"+
		    //          "<td style='width:20px;'><span class='fa fa-angle-right'></span></td>"+
		    //          "<td style='width:50%;'><input style='width:100%;height: 20px;' placeholder='Branch Code' type='textbox' id='asd1' value=''></td>"+
		    //          "<td style='width:50%;'><input style='width:100%;height: 20px;' placeholder='Name' type='textbox' id='asd2' value=''></td>"+
			//		  "</tr>");

		  });
		  $("#updatebtn1").click(function(){
		    //alert(document.getElementById("hide").value);
		    var condition = $('#condition').val();
			var SelectedVal = $('#hide').val();
			var accountcode = $('#inchide').val();

			var linenum = $('#inchides').val();

		  	//var rformula = $('#rFormula').val();
		  	//var cformula = $('#cFormula').val();

			//alert(accountcode);
			var action = "updateline";
			//alert(BranchId);
			$.ajax({	
					type: 'GET',
					url: 'accountconditionprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action,  SelectedVal:SelectedVal, accountcode:accountcode, condition:condition, linenum:linenum},
					beforeSend:function(){
							
					$("#dataln").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						
					},
					success: function(data){
					//$('#dataln').html(data);
					location.reload();					
					}
			});
		    flag=0;
		    //location.reload();
		  });


		});*/

		function Create()
		{
			var action = "save";
			var actmode = "generateNew";
			var accountcode = $('#inchide').val();
			$.ajax({	
							type: 'GET',
							url: 'accountconditionprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actmode, accountcode:accountcode},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							
								
							},
							success: function(data){
							//$('#conttables').html(data);
							location.reload();					
							}
					}); 

		}

		function Delete()
		{
			var action = "delete";
			if(so != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'accountconditionprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, SelectedVal:so},
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
				alert("Please Select a record you want to delete.");
			}	
		}


	function saveline()
	{
			modal.style.display = "none";
			var action = "saveline";
			var condit = $('#add-condition').val();

			if(so != '') {
					$.ajax({	
							type: 'GET',
							url: 'accountconditionprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, SelectedVal:so, condit:condit},
							beforeSend:function(){
									
							$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							$('#lineresult').html(data);
							//location.reload();					
							}
					}); 
			}
			else 
			{
				alert("Please Select a record.");
			}			
	}

		function updateline()
		{
			modal.style.display = "none";
			var action = "updateline";
			var condit = $('#add-condition').val();
			so = document.getElementById("hide").value;

			if(lnnmline != '') {
					$.ajax({	
							type: 'GET',
							url: 'accountconditionprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, SelectedVal:so, linenum:lnnmline, condit:condit},
							beforeSend:function(){
									
							$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							$('#lineresult').html(data);
							//location.reload();					
							}
					}); 
			}
			else 
			{
				alert("Please Select a record you want to update.");
			}	
		}

		function DeleteLine()
		{
			var action = "deleteline";
			if(so != '' && lnnmline != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'accountconditionprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, SelectedVal:so, linenum:lnnmline},
							beforeSend:function(){
									
							$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							$('#lineresult').html(data);
							//location.reload();					
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

		function SetResult()
		{
			//alert(1);
			so = document.getElementById("hide").value;
			if(so != ''){
				var action = "Result";
				$.ajax({
					type: 'GET',
					url: 'accountconditionprocess.php',
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

		function SetReference()
		{
			//alert(1);
			so = document.getElementById("hide").value;
			if(so != '' && lnnmline != ''){
				var action = "Reference";
				$.ajax({
					type: 'GET',
					url: 'accountconditionprocess.php',
					data:{action:action, accId:so, lnnmline:lnnmline},
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
			so = document.getElementById("hide").value;
			if(so != '' && lnnmline != ''){
				var action = "Condition";
				$.ajax({
					type: 'GET',
					url: 'accountconditionprocess.php',
					data:{action:action, accId:so, lnnmline:lnnmline},
					success: function(data) {
					    window.location.href='calc.php';
				    }
				});
			}
			else {
				alert("Please Select Account.");
			}
		}


</script>
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>