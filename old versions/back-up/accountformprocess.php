<?php

session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if($_GET["action"]=="save"){
	 
	if($_GET["actmode"]=="userform"){
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
	
}
if($_GET["action"]=="update"){
	 
	if($_GET["actmode"]=="userform"){
		 $id=$_GET["NumId"];
		 $prefix=$_GET["NumPrefix"];
		 $first=$_GET["NumFirst"];
		 $last=$_GET["NumLast"];
		 $format=$_GET["NumFormat"];
		 $next=$_GET["NumNext"];
		 $suffix=$_GET["NumSuffix"];
		 
		 if($id != ""){
		 $sql = "UPDATE numbersequence SET
					id = '$id',
					prefix = '$prefix',
					first = '$first',
					last = '$last',
					format = '$format',
					next = '$next',
					suffix = '$suffix',
					modifiedby = '$userlogin',
					modifieddatetime = now()
					WHERE id = '$id'
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
		 
		header('location: accountform.php');
	}
	
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
		while ($row = $result->fetch_assoc())
		{
			$output .= '
			<tr class="rowA">
				<td><span class="fa fa-adjust"></span></td>
				<td><input type="checkbox" name="chkbox" style="width:100%;height: 20px;"  value="true"'.($row["autoinclude"]==1 ? "checked" : "").' onclick="return false;"><div style="visibility:hidden;height: 1px;">'.$row["autoinclude"].'</div></td>
				<td>'.$row["accountcode"].'</td>
				<td>'.$row["name"].'</td>
				<td>'.$row["label"].'</td>
				<td>'.$row["um"].'</td>
				<td>'.$row["accounttype"].'</td>
				<td>'.$row["category"].'</td>
				<td>'.$row["formula"].'</td>
				<td>'.$row["defaultvalue"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
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
				while ($row = $result->fetch_assoc())
				{
					$output .= '
					<tr id="'.$row["accountcode"].'" class="rowA">
						<td><span class="fa fa-adjust"></span></td>
						<td><input type="checkbox" name="chkbox" style="width:100%;height: 20px;"  value="true"'.($row["autoinclude"]==1 ? "checked" : "").' onclick="return false;"><div style="visibility:hidden;height: 1px;">'.$row["autoinclude"].'</div></td>
						<td>'.$row["accountcode"].'</td>
						<td>'.$row["name"].'</td>
						<td>'.$row["label"].'</td>
						<td>'.$row["um"].'</td>
						<td>'.$row["accounttype"].'</td>
						<td>'.$row["category"].'</td>
						<td>'.$row["formula"].'</td>
						<td>'.$row["defaultvalue"].'</td>
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
				while ($row = $result->fetch_assoc())
				{
					$output .= '
					<tr id="'.$row["accountcode"].'" class="rowA">
						<td><span class="fa fa-adjust"></span></td>
						<td><input type="checkbox" name="chkbox" style="width:100%;height: 20px;"  value="true"'.($row["autoinclude"]==1 ? "checked" : "").' onclick="return false;"><div style="visibility:hidden;height: 1px;">'.$row["autoinclude"].'</div></td>
						<td>'.$row["accountcode"].'</td>
						<td>'.$row["name"].'</td>
						<td>'.$row["label"].'</td>
						<td>'.$row["um"].'</td>
						<td>'.$row["accounttype"].'</td>
						<td>'.$row["category"].'</td>
						<td>'.$row["formula"].'</td>
						<td>'.$row["defaultvalue"].'</td>
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
?>

<script  type="text/javascript">
		var so='';
	  	var inc='';
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
		var HL = document.getElementById("hide").value;
			$(document).ready(function(){
			$("#"+HL+"").css("color","red");
			$("#"+HL+"").addClass("info");
			//alert(document.getElementById("hide").value);
		});

</script>