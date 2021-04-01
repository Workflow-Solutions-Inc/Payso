<?php

session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if($_POST["action"]=="getline"){
	if($_POST["actmode"]=="userform"){
		$id=$_POST["PayId"];

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
				var payline = transnumline.toString();
				document.getElementById("hide2").value = payline;
				//alert(document.getElementById("hide").value);
					
					  
			});
		});
</script>