<?php
session_start();
include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];

$attbranch = $_POST['attbranch'];
$attdept = $_POST['attdept'];
$prevdate = $_POST['prevdate'];

?>



	<?php

	$query = "call get_attendance('$dataareaid', '$prevdate', '$attbranch', '$attdept');";

	$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		$rowcnt2 = 0;
		
		while ($row = $result->fetch_assoc())
		{ 
			$rowcnt++;
			$rowcnt2++;
			if($rowcnt > 1)
			{ 
				$rowcnt = 0;
				$rowclass = "rowB";
			}
			else
			{
				$rowclass = "rowA";
			}
				
		?>	

		<tr  class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
			<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
			<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
			<td style="width:20%;"><?php echo $row['name'];?></td>
			<td style="width:20%;"><?php echo $row['position'];?></td>
			<td style="width:20%;"><?php echo $row['department'];?></td>
			<td style="width:20%;"><?php echo $row['branch'];?></td>
			<td style="width:20%;"><?php echo $row['timein'];?></td>
			<td style="width:20%;"><?php echo $row['timeout'];?></td>
		</tr>

	<?php 
		}
	?>


<!-- end TABLE AREA -->
<script  type="text/javascript">
	
	function Load(){
  			//-----------get Header--------------//
  			var prevdate='';
	  			prevdate = document.getElementById("add-prevdate").value;
  			var attbranch='';
	  			attbranch = document.getElementById("add-branch").value;
	  		var attdept='';
	  			attdept = document.getElementById("add-dept").value;
			var action = "dept";
			var actionmode = "dept";

			if(prevdate != '')
			{
				$.ajax({
					type: 'POST',
					url: 'attendanceloadprev.php',
					data:{action:action, actmode:actionmode, attbranch:attbranch, attdept:attdept, prevdate:prevdate},
					beforeSend:function(){
					
						$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide").value = "1";
						$('#result').html(data);
					}
				});
			}
			else
			{
				alert('Please select date.');
			}
			
  		}
		
</script>