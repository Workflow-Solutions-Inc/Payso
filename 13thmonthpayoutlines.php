<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];
$payrollperiod = '';

if(isset($_SESSION['thpayoutid']))
{
	$thpayoutid = $_SESSION['thpayoutid'];
}
$workerid= $_POST['workerval'];

?>
<!-- start TABLE AREA -->
<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
	<div class="mainpanel-content">
		<!-- title & search -->
		<div class="mainpanel-title">
			<span class="fa fa-archive"></span> 
			13th Month Details
		</div>

		<!-- table -->
		<div id="container1" class="half">
			<table width="100%" style="border: 1px solid #d9d9d9;" id="dataln" class="table table-striped mainpanel-table">
				<thead>
					<tr class="rowtitle">
						<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
						<td style="width:25%;">Payroll ID</td>
						<td style="width:25%;">Payroll Period</td>
						<td style="width:25%;">Payroll Month</td>
						<td style="width:25%;">Amount</td>
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

						$query = "SELECT payrollid,payrollperiod,payrollmonth,format(payoutamount,2) payoutamount from thmonthpayoutdetails
									where accountcode = 'TMTH' and dataareaid = '$dataareaid' and workerid = '$workerid' and thmonthpayoutid = '$thpayoutid'";
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
								<td style="width:20px;"><span class="fa fa-angle-right"></span></td>
								<td style="width:25%;"><?php echo $row['payrollid'];?></td>
								<td style="width:25%;"><?php echo $row['payrollperiod'];?></td>
								<td style="width:25%;"><?php echo $row['payrollmonth'];?></td>
								<td style="width:25%;"><?php echo $row['payoutamount'];?></td>
								
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
		var locDate='';
  		var locDTName='';
  		var stimer = '';
		var etimer = '';
		$(document).ready(function(){
			$('#dataln tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","orange");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
				locDTName = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();

				stimer = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(6)").text();
				etimer = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(7)").text();

				locDate = transnumline.toString();
				document.getElementById("hide2").value = locDate;
				//alert(document.getElementById("hide").value);
					
				//flaglocation = false;
		        //$("#myUpdateBtn").prop("disabled", true);
		        //alert(flaglocation);		
				//flaglocation = false;
				//alert(payline);
				loc = document.getElementById("hide").value;
	            //$("#myUpdateBtn").prop("disabled", false);
	             var pos = $("#"+loc+"").attr("tabindex");
				    //$("tr[tabindex="+pos+"]").focus();
				    $("tr[tabindex="+pos+"]").css("color","red");
				    $("tr[tabindex="+pos+"]").addClass("info");
				//document.getElementById("myUpdateBtn").style.disabled = disabled;
					  
			});
		});

		
</script>