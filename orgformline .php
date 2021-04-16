<?php
session_id("payso");
session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];


if($_POST["action"]=="getline"){
	if($_POST["actmode"]=="userform"){
		$id=$_POST["userId"];
		$_SESSION['orgnum'] = $id;

		/*$id=$_GET["sLocId"];
		$name=$_GET["slocName"];
		$postion=$_GET["slocPosition"];
		$department=$_GET["sLocDepartment"];
		$branch=$_GET["slocbranch"];*/

		$output='';
		//$output .= '<tbody>';
		$query = "SELECT distinct wk.workerid,wk.Name,pos.name as 'position',dep.name as 'department',bra.name	as 'branch',
																format(wk.serviceincentiveleave,2) as serviceincentiveleave,
																format(wk.birthdayleave,2) as birthdayleave,wk.birdeclared,
																lastname,firstname,middlename,STR_TO_DATE(birthdate, '%Y-%m-%d') birthdate,STR_TO_DATE(regularizationdate, '%Y-%m-%d') regularizationdate,STR_TO_DATE(inactivedate, '%Y-%m-%d') inactivedate,bankaccountnum,address,contactnum
																,STR_TO_DATE(datehired, '%Y-%m-%d') as datehired,phnum,pagibignum,tinnum,sssnum
																,case when wk.employmentstatus = 0 then 'Regular' 
																when wk.employmentstatus = 1 then 'Reliever'
																when wk.employmentstatus = 2 then 'Probationary'
																when wk.employmentstatus = 3 then 'Contractual' 
																when wk.employmentstatus = 4 then 'Trainee' else '' end as employmentstatus
																,wk.employmentstatus as employmentstatusid
																,wk.inactive
																,wk.bioid
																,DATE_SUB(curdate(), INTERVAL 50 DAY) getfromdate
																,DATE_ADD(curdate(), INTERVAL 50 DAY) gettodate

					FROM worker wk
					left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
					left join contract con on con.workerid = wk.workerid and con.dataareaid = wk.dataareaid
					left join ratehistory rt on con.contractid = rt.contractid and con.dataareaid = rt.dataareaid 
					left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid
					left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
					left join organizationalchart org on org.workerid = wk.workerid and org.dataareaid = wk.dataareaid

					 where rt.status = 1 
					 and wk.dataareaid = '$dataareaid' and org.repotingid = '$id'


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
				<td style="width:19%;">'.$row["branch"].'</td>
				<td style="display:none;width:1%;"><input type="checkbox" name="chkbox" class="checkbox" value="true"'.($row["birdeclared"]==1 ? "checked" : "").' onclick="return false;"><div style="visibility:hidden;height: 1px;">'.$row["birdeclared"].'</div></td>
				<td style="display:none;width:1%;">'.$row['firstname'].'</td>
				<td style="display:none;width:1%;">'.$row['middlename'].'</td>
				<td style="display:none;width:1%;">'.$row['lastname'].'</td>
				<td style="display:none;width:1%;">'.$row['birthdate'].'</td>
				<td style="display:none;width:1%;">'.$row['inactivedate'].'</td>
				<td style="display:none;width:1%;">'.$row['regularizationdate'].'</td>
				<td style="display:none;width:1%;">'.$row['bankaccountnum'].'</td>
				<td style="display:none;width:1%;">'.$row['address'].'</td>
				<td style="display:none;width:1%;">'.$row['contactnum'].'</td>
				<td style="display:none;width:1%;">'.$row['datehired'].'</td>
				<td style="display:none;width:1%;">'.$row['phnum'].'</td>
				<td style="display:none;width:1%;">'.$row['pagibignum'].'</td>
				<td style="display:none;width:1%;">'.$row['tinnum'].'</td>
				<td style="display:none;width:1%;">'.$row['sssnum'].'</td>
				<td style="display:none;width:1%;">'.$row['employmentstatus'].'</td>
				<td style="display:none;width:1%;">'.$row['inactive'].'</td>
				<td style="display:none;width:1%;">'.$row['bioid'].'</td>
				<td style="display:none;width:1%;">'.$row['getfromdate'].'</td>
				<td style="display:none;width:1%;">'.$row['gettodate'].'</td>
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

<!-- <script  type="text/javascript">
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
</script> -->