<?php 
session_id("payso");
session_start();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

/*if(isset($_SESSION['thpayoutid']))
{
	$thpayoutid = $_SESSION['thpayoutid'];
}
else
{
	header('location: 13thmonthpayout.php');
}
$thpayoutfromdate = $_SESSION['thpayoutfromdate'];
$thpayouttodate = $_SESSION['thpayouttodate'];
$thpayoutyear = $_SESSION['thpayoutyear'];
$thpayoutstatus = $_SESSION['thpayoutstatus'];*/

$finalpayoutid = $_SESSION['finalpayoutid'];
$locworker = $_SESSION['finalpayoutworker'];
$status = $_SESSION['finalpayoutstatus'];
$finaltype = $_SESSION['finalpayouttype'];
//$thpayoutid = 'DCMP000011';
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Final Payout Details</title>

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
			<div class="leftpanel-title"><b>Generate</b></div>
			<!--<li><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>-->
			<li><button onClick="GenerateFinalPay();"><span class="fa fa-folder-plus"></span> Last Payout</button></li>
			<li><button onClick="GenerateFinalLeave();"><span class="fa fa-folder-plus"></span> Leave Payout</button></li>
			<li><button onClick="GenerateFinalTH();"><span class="fa fa-folder-plus"></span> 13th Month</button></li>
			<li><button id='separationbtn' style="display:none;" onClick="GenerateSeparation();"><span class="fa fa-folder-plus"></span> Separation Pay</button></li>
			<li><button onClick="GenerateFinalLoan();"><span class="fa fa-folder-plus"></span> Loan</button></li>
			<!-- <li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li> -->
			<!-- <li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li> -->
			<!-- <li><button id="myAssessBtn" onClick="Assess();"><span class="fa fa-edit"></span> Assess Application</button></li>
			<li><button id="myAssessBtn" onClick="sendSMS();"><span class="fa fa-edit"></span> Send Message</button></li>-->
		</ul>

		<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
		</ul>
		
		<!-- extra buttons -->		
		<ul class="extrabuttons">
			<li><button onClick="Cancel()"><span class="fas fa-arrow-circle-left fa-lg"></span> Back</button></li>
			<!-- <li><button><span class="fas fa-arrow-up fa"></span> Move Up</button></li> -->
			<!-- <li><button><span class="fas fa-arrow-down fa"></span> Move Down</button></li> -->
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
							<?php
							$query2 = "SELECT * FROM worker where workerid = '$locworker' and dataareaid = '$dataareaid'";
								$result2 = $conn->query($query2);
								$row2 = $result2->fetch_assoc();
								$uname = $row2["name"];

							?>
							<span class="fa fa-archive"></span> Final Payout Details for <?php echo $uname; ?>
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
										<!-- <td style="width:5%;">Include</td> -->
										<td style="width:33%;">Final Payout ID</td>
										<td style="width:33%;">Payout Type</td>
										<td style="width:33%;">Payout Amount</td>
										<td style="width:17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
										<td class="text-center"><span class="fas fa-search fa-xs"></span></td>
										<!-- <td><center><input id="selectAll" type="checkbox"></span></center></td> -->

										

									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  
									</tr>	
									
								</thead>
								
								<tbody id="result">
									<?php	
										$query = "SELECT finalpayoutid,
													case when finalpaytype = 0 then 'Final Pay' 
														when finalpaytype = 1 then 'Leave Payout' 
														when finalpaytype = 3 then 'Remaining Loan' 
													    else '13th Month Payout' end finalpaytype,
													    workerid,
													    finalpaytype as finalpaytypecode,
													    format(abs(amount),2) as amount


													 FROM finalpaydetails where workerid = '$locworker' and finalpayoutid = '$finalpayoutid'
													 order by cast(finalpaytype as decimal) asc";
										$result = $conn->query($query);
										$rowclass = "rowA";
										$rowcnt = 0;
										$rowcnt2 = 0;
										$detailfocus = '';
										$collection = '';
										while ($row = $result->fetch_assoc())
										{ 
											$rowcnt++;
											$rowcnt2++;
												if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
												else { $rowclass = "rowA";}
												$collection = $collection.','.$row['finalpaytypecode'];
											?>
											<tr id="<?php echo $row['name'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
												<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
												<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
												<td style="width:33%;"><?php echo $row['finalpayoutid'];?></td>
												<td style="width:33%;"><?php echo $row['finalpaytype'];?></td>
												<td style="width:33%;"><?php echo $row['amount'];?></td>
												<td style="display:none;width:1%;"><?php echo $row['finalpaytypecode'];?></td>
												<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
												
											</tr>

										<?php 
										$firstresult = $row["workerid"];

										$resultfoc = $conn->query($query);
											$rowfoc = $resultfoc->fetch_assoc();
											$detailfocus = $rowfoc["finalpaytypecode"];
										//$conn->close();
										//include("dbconn.php");
										}
										?>

								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
									<input type="hidden" id="hidedetails" value="<?php echo $detailfocus; ?>">
									<input type="hidden" id="hidewk" value="<?php echo $firstresult; ?>">
									<input type="hidden" id="hidestatus" value="<?php echo $status; ?>">
									<input type="input" id="hidetype" value="<?php echo $finaltype; ?>">
									<div style="display:none;width:1%;"><textarea id="t2" value = "<?php echo substr($collection,1);?>"><?php echo substr($collection,1);?></textarea></div>
									
								</span>
							</table>
						</div>	
					</div>
					<br>
				</div>
				<!-- end TABLE AREA -->
				<div id='dtrContent'>
					
				</div>
				<!-- end DTR Content-->



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
				<div class="col-lg-6">Separation Pay</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="finalpayoutprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Separation Type:</label>
							
							<select value="" placeholder="" name ="PayGroup" id="add-cat" class="modal-textarea" style="width:100%;height: 28px;" onchange="filtercat()"  required="required">
								<option value="" selected="selected"></option>
								<option value="0">A. One-Half (1/2) Month Pay per Year of Service</option>
								<option value="1">B. One-Month Pay per Year of Service</option>
							</select>
							
						</div>


						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div id='categresult'>
							
							
							</div>
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

		var locname='';
	  	var so = '';
	  	var loctype= '';
		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			loctype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
			so = usernum.toString();


			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(loctype);	
						if(loctype == 0)
						{
							//-----------get line--------------//
							var action = "getline";
							var actionmode = "userform";
							var workerval = document.getElementById("hidewk").value;
							//var workerval = 'DCWR000001';
							$.ajax({
								type: 'POST',
								url: 'finalpayoutlines.php',
								data:{action:action, actmode:actionmode, workerval:workerval},
								beforeSend:function(){
								
									$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
									
								},
								success: function(data){
									//payline='';
									//document.getElementById("hide2").value = "";
									$('#dtrContent').html(data);
								}
							}); 
							//-----------get line--------------//
						}
						else if(loctype == 1)
						{
							//-----------get line--------------//
							var action = "getline";
							var actionmode = "userform";
							var workerval = document.getElementById("hidewk").value;
							//var workerval = 'DCWR000001';
							$.ajax({
								type: 'POST',
								url: 'finalleavepayoutlines.php',
								data:{action:action, actmode:actionmode, workerval:workerval},
								beforeSend:function(){
								
									$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
									
								},
								success: function(data){
									//payline='';
									//document.getElementById("hide2").value = "";
									$('#dtrContent').html(data);
								}
							}); 
							//-----------get line--------------//
						}
						else if(loctype == 2)
						{
							//-----------get line--------------//
							var action = "getline";
							var actionmode = "userform";
							var workerval = document.getElementById("hidewk").value;
							//var workerval = 'DCWR000001';
							$.ajax({
								type: 'POST',
								url: 'finalthpayoutlines.php',
								data:{action:action, actmode:actionmode, workerval:workerval},
								beforeSend:function(){
								
									$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
									
								},
								success: function(data){
									//payline='';
									//document.getElementById("hide2").value = "";
									$('#dtrContent').html(data);
								}
							}); 
							//-----------get line--------------//
						}

						else if(loctype == 3)
						{
							//-----------get line--------------//
							var action = "getline";
							var actionmode = "userform";
							var workerval = document.getElementById("hidewk").value;
							//var workerval = 'DCWR000001';
							$.ajax({
								type: 'POST',
								url: 'finalloanpayoutlines.php',
								data:{action:action, actmode:actionmode, workerval:workerval},
								beforeSend:function(){
								
									$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
									
								},
								success: function(data){
									//payline='';
									//document.getElementById("hide2").value = "";
									$('#dtrContent').html(data);
								}
							}); 
							//-----------get line--------------//
						}

			
						  
				});
			});

		// Get the modal -------------------
		var modal = document.getElementById('myModal');
		// Get the button that opens the modal
		var CreateBtn = document.getElementById("separationbtn");
		//var UpdateBtn = document.getElementById("myUpdateBtn");
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("modal-close")[0];
		// When the user clicks the button, open the modal 
		CreateBtn.onclick = function() {
		    //modal.style.display = "block";
		    $("#myModal").stop().fadeTo(500,1);
		    //$("#add-payrollperiod").prop('readonly', false);
		    //document.getElementById("add-payrollperiod").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		    
		   

		}
		/*UpdateBtn.onclick = function() {
			if(so != '') {
				if (locStatus != '1') {
				    //modal.style.display = "block";
				    $("#myModal").stop().fadeTo(500,1);
				    $("#add-finalpayout").prop('readonly', true);
				    
				    document.getElementById("add-finalpayout").value = so;

				    document.getElementById("addbt").style.visibility = "hidden";
				    document.getElementById("upbt").style.visibility = "visible";
				}
				else{
					alert("Leave Payout has already Posted.");
				}
			}
			else 
			{
				alert("Please Select a record you want to update.");
			}

		}*/
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
		}*/
		//end modal --------------------------- 

		$(document).ready(function() {
			var loctype2 = document.getElementById("hidedetails").value;
			//alert(1);
			//-----------get line--------------//
			/*var action = "getline";
			var actionmode = "userform";
			var workerval = document.getElementById("hidewk").value;
			//var workerval = 'DCWR000001';
			$.ajax({
				type: 'POST',
				url: 'finalpayoutlines.php',
				data:{action:action, actmode:actionmode, workerval:workerval},
				beforeSend:function(){
				
					$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					
				},
				success: function(data){
					//payline='';
					//document.getElementById("hide2").value = "";
					$('#dtrContent').html(data);
				}
			}); */
			//-----------get line--------------//

			if(loctype2 == 0)
			{
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				var workerval = document.getElementById("hidewk").value;
				//var workerval = 'DCWR000001';
				$.ajax({
					type: 'POST',
					url: 'finalpayoutlines.php',
					data:{action:action, actmode:actionmode, workerval:workerval},
					beforeSend:function(){
					
						$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide2").value = "";
						$('#dtrContent').html(data);
					}
				}); 
				//-----------get line--------------//
			}
			else if(loctype2 == 1)
			{
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				var workerval = document.getElementById("hidewk").value;
				//var workerval = 'DCWR000001';
				$.ajax({
					type: 'POST',
					url: 'finalleavepayoutlines.php',
					data:{action:action, actmode:actionmode, workerval:workerval},
					beforeSend:function(){
					
						$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide2").value = "";
						$('#dtrContent').html(data);
					}
				}); 
				//-----------get line--------------//
			}
			else if(loctype2 == 2)
			{
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				var workerval = document.getElementById("hidewk").value;
				//var workerval = 'DCWR000001';
				$.ajax({
					type: 'POST',
					url: 'finalthpayoutlines.php',
					data:{action:action, actmode:actionmode, workerval:workerval},
					beforeSend:function(){
					
						$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide2").value = "";
						$('#dtrContent').html(data);
					}
				}); 
				//-----------get line--------------//
			}

			else if(loctype2 == 3)
			{
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				var workerval = document.getElementById("hidewk").value;
				//var workerval = 'DCWR000001';
				$.ajax({
					type: 'POST',
					url: 'finalloanpayoutlines.php',
					data:{action:action, actmode:actionmode, workerval:workerval},
					beforeSend:function(){
					
						$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide2").value = "";
						$('#dtrContent').html(data);
					}
				}); 
				//-----------get line--------------//
			}


			//alert(document.getElementById("hidestatus").value);
				var crtControl = document.getElementById("hidetype").value;
				if (crtControl == 'Separation Pay') 
				{
					$('#separationbtn').css("display", "block");
				}
				else
				{
					$('#separationbtn').css("display", "none");
				}
		});

		function filtercat()
		{
			var action = "categ";
			var acttype = document.getElementById("add-cat").value;
			//alert(acttype);
		    $.ajax({
						type: 'GET',
						url: 'finalpayoutdetailprocess.php',
						data:{action:action, acttype:acttype},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							//$("#result").html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#categresult').html(data);
							//$("#add-finalpayout").prop('readonly', true); 
				}
			});
		}
		

		function GenerateFinalPay(){

			var myPayout = [];
			var stats = document.getElementById("hidestatus").value;

			action = "generate";

			var cont = document.getElementById("t2").value;
			myPayout = cont.toLowerCase().split(",");
			
			var n = myPayout.includes('0');

			if(n == true){
				alert("Final Pay has been generated!");
				//return false;
			}
			else
			{
				//alert("Continue Saving...");
				//return true;

				if (stats != '1') {

					$.ajax({	
							type: 'GET',
							url: 'finalpayoutdetailprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action},
							beforeSend:function(){
									
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#result').html(data);
							//alert("New leave payouts generated successfully.");
							location.reload();					
							}
					});
				}
				else 
				{
					alert("13th Payout has been Posted.");
				}

			}
			
			
		}

		function GenerateFinalLeave(){

			var myPayout = [];
			var stats = document.getElementById("hidestatus").value;

			action = "generateleave";

			var cont = document.getElementById("t2").value;
			myPayout = cont.toLowerCase().split(",");
			
			var n = myPayout.includes('1');

			if(n == true){
				alert("Leave Payout has been generated!");
				//return false;
			}
			else
			{
				if (stats != '1') {

					$.ajax({	
							type: 'GET',
							url: 'finalpayoutdetailprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action},
							beforeSend:function(){
									
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#result').html(data);
							//alert("New leave payouts generated successfully.");
							location.reload();					
							}
					});
				}
				else 
				{
					alert("13th Payout has been Posted.");
				}
			}

			
		}

		function GenerateFinalTH(){

			var myPayout = [];
			var stats = document.getElementById("hidestatus").value;

			action = "generateth";

			var cont = document.getElementById("t2").value;
			myPayout = cont.toLowerCase().split(",");
			
			var n = myPayout.includes('2');

			if(n == true){
				alert("13th Month Payout has been generated!");
				//return false;
			}
			else
			{
				if (stats != '1') {

					$.ajax({	
							type: 'GET',
							url: 'finalpayoutdetailprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action},
							beforeSend:function(){
									
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#result').html(data);
							//alert("New leave payouts generated successfully.");
							location.reload();					
							}
					});
				}
				else 
				{
					alert("13th Payout has been Posted.");
				}
			}

			
		}

		function GenerateSeparation()
		{
			alert(1);
		}

		function GenerateFinalLoan()
		{

			var myPayout = [];
			var stats = document.getElementById("hidestatus").value;

			action = "loan";

			var cont = document.getElementById("t2").value;
			myPayout = cont.toLowerCase().split(",");
			
			var n = myPayout.includes('3');

			if(n == true){
				alert("Loan has been generated!");
				//return false;
			}
			else
			{
				if (stats != '1') {

					$.ajax({	
							type: 'GET',
							url: 'finalpayoutdetailprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action},
							beforeSend:function(){
									
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							window.location.href='loanfileselection.php';
							//alert("New leave payouts generated successfully.");
							//location.reload();					
							}
					});
				}
				else 
				{
					alert("Loan has been Posted.");
				}
			}

			/*var action = "unload";
			$.ajax({
				type: 'GET',
				url: '13thmonthpayoutdetailprocess.php',
				data:{action:action},
				success: function(data) {
				    window.location.href='loanfileselection.php';
			    }
			}); */
		}


		function Cancel()
		{

			
			var action = "unload";
			$.ajax({
				type: 'GET',
				url: '13thmonthpayoutdetailprocess.php',
				data:{action:action},
				success: function(data) {
				    window.location.href='finalpayout.php';
			    }
			});    
		}

		function Delete()
		{
			
			var stats = document.getElementById("hidestatus").value;
			var workerval = document.getElementById("hidewk").value;
			action = "delete"
			if(loctype == 0)
			{
				actmode = "deletefinalpay";
			}
			else if(loctype == 1)
			{
				actmode = "deleteleavepay";
			}
			else if(loctype == 2)
			{
				actmode = "deletethpay";
			}
			else if(loctype == 3)
			{
				actmode = "deleteloan";
			}

			//alert(action)
			

			
				if (stats != '1') {

					$.ajax({	
							type: 'GET',
							url: 'finalpayoutdetailprocess.php',
							
							data:{action:action, actmode:actmode, payoutid:so, workerval:workerval},
							beforeSend:function(){
									
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#result').html(data);
							//alert("New leave payouts generated successfully.");
							location.reload();					
							}
					});
				}
				else 
				{
					alert("Payout has been Posted.");
				}
			
		}

</script>
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>