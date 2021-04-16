
<?php
session_id("payso");
session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$firstresult = $_POST['PayId'];
?>
<!-- start TABLE AREA -->
				<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> Account Summary
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
							</div> -->
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
										$query = "SELECT accountcode,
													accountname,
													um,
													case when accounttype = 0 then 'Entry'
													when accounttype = 1 then 'Computed'
													when accounttype = 2 then 'Condition'
													else 'Total'
													end as accounttype,
													format(value,2) value
													FROM payrollheaderaccounts
													where payrollid = '$firstresult'
													and dataareaid = '$dataareaid'
													order by um";
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
												<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
												
											</tr>

										<?php 
										$qNet = "CALL SP_CheckNetPay ('$firstresult','$dataareaid')";

											$rNet = $conn->query($qNet);

											$collection = '';

											
											while ($rowNet = $rNet->fetch_assoc())
											{
												$collection = $collection.','.$rowNet['name'];
											}


											/*echo $output2 = '<tr class="rowA">
																<td style="display:none;width:1%;"><input type="input" id="hide0net" value="'.substr($collection,1).'"></td>
															</tr>';*/
											$conn->close();
											include("dbconn.php");



									}?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide2" value="<?php echo $firstresult;?>">
									<input type="hidden" id="hide0net" value="<?php echo substr($collection,1);?>">
								</span>	
							</table>
						</div>
					</div>
				</div>

<script  type="text/javascript">
		/*var so='';
	  	
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'GET',
					url: 'payrolltransactionprocess.php',
					data:{action:action, actmode:actionmode, PayId:so},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						payline='';
						document.getElementById("hide2").value = "";
						$('#lineresult').html(data);
					}
				}); 	
				//-----------get line--------------//	  
			});
		});*/
		var payline='';
  		$(document).ready(function(){
			$('#dataln tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","orange");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
				payline = transnumline.toString();
				document.getElementById("hide2").value = payline;
				//alert(document.getElementById("hide").value);

				loc = document.getElementById("hidefocus").value;
		            //alert(loc);
		             var pos = $("#"+loc+"").attr("tabindex");
					    $("tr[tabindex="+pos+"]").focus();
					    $("tr[tabindex="+pos+"]").css("color","red");
					    $("tr[tabindex="+pos+"]").addClass("info");
					//document.getElementById("myUpdateBtn").style.disabled = disabled;
					
					  
			});
		});

		
</script>