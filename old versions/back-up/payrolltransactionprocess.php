<?php

session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if($_GET["action"]=="save"){
	 
	if($_GET["actmode"]=="userform"){
		 $id=$_GET["NumId"];
		 $prefix=$_GET["NumPrefix"];
		 $first=$_GET["NumFirst"];
		 $last=$_GET["NumLast"];
		 $format=$_GET["NumFormat"];
		 $next=$_GET["NumNext"];
		 $suffix=$_GET["NumSuffix"];
		 
		 if($id != ""){
		 $sql = "INSERT INTO numbersequence (id,prefix,first,last,format,next,suffix,dataareaid,createdby,createddatetime)
				values 
				('$id', '$prefix', '$first', '$last', '$format', '$next', '$suffix', '$dataareaid', '$userlogin', now())";
			if(mysqli_query($conn,$sql))
			{
				echo "New Rec Created";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		 }
		 
		header('location: numbersequence.php');
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
		 
		header('location: numbersequence.php');
	}
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["NumId"];

		if($id != ""){
			$sql = "DELETE from numbersequence where id = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: numbersequence.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$branch=$_GET["PTBranch"];
		$id=$_GET["PTId"];
		$period=$_GET["PTPeriod"];
		$fromdate=$_GET["PTFromDt"];
		$todate=$_GET["PTToDt"];
		$firstresult ='';
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT bh.name as branch,  
						case              
							when paymenttype = 0 then 'Cash' 
							when paymenttype = 1 then 'ATM' 
						else '' end as 'Payment',
						ph.payrollid, 
						ph.payrollperiod,
						fromdate, 
						todate,
						case when payrollstatus = 0 then 'Created' 
							when payrollstatus = 1 then 'Submitted' 
							when payrollstatus = 2 then 'Canceled' 
							when payrollstatus = 3 then 'Approved' 
							when payrollstatus = 4 then 'Disapproved' 
						else '' end as 'status'

						from payrollheader ph 
						left join branch bh on ph.branchcode = bh.branchcode and ph.dataareaid = bh.dataareaid
						 where (bh.name like '%$branch%') and (ph.payrollid like '%$id%') and (ph.payrollperiod like '%$period%') 
						 and (fromdate like '%$fromdate%') and (todate like '%$todate%') 
						 and ph.dataareaid = '$dataareaid'";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$output .= '
			<tr class="rowA">
				<td><span class="fa fa-adjust"></span></td>
				<td>'.$row["branch"].'</td>
				<td>'.$row["Payment"].'</td>
				<td>'.$row["payrollid"].'</td>
				<td>'.$row["payrollperiod"].'</td>
				<td>'.$row["fromdate"].'</td>
				<td>'.$row["todate"].'</td>
				<td>'.$row["status"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		$result2 = $conn->query($query);
		$row2 = $result2->fetch_assoc();
		$firstresult = $row2["payrollid"];
		echo $output2 = '<tr class="rowA">
							<td hidden><input type="input" id="hide3" value="'.$firstresult.'"></td>
						</tr>';
		//header('location: process.php');
	}
}

/*else if($_GET["action"]=="getline"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["PayId"];

		$output='';
		//$output .= '<tbody>';
		$query = "SELECT accountcode,
					accountname,
					um,
					case when accounttype = 0 then 'Entry'
					when accounttype = 1 then 'Computed'
					when accounttype = 2 then 'Condition'
					else 'Total'
					end as accounttype,
					format(value,2) value
					FROM payrollheaderaccounts
					where payrollid = '$id'
					and dataareaid = '$dataareaid'
					order by um";

		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$output .= '
			<tr class="rowA">
				<td><span class="fa fa-adjust"></span></td>
				<td>'.$row["accountcode"].'</td>
				<td>'.$row["accountname"].'</td>
				<td>'.$row["um"].'</td>
				<td>'.$row["accounttype"].'</td>
				<td>'.$row["value"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}*/

?>

<script  type="text/javascript">
		var so='';
	  	var payline='';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide3").value);
				//alert(document.getElementById("hide").value);
				//alert(so);
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'payrolltransactionline.php',
					data:{action:action, actmode:actionmode, PayId:so},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						payline='';
						document.getElementById("hide2").value = "";
						$('#lineresult').html(data);
					}
				}); 	
				//-----------get line--------------//	  
			});
		});

	  		/*$(document).ready(function(){
				$('#dataln tbody tr').click(function(){
					$('table tbody tr').css("color","black");
					$(this).css("color","orange");
					$('table tbody tr').removeClass("info");
					$(this).addClass("info");
					var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
					var payline = transnumline.toString();
					document.getElementById("hide2").value = payline;
					//alert(document.getElementById("hide").value);
						
						  
				});
			});*/
</script>