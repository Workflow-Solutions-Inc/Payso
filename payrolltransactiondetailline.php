<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$paynum = $_SESSION['paynum'];

if(isset($_SESSION['paylinenum'])) {
	$line = $_SESSION['paylinenum'];
	$_SESSION['linefocus'] = $line;
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
					FROM payrolldetailsaccounts
					where payrollid = '$paynum'
					and reflinenum = '$line'
					and dataareaid = '$dataareaid'
					order by priority";

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
		//$output .= '</tbody>';
		//echo $output;
		unset($_SESSION['paylinenum']);
		//header('location: process.php');

}
else
{
	if($_POST["action"]=="getline"){
		if($_POST["actmode"]=="userform"){
			$id=$_POST["PayId"];
			$_SESSION['linefocus'] = $id;
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
						FROM payrolldetailsaccounts
						where payrollid = '$paynum'
						and reflinenum = '$id'
						and dataareaid = '$dataareaid'
						order by priority";

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
			//$output .= '</tbody>';
			echo $output;
			//$_SESSION['linefocus'] = $id;
			//header('location: process.php');
		}
	}

	else if($_POST["action"]=="clearline"){
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
		var locValue='';
		var locType='';
		$(document).ready(function(){
				$('#dataln tbody tr').click(function(){
					$('table tbody tr').css("color","black");
					$(this).css("color","orange");
					$('table tbody tr').removeClass("info");
					$(this).addClass("info");
					var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
					locValue = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(5)").text();
					locType = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(4)").text();
					payline = transnumline.toString();
					document.getElementById("hide2").value = payline;
					//alert(document.getElementById("hide").value);
						
					//document.getElementById("myUpdateBtn").style.disabled = disabled;
					flaglocation = false;
					//alert(flaglocation);
					var foc = document.getElementById("hidefocus").value;

		            $("#myUpdateBtn").prop("disabled", false);
		            var pos = $("#"+foc+"").attr("tabindex");
					    //$("tr[tabindex="+pos+"]").focus();
					    $("tr[tabindex="+pos+"]").css("color","red");
					    $("tr[tabindex="+pos+"]").addClass("info");
					    //alert(1);
				});
			});
</script>