<?php
session_id("payso");
session_start();
include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];
$payrollperiod = '';

if(isset($_SESSION['finalpayoutid']))
{
	$finalpayoutid = $_SESSION['finalpayoutid'];
}


$locworker = $_SESSION['finalpayoutworker'];
$status = $_SESSION['finalpayoutstatus'];

$workerid= $_POST['workerval'];

?>
<!-- start TABLE AREA -->
<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
	<div class="mainpanel-content">
		<!-- title & search -->
		<div class="mainpanel-title">
			<span class="fa fa-archive"></span> 
			Payroll Details
		</div>

		<!-- table -->
		<div id="container1" class="half">
			<table width="100%" style="border: 1px solid #d9d9d9;" id="dataln" class="table table-striped mainpanel-table">
				<thead>
					<tr class="rowtitle">
						<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
						<td style="width:20%;">Account Code</td>
						<td style="width:20%;">Name</td>
						<td style="width:20%;">UM</td>
						<td style="width:20%;">Type</td>
						<td style="width:20%;">Value</td>
						<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>	
					</tr>
				
				</thead>

				<tbody id="lineresult">
						<?php
						/*if(isset($_SESSION['UsrNum']))
						{ 
							$VarUserid = $usrid; 
						}
						else
						{
							$VarUserid = $firstresult; 
						}*/

						$query = "SELECT finalpayoutid,payrollid,workerid,priority,
										accountcode,accountname,um,case when accounttype = 0 then 'Entry'
											when accounttype = 1 then 'Computed'
											when accounttype = 2 then 'Condition'
											else 'Total'
											end as accounttype,
										format(value,2) value FROM finalpaysaccounts 
										where dataareaid = '$dataareaid' and workerid = '$workerid' and finalpayoutid = '$finalpayoutid'
										order by priority";
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
								<td style="width:20%;"><?php echo $row['accountcode'];?></td>
								<td style="width:20%;"><?php echo $row['accountname'];?></td>
								<td style="width:20%;"><?php echo $row['um'];?></td>
								<td style="width:20%;"><?php echo $row['accounttype'];?></td>
								<td style="width:20%;"><?php echo $row['value'];?></td>
								
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