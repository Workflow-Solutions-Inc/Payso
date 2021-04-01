<?php

session_start();
#$userlogin = $_SESSION["user"];

include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];
if(isset($_GET["save"])){
	 
//-------Personal Information	
		 $shifttype=$_GET["shifttype"];
		 $starttime=$_GET["starttime"];
		 $endtime=$_GET["endtime"];
	
		 $sql = "Insert Into shifttype (shifttype,starttime,endtime,dataareaid) values ('$shifttype',TIME_FORMAT('$starttime', '%h:%i %p'),TIME_FORMAT('$endtime', '%h:%i %p'),'$dataareaid')";
			if(mysqli_query($conn,$sql))
			{
				echo "New Rec Created";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}
	
		//header('location: shiftype.php'); 
	
}

else if(isset($_GET["update"])){

		$shifttype = $_GET["shifttype"];
		$daytype = $_GET["daytype"];

		$shiftscheduledate = $_GET["SelectedVal"];
		$wkid = $_GET["wkid"];

		/*echo $shifttype.' - ';
		echo $daytype.' - ';
		echo $shiftscheduledate.' - ';
		echo $wkid.' - ';*/
		$starttime = '';
		$endtime = '';
		$stat = '';
		$breakout = '';
		$breakin = '';
		 if($shifttype != ""){

		 $query = "SELECT *
					from shifttype 
								
					where dataareaid = '$dataareaid' and shifttype = '$shifttype' ";
		$result = $conn->query($query);
		
		while ($row = $result->fetch_assoc())
		{
			$starttime = $row["starttime"];
			$endtime = $row["endtime"];
			$breakout = $row["breakout"];
			$breakin = $row["breakin"];
		}

		$wksquery = "SELECT * FROM worker where workerid = '$wkid'";
				$wksresult = $conn->query($wksquery);

				while ($wksrow = $wksresult->fetch_assoc())
				{
					$userid=$wksrow["workerid"];
					$query = "UPDATE shiftschedule a 
                        left join  calendartable b 
                        on a.Date = b.date and a.dataareaid = b.dataareaid 
                        set a.shifttype = '$shifttype',
                        
                        a.starttime = concat(b.date,' ','$starttime'), 
                        a.endtime = case when '$endtime' <= CONVERT('06:00:00', TIME) and '$endtime' >= CONVERT('00:00:00', TIME) 
                        then concat(DATE_ADD(b.date, INTERVAL 1 day),' ','$endtime') else concat(b.date,' ','$endtime') end, 
                        a.daytype = '$daytype',
                        a.breakout = concat(b.date,' ','$breakout'),
                        a.breakin = case when '$breakin' <= CONVERT('06:00:00', TIME) and '18:00:00' >= CONVERT('00:00:00', TIME)  
		                then concat(DATE_ADD(b.date, INTERVAL 1 day),' ','$breakin') else concat(b.date,' ','$breakin') end
                        where a.workerid =  '$userid' and a.date between cast('$shiftscheduledate' as date) and cast('$shiftscheduledate' as date)";

		            if(mysqli_query($conn,$query))
					{
						echo "Rec Updated";
					}
					else
					{
						echo "error ".$query."<br>".$conn->error;
					}
				}



		 /*$sql = "UPDATE shiftschedule a 
					left join  shifttype b 
					on a.dataareaid = b.dataareaid 

					set a.shifttype = '$shifttype',

					a.starttime =  concat('$shiftscheduledate',' ',STR_TO_DATE(b.starttime, '%l:%i %p')), 
					a.endtime = concat('$shiftscheduledate',' ',STR_TO_DATE(b.endtime, '%l:%i %p')),
					a.daytype = '$daytype' 

					where b.shifttype = '$shifttype' and a.workerid =  '$wkid' and a.date between cast('$shiftscheduledate' as date) and cast('$shiftscheduledate' as date)
					and a.dataareaid = '$dataareaid'

					";

			if(mysqli_query($conn,$sql))
			{
				echo "Rec Updated";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}*/

		 }
		 else{
		 	echo "";
		 }
header('location: viewschedule.php');
	
}
else if($_GET["action"]=="changeTime"){
//----------Schedule
	if($_GET["actmode"]=="time"){
		$output='';
		$sched = '';
		$schedparam = '';
		$stype = $_GET["stype"];

		//$schedtype=$_GET["locType"];

		$query = "SELECT TIME_FORMAT(starttime, '%h:%i %p') starttime,TIME_FORMAT(endtime, '%h:%i %p') endtime,
				TIME_FORMAT(breakout, '%h:%i %p') as 'BreakOut',TIME_FORMAT(breakin, '%h:%i %p') as 'BreakIn' from shifttype where shifttype = '$stype' and dataareaid = '$dataareaid'";
		$result = $conn->query($query);

		while ($row = $result->fetch_assoc())
		{
			$output .= '
				<label>Updated Start Time:</label>
				<input type="text" value="'.$row["starttime"].'" id="add-starttime"  class="modal-textarea">
				<label>Updated End Time:</label>
				<input type="text" value="'.$row["endtime"].'" id="add-endtime"  class="modal-textarea">
				<label>Updated Break Out:</label>
				<input type="text" value="'.$row["BreakOut"].'" id="add-breakout"  class="modal-textarea">
				<label>Updated Break In:</label>
				<input type="text" value="'.$row["BreakIn"].'" id="add-breakin"  class="modal-textarea">
				 ';
			
		}
		

		echo $output;

	}
}

else if($_GET["action"]=="delete"){
	if($_GET["actmode"]=="schedule"){	
	
		$shiftschedule = $_GET["SelectedVal"];
		$wkid = $_GET["wkid"];
		//$ssvalue = $_GET["SelectedVal"];
		//echo "<h2>" . $shiftschedule . "</h2>";

		if($shiftschedule != ""){
			$sql = "DELETE from shiftschedule where date in ($shiftschedule) and workerid = '$wkid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
	//header('location: shiftype.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$daytype = $_GET["daytype"];
		$date = $_GET["date"];
		$weekday = $_GET["weekday"];
		$shifttype = $_GET["shifttype"];
		$wkid = $_GET["wkid"];



		$output='';
		//$output .= '<tbody>';
		if($date != '')
		{
			$query = "SELECT date,weekday,shifttype ,
												TIME_FORMAT(starttime, '%h:%i %p') as 'StartTime',
												TIME_FORMAT(endtime, '%h:%i %p') as 'EndTime',daytype as 'Daytype',
												DATE_FORMAT(starttime,'%H:%i:%s') as stime,
												DATE_FORMAT(endtime,'%H:%i:%s') as etime,
												TIME_FORMAT(breakout, '%h:%i %p') as 'BreakOut',
												TIME_FORMAT(breakin, '%h:%i %p') as 'BreakIn',
												DATE_FORMAT(breakout,'%H:%i:%s') as bkout,
												DATE_FORMAT(breakin,'%H:%i:%s') as bkin
												 from shiftschedule
			where dataareaid = '$dataareaid' and workerid = '$wkid' and daytype like '%$daytype%' and weekday like '%$weekday%' and shifttype like '%$shifttype%' and date = '$date' ";
		}
		else
		{
			$query = "SELECT date,weekday,shifttype ,
												TIME_FORMAT(starttime, '%h:%i %p') as 'StartTime',
												TIME_FORMAT(endtime, '%h:%i %p') as 'EndTime',daytype as 'Daytype',
												DATE_FORMAT(starttime,'%H:%i:%s') as stime,
												DATE_FORMAT(endtime,'%H:%i:%s') as etime,
												TIME_FORMAT(breakout, '%h:%i %p') as 'BreakOut',
												TIME_FORMAT(breakin, '%h:%i %p') as 'BreakIn',
												DATE_FORMAT(breakout,'%H:%i:%s') as bkout,
												DATE_FORMAT(breakin,'%H:%i:%s') as bkin
												 from shiftschedule
			where dataareaid = '$dataareaid' and workerid = '$wkid' and daytype like '%$daytype%' and weekday like '%$weekday%' and shifttype like '%$shifttype%'";
		}
		

	

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
			$output .= '
			<tr class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
			<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:5%;"><input type="checkbox" id="chkbox" name="chkbox" class="checkbox"
				 	value="'.$row['Daytype'].'"></td>
				<td style="width:12%;">'.$row["Daytype"].'</td>			
				<td style="width:12%;">'.$row["date"].'</td>
				<td style="width:12%;">'.$row["weekday"].'</td>
				<td style="width:12%;">'.$row["shifttype"].'</td>
				<td style="width:12%;">'.$row["StartTime"].'</td>
				<td style="width:12%;">'.$row["EndTime"].'</td>
				<td style="width:12%;">'.$row["BreakOut"].'</td>
				<td style="width:12%;">'.$row["BreakIn"].'</td>
				<td style="display:none;width:1%;">'.$row["stime"].'</td>
				<td style="display:none;width:1%;">'.$row["etime"].'</td>
				<td style="display:none;width:1%;">'.$row["bkout"].'</td>
				<td style="display:none;width:1%;">'.$row["bkin"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}


if(isset($_GET["proceed"])){
	 
//-------Personal Information	
		$status=$_GET["status"];
		$appid=$_GET["appId"];
		#echo $status;
		if($appid != ""){
			$sql = "UPDATE applicanttable SET STATUS = '$status' WHERE applicantid = '$appid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec updated";

			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		 
		//header('location: applicantmasterlist.php');
	
}

?>
