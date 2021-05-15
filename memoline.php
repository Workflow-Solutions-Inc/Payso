<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];


if($_POST["action"]=="getline"){
	if($_POST["actmode"]=="userform"){

		$id = $_POST["userId"];
		//$_SESSION['orgnum'] = $id;

		/*$id=$_GET["sLocId"];
		$name=$_GET["slocName"];
		$postion=$_GET["slocPosition"];
		$department=$_GET["sLocDepartment"];
		$branch=$_GET["slocbranch"];*/

		$output='';
		//$output .= '<tbody>';
		$query = "SELECT wk.workerid,wk.Name,pos.name as 'position',dep.name as 'department',md.status	as 'status'
					FROM worker wk
					left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
					left join contract con on con.workerid = wk.workerid and con.dataareaid = wk.dataareaid
					left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid
					left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
                    left join memodetail md on wk.workerid = md.workerid and wk.dataareaid = md.dataareaid

					where wk.dataareaid = '$dataareaid' and md.memoid = '$id'
					order by wk.workerid";
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
			<tr class="'.$rowclass.'">
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:19%;">'.$row["workerid"].'</td>
				<td style="width:19%;">'.$row["Name"].'</td>
				<td style="width:19%;">'.$row["position"].'</td>
				<td style="width:19%;">'.$row["department"].'</td>
				<td style="width:19%;">'.$row["status"].'</td>
				</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
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
		var locworker='';
  		
		$(document).ready(function(){
			$('#dataln tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","orange");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var orgnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
				
				locworker = orgnumline.toString();
				document.getElementById("hide2").value = locworker;
				//alert(document.getElementById("hide").value);
					
				flaglocation = false;
		        $("#myUpdateBtn").prop("disabled", true);
		        //alert(flaglocation);		
				//flaglocation = false;
				//alert(payline);
				loc = document.getElementById("hide").value;
	            //$("#myUpdateBtn").prop("disabled", false);
	             var pos = $("#"+loc+"").attr("tabindex");
				    $("tr[tabindex="+pos+"]").focus();
				    $("tr[tabindex="+pos+"]").css("color","red");
				    $("tr[tabindex="+pos+"]").addClass("info");
				//document.getElementById("myUpdateBtn").style.disabled = disabled;
					  
			});
		});
</script>