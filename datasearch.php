
<?php
session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$id=$_GET["DataId"];
		$name=$_GET["name"];
?>
<!-- start TABLE AREA -->
				
							<table width="100%" style="border: 1px solid #d9d9d9;" id="dataln" class="table table-striped mainpanel-table">
								

								<tbody id="lineresult" >
										
						<?php	
						$query = "SELECT * FROM dataarea where (dataareaid like '%$id%') and (name like '%$name%') ";
						$result = $conn->query($query);
						$rowclass = "rowA";
						$rowcnt = 0;
						while ($row = $result->fetch_assoc())
						{ 
							$rowcnt++;
								if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
								else { $rowclass = "rowA";}
							?>
							<tr id="<?php echo $row['dataareaid'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:25%;"><?php echo $row['dataareaid'];?></td>
											<td style="width:25%;"><?php echo $row['name'];?></td>
											<td style="width:25%;"><?php echo $row['address'];?></td>
											<td style="width:25%;"><?php echo $row['companytin'];?></td>
							</tr>




				<?php	}?>
								</tbody>
								
							</table>
						
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