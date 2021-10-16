<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];

$attbranch = $_POST['attbranch'];
$attdept = $_POST['attdept'];
$attpos = $_POST['attpos'];

?>



	<?php

	if($_POST["actmode"]=="loadcurday"){
		$query = "SELECT wk.name as name, pos.name as position, dm.name as department,bra.name as branch, 
					MIN(case when mt.type = 0 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end) as 'timein',
					MAX(case when mt.type = 1 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end) as 'timeout',
					MIN(case when mt.type = 3 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end) as 'breakout',
					MIN(case when mt.type = 4 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end) as 'breakin' 

					from monitoringtable mt 
					LEFT JOIN worker wk ON mt.Name = wk.BioId left join branch brn on wk.branch = brn.branchcode and wk.dataareaid = brn.dataareaid 
					left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid
					LEFT JOIN contract con ON wk.workerid = con.workerid and con.dataareaid = wk.dataareaid 
					LEFT JOIN department dm ON con.departmentid = dm.departmentid and wk.dataareaid = dm.dataareaid 
					left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
					where 

					mt.Date = curdate() and 
					wk.dataareaid = '$dataareaid'";
					
					if($attdept != '' && $attbranch == '' && $attpos == '')
					{
						$query .= " and dm.departmentid = '$attdept' ";
					}
					else if($attdept == '' && $attbranch != '' && $attpos == '')
					{
						$query .= " and bra.branchcode = '$attbranch' ";
					}
					else if($attdept == '' && $attbranch == '' && $attpos != '')
					{
						$query .= " and pos.positionid = '$attpos' ";
					}
					else if($attdept != '' && $attbranch != '' &&  $attpos == '')
					{
						$query .= " and dm.departmentid = '$attdept' and bra.branchcode = '$attbranch' ";
					}
					else if($attdept != '' && $attbranch == '' &&  $attpos != '')
					{
						$query .= " and dm.departmentid = '$attdept' and pos.positionid = '$attpos' ";
					}
					else if($attdept == '' && $attbranch != '' &&  $attpos != '')
					{
						$query .= " and bra.branchcode = '$attbranch' and pos.positionid = '$attpos' ";
					}
		$query .=
					"group by wk.name, pos.name, dm.name, bra.name
					order by MIN(case when mt.type = 0 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end),wk.name asc";

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
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:20%;"><?php echo $row['name'];?></td>
				<td style="width:20%;"><?php echo $row['position'];?></td>
				<td style="width:20%;"><?php echo $row['department'];?></td>
				<td style="width:20%;"><?php echo $row['branch'];?></td>
				<td style="width:20%;"><?php echo $row['timein'];?></td>
				<td style="width:20%;"><?php echo $row['timeout'];?></td>
				<td style="width:20%;"><?php echo $row['breakout'];?></td>
				<td style="width:20%;"><?php echo $row['breakin'];?></td>
				
			</tr>

			<?php
			$CURquery = "SELECT currentCount,realtimeCount from notificationcountertable;";

			$CURresult = $conn->query($CURquery);
			
			$currentCount = 0;
			$realtimeCount = 0;
			while ($CURrow = $CURresult->fetch_assoc())
			{ 
					$currentCount = $CURrow['currentCount'];
					
					$realtimeCount = $CURrow['realtimeCount'];
			}
			
		?>
			<tr class="rowA">
					<td hidden><input type="input" id="hdcurrentCount" value="<?php echo $currentCount;?>"></td>
					<td hidden><input type="input" id="hdrealtimeCount" value="<?php echo $realtimeCount;?>"></td>
			</tr>;
		<?php }
	
	}
	
	?>
	<?php
		$LastRecquery = "SELECT wk.name as name,  
							TIME_FORMAT(mt.Time,'%h:%i %p') logtime,
							case when mt.type = 0
							then 'Time In'
							when mt.type = 1
							then 'Time Out'
							when mt.type = 3
							then 'Break Out'
							else 'Break In'
							end as log

							from monitoringtable mt 
							LEFT JOIN worker wk ON mt.Name = wk.BioId left join branch brn on wk.branch = brn.branchcode and wk.dataareaid = brn.dataareaid 

							where wk.dataareaid = '$dataareaid' and Date = curdate()

							order by mt.recid asc";

			$LastRecresult = $conn->query($LastRecquery);
			
			$LastRecName = '';
			$LastRectime = '';
			$LastRecTag = '';
			
			while ($LastRecrow = $LastRecresult->fetch_assoc())
			{ 
					$LastRecName = $LastRecrow['name'];
					$LastRectime = 'Has '.$LastRecrow['log'].': '.$LastRecrow['logtime'];
					//$LastRectime = $LastRecrow['realtimeCount'];
					

			}
	?>

	<tr class="rowA">
					<td hidden><input type="input" id="LastRecName" value="<?php echo $LastRecName;?>"></td>
					<td hidden><input type="input" id="LastRectime" value="<?php echo $LastRectime;?>"></td>
			</tr>;
	<?php
	
		if($_POST["actiondel"]=="delnotif"){
	 
			$sqlNotif = "DELETE from notificationcountertable";
			if(mysqli_query($conn,$sqlNotif))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sqlNotif."<br>".$conn->error;
			}

		}


	?>


<!-- end TABLE AREA -->
<script  type="text/javascript">
	

	setTimeout(function() {
			//location.reload();
			var prevdate='';
	  			prevdate = document.getElementById("add-prevdate").value;
			var attbranch='';
	  			attbranch = document.getElementById("add-branch").value;
	  		var attdept='';
	  			attdept = document.getElementById("add-dept").value;
	  		var attpos='';
	  			attpos = document.getElementById("add-position").value;

	  		var	LastRecName = document.getElementById("LastRecName").value;
	  		var	LastRectime = document.getElementById("LastRectime").value;

	  			//alert(attdept);
	  			//alert($('#hdrealtimeCount').val());
	  			//alert($('#hdcurrentCount').val());
	  		//if($('#hdrealtimeCount').val() != $('#hdcurrentCount').val())
	  		if(($('#LastRecName').val() != $('#lastname').val())||($('#LastRectime').val() != $('#lastaction').val()))
	  		{
	  			if(!("Notification" in window))
				{
					alert("This browser does not support notifications.");
				}
				else if(Notification.permission == "granted")
				{
					var notification = new Notification(LastRecName+'\n'+LastRectime);
						document.getElementById("lastname").value= $('#LastRecName').val();
						document.getElementById("lastaction").value= $('#LastRectime').val();
				}
				else if (Notification.permission != "denied")
				{
					Notification.requestPermission(function(permission){

						if("permission" == "granted")
						{
							var notification = new Notification(LastRecName+'\n'+LastRectime);
							document.getElementById("lastname").value= $('#LastRecName').val();
							document.getElementById("lastaction").value= $('#LastRectime').val();
						}

					});

				}

				var actiondel = "delnotif";
				$.ajax({
					type: 'POST',
					url: 'attendanceload.php',
					data:{actiondel:actiondel},
					beforeSend:function(){
					
						//$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						//document.getElementById("HDincAcc").value = "";
						//$('#result').html(data);
					}
				}); 
				//alert("test")
	  		}

	  			//-----------get line--------------//
				var action = "getline";
				var actionmode = "loadcurday";
				$.ajax({
					type: 'POST',
					url: 'attendanceload.php',
					data:{action:action, actmode:actionmode, attbranch:attbranch, attdept:attdept, attpos:attpos},
					beforeSend:function(){
					
						//$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						//document.getElementById("HDincAcc").value = "";
						$('#result').html(data);
					}
				}); 	
				//-----------get line--------------//
	  		
	  			
	  		

	  		
			
		

		}, 1000);

		
</script>