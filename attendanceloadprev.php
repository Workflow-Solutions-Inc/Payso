<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];

$attbranch = $_POST['attbranch'];
$attdept = $_POST['attdept'];
$attpos = $_POST['attpos'];
$prevdate = $_POST['prevdate'];

?>



	<?php
	if($_POST["actmode"]=="loadprev")
	{
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

					mt.Date = '$prevdate' and 
					wk.dataareaid = '$dataareaid' ";
					

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
					"group by wk.name  
					order by MIN(case when mt.type = 0 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end),wk.name asc";
		//echo $query;		
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

		<?php }
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
	  		var attpos='';
	  			attpos = document.getElementById("add-position").value;

			var action = "dept";
			var actionmode = "loadprev";

			if(prevdate != '')
			{
				$.ajax({
					type: 'POST',
					url: 'attendanceloadprev.php',
					data:{action:action, actmode:actionmode, attbranch:attbranch, attdept:attdept, attpos:attpos, prevdate:prevdate},
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