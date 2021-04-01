<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $uno=$_GET["userno"];
	 $upass=$_GET["pass"];
	 $ul=$_GET["lname"];
	 $dtarea=$_GET["darea"];
	 
	 if($uno != ""){
	 $sql = "INSERT INTO userfile (userid,name,defaultdataareaid,password,createdby,createddatetime)
			values 
			('$uno', '$ul', '$dtarea', aes_encrypt('$upass','password'), '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
header('location: orgform.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $uno=$_GET["userno"];
	 $upass=$_GET["pass"];
	 $ul=$_GET["lname"];
	 $dtarea=$_GET["darea"];
	 
	 if($uno != ""){
	 $sql = "UPDATE userfile SET
				userid = '$uno',
				name = '$ul',
				defaultdataareaid = '$dtarea',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE userid = '$uno'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	
	header('location: orgform.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$uno=$_GET["userno"];

		if($uno != ""){
			$sql = "DELETE from userfile where userid = '$uno'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: orgform.php');
	
	}
	if($_GET["actmode"]=="subline"){	
		$sublineid=$_GET["locworker"];
		$subheadid=$_GET["userno"];

		if($sublineid != ""){
			$sql = "DELETE from organizationalchart where workerid = '$sublineid' and repotingid = '$subheadid' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: orgform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["sLocId"];
		$name=$_GET["slocName"];
		$postion=$_GET["slocPosition"];
		$department=$_GET["sLocDepartment"];
		$branch=$_GET["slocbranch"];

		$output='';
		//$output .= '<tbody>';
		$query = "SELECT distinct wk.workerid,wk.Name,pos.name as 'position',dep.name as 'department',bra.name	as 'branch'

																FROM worker wk
																left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
																left join contract con on con.workerid = wk.workerid and con.dataareaid = wk.dataareaid
																left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid
																left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
					

					 where (wk.workerid like '%$id%') and (wk.name like '%$name%') and (pos.name like '%$postion%') #and (dep.name like '%$department%') and (bra.name like '%$branch%') #and rt.status = 1 
					 and wk.dataareaid = '$dataareaid'


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
			<tr id="'.$row["workerid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:20%;">'.$row["workerid"].'</td>
				<td style="width:20%;">'.$row["Name"].'</td>
				<td style="width:20%;">'.$row["position"].'</td>
				<td style="width:20%;">'.$row["department"].'</td>
				<td style="width:20%;">'.$row["branch"].'</td>
				</tr>';
		}
		//$output .= '</tbody>';
		echo $output;

		$result2 = $conn->query($query);
		$row2 = $result2->fetch_assoc();
		//$fdate = $row2["getfromdate"];
		//$tdate = $row2["gettodate"];
		$wkid = $row2["workerid"];
		//$bid = $row2["bioid"];
		echo $output2 = '<tr class="rowA">
							<td hidden><input type="input" id="hide3" value="'.$wkid.'"></td>
							
						</tr>';
		//header('location: process.php');
	}
}
else if($_GET["action"]=="sublist"){
	 	
	$id=$_GET["UsrId"];
	$_SESSION['HeadId'] = $id;
	//unset($_SESSION['paynum']);
	header('location: orgform.php');
	
}
else if($_GET["action"]=="unload"){
	 	
	unset($_SESSION['orgnum']);
	//unset($_SESSION['paynum']);
	header('location: orgform.php');
	
}
?>

<!-- <script  type="text/javascript">
		var so='';
		var locUPass = '';
		var locNM = '';
		var locDT = '';
		var usernum = '';
		if(usernum == '')
		{
			so = document.getElementById("hide").value;
		}
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locNM = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locDT = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locUPass = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				//locIndex = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//document.getElementById("hidefocus").value = locIndex.toString();
				//alert(document.getElementById("hide").value);
				//alert(so);

				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'userformline.php',
					data:{action:action, actmode:actionmode, userId:so},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						document.getElementById("hide2").value = "";
						$('#lineresult').html(data);
					}
				}); 
				//-----------get line--------------//
				flaglocation = true;
				//alert(flaglocation);
		        $("#myUpdateBtn").prop("disabled", false);	
					  
			});
		});

</script> -->