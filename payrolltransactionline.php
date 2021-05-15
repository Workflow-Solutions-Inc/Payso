<?php
session_start();
session_regenerate_id();
include("dbconn.php");

$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if($_POST["action"]=="getline"){
	if($_POST["actmode"]=="userform"){
		$id=$_POST["PayId"];

		$output='';
		$output .= '<tbody>';
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
		$rowclass = "rowA";
		$rowcnt = 0;
		while ($row = $result->fetch_assoc())
		{
			$rowcnt++;
				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
				else { $rowclass = "rowA";}
			$output .= '
			<tr class="'.$rowclass.'">
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:20%;">'.$row["accountcode"].'</td>
				<td style="width:20%;">'.$row["accountname"].'</td>
				<td style="width:20%;">'.$row["um"].'</td>
				<td style="width:20%;">'.$row["accounttype"].'</td>
				<td style="width:20%;">'.$row["value"].'</td>
			</tr>';
		}

		
		echo $output;
		//$output .= '</tbody>';
		//echo $output;

		$qNet = "CALL SP_CheckNetPay ('$id','$dataareaid')";

		$rNet = $conn->query($qNet);

		$collection = '';

		
		while ($rowNet = $rNet->fetch_assoc())
		{
			$collection = $collection.','.$rowNet['name'];
		}


		echo $output2 = '<tr class="rowA">
							<td style="display:none;width:1%;"><input type="input" id="hide0net" value="'.substr($collection,1).'"></td>
						</tr>';
		$conn->close();
		include("dbconn.php");
		//header('location: process.php');
	}
}

if($_POST["action"]=="clearline"){
	if($_POST["actmode"]=="userform"){

		$output='';
		$output .= '
			<tr class="rowA">
				<td><span class="fa fa-adjust"></span></td>
				<td>'.'</td>
				<td>'.'</td>
				<td>'.'</td>
				<td>'.'</td>
				<td>'.'</td>
			</tr>';
		echo $output;
	}
}

?>

<script  type="text/javascript">
		/*var so='';
	  	
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'GET',
					url: 'payrolltransactionprocess.php',
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
		});*/
		var payline='';
  		$(document).ready(function(){
			$('#dataln tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","orange");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
				payline = transnumline.toString();
				document.getElementById("hide2").value = payline;
				//alert(document.getElementById("hide").value);
					
					  
			});
		});
</script>