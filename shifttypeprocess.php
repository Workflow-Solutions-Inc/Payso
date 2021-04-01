<?php

session_start();
#$userlogin = $_SESSION["user"];

include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];
if(isset($_GET["save"])){
	 
//-------Personal Information	
		 $shifttype=$_GET["shifttypenew"];
		 $starttime=$_GET["starttime"];
		 $endtime=$_GET["endtime"];
		 $breakout=$_GET["breakout"];
		 $breakin=$_GET["breakin"];
		
		if($shifttype != ''){


		 $sql = "INSERT Into shifttype (shifttype,starttime,endtime,breakout,breakin,dataareaid) values ('$shifttype',TIME_FORMAT('$starttime', '%H:%i:%s'),TIME_FORMAT('$endtime', '%H:%i:%s')
		 						,TIME_FORMAT('$breakout', '%H:%i:%s'),TIME_FORMAT('$breakin', '%H:%i:%s'),'$dataareaid')";

			if(mysqli_query($conn,$sql))
			{
				echo "New Rec Created";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}
		}
		else{
			echo "no changes";
		}
		header('location: shiftype.php'); 
	
}

else if(isset($_GET["update"])){
	 

		 $stype = $_GET["shifttypenew"];
		 $stypeold = $_GET["shifttypeold"];
		 $starttime = $_GET["starttime"];
		 $endtime = $_GET["endtime"];
		 
		 if($stype != ''){
		 $sql = "UPDATE shifttype SET
					shifttype = '$stype',
					starttime = TIME_FORMAT('$starttime', '%H:%i:%s'),
					endtime = TIME_FORMAT('$endtime', '%H:%i:%s')
					
					WHERE shifttype = '$stypeold'
					and dataareaid = '$dataareaid'";

			if(mysqli_query($conn,$sql))
			{
				echo "Rec Updated";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}
		}	 
		 
		header('location: shiftype.php');

	
}
else if($_GET["action"]=="delete"){
	if($_GET["actmode"]=="schedule"){	
	
		$shifttype = $_GET["shifttype"];

		if($shifttype != ""){
			$sql = "DELETE from shifttype where shifttype = '$shifttype'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
	header('location: shiftype.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$daytype = $_GET["daytype"];
		$date = $_GET["date"];
		$weekday = $_GET["weekday"];
		$shifttype = $_GET["shifttype"];



		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * from shiftschedule where dataareaid = '$dataareaid' and daytype like '%$daytype%' and date like '%$date%'  and weekday like '%$weekday%' and shifttype like '%$shifttype%'";
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
				 	value="'.$row['daytype'].'"></td>
				<td style="width:16%;">'.$row["daytype"].'</td>			
				<td style="width:16%;">'.$row["date"].'</td>
				<td style="width:16%;">'.$row["weekday"].'</td>
				<td style="width:16%;">'.$row["shifttype"].'</td>
				<td style="width:16%;">'.$row["Start Time"].'</td>
				<td style="width:16%;">'.$row["End Time"].'</td>
				<td style="display:none;width:1%;">'.$row["stime"].'</td>
				<td style="display:none;width:1%;">'.$row["etime"].'</td>
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
		 
		header('location: applicantmasterlist.php');
	
}

?>
