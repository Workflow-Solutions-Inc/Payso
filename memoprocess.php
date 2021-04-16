<?php
session_id("payso");
session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $memoid = $_GET["memoid"];
	 $from = $_GET["from"];
	 $subject = $_GET["subject"];
	 $body = $_GET["body"];
	 
	 if($memoid != ""){
	 $sql = "INSERT INTO memoheader (memoid,memofrom,subject,body,dataareaid,createdby,createddatetime)
			values 
			('$memoid', '$from', '$subject', '$body','$dataareaid', '$userlogin', now())";

		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
header('location: memo.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $memoid = $_GET["memoid"];
	 $from = $_GET["from"];
	 $subject = $_GET["subject"];
	 $body = $_GET["body"];
	 
	 if($memoid != ""){
	 $sql = "UPDATE memoheader SET subject = '$subject', body = '$body', memofrom = '$from',modifiedby = '$userlogin',modifieddatetime = now() 
			where memoid = '$memoid' and dataareaid = '$dataareaid'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	
	header('location: memo.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="memoform"){	

		$memoid = $_GET["memoid"];

		if($memoid != ""){
			$sql = "DELETE from memoheader where memoid = '$memoid' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}

		header('location: memo.php');
	
	}

}
else if($_GET["action"]=="deleteline"){
	 
	if($_GET["actmode"]=="subline"){	

		$memoid = $_GET["memoid"];
		$worker = $_GET["locworker"];
		

		if($memoid != ""){
			$sql = "DELETE from memodetail where memoid = '$memoid' and workerid = '$worker' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}

		header('location: memo.php');
	
	}

}
else if($_GET["action"]=="sublist"){
	 	
	$id=$_GET["UsrId"];
	
	$_SESSION['setMemo'] = $id;
	//unset($_SESSION['paynum']);
	header('location: memo.php');
	
}
else if($_GET["action"]=="unload"){
	 	
	unset($_SESSION['memoheadid']);
	//unset($_SESSION['paynum']);
	header('location: memo.php');
	
}
else if($_GET["action"]=="unload2"){
	 	
	unset($_SESSION['WKNumMemo']);
	//unset($_SESSION['paynum']);
	header('location: memo.php');
	
}
else if($_GET["action"]=="add"){
	 $output='';
	 $sequence='';
	 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='memoreports'";
	 $result = $conn->query($query);
	 $row = $result->fetch_assoc();
	 $prefix = $row["prefix"];
	 $first = $row["first"];
	 $last = $row["last"];
	 $format = $row["format"];
	 $next = $row["next"];
	 $suffix = $row["suffix"];
	 if($last >= $next)
	 {
	 	$sequence = $prefix.substr($format,0,strlen($next)*-1).$next.$suffix;
	 }
	 else if ($last < $next)
	 {
	 	$sequence = $prefix.$next.$suffix;
	 }
	 $increment=$next+1;
	 $sql = "UPDATE numbersequence SET
				next = '$increment',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE id = 'memoreports'
				and dataareaid = '$dataareaid'";
	 //mysqli_query($conn,$sql);	
		if(mysqli_query($conn,$sql))
		{
			$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Memo Id" name ="memoid" id="add-MemoId"  class="modal-textarea" required="required">
				 ';
		}
		else
		{
			$output .= "error".$sql."<br>".$conn->error;
		}
	 
	 /*$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Worker Id" name ="Wid" id="add-wid"  class="textbox text-center width-full" required="required">
				 ';*/
	 echo $output;
	
}
?>

<script  type="text/javascript">
		var so='';
		var locUPass = '';
		var locNM = '';
		var locDT = '';
		var usernum = '';
		if(usernum == '')
		{
			so = document.getElementById("hide").value;
		}
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locNM = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locDT = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locUPass = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				//locIndex = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//document.getElementById("hidefocus").value = locIndex.toString();
				//alert(document.getElementById("hide").value);
				//alert(so);

				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'userformline.php',
					data:{action:action, actmode:actionmode, userId:so},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						document.getElementById("hide2").value = "";
						$('#lineresult').html(data);
					}
				}); 
				//-----------get line--------------//
				flaglocation = true;
				//alert(flaglocation);
		        $("#myUpdateBtn").prop("disabled", false);	
					  
			});
		});

</script>