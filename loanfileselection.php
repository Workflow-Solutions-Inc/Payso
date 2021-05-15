<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
//$locworker = $_SESSION['finalpayoutworker'];

if(isset($_SESSION['finalpayoutworker']))
{
	$wkid = $_SESSION['finalpayoutworker'];
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
	<title>Select Loan</title>

	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>

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
			<li class="LoanFileMaintain" style="display: none;"><button onClick="SetLoan();"><span class="fa fa-plus"></span> Save</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>
		
		<!-- extra buttons -->
		<!--<ul class="extrabuttons">
			<li><button><span class="fas fa-arrow-up fa"></span> Move Up</button></li>
			<li><button><span class="fas fa-arrow-down fa"></span> Move Down</button></li>
		</ul>-->

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
							<span class="fa fa-archive"></span> Select Loan
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
							<div class="mainpanel-sub-cmd" style="border: 0px solid #d9d9d9;">
								<b><label style="width: 170px;height: 25px;color:red;font-size:20px;border: 0px solid;">Hide Zero Balance:</label></b>
								<input type="checkbox" value="0" name ="view-archive" id="view-archive" style="width: 50px;height: 25px;margin-right: 50px;">
							</div>
						</div>
						<!-- tableheader -->
						<div id="container1" class="full">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:5%;">Include</td>
										<td style="display:none;width:1%;">Name</td>
										<td style="width:9%;">Voucher</td>
										<td style="width:8%;">Subtype</td>
										<td style="width:7%;">Loan Type</td>
										<td style="width:8%;">Account</td>
										<td style="width:8%;">Loan Date</td>
										<td style="width:8%;">Loan Amount</td>
										<td style="width:8%;">Amortization</td>
										<td style="width:8%;">Balance</td>
										<td style="width:8%;">From Date</td>
										<td style="width:8%;">To Date</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td><input list="SearchId" class="search" disabled>
										<?php
											$query = "SELECT distinct lf.workerid FROM loanfile lf
														left join worker wk on wk.workerid	= lf.workerid and wk.dataareaid = lf.dataareaid

														where lf.dataareaid = '$dataareaid' and wk.inactive = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchId">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["workerid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td style="display:none;width:1%;"><input list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct wk.name FROM loanfile lf
														left join worker wk on wk.workerid	= lf.workerid and wk.dataareaid = lf.dataareaid

														where lf.dataareaid = '$dataareaid' and wk.inactive = 0";
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
									  <td><input list="SearchVoucher" class="search" disabled>
										<?php
											$query = "SELECT distinct voucher FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchVoucher">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["voucher"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchSubType" class="search" disabled>
										<?php
											$query = "SELECT distinct subtype FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchSubType">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["subtype"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchLoanType" class="search" disabled>
										<?php
											$query = "SELECT distinct loantype FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchLoanType">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["loantype"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchAcc" class="search" disabled>
										<?php
											$query = "SELECT distinct todate FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchAcc">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["todate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchLoanDate" class="search" disabled>
										<?php
											$query = "SELECT distinct loandate FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchLoanDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["loandate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchAmount" class="search" disabled>
										<?php
											$query = "SELECT distinct loanamount FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchAmount">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["loanamount"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchAmortization" class="search" disabled>
										<?php
											$query = "SELECT distinct amortization FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchAmortization">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["amortization"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchBalance" class="search" disabled>
										<?php
											$query = "SELECT distinct balance FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchBalance">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["balance"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchFromDate" class="search" disabled>
										<?php
											$query = "SELECT distinct fromdate FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchFromDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["fromdate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchToDate" class="search" disabled>
										<?php
											$query = "SELECT distinct todate FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchToDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["todate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>

									  <td><span></span></td>
									</tr>
								</thead>
								<tbody id="result">
									<?php					
									$query = "SELECT 
												lf.workerid,wk.name,lf.voucher,lf.subtype,lf.loantype,STR_TO_DATE(lf.loandate, '%Y-%m-%d') loandate,format(lf.loanamount,2) as loanamount,
												format(lf.amortization,2) as amortization,format(lf.balance,2) as balance,STR_TO_DATE(lf.fromdate, '%Y-%m-%d') as fromdate
												,STR_TO_DATE(lf.todate, '%Y-%m-%d') as todate,lf.accountid,acc.name as accname,lf.accountid
												FROM 
												loanfile lf
												left join worker wk on wk.workerid	= lf.workerid and wk.dataareaid = lf.dataareaid
												left join accounts acc on acc.accountcode = lf.accountid and acc.dataareaid = lf.dataareaid

												where lf.dataareaid = '$dataareaid'  and wk.workerid = '$wkid'

												order by lf.workerid";
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
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:5%;"><input type='checkbox' id="chkbox" name="chkbox" class="checkbox" 
												value="<?php echo $row['voucher'];?>" ></td>
											<td style="display:none;width:1%;"><?php echo $row['name'];?></td>
											<td style="width:9%;"><?php echo $row['voucher'];?></td>
											<td style="width:8%;"><?php echo $row['subtype'];?></td>
											<td style="width:7%;"><?php echo $row['loantype'];?></td>
											<td style="width:8%;"><?php echo $row['accname'];?></td>
											<td style="width:8%;"><?php echo $row['loandate'];?></td>
											<td style="width:8%;"><?php echo $row['loanamount'];?></td>
											<td style="width:8%;"><?php echo $row['amortization'];?></td>
											<td style="width:8%;"><?php echo $row['balance'];?></td>
											<td style="width:8%;"><?php echo $row['fromdate'];?></td>
											<td style="width:8%;"><?php echo $row['todate'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['accountid'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="input" id="hide" value = "<?php echo $wkid;?>">
									<input type="input" id="inchide">
									<input type="input" id="inchide2">
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



<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	<script  type="text/javascript">

	  	var so='';
	  	//var locWorkerId = "";
		var locName = "";
		var locVoucher = "";
		var locSubtype = "";
		var locLoantype = "";
		var locAccount = "";
		var locLoandate = "";
		var locLoanamount = "";
		var locAmortization = "";
		var locBalance = "";
		var locFromdate = "";
		var locTodate = "";
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				//var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locVoucher = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				/*locSubtype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locLoantype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locAccount = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
				locLoandate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				locLoanamount = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locAmortization = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locBalance = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
				locFromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
				locTodate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();*/
				so = locVoucher.toString();
				//document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);	
					  
			});
		});

		var allVals = [];
		var uniqueNames = [];
		var remVals = [];
		var remValsEx = [];
		$('[name=chkbox]').change(function(){
		    if($(this).attr('checked'))
		    {
	      		//document.getElementById("inchide").value = $(this).val();
	      		Add();
		    }
		    else
		    {
					         
		         //document.getElementById("inchide").value=$(this).val();
		         remVals.push("'"+$(this).val()+"'");
		         $('#inchide2').val(remVals);

		         $.each(remVals, function(i, el2){

		    		removeA(allVals, el2);
		    		removeA(uniqueNames, el2);
			    	//$("input[value="+el+"]").prop("checked", true);
			    	//alert(el);
				});
		        Add();

		    }
		 });

		function removeA(arr) 
		{
		    var what, a = arguments, L = a.length, ax;
		    while (L > 1 && arr.length) {
		        what = a[--L];
		        while ((ax= arr.indexOf(what)) !== -1) {
		            arr.splice(ax, 1);
		        }
		    }
		    return arr;
		}
		
		function Add() 
		{  

			
			$('#inchide').val('');
			 $('[name=chkbox]:checked').each(function() {
			   allVals.push("'"+$(this).val()+"'");
			 });

			  //remove existing rec start-----------------------
			 $('[name=chkbox]:disabled').each(function() {
			   
			   remValsEx.push("'"+$(this).val()+"'");
		         //$('#inchide2').val(remValsEx);

		         $.each(remValsEx, function(i, el2){
		         		
		    		removeA(allVals, el2);
		    		removeA(uniqueNames, el2);
			    	//"'"+"PCC"+"'"
				});
			   
			 });
			 //remove existing rec end-------------------------

			 
				$.each(allVals, function(i, el){
				    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
				});
			
			 $('#inchide').val(uniqueNames);

		} 
		function CheckedVal()
		{ 
			$.each(uniqueNames, function(i, el){
				    $("input[value="+el+"]").prop("checked", true);
				    //alert(el);
				});
		}


		function SetLoan()
		{

			var SelectedVal = $('#inchide').val();
			var action = "generateloan";
			var actionmode = "userform";
			//alert(document.getElementById("add-include").value);
			$.ajax({	
					type: 'GET',
					url: 'finalpayoutdetailprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, SelectedVal:SelectedVal},
					beforeSend:function(){
							
					$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						
					},
					success: function(data){
					window.location.href='finalpayoutdetail.php';	
					//$('#datatbl').html(data);
					//location.reload();					
					}
			});

		}
		function Cancel()
		{

			var action = "unloadloan";
			$.ajax({
				type: 'GET',
				url: 'finalpayoutdetailprocess.php',
				data:{action:action},
				success: function(data) {
				    window.location.href='finalpayoutdetail.php';
			    }
			});	   
		}

	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>