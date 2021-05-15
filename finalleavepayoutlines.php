<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];
$payrollperiod = '';

if(isset($_SESSION['finalpayoutid']))
{
	$leavepayoutid = $_SESSION['finalpayoutid'];
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
			Leave Payout Details
		</div>

		<!-- table -->
		<div id="container1" class="half">
			<table width="100%" style="border: 1px solid #d9d9d9;" id="dataln" class="table table-striped mainpanel-table">
				<thead>
					<tr class="rowtitle">
						<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
						<!-- <td style="width:5%;">Include</td> -->
						<td style="width:25%;">Leave Type</td>
						<td style="width:25%;">Rate</td>
						<td style="width:25%;">Leave Credit</td>
						<td style="width:25%;">Payout Amount</td>
						<td style="width:17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
					</tr>
				
				</thead>

				<tbody id="lineresult">
						<?php	
							$query = "SELECT w.name as name, format(l.rate,2)  as rate, format(l.leavecredits,2) as leavecredits, format(l.payoutamount,2) as payoutamount, lt.description as description,l.recid,l.workerid
										from leavepayoutdetail l
										left join worker w on l.workerid = w.workerid and l.dataareaid = w.dataareaid 
										left join leavetype lt on lt.leavetypeid = l.leavetype
									where l.leavepayoutid = '$leavepayoutid' and l.dataareaid = '$dataareaid'";
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
								<tr id="<?php echo $row['name'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
									<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
									<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
									<td style="width:25%;"><?php echo $row['description'];?></td>
									<td style="width:25%;"><?php echo $row['rate'];?></td>
									<td style="width:25%;"><?php echo $row['leavecredits'];?></td>
									<td style="width:25%;"><?php echo $row['payoutamount'];?></td>
									<td style="display:none;width:1%;"><?php echo $row['recid'];?></td>

									<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
									
								</tr>

							<?php 
							//$firstresult = $row["name"];
							//$conn->close();
							//include("dbconn.php");
							}
							/*$result2 = $conn->query($query);
								$row2 = $result2->fetch_assoc();
								$firstresult = $row2["workerid"];*/
							?>
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