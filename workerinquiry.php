<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Worker Inquiry</title>

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
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
			<!--<li><button  onClick="#"><span class="fa fa-plus"></span> Export to Excel</button></li>-->
			<!-- <li><button  onClick="savedCalendar()"><span class="fa fa-edit"></span> Save Calendar</button></li> -->
			<!-- <li><button  onClick="filteredCalendar()"><span class="fa fa-trash-alt"></span> Filtered Calendar</button></li> -->
			<!-- <li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			 -->
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
							<span class="fa fa-archive"></span> Worker Inquiry
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
						<div id="container1" class="full-h" style="border: 1px solid #d9d9d9;">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:210px;">WorkerID</td>
										<td style="width:400px;">Name</td>
										<td style="width:200px;">Position</td>
										<td style="width:200px;">Rate</td>
										<td style="width:200px;">Ecola</td>
										<td style="width:200px;">Transpo</td>
										<td style="width:200px;">Meal</td>
										<td style="width:250px;">Last Salary Movement</td>
										<td style="width:600px;">Address</td>

										<td style="width:200px;">Contact Number</td>
										<td style="width:200px;">Birthdate</td>
										<td style="width:200px;">Age</td>
										<td style="width:200px;">Date Hired</td>
										<td style="width:200px;">Length of Service</td>
										<td style="width:200px;">Regulazation Date</td>

										<td style="width:200px;">SSS</td>
										<td style="width:200px;">PhilHealth</td>
										<td style="width:200px;">Pag-ibig</td>
										<td style="width:200px;">TIN</td>
										<td style="width:200px;">Bank Number</td>
										<td style="width:200px;">Company</td>
										<td style="width:17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
										<td class="text-center"><span class="fas fa-search fa-xs"></span></td>

									  <td><input list="SearchShiftWorkerid" class="search">
										<?php
											$query = "SELECT distinct * FROM worker where dataareaid = '$dataareaid'";
											$result = $conn->query($query);
									  	?>
									  <datalist id="SearchShiftWorkerid">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["workerid"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>
									  

									  <td><input list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM worker where dataareaid = '$dataareaid'";

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


									 <!--  <td><input list="SearchPosition" class="search">
										<?php
											$query = "SELECT distinct p.name AS position FROM position p LEFT JOIN worker wk ON wk.position = p.positionid and wk.dataareaid = p.dataareaid 
											where wk.position = p.positionid and p.dataareaid = '$dataareaid'";
											$result = $conn->query($query);		
									  	?>
									  <datalist id="SearchPosition">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["position"];?>"></option>
										<?php } ?>
										</datalist>



									  </td> -->

									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
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
									$query = "call workerinquiry('$dataareaid','0');";

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
											<td style="width:210px;"><?php echo $row['workerid'];?></td>
											<td style="width:400px;"><?php echo $row['name'];?></td>
											<td style="width:200px;"><?php echo $row['position'];?></td>
											<td style="width:200px;"><?php echo $row['rate'];?></td>
											<td style="width:200px;"><?php echo $row['ecola'];?></td>
											<td style="width:200px;"><?php echo $row['transpo'];?></td>
											<td style="width:200px;"><?php echo $row['meal'];?></td>
											<td style="width:250px;"><?php echo $row['lastsalarymovement'];?></td>
											<td style="width:600px;"><?php echo $row['address'];?></td>

											<td style="width:200px;"><?php echo $row['contactnum'];?></td>
											<td style="width:200px;"><?php echo $row['birthdate'];?></td>
											<td style="width:200px;"><?php echo $row['age'];?></td>
											<td style="width:200px;"><?php echo $row['datehired'];?></td>
											<td style="width:200px;"><?php echo $row['lengthofservice'];?></td>
											<td style="width:200px;"><?php echo $row['regularizationdate'];?></td>

											<td style="width:200px;"><?php echo $row['sssnum'];?></td>
											<td style="width:200px;"><?php echo $row['phnum'];?></td>
											<td style="width:200px;"><?php echo $row['pagibignum'];?></td>
											<td style="width:200px;"><?php echo $row['tinnum'];?></td>
											<td style="width:200px;"><?php echo $row['bankaccountnum'];?></td>
											<td style="width:200px;"><?php echo $row['company'];?></td>
										</tr>
										

									<?php }?>

								</tbody>
								<span class="temporary-container-input">
									<input class="hide" type="input" id="hide">
									
								</span>
							</table>
						</div>	
					</div>
					<br><br>
				</div>
				<!-- end TABLE AREA -->

				<!-- Insert notepad table 2 for worker inquiry -->


			</div>
		</div>
	</div>
	<!-- end MAINPANEL -->

<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	 <script  type="text/javascript">

		var locname='';
	  	var so='';
	  	var gl_stimer= '';
	  	var gl_etimer= '';
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
			//document.getElementById("add-type").value = wa;
			//alert(wa);

			var position = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
			var rate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
			var ecola = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
			var transpo = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(6)").text();
			var meal = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
			var LSM = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
			var address = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
			var cnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
			var birthdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
			var age = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
			var datehired = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
			var LOS = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(14)").text();
			var rdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(15)").text();
			var sssnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(16)").text();
			var phnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(17)").text();
			var pagibignum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(18)").text();
			var tinnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(19)").text();
			var bankaccountnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(20)").text();
			var company = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(21)").text();

			document.getElementById("view-workerid").value = so.toString();
			document.getElementById("view-position").value = position.toString();
			document.getElementById("view-rate").value = rate.toString();
			document.getElementById("view-ecola").value = ecola.toString();
			document.getElementById("view-transpo").value = transpo.toString();
			document.getElementById("view-meal").value = meal.toString();
			document.getElementById("view-LSM").value = LSM.toString();
			document.getElementById("view-address").value = address.toString();
			document.getElementById("view-cnum").value = cnum.toString();
			document.getElementById("view-birthdate").value = birthdate.toString();
			document.getElementById("view-age").value = age.toString();
			document.getElementById("view-datehired").value = datehired.toString();
			document.getElementById("view-LOS").value = LOS.toString();
			document.getElementById("view-rdate").value = rdate.toString();
			document.getElementById("view-sssnum").value = sssnum.toString();
			document.getElementById("view-phnum").value = phnum.toString();
			document.getElementById("view-pagibignum").value = pagibignum.toString();
			document.getElementById("view-tinnum").value = tinnum.toString();
			document.getElementById("view-bankaccountnum").value = bankaccountnum.toString();
			document.getElementById("view-company").value = company.toString();
						  
				});
			});
		$(document).ready(function(){
        	$("#container2 :input").prop("disabled", true);
    	});

		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var workerid;
			var name;
			var position;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 workerid = data[0];
			 name = data[1];
			 position = data[2];

			 $.ajax({
						type: 'GET',
						url: 'workerinquiryprocess.php',
						data:{action:action, actmode:actionmode, workerid:workerid, name:name, position:position},
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
		function Cancel()
		{
			window.location.href='menu.php?list='+ActiveMode;
		}


</script>
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>