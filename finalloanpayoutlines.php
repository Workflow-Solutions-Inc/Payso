<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];
$payrollperiod = '';

if(isset($_SESSION['finalpayoutid']))
{
	$payoutid = $_SESSION['finalpayoutid'];
}
//$leavepayoutid = 'DCLPT0000013';
$workerid= $_POST['workerval'];


?>
<!-- start TABLE AREA -->
<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
	<div class="mainpanel-content">
		<!-- title & search -->
		<div class="mainpanel-title">
			<span class="fa fa-archive"></span> 
			Loan Details
		</div>

		<!-- table -->
		<div id="container1" class="half">
			<table width="100%" style="border: 1px solid #d9d9d9;" id="dataln" class="table table-striped mainpanel-table">
				<thead>
					<tr class="rowtitle">
						<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
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
				
				</thead>

				<tbody id="lineresult">
						<?php					
									$query = "SELECT 
												lf.workerid,wk.name,lf.voucher,lf.subtype,lf.loantype,STR_TO_DATE(lf.loandate, '%Y-%m-%d') loandate,format(lf.loanamount,2) as loanamount,
												format(lf.amortization,2) as amortization,format(lf.balance,2) as balance,STR_TO_DATE(lf.fromdate, '%Y-%m-%d') as fromdate
												,STR_TO_DATE(lf.todate, '%Y-%m-%d') as todate,lf.accountid,acc.name as accname,lf.accountid
												FROM 
												finalloandetails lf
												left join worker wk on wk.workerid	= lf.workerid and wk.dataareaid = lf.dataareaid
												left join accounts acc on acc.accountcode = lf.accountid and acc.dataareaid = lf.dataareaid

												where lf.dataareaid = '$dataareaid'  and wk.workerid = '$workerid' and lf.loanpayoutid = '$payoutid'

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
				<input type="hidden" id="hide2">	
				<input type="hidden" id="hideworker" value="<?php echo $workerid;?>">	
			</table>
		</div>
	</div>
	<br><br><br><br>
</div>
<!-- end TABLE AREA -->
<script  type="text/javascript">

		
</script>