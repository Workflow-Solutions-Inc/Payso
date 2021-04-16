<?php 
session_id("payso");
session_start();
include("dbconn.php");
#$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if(isset($_SESSION['WKNumMemo']))
{
	$wkid = $_SESSION['WKNumMemo'];
}
else
{
	header('location: workerform.php');
}
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Memo Reports</title>

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
			<li><button onClick="Read();"><span class="fa fa-book"></span> Read Memo</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
			
		</ul>
		
		<!-- extra buttons -->
		<ul class="extrabuttons">
			<!-- <li><button onClick="generateMemo();"><span class="fa fa-print fa-lg"></span> Generate Memo</button></li> -->
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
							<span class="fa fa-archive"></span> Memo
						</div>
						<div class="mainpanel-sub">
						</div>
						<!-- tableheader -->
						<div id="container1" class="full">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:10%;">Memo ID</td>
										<td style="width:25%;">Subject</td>
										<td style="width:40%;">Body</td>
										<td style="width:15%;">Sender</td>
										<td style="width:10%;">Status</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>										
									</tr>
								
								
									<tr class="rowsearch">
												  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
												  
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
									$query = "SELECT mh.memoid,mh.subject,mh.body,mh.memofrom,md.status,CONCAT(LEFT(body,100),IF(length(body) > 100, '...', '')) as cutBody from memoheader mh
										        left join memodetail md on mh.memoid = md.memoid and mh.dataareaid = md.dataareaid
										        left join worker wk on md.workerid = wk.workerid and mh.dataareaid = wk.dataareaid
										        where wk.workerid = '$wkid'";
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
											<tr id="<?php echo $row['memoid'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:10%;"><?php echo $row['memoid'];?></td>
											<td style="width:25%;"><?php echo $row['subject'];?></td>
											<td style="width:40%;"><?php echo $row['cutBody'];?></td>
											<td style="width:15%;"><?php echo $row['memofrom'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['body'];?></td>
											<td style="width:10%;"><?php echo $row['status'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly' style="width:100%;"></td>-->
										</tr>

									<?php 
									//$firstresult = $row["userid"];
									}
										$result2 = $conn->query($query);
										$row2 = $result2->fetch_assoc();
										$firstresult = $row2["memoid"];
									?>
								
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php echo $firstresult; ?>">
									<input type="hidden" id="hide2" value="<?php echo $wkid; ?>">
									
									
									<div style="display:none;width:1%;"><textarea id="t2" value = "<?php echo substr($collection,1);?>"><?php echo substr($collection,1);?></textarea></div>
								</span>
							</table>
						</div>
					</div>
					<br>
				</div>
				<!-- end TABLE AREA -->

	
			</div>
		</div>
	</div>
	<!-- end MAINPANEL -->


<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	 <script  type="text/javascript">
	 	var flaglocation=true;
		var so='';
		var locUPass = '';
		var locNM = '';
		var locDT = '';
		var usernum = '';
		var myId = [];
		if(usernum == '')
		{
			so = document.getElementById("hide").value;
		}
		//var locIndex = '';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locSub = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locBody = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locFrom = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				var locstatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(6)").text();
				var status =  locstatus.toString();
				//alert(status);
				//locIndex = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				document.getElementById("inhide").value = status;

				//document.getElementById("hidefocus").value = locIndex.toString();
				//alert(document.getElementById("hide").value);
				//alert(so);

				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'memoline.php',
					data:{action:action, actmode:actionmode, userId:so},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						document.getElementById("hide2").value = "";
						$('#lineresult').html(data);
					}
				}); 
				//-----------get line--------------//
				flaglocation = true;
				//alert(flaglocation);
		        $("#myUpdateBtn").prop("disabled", false);	
					  
			});
		});
  		var locworker='';


		$(document).ready(function() {
			loc = document.getElementById("hide").value;
	            //$("#myUpdateBtn").prop("disabled", false);
	        if(loc != '')
	        {
	        	var pos = $("#"+loc+"").attr("tabindex");
	        }
	        else
	        {
	        	var pos = 1;
	        }
			//var pos = 1;
			//document.getElementById("hide").value;
		    //$("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").css("color","red");
		    $("tr[tabindex="+pos+"]").addClass("info");
		    //$("tr[tabindex=0]").focus();
		    //$("tr[tabindex="+pos+"]").css("color","red");  
		    //var idx = $("tr:focus").attr("tabindex");
		    //alert(idx);
		    //document.onkeydown = checkKey;
		});


		function checkExistForm()
		{
			var cont = document.getElementById("t2").value;
			myId = cont.toLowerCase().split(",");
			//myId.push("Kiwi","Lemon","Pineapple",'asd');
			/*$.each(myId, function(i, el2){
		    	alert(el2);
			});*/
			//alert(myId.length);
			var n = myId.includes(document.getElementById("add-UserId").value.toLowerCase());
			//alert(n);
			if(n == true){
				alert("User ID already Exist!");
				return false;
			}
			else
			{
				alert("Continue Saving...");
				return false;
			}
			
		}


		function Cancel()
		{
			//alert(so);
			//window.location.href='workerform.php';
			var action = "unload2";
			$.ajax({
				type: 'GET',
				url: 'memoprocess.php',
				data:{action:action},
				success: function(data) {
				    window.location.href='workerform.php';
			    }
			});  
		}
		function Read()
		{
			var wkidname = document.getElementById("hide2").value;
			//var stats = document.getElementById("inhide").value;
			//alert(stats);
			if(so != '')
			{

					window.open('Reports/Memo/Memo2.php?memoid='+so+'&wkid='+wkidname, "_blank");
				
			}
			else
			{
				alert("Please a specific memo and worker to proceed.");
			}
		}


	</script>
	
	<script type="text/javascript" src="js/custom.js">
	</script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>