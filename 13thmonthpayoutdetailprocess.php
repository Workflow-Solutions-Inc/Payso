<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$thpayoutid = $_SESSION["thpayoutid"];
$thpayoutfromdate = $_SESSION['thpayoutfromdate'];
$thpayouttodate = $_SESSION['thpayouttodate'];
$thpayoutyear = $_SESSION['thpayoutyear'];

include("dbconn.php");


if($_GET["action"]=="generate"){

		#$sql = "call generateLeavePayout('$dataareaid','$leavepayoutid', '$userlogin' )";
		$sql = "call generatethpayout('$dataareaid','$thpayoutid', '$userlogin', '$thpayoutfromdate', '$thpayouttodate', '$thpayoutyear', '', '1' )";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Generated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	header('location: 13thmonthpayoutdetail.php');

}
else if($_GET["action"]=="unload"){
	 	
	unset($_SESSION['thpayoutid']);
	unset($_SESSION['thpayoutfromdate']);
	unset($_SESSION['thpayouttodate']);
	unset($_SESSION['thpayoutyear']);
	//unset($_SESSION['paynum']);
	header('location: 13thmonthpayoutdetail.php');
	
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