<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$leavepayoutid = $_SESSION["leavepayoutid"];
$leavepayoutfromdate = $_SESSION['leavepayoutfromdate'];
$leavepayouttodate = $_SESSION['leavepayouttodate'];
$leavepayoutyear = $_SESSION['leavepayoutyear'];

include("dbconn.php");


if($_GET["action"]=="generate"){

		#$sql = "call generateLeavePayout('$dataareaid','$leavepayoutid', '$userlogin' )";
		$sql = "call generateleavepayout_V2('$dataareaid','$leavepayoutid', '$userlogin', '$leavepayoutfromdate', '$leavepayouttodate', '$leavepayoutyear', '', '1' )";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Generated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	header('location: leavepayoutline.php');

}

else if($_GET["action"]=="delete"){

		$id=$_GET["locrecnum"];

		#$sql = "call generateLeavePayout('$dataareaid','$leavepayoutid', '$userlogin' )";
		$sql = "UPDATE
				leavefile  lf


				left join leavepayoutdetail lp on lf.workerid = lp.workerid and lf.dataareaid = lp.dataareaid
				and lp.leavetype = lf.leavetype

				set lf.balance = lp.leavecredits

				where
				#lf.fromdate >= '$leavepayoutfromdate'  and lf.todate <= '$leavepayouttodate' and 
				lf.year = '$leavepayoutyear'
				and lp.leavecredits IS NOT NULL
				and lp.recid = '$id'";
		if(mysqli_query($conn,$sql))
		{
			$sqldelete = "DELETE from leavepayoutdetail where recid = '$id' and dataareaid = '$dataareaid'";

			if(mysqli_query($conn,$sqldelete))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sqldelete."<br>".$conn->error;
			}
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	header('location: leavepayoutline.php');

}
else if($_GET["action"]=="unload"){
	 	
	unset($_SESSION['leavepayoutid']);
	unset($_SESSION['leavepayoutfromdate']);
	unset($_SESSION['leavepayouttodate']);
	unset($_SESSION['leavepayoutyear']);
	//unset($_SESSION['paynum']);
	header('location: leavepayoutline.php');

	
}

?>

<script  type="text/javascript">
	  	var so='';
	  	var locPayPer;
		var locYear;
		var locDate;
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locPayPer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locYear = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(locPayGroup);	
					  
			});
		});
</script>