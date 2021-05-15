<?php
session_start();
session_regenerate_id();
#$userlogin = $_SESSION["user"];

include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];
$user = $_SESSION["user"];

if($_GET["action"]=="update") {
	 
	 $date=$_GET["CalDate"];
	 $daytype = $_GET["DayType"];
	 $branchcode = $_GET["CalBRanch"];
	 
	 if($date != ""){
	$query = "UPDATE calendartable set DayType = '$daytype' where date = '$date' and branchcode = '$branchcode' and dataareaid = '$dataareaid'";

		if(mysqli_query($conn,$query))
			{
				echo "Update Calendar";
			}
			else
			{
				echo "error ".$query."<br>".$conn->error;
			}

	if($daytype == 'Regular')
	{
		$querySched = "UPDATE shiftschedule ss 
					left join worker wk on wk.workerid = ss.workerid and wk.dataareaid = ss.dataareaid 

					set ss.daytype = '$daytype'

					 where ss.date = '$date' 
					 and wk.branch = '$branchcode'
					 and ss.dataareaid = '$dataareaid'
					 and ss.daytype != 'Restday'";

		if(mysqli_query($conn,$querySched))
			{
				echo "Update Calendar";
			}
			else
			{
				echo "error ".$querySched."<br>".$conn->error;
			}
	}
	else
	{
		$querySched = "UPDATE shiftschedule ss 
					left join worker wk on wk.workerid = ss.workerid and wk.dataareaid = ss.dataareaid 

					set ss.daytype = '$daytype'

					 where ss.date = '$date' 
					 and wk.branch = '$branchcode'
					 and ss.dataareaid = '$dataareaid'";

		if(mysqli_query($conn,$querySched))
			{
				echo "Update Calendar";
			}
			else
			{
				echo "error ".$querySched."<br>".$conn->error;
			}

	}

	



			$_SESSION['CalDateFoc'] = $date;
	 }
	 
	//header('location: calendar.php');
	
}

else if($_GET["action"]=="createcal"){
	$dayYear = $_GET["dayYear"];

	$branchcode = $_GET["branch"];

	$isupdate= $_GET["overwrite"];

	$checkYear = '';
	//$checkYear = [];dataareaid = '$dataareaid'
	$checkquery = "SELECT distinct extract(YEAR FROM Date) as 'year' from calendartable
					 where dataareaid = '$dataareaid' and branchcode = '$branchcode' and  extract(YEAR FROM Date) = '$dayYear'
					 order by date ASC ";

	$checkresult = $conn->query($checkquery);

	while ($checkrow = mysqli_fetch_array($checkresult))
	{
		$checkYear = $checkrow["year"];
	}

	if($checkYear != '')
	{
		echo "<script type='text/javascript'>alert('Generation Cancelled. Year Already Existed.');</script>";
	}
	else
	{
		//echo "<script type='text/javascript'>alert('Not Exist');</script>";
		$spquery = "call SP_Calendar(concat('$dayYear','-01-01'),concat('$dayYear','-12-31'),'$dataareaid','$branchcode');";

		if(mysqli_query($conn,$spquery))
				{
					echo "Created New Calendar ";
				}
				else
				{
					echo "error ".$spquery."<br>".$conn->error;
				}

		if ($isupdate == "true")
			{
				//update
				$uquery = "UPDATE  calendartable c1  left join  calendartable c2 on c1.Date = DATE_ADD(c2.date, INTERVAL 1 YEAR) and c1.dataareaid = c2.dataareaid 
				set c1.DayType = c2.DayType 
				where c2.daytype not in ('regular', 'weekend')
				and c1.branchcode = '$branchcode'
				and c1.dataareaid = '$dataareaid'
				";

				if(mysqli_query($conn,$uquery))
				{
					echo "Updated the Calendar from previous";
				}
				else
				{
					echo "error ".$query."<br>".$conn->error;
				}
			}


	}
 	header('location: calendarload.php');
		/*if($checkYear == $dayYear){
			// $query = "SELECT branchcode from branch where dataareaid = '$dataareaid' and branchcode = '$branch'";
			// $result = $conn->query($query);
			
			// while ($row = $result->fetch_assoc())
			// {
			// 	$branchcode = $row["branchcode"];
				$spquery = "call SP_Calendar(concat('$dayYear','-01-01'),concat('$dayYear','-12-31'),'$dataareaid','$branchcode');";
			//}

				if(mysqli_query($conn,$spquery))
				{
					echo "Created New Calendar ";
				}
				else
				{
					echo "error ".$spquery."<br>".$conn->error;
				}

			if ($isupdate == "true")
			{
				//update
				$uquery = "UPDATE  calendartable c1  left join  calendartable c2 on c1.Date = DATE_ADD(c2.date, INTERVAL 1 YEAR) and c1.dataareaid = c2.dataareaid 
				set c1.DayType = c2.DayType where c2.daytype not in ('regular', 'weekend')";

				if(mysqli_query($conn,$uquery))
				{
					echo "Updated the Calendar from previous";
				}
				else
				{
					echo "error ".$query."<br>".$conn->error;
				}
			}
			else{
				echo "";
			}
		}
		else if($dayYear > $checkYear){
			echo "You dont have the previous year";
		}
		else{
			echo "The Year is already existed";
		}*/
			

}

else if($_GET["action"]=="filtered"){

		$todate =$_GET["todate"];
		$frdate = $_GET["frdate"];
		$daytype = $_GET["dayType"];
		$branchCode = $_GET["branch"];

		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * from calendartable where dataareaid = '$dataareaid' and Date between cast('$frdate' as date) and cast('$todate' as date) 
			 
			and branchcode = '$branchCode'

			order by Date;";
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
			<tr id="'.$row["Date"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:32%;">'.$row["Date"].'</td>
				<td style="width:32%;">'.$row["DayType"].'</td>
				<td style="width:32%;">'.$row["Weekday"].'</td>
				<td style="display:none;width:1%;">'.$row['branchcode'].'</td>
				
			</tr>';
			
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
}

else if($_GET["action"]=="unload"){
	 	
	unset($_SESSION['CalDateFoc']);
	//unset($_SESSION['paynum']);
	header('location: calendar.php');
	
}

?>

<script src="js/ajax.js"></script>
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
<script type="text/javascript" src="js/custom.js"></script>