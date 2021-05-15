<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];
$payrollperiod = '';
if(isset($_SESSION['DTRPeriod']))
{
	$payrollperiod = $_SESSION['DTRPeriod'];
}
$workerid= $_POST['transval'];
$_SESSION['DTRWorker'] = $_POST['transval'];
?>
<!-- start TABLE AREA -->
<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
	<div class="mainpanel-content">
		<!-- title & search -->
		<div class="mainpanel-title">
			<span class="fa fa-archive"></span> 
			Schedule
		</div>

		<!-- table -->
		<div id="container1" class="half">
			<table width="100%" style="border: 1px solid #d9d9d9;" id="dataln" class="table table-striped mainpanel-table">
				<thead>
					<tr class="rowtitle">
						<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
						<td style="width:15%;">Date</td>
						<td style="width:15%;">Week Day</td>
						<td style="width:15%;">Time In</td>
						<td style="width:15%;">Time Out</td>
						<td style="width:15%;">Day Type</td>
						<td style="width:15%;">Break Out</td>
						<td style="width:15%;">Break In</td>
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

						$query = "SELECT date as Date,weekday,ifnull(TIME_FORMAT(timein,'%h:%i %p'),'00:00') as timein,ifnull(TIME_FORMAT(timeout,'%h:%i %p'),'00:00') as timeout
									,case when DayType = 'Weekend' then 'Regular' else daytype end as daytype,

									/*STR_TO_DATE(TIME_FORMAT(timein, '%h:%i %p'), '%l:%i %p' ) as stime,
									STR_TO_DATE(TIME_FORMAT(timeout, '%h:%i %p'), '%l:%i %p' ) as etime,*/
									DATE_FORMAT(timein,'%H:%i:%s') as stime,
									DATE_FORMAT(timeout,'%H:%i:%s') as etime,


									ifnull(TIME_FORMAT(breakout, '%h:%i %p'),'00:00') as 'BreakOut',
									ifnull(TIME_FORMAT(breakin, '%h:%i %p'),'00:00') as 'BreakIn',
									DATE_FORMAT(breakout,'%H:%i:%s') as bkout,
									DATE_FORMAT(breakin,'%H:%i:%s') as bkin,

									modifiedby
						 from dailytimerecorddetail 
									where dataareaid = '$dataareaid' and workerid = '$workerid' and payrollperiod = '$payrollperiod' order by workerid,date asc";
						$result = $conn->query($query);
						$rowclass = "rowA";
						$rowcnt = 0;
						while ($row = $result->fetch_assoc())
						{ 
							$rowcnt++;
								if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
								else { $rowclass = "rowA";}

								if(($row['timein'] == "00:00" && $row['timeout'] == "00:00" && $row['BreakOut'] == "00:00" && $row['BreakIn'] == "00:00") && $row['daytype'] == 'Regular')
								{
									$rowclass = "rowInvalid";
								}
								else if($row['modifiedby'] != "")
								{
									$rowclass = "rowModified";
								}
								else if($row['timein'] == "00:00" && $row['daytype'] == 'Regular')
								{
									$rowclass = "rowNoIn";
								}
								else if($row['timeout'] == "00:00" && $row['daytype'] == 'Regular')
								{
									$rowclass = "rowNoOut";
								}
							?>
							<tr class="<?php echo $rowclass; ?>">
								<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
								<td style="width:20px;"><span class="fa fa-angle-right"></span></td>
								<td style="width:15%;"><?php echo $row['Date'];?></td>
								<td style="width:15%;"><?php echo $row['weekday'];?></td>
								<td style="width:15%;"><?php echo $row['timein'];?></td>
								<td style="width:15%;"><?php echo $row['timeout'];?></td>
								<td style="width:15%;"><?php echo $row['daytype'];?></td>
								<td style="width:15%;"><?php echo $row['BreakOut'];?></td>
								<td style="width:15%;"><?php echo $row['BreakIn'];?></td>
								<td style="display:none;width:1%;"><?php echo $row['stime'];?></td>
								<td style="display:none;width:1%;"><?php echo $row['etime'];?></td>
								<td style="display:none;width:1%;"><?php echo $row['bkout'];?></td>
								<td style="display:none;width:1%;"><?php echo $row['bkin'];?></td>
								
								
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
		var bkout = '';
		var bkin = '';
		$(document).ready(function(){
			$('#dataln tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","orange");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
				locDTName = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();

				stimer = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(8)").text();
				etimer = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(9)").text();
				bkout = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(10)").text();
				bkin = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(11)").text();

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