<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$conid = $_SESSION['ConNum'];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $type=$_GET["CTtype"];
	 $department=$_GET["CTdeparment"];
	 $payment=$_GET["CTpayment"];
	 $fromdate=$_GET["CTfromdate"];
	 $todate=$_GET["CTtodate"];
	 $contractnum = '';

	 if($todate == '')
	 {
	 	$todate = '1900-01-01';
	 }

	 
	 if($conid != ""){
	 $query2 = "SELECT 
				max(ct.linenum) as linenum
				FROM contract ct
				where ct.dataareaid = '$dataareaid' and ct.workerid = '$conid'";
	$result2 = $conn->query($query2);
	$row2 = $result2->fetch_assoc();
	$lastval = $row2["linenum"];
	$maxval = $lastval + 1; 
	$contractnum = $conid.'-'.$maxval;

	 $sql = "INSERT INTO contract (contractid,linenum,workerid,accountnum,rate,ecola,transpo,meal,fromdate,todate,contracttype,departmentid,paymenttype,dataareaid,createdby,createddatetime)
			values 
			('$contractnum','$maxval','$conid','','0.00','0.00','0.00','0.00','$fromdate','$todate','$type','$department','$payment', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: contractform.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $id=$_GET["CTcontract"];
	 $type=$_GET["CTtype"];
	 $department=$_GET["CTdeparment"];
	 $payment=$_GET["CTpayment"];
	 $fromdate=$_GET["CTfromdate"];
	 $todate=$_GET["CTtodate"];
	 
	 if($id != ""){
	 $sql = "UPDATE contract SET
				fromdate = '$fromdate',
				todate = '$todate',
				contracttype = '$type',
				departmentid = '$department',
				paymenttype = '$payment',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE contractid = '$id' and dataareaid = '$dataareaid'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: contractform.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		 $id=$_GET["CTcontract"];

		if($id != ""){
			$sql = "DELETE from contract WHERE contractid = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: contractform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["slocWorkerId"];
		$name=$_GET["slocName"];
		$voucher=$_GET["slocVoucher"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT 
					lf.workerid,wk.name,lf.voucher,lf.subtype,lf.loantype,STR_TO_DATE(lf.loandate, '%Y-%m-%d') loandate,format(lf.loanamount,2) as loanamount,
					format(lf.amortization,2) as amortization,format(lf.balance,2) as balance,STR_TO_DATE(lf.fromdate, '%Y-%m-%d') as fromdate
					,STR_TO_DATE(lf.todate, '%Y-%m-%d') as todate,lf.accountid,acc.name as accname,lf.accountid
					FROM 
					loanfile lf
					left join worker wk on wk.workerid	= lf.workerid and wk.dataareaid = lf.dataareaid
					left join accounts acc on acc.accountcode = lf.accountid and acc.dataareaid = lf.dataareaid

					where lf.dataareaid = '$dataareaid' and wk.inactive = 0 and (lf.workerid like '%$id%') and (wk.name like '%$name%') and (lf.voucher like '%$voucher%')

					order by lf.workerid";
		$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		while ($row = $result->fetch_assoc())
		{
			$rowcnt++;
				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
				else { $rowclass = "rowA";}
			$output .= '
			<tr class="'.$rowclass.'">
				<td style="width:20px;"><span class="fa fa-adjust"></span></td>
				<td style="width:8%;">'.$row["workerid"].'</td>
				<td style="width:12%;">'.$row["name"].'</td>
				<td style="width:9%;">'.$row["voucher"].'</td>
				<td style="width:8%;">'.$row["subtype"].'</td>
				<td style="width:7%;">'.$row["loantype"].'</td>
				<td style="width:8%;">'.$row["accname"].'</td>
				<td style="width:8%;">'.$row["loandate"].'</td>
				<td style="width:8%;">'.$row["loanamount"].'</td>
				<td style="width:8%;">'.$row["amortization"].'</td>
				<td style="width:8%;">'.$row["balance"].'</td>
				<td style="width:8%;">'.$row["fromdate"].'</td>
				<td style="width:8%;">'.$row["todate"].'</td>
				<td style="display:none;width:1%;">'.$row["accountid"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
else if($_GET["action"]=="worker"){
	 	
	//$id=$_GET["WorkId"];
	//$_SESSION['paynum'] = $id;
	//unset($_SESSION['paynum']);
	header('location: contractform.php');
	
}
else if($_GET["action"]=="rate"){
	 	
	$id=$_GET["WorkId"];
	$_SESSION['contract'] = $id;
	//unset($_SESSION['paynum']);
	header('location: contractform.php');
	
}
?>

<script  type="text/javascript">
		var so='';
	  	//var locWorkerId = "";
		var locContract = "";
		var locRate = "";
		var locEcola = "";
		var locTranspo = "";
		var locMeal = "";
		var locType = "";
		var locDepartment = "";
		var locPayment = "";
		var locFromdate = "";
		var locTodate = "";
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locRate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locEcola = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locTranspo = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locMeal = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locType = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
				locDepartment = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
				locPayment = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
				locFromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locTodate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);	
					  
			});
		});
</script>