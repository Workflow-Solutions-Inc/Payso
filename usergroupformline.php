<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$id=$_POST["userId"];
$_SESSION['UsrNum'] = $id;
?>
<!-- start TABLE AREA -->
<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
	<div class="mainpanel-content">
		<!-- title & search -->
		<div class="mainpanel-title">
			<span class="fa fa-archive"></span> 
			User Group
		</div>

		<!-- table -->
		<div id="container1" class="half">
			<table width="100%" style="border: 1px solid #d9d9d9;" id="dataln" class="table table-striped mainpanel-table">
				<thead>
					<tr class="rowtitle">
						<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
						<td style="width:50%;">User Group id</td>
						<td style="width:50%;">Name</td>
						<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
					</tr>
				
				</thead>

				<tbody id="lineresult">
						<?php
						$query = "SELECT ug.usergroupid,ug.name from usergroups ug
						left join usergroupsassignment ua on ua.usergroupid = ug.usergroupid
						where ua.userid = '$id'";
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
							<tr id="<?php echo $row['usergroupid'];?>" class="<?php echo $rowclass; ?>">
								<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
								<td style="width:50%;"><?php echo $row['usergroupid'];?></td>
								<td style="width:50%;"><?php echo $row['name'];?></td>
								
							</tr>

						<?php }?>
				</tbody>
				<input type="hidden" id="hide3">
			</table>
		</div>
	</div>
	<br><br><br><br>
</div>
<!-- end TABLE AREA -->

<script  type="text/javascript">


	  	var locgroup='';
	  	var locgroupname = '';
	  	var locgroupid = '';
		$(document).ready(function(){
		$('#dataln tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","orange");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			locgroup = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
			locgroupname = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();
			locgroupid = locgroup.toString();
			document.getElementById("hide3").value = locgroupid;
			//alert(document.getElementById("hide").value);
			//alert(locgroupid);
				flaglocation = false;
		        $("#myUpdateBtn").prop("disabled", true);
		        //alert(flaglocation);		
				//flaglocation = false;
				//alert(payline);
				loc = document.getElementById("hide").value;
	            //$("#myUpdateBtn").prop("disabled", false);
	             var pos = $("#"+loc+"").attr("tabindex");
				    $("tr[tabindex="+pos+"]").focus();
				    $("tr[tabindex="+pos+"]").css("color","red");
				    $("tr[tabindex="+pos+"]").addClass("info");
				//document.getElementById("myUpdateBtn").style.disabled = disabled;
						  
				});
			});

		
</script>


