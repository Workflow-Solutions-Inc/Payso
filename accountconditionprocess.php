<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];

include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];
$accnt = $_SESSION["accnt"];

if($_GET["action"]=="saveline"){	
	 
		$id = $_GET["SelectedVal"];
		$condi = $_GET["condit"];
		 

	 	$linenum = "SELECT MAX( linenum )+1 as numbers FROM accountconditiondetail act
			left join accountconditionheader ah
			on act.accountconditioncode = ah.accountconditioncode and act.dataareaid = ah.dataareaid
			left join accounts a 
			on ah.accountcode = a.accountcode and ah.dataareaid = a.dataareaid
			where a.accountcode = '$accnt' ";

			$result = $conn->query($linenum);
			
			while ($row = $result->fetch_assoc())
			{
				$line = $row["numbers"];
			}


		$sql = "INSERT into accountconditiondetail (accountconditioncode,accountconditiondetail.condition,linenum,dataareaid,createdby,createddatetime)
				values ('$id','$condi','$line', '$dataareaid', '$userlogin', now())";
			if(mysqli_query($conn,$sql))
			{
				echo "New Rec Created";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		$_SESSION['selectAcct'] = $id;
		header('location: accountconditionline.php');
	
}
else if($_GET["action"]=="updateline"){	
	 
		$id = $_GET["SelectedVal"];
		$condi = $_GET["condit"];
		$line = $_GET["linenum"];

		$sql = "UPDATE accountconditiondetail SET accountconditiondetail.condition = '$condi', modifiedby = '$userlogin', modifieddatetime = now()
			WHERE accountconditioncode = '$id' and linenum = '$line' and dataareaid = '$dataareaid'";

			if(mysqli_query($conn,$sql))
			{
				echo "New Rec Created";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}
		 
	$_SESSION['selectAcct'] = $id;
	header('location: accountconditionline.php');
	
}

// else if($_POST["action"]=="getline"){
// 	if($_POST["actmode"]=="userform"){
// 		$accountcode = $_POST["accountcode"];

// 		$output='';
// 		//$output .= '<tbody>';
// 		$query = "SELECT * FROM accountconditionheader ah left join accountconditiondetail ad 
// 				on ah.accountconditioncode = ad.accountconditioncode and ah.dataareaid = ad.dataareaid
// 				where ah.accountconditioncode = '$accountcode' and ah.dataareaid = '$dataareaid'";

// 		$result = $conn->query($query);
// 		$rowclass = "rowA";
// 		$rowcnt = 0;
// 		while ($row = $result->fetch_assoc())
// 		{
// 			$rowcnt++;
// 				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
// 				else { $rowclass = "rowA";}
// 			$output .= '
// 			<tr class="'.$rowclass.'">
// 				<td style="width:20px;"><span class="fa fa-adjust"></span></td>
// 				<td style="width:34%;">'.$row["referenceformula"].'</td>
// 				<td style="width:34%;">'.$row["condition"].'</td>
// 				<td style="width:34%;">'.$row["conditionformula"].'</td>
// 				<td style="display:none;width:1%;">'.$row["linenum"].'</td>
// 			</tr>';
// 		}
// 		//$output .= '</tbody>';
// 		echo $output;
// 		//header('location: process.php');
// 	}
// }

// else if($_GET["action"]=="saveline"){

// 		$id = $_GET["SelectedVal"];
// 		$condi = $_GET["condition"];
// 		$accnt = $_GET["accountcode"];
		 

// 	 	$linenum = "SELECT MAX( linenum )+1 as numbers FROM accountconditiondetail act
// 			left join accountconditionheader ah
// 			on act.accountconditioncode = ah.accountconditioncode and act.dataareaid = ah.dataareaid
// 			left join accounts a 
// 			on ah.accountcode = a.accountcode and ah.dataareaid = a.dataareaid
// 			where a.accountcode = '$accnt' ";

// 			$result = $conn->query($linenum);
			
// 			while ($row = $result->fetch_assoc())
// 			{
// 				$line = $row["numbers"];
// 			}


// 		 $sql = "INSERT into accountconditiondetail (accountconditioncode,accountconditiondetail.condition,linenum,dataareaid,createdby,createddatetime)
// 				values ('$id','$condi','$line', '$dataareaid', '$userlogin', now())";
// 			if(mysqli_query($conn,$sql))
// 			{
// 				echo "New Rec Created";
// 			}
// 			else
// 			{
// 				echo "error".$sql."<br>".$conn->error;
// 			}
		 
// 		//header('location: accountcondition.php');
// }


else if($_GET["action"]=="save"){
	if($_GET["actmode"]=="generateNew"){
		$accnt = $_GET["accountcode"];

		$sql = "INSERT INTO accountconditionheader (accountconditioncode,accountcode,priority,createddatetime,createdby,dataareaid) 
		 		values ('$accnt','$accnt', (SELECT MAX( priority )+1 FROM accountconditionheader act), now(),'$userlogin','$dataareaid');";

		 	if(mysqli_query($conn,$sql))
			{
				echo "New Rec Created";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}


		$acc = "SELECT replace(accountconditioncode, '$accnt-', '')+1 as accode from accountconditionheader where accountcode = '$accnt' and dataareaid = '$dataareaid'
 			order by length(accountconditioncode) desc, accountconditioncode desc limit 1 ";

		$result = $conn->query($acc);
		
		while ($row = $result->fetch_assoc())
		{
			$pnumber = $row["accode"];
		}

		$newAccountCode = $accnt . "-" . $pnumber;

		$nextSql = "UPDATE accountconditionheader SET accountconditioncode = '$newAccountCode' where accountcode = '$accnt' and dataareaid = '$dataareaid' ORDER BY priority DESC LIMIT 1";
			if(mysqli_query($conn,$nextSql))
			{
				echo "New Rec Created";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}
	}
}

else if($_GET["action"]=="delete"){	
	
		$id = $_GET["SelectedVal"];
		//$ssvalue = $_GET["SelectedVal"];
		//echo "<h2>" . $shiftschedule . "</h2>";

		if($id != ""){
			$sql = "DELETE from accountconditionheader WHERE accountconditioncode ='$id' and`dataareaid`='$dataareaid'";
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

else if($_GET["action"]=="deleteline"){	
	
		$id = $_GET["SelectedVal"];
		$lineid = $_GET["linenum"];
		//$ssvalue = $_GET["SelectedVal"];
		//echo "<h2>" . $shiftschedule . "</h2>";

		if($id != ""){
			$sql = "DELETE from accountconditiondetail WHERE accountconditioncode = '$id'  and linenum = '$lineid' and dataareaid ='$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
	$_SESSION['selectAcct'] = $id;
	header('location: accountconditionline.php');
}

else if($_GET["action"]=="Result"){
	 	
	$id=$_GET["accId"];
	//$line=$_GET["lnnmline"];
	$_SESSION['AccID'] = $id;
	//$_SESSION['AccLine'] = $line;
	$_SESSION['CalcMode'] = 'CalcResult';
	header('location: accountcondition.php');
	
}

else if($_GET["action"]=="UpdateResult"){
	 	
	$id=$_GET["AccIdCode"];
	$formula=$_GET["AccFormula"];
	

	$sql = "UPDATE accountconditionheader SET
				resultformula = '$formula',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE accountconditioncode = '$id'
				AND dataareaid = '$dataareaid'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
			unset($_SESSION['AccID']);
			unset($_SESSION['CalcMode']);
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}
	
	header('location: accountcondition.php');
	
}

else if($_GET["action"]=="Reference"){
	 	
	$id=$_GET["accId"];
	$line=$_GET["lnnmline"];
	$_SESSION['AccID'] = $id;
	$_SESSION['AccLine'] = $line;
	$_SESSION['CalcMode'] = 'CalcReference';
	header('location: accountcondition.php');
	
}

else if($_GET["action"]=="UpdateReference"){
	 	
	$id=$_GET["AccIdCode"];
	$line=$_GET["AccLineCode"];
	$formula=$_GET["AccFormula"];
	

	$sql = "UPDATE accountconditiondetail SET
				referenceformula = '$formula',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE accountconditioncode = '$id'
				and linenum = '$line'
				AND dataareaid = '$dataareaid'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
			unset($_SESSION['AccID']);
			unset($_SESSION['AccLine']);
			unset($_SESSION['CalcMode']);
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}
	
	header('location: accountcondition.php');
	
}

else if($_GET["action"]=="Condition"){
	 	
	$id=$_GET["accId"];
	$line=$_GET["lnnmline"];
	$_SESSION['AccID'] = $id;
	$_SESSION['AccLine'] = $line;
	$_SESSION['CalcMode'] = 'CalcCondition';
	header('location: accountcondition.php');
	
}

else if($_GET["action"]=="UpdateCondition"){
	 	
	$id=$_GET["AccIdCode"];
	$line=$_GET["AccLineCode"];
	$formula=$_GET["AccFormula"];
	

	$sql = "UPDATE accountconditiondetail SET
				conditionformula = '$formula',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE accountconditioncode = '$id'
				and linenum = '$line'
				AND dataareaid = '$dataareaid'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
			unset($_SESSION['AccID']);
			unset($_SESSION['AccLine']);
			unset($_SESSION['CalcMode']);
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}
	
	header('location: accountcondition.php');
	
}



?>

<script  type="text/javascript">
	  	var so='';
	  	var payline = '';
		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			so = usernum.toString();
			document.getElementById("hide").value = so;

			//alert(document.getElementById("hide").value);
			//alert(so);	
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'accountconditionline.php',
					data:{action:action, actmode:actionmode, accountcode:so},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						payline='';
						document.getElementById("inchides").value = "";
						$('#lineresult').html(data);
					}
				}); 	
				//-----------get line--------------//	
						  
				});
			});

/*	$(document).ready(function(){
		$('#dataln tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","orange");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var linenumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(4)").text();
			lnnmline = linenumline.toString();
			document.getElementById("inchides").value = linenumline.toString();
			//alert(document.getElementById("hide").value);
			var conditiontest = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();
			cndtntst = conditiontest.toString();
			document.getElementById("inchides2").value = cndtntst.toString();


			var rformula = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
			document.getElementById("inchides3").value = rformula.toString();
			
			var cformula = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(3)").text();
			document.getElementById("inchides4").value = cformula.toString();
					  
		});
	});*/
</script>