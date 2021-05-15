<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];

$CalHead = $_POST['headerid'];

?>



	<?php
		$query = "SELECT * from calendartable where dataareaid = '$dataareaid' and branchcode = '$CalHead'
		and year(date) = year(curdate()) order by Date";

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
			<tr  class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
				<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
				<td style="width:20px;" class="text-center" ><span class="fa fa-angle-right"></span></td>
				<td style="width:32%;"><?php echo $row['Date'];?></td>
				<td style="width:32%;"><?php echo $row['DayType'];?></td>
				<td style="width:32%;"><?php echo $row['Weekday'];?></td>
				<td style="display:none;width:1%;"><?php echo $row['branchcode'];?></td>
			</tr>
			

	<?php }?>


<!-- end TABLE AREA -->
<script  type="text/javascript">
	var locdaytype='';
  	var so='';
  	var locbranch= '';
	$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
		var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
		locbranch = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
		locdaytype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
		//locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
		so = usernum.toString();
		//gl_stimer = stimer;
		//gl_etimer = etimer.toString();
		document.getElementById("hide").value = so;
		//alert(document.getElementById("hide").value);
		//alert(so);	
		//document.getElementById("add-type").value = wa;
		//alert(locbranch);  
			});
	});

		
</script>