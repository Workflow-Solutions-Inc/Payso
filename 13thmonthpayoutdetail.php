<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if(isset($_SESSION['thpayoutid']))
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
$thpayoutstatus = $_SESSION['thpayoutstatus'];
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>13th Month Payout Line</title>

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
			<!--<li><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>-->
			<li><button onClick="Generate();"><span class="fa fa-edit"></span> Generate</button></li>
			<!-- <li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li> -->
			<!-- <li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li> -->
			<!-- <li><button id="myAssessBtn" onClick="Assess();"><span class="fa fa-edit"></span> Assess Application</button></li>
			<li><button id="myAssessBtn" onClick="sendSMS();"><span class="fa fa-edit"></span> Send Message</button></li>-->
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
							<span class="fa fa-archive"></span> Line Details for <?php echo $thpayoutid; ?>
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
										<td style="width:20%;">Worker ID</td>
										<td style="width:20%;">Worker</td>
										<td style="width:20%;">Rate</td>
										<td style="width:20%;">Total BPAY</td>
										<td style="width:20%;">Total 13th Month</td>
										
										<td style="width:17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
										<td class="text-center"><span class="fas fa-search fa-xs"></span></td>
										<!-- <td><center><input id="selectAll" type="checkbox"></span></center></td> -->

										

									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>

									</tr>	
									
								</thead>
								
								<tbody id="result">
									<?php	
										$query = "SELECT w.workerid,w.name as name, format(l.rate,2)  as rate,
													format(sum(IF(l.accountcode = 'BPAY', payoutamount, NULL)),2) AS bpay,
													format(sum(IF(l.accountcode = 'TMTH', payoutamount, NULL)),2) AS thmonth

													from thmonthpayoutdetails l
													left join worker w on l.workerid = w.workerid and l.dataareaid = w.dataareaid 

													
													
												where l.thmonthpayoutid = '$thpayoutid' and l.dataareaid = '$dataareaid'

												group by w.name";
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
											<tr id="<?php echo $row['workerid'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
												<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
												<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
												<td style="width:20%;"><?php echo $row['workerid'];?></td>
												<td style="width:20%;"><?php echo $row['name'];?></td>
												<td style="width:20%;"><?php echo $row['rate'];?></td>
												<td style="width:20%;"><?php echo $row['bpay'];?></td>
												<td style="width:20%;"><?php echo $row['thmonth'];?></td>

												<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
												
											</tr>

										<?php 
										//$firstresult = $row["workerid"];
										//$conn->close();
										//include("dbconn.php");
										}
										$result2 = $conn->query($query);
											$row2 = $result2->fetch_assoc();
											$firstresult = $row2["workerid"];
										?>

								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php echo $firstresult; ?>">
									<input class="hidden" type="input" id="hidestatus" value="<?php echo $thpayoutstatus; ?>">
									
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




<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	 <script  type="text/javascript">

		var locname='';
	  	var so = '';
	  	var gl_stimer= '';
	  	var gl_etimer= '';
		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			//locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			so = usernum.toString();


			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);	

			//-----------get line--------------//
			var action = "getline";
			var actionmode = "userform";
			var workerval = document.getElementById("hide").value;
			$.ajax({
				type: 'POST',
				url: '13thmonthpayoutlines.php',
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
						  
				});
			});

		$(document).ready(function() {
			//alert(1);
			//-----------get line--------------//
			var action = "getline";
			var actionmode = "userform";
			var workerval = document.getElementById("hide").value;
			$.ajax({
				type: 'POST',
				url: '13thmonthpayoutlines.php',
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
		});


		function Generate(){

			var stats = document.getElementById("hidestatus").value;

			action = "generate";

			if (stats != '1') {

				$.ajax({	
						type: 'GET',
						url: '13thmonthpayoutdetailprocess.php',
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


		function Cancel()
		{

			
			var action = "unload";
			$.ajax({
				type: 'GET',
				url: '13thmonthpayoutdetailprocess.php',
				data:{action:action},
				success: function(data) {
				    window.location.href='13thmonthpayout.php';
			    }
			});    
		}

</script>
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>