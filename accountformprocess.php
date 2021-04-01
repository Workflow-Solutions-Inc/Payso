<?php

session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if(isset($_GET["save"])) {
	 
	$accinc=$_GET["AccInc"];
	$id=$_GET["AccCode"];
	$accname=$_GET["AccName"];
	$acclabel=$_GET["AccLabel"];
	$accum=$_GET["AccUm"];
	$acctype=$_GET["AccType"];
	$acccat=$_GET["AccCat"];
	$accval=$_GET["AccVal"];
	$last=$_GET["AccLast"];
	 
	 if($id != ""){
	 $sql = "INSERT INTO accounts (autoinclude,accountcode,name,label,um,accounttype,category,defaultvalue,priority,dataareaid,createdby,createddatetime)
			values 
			('$accinc', '$id', '$accname', '$acclabel', '$accum', '$acctype', '$acccat', '$accval', '$last', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: accountform.php');
	
}
else if(isset($_GET["update"])) {
	 
	$accinc=$_GET["AccInc"];
	$id=$_GET["AccCode"];
	$accname=$_GET["AccName"];
	$acclabel=$_GET["AccLabel"];
	$accum=$_GET["AccUm"];
	$acctype=$_GET["AccType"];
	$acccat=$_GET["AccCat"];
	$accval=$_GET["AccVal"];
	 
	 if($id != ""){
	 $sql = "UPDATE accounts SET
				accountcode = '$id',
				name = '$accname',
				label = '$acclabel',
				um = '$accum',
				accounttype = '$acctype',
				category = '$acccat',
				defaultvalue = '$accval',
				autoinclude = '$accinc',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE accountcode = '$id' AND dataareaid = '$dataareaid'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: accountform.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["AccCode"];

		if($id != ""){
			$sql = "DELETE from accounts where accountcode = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: accountform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["AccCode"];
		$accname=$_GET["AccName"];
		$acclabel=$_GET["AccLabel"];
		$accum=$_GET["AccUm"];
		$acctype=$_GET["AccType"];
		$acccat=$_GET["AccCat"];



		$output='';
		//$output .= '<tbody>';
		$query = "SELECT autoinclude,
					accountcode,
					name,
					label,
					um,
					case when accounttype = 0 then 'Entry'
						when accounttype = 1 then 'Computed'
						when accounttype = 2 then 'Condition'
					else 'Total'
					end as accounttype,
					case when category = 0 then 'Lines'
					else 'Header' 
					end as category,
					formula,
					format(defaultvalue,2) defaultvalue
			FROM accounts where (accountcode like '%$id%') and (name like '%$accname%') 
			and (label like '%$acclabel%') and (um like '%$accum%') and dataareaid = '$dataareaid'
			order by priority asc";
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
			<tr id="'.$row["accountcode"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:5%;"><input type="checkbox" name="chkbox" class="checkbox" value="true"'.($row["autoinclude"]==1 ? "checked" : "").' onclick="return false;"><div style="visibility:hidden;height: 1px;">'.$row["autoinclude"].'</div></td>
				<td style="width:8%;">'.$row["accountcode"].'</td>
				<td style="width:16%;">'.$row["name"].'</td>
				<td style="width:16%;">'.$row["label"].'</td>
				<td style="width:5%;">'.$row["um"].'</td>
				<td style="width:7.5%;">'.$row["accounttype"].'</td>
				<td style="width:7.5%;">'.$row["category"].'</td>
				<td style="width:30%;">'.$row["formula"].'</td>
				<td style="width:5%;">'.$row["defaultvalue"].'</td>
			</tr>';
			$firstresult2 = $row["accountcode"];
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
		$result2 = $conn->query($query);
		$row2 = $result2->fetch_assoc();
		
		echo $output2 = '<tr class="rowA">
							<td hidden><input type="input" id="hide3" value="'.$firstresult2.'"></td>
						</tr>';
	}
}
else if($_GET["action"]=="moveup"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["AccCode"];
		$currec='';
		$prevrec='';
		if($id != ""){
			$query = "SELECT 
					accountcode,
					priority
			FROM accounts where accountcode = '$id' and dataareaid = '$dataareaid'
			order by priority asc";


			$result = $conn->query($query);
			$row = $result->fetch_assoc();
			$currec = $row["priority"];
			//echo $currec;

			$query = "SELECT 
					accountcode,
					priority
			FROM accounts where priority < '$currec' and dataareaid = '$dataareaid'
			order by priority desc
			limit 1";
			//$conn->close();
			//$conn->open();
			$result = $conn->query($query);
			$row = $result->fetch_assoc();
			$prevrec = $row["priority"];
			//echo $prevrec;
			$sql = "UPDATE accounts a
						 inner join accounts b on a.priority <> b.priority
						 and a.dataareaid = b.dataareaid
						 set 
       						a.priority = b.priority
					WHERE a.priority in ('$currec','$prevrec') and b.priority in ('$currec','$prevrec')
					and a.dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				$output='';
				//$output .= '<tbody>';
				$query = "SELECT autoinclude,
								accountcode,
								name,
								label,
								um,
								case when accounttype = 0 then 'Entry'
									when accounttype = 1 then 'Computed'
									when accounttype = 2 then 'Condition'
								else 'Total'
								end as accounttype,
								case when category = 0 then 'Lines'
								else 'Header' 
								end as category,
								formula,
								format(defaultvalue,2) defaultvalue,
								priority
								FROM accounts
								where dataareaid = '$dataareaid'
								order by priority asc";
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
					<tr id="'.$row["accountcode"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'">
						<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
						<td style="width:5%;"><input type="checkbox" name="chkbox" class="checkbox" value="true"'.($row["autoinclude"]==1 ? "checked" : "").' onclick="return false;"><div style="visibility:hidden;height: 1px;">'.$row["autoinclude"].'</div></td>
						<td style="width:8%;">'.$row["accountcode"].'</td>
						<td style="width:16%;">'.$row["name"].'</td>
						<td style="width:16%;">'.$row["label"].'</td>
						<td style="width:5%;">'.$row["um"].'</td>
						<td style="width:7.5%;">'.$row["accounttype"].'</td>
						<td style="width:7.5%;">'.$row["category"].'</td>
						<td style="width:30%;">'.$row["formula"].'</td>
						<td style="width:5%;">'.$row["defaultvalue"].'</td>
					</tr>';
				}
				//$output .= '</tbody>';
				echo $output;
				//echo "Rec Updated";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}


		}
		//header('location: accountform.php');
	
	}
}
else if($_GET["action"]=="movedown"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["AccCode"];
		$currec='';
		$prevrec='';
		if($id != ""){
			$query = "SELECT 
					accountcode,
					priority
			FROM accounts where accountcode = '$id' and dataareaid = '$dataareaid'
			order by priority asc";


			$result = $conn->query($query);
			$row = $result->fetch_assoc();
			$currec = $row["priority"];
			//echo $currec;

			$query = "SELECT 
					accountcode,
					priority
			FROM accounts where priority > '$currec' and dataareaid = '$dataareaid'
			order by priority asc
			limit 1";
			//$conn->close();
			//$conn->open();
			$result = $conn->query($query);
			$row = $result->fetch_assoc();
			$prevrec = $row["priority"];
			//echo $prevrec;
			$sql = "UPDATE accounts a
						 inner join accounts b on a.priority <> b.priority
						 and a.dataareaid = b.dataareaid
						 set 
       						a.priority = b.priority
					WHERE a.priority in ('$currec','$prevrec') and b.priority in ('$currec','$prevrec')
					and a.dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				$output='';
				//$output .= '<tbody>';
				$query = "SELECT autoinclude,
								accountcode,
								name,
								label,
								um,
								case when accounttype = 0 then 'Entry'
									when accounttype = 1 then 'Computed'
									when accounttype = 2 then 'Condition'
								else 'Total'
								end as accounttype,
								case when category = 0 then 'Lines'
								else 'Header' 
								end as category,
								formula,
								format(defaultvalue,2) defaultvalue,
								priority
								FROM accounts
								where dataareaid = '$dataareaid'
								order by priority asc";
				$result = $conn->query($query);
				$rowcnt = 0;
				$rowcnt2 = 0;
				while ($row = $result->fetch_assoc())
				{
					$rowcnt++;
					$rowcnt2++;
						if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
						else { $rowclass = "rowA";}
					$output .= '
					<tr id="'.$row["accountcode"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'">
						<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
						<td style="width:5%;"><input type="checkbox" name="chkbox" class="checkbox" value="true"'.($row["autoinclude"]==1 ? "checked" : "").' onclick="return false;"><div style="visibility:hidden;height: 1px;">'.$row["autoinclude"].'</div></td>
						<td style="width:8%;">'.$row["accountcode"].'</td>
						<td style="width:16%;">'.$row["name"].'</td>
						<td style="width:16%;">'.$row["label"].'</td>
						<td style="width:5%;">'.$row["um"].'</td>
						<td style="width:7.5%;">'.$row["accounttype"].'</td>
						<td style="width:7.5%;">'.$row["category"].'</td>
						<td style="width:30%;">'.$row["formula"].'</td>
						<td style="width:5%;">'.$row["defaultvalue"].'</td>
					</tr>';
				}
				//$output .= '</tbody>';
				echo $output;
				//echo "Rec Updated";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}


		}
		//header('location: accountform.php');
	
	}
}

else if($_GET["action"]=="Formula"){
	 	
	$id=$_GET["accId"];
	$_SESSION['AccID'] = $id;
	$_SESSION['CalcMode'] = 'CalcFormula';
	header('location: accountform.php');
	
}

else if($_GET["action"]=="Condition"){
	 	
	$id=$_GET["accId"];
	$_SESSION['accnt'] = $id;
	unset($_SESSION['AccFocus']);
	header('location: accountform.php');
	
}


else if($_GET["action"]=="UpdateFormula"){
	 	
	$id=$_GET["AccIdCode"];
	$formula=$_GET["AccFormula"];
	

	$sql = "UPDATE accounts SET
				formula = '$formula',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE accountcode = '$id' AND dataareaid = '$dataareaid'";
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
	
	header('location: accountform.php');
	
}
?>

<!-- <script  type="text/javascript">
		var so='';
	  	var inc='';
	  	var HL='';
	  	
	$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			var AcInc = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			inc = AcInc.toString();
			so = usernum.toString();
			document.getElementById("hide").value = so;		
					  
		});
	});
		
  		
		HL = document.getElementById("hide").value;
			/*$(document).ready(function(){
				
				$("#"+HL+"").css("color","red");
				$("#"+HL+"").addClass("info");
				//alert(HL);
				var idx = $("#"+HL+"").attr("tabindex");
		    	alert(idx);	
			if(HL != ''){
				MoveDownFocus();
			}
			
		});*/
		$(document).ready(function() {
			var pos = $("#"+HL+"").attr("tabindex");
		    $("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").css("color","red");
		    $("tr[tabindex="+pos+"]").addClass("info");   
		    //var idx = $("tr:focus").attr("tabindex");
		    //alert(idx);
		    //document.onkeydown = checkKey;
		});

		function MoveDownFocus()
		{
			/*var row_index = $('td').parent().index();
		   var col_index = $('td').index();
		   $('td').closest('tr').next().find('td:eq(' + row_index + ')').focus();  
		   alert(row_index.toString()); */
		   //alert(HL);
		   
		   //$("#SAMP").css("color","red");
			//$("#SAMP").addClass("info");
			document.getElementById(HL).scrollIntoView();

		}

</script> -->