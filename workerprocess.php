<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if(isset($_GET["save"])) {
	 
	$id=$_GET["Wid"];
	$lname=$_GET["Lname"];
	$fname=$_GET["Fname"];
	$mname=$_GET["Mname"];
	$fullname = $lname.' '.$fname.' '.$mname[0];
	$address=$_GET["Address"];
	$contact=$_GET["Contact"];
	$bday=$_GET["Bday"];
	if($bday == ""){
		$bday = '1900-01-01';
	}
	$regdate=$_GET["Regdate"];
	if($regdate == ""){
		$regdate = '1900-01-01';
	}
	$bankacc=$_GET["BankAcc"];
	$SSS=$_GET["SSS"];
	$philnum=$_GET["Philnum"];
	$pibig=$_GET["Pibig"];
	$tin=$_GET["Tin"];
	$branch=$_GET["Branch"];
	$position=$_GET["Position"];
	$datehired=$_GET["Hiredate"];
	if($datehired == ""){
		$datehired = '1900-01-01';
	}
	$empstatus=$_GET["Empstatus"];
	$internalid=$_GET["InternalID"];
	$bioid=$_GET["BioId"];
	$dec = $_GET["dec"];
	$payrollgroup = $_GET["PayGroup"];

	 
	 if($id != ""){
	 $sql = "INSERT INTO worker
	  			(workerid,name,lastname,firstname,middlename,address,contactnum,birthdate,regularizationdate,bankaccountnum,sssnum,phnum,pagibignum,tinnum,branch,position,datehired,employmentstatus,serviceincentiveleave,birthdayleave,inactive,inactivedate,BioId,internalId,activeonetimeded,payrollgroup,dataareaid,createdby,createddatetime)
			values 
			('$id','$fullname','$lname','$fname','$mname','$address','$contact',STR_TO_DATE('$bday','%Y-%m-%d'),STR_TO_DATE('$regdate','%Y-%m-%d'),'$bankacc','$SSS','$philnum','$pibig','$tin','$branch','$position',STR_TO_DATE('$datehired','%Y-%m-%d'),'$empstatus','0','1','0',STR_TO_DATE('1900-01-01', '%Y-%m-%d'),'$bioid','$internalid', '$dec', '$payrollgroup', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	header('location: workerform.php');
	
}

else if(isset($_GET["update"])) {
	 
	$id=$_GET["Wid"];
	$lname=$_GET["Lname"];
	$fname=$_GET["Fname"];
	$mname=$_GET["Mname"];
	$fullname = $lname.' '.$fname.' '.$mname[0];
	$address=$_GET["Address"];
	$contact=$_GET["Contact"];
	$bday=$_GET["Bday"];
	$regdate=$_GET["Regdate"];
	$bankacc=$_GET["BankAcc"];
	$SSS=$_GET["SSS"];
	$philnum=$_GET["Philnum"];
	$pibig=$_GET["Pibig"];
	$tin=$_GET["Tin"];
	$branch=$_GET["Branch"];
	$position=$_GET["Position"];
	$datehired=$_GET["Hiredate"];
	$empstatus=$_GET["Empstatus"];
	$inactive=$_GET["AccInc"];
	$inactivedate=$_GET["Incdate"];
	$internalid=$_GET["InternalID"];
	$bioid=$_GET["BioId"];
	$dec = $_GET["dec"];
	$payrollgroup = $_GET["PayGroup"];
	 
	 if($id != ""){
	 $sql = "UPDATE worker
				SET
				BioId = '$bioid',
				internalId = '$internalid',
				name = '$fullname',
				lastname = '$lname',
				firstname = '$fname',
				middlename = '$mname',
				address = '$address',
				contactnum = '$contact',
				sssnum = '$SSS',
				phnum = '$philnum',
				pagibignum = '$pibig',
				tinnum = '$tin',
				bankaccountnum = '$bankacc',
				branch = '$branch',
				position = '$position',
				datehired = STR_TO_DATE('$datehired','%Y-%m-%d'),
				employmentstatus = '$empstatus',
				birthdate = STR_TO_DATE('$bday','%Y-%m-%d'),
				inactive = '$inactive',
				inactivedate = STR_TO_DATE('$inactivedate','%Y-%m-%d'),
				regularizationdate = STR_TO_DATE('$regdate','%Y-%m-%d'),
				activeonetimeded = '$dec',
				payrollgroup = '$payrollgroup',
				dataareaid = '$dataareaid',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE workerid = '$id'
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
	 
	header('location: workerform.php');

}

else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){

		$id=$_GET["WorkerId"];
		$name=$_GET["name"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT wk.workerid,wk.Name,pos.name as 'position',format(wk.serviceincentiveleave,2) as serviceincentiveleave,
						format(wk.birthdayleave,2) as birthdayleave,wk.birdeclared,
						lastname,firstname,middlename,
						STR_TO_DATE(birthdate, '%Y-%m-%d') birthdate,
						STR_TO_DATE(regularizationdate, '%Y-%m-%d') regularizationdate,
						STR_TO_DATE(inactivedate, '%Y-%m-%d') inactivedate,
						bankaccountnum,address,contactnum
						,STR_TO_DATE(datehired, '%Y-%m-%d') as datehired,phnum,pagibignum,tinnum,sssnum
						,case when wk.employmentstatus = 0 then 'Normal' 
						when wk.employmentstatus = 1 then 'New'
						when wk.employmentstatus = 2 then 'Separated'
						else '' end as employmentstatus
						,wk.employmentstatus as employmentstatusid
						,wk.inactive
						,wk.position as posid
						,wk.branch
						,wk.BioId
						,wk.internalId
						,wk.activeonetimeded
						,bra.name as branchname
						,wk.payrollgroup

						FROM worker wk
						left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
						left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
						where wk.workerid like '%$id%' and wk.name like '%$name%' and  wk.dataareaid = '$dataareaid'";
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
				<td style="width:19%;">'.$row["workerid"].'</td>
				<td style="width:19%;">'.$row["Name"].'</td>
				<td style="width:19%;">'.$row["position"].'</td>
				<td style="width:19%;">'.$row["branchname"].'</td>
				<td style="display:none;width:1%;">'.$row["birthdayleave"].'</td>
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
				<td style="display:none;width:1%;">'.$row['posid'].'</td>
				<td style="display:none;width:1%;">'.$row['employmentstatusid'].'</td>
				<td style="display:none;width:1%;">'.$row['branch'].'</td>
				<td style="display:none;width:1%;">'.$row['BioId'].'</td>
				<td style="display:none;width:1%;">'.$row['internalId'].'</td>
				<td style="display:none;width:1%;">'.$row['activeonetimeded'].'</td>
				<td style="display:none;width:1%;">'.$row['payrollgroup'].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}

else if($_GET["action"]=="contract"){
	 	
	$id=$_GET["ConId"];
	$_SESSION['ConNum'] = $id;
	header('location: workerform.php');
	
}

else if($_GET["action"]=="loan"){
	 	
	$id=$_GET["workID"];
	$_SESSION['WKNumLoan'] = $id;
	header('location: workerform.php');
	
}

else if($_GET["action"]=="leave"){
	 	
	$id=$_GET["workID"];
	$_SESSION['WKNumLeave'] = $id;
	header('location: workerform.php');
	
}

else if($_GET["action"]=="upload"){
	 	
	$id=$_GET["workID"];
	$_SESSION['WKNumUpload'] = $id;
	header('location: workerform.php');
	
}

else if($_GET["action"]=="enroll"){
	 	
	$id=$_GET["workID"];


	$sqlinsert = "call SP_EnrollToPortal('$dataareaid','$id','$userlogin')";
			//mysqli_query($conn,$sqlinsert);
			//echo $sqlinsert."<br>".$conn->error;
			if(mysqli_query($conn,$sqlinsert))
			{
				echo $sqlinsert."<br>".$conn->error;
			}
			else
			{
				echo "error".$sqlinsert."<br>".$conn->error;
			}

	//header('location: workerform.php');
	
}

else if($_GET["action"]=="add"){
	 $output='';
	 $sequence='';
	 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='worker'";
	 $result = $conn->query($query);
	 $row = $result->fetch_assoc();
	 $prefix = $row["prefix"];
	 $first = $row["first"];
	 $last = $row["last"];
	 $format = $row["format"];
	 $next = $row["next"];
	 $suffix = $row["suffix"];
	 if($last >= $next)
	 {
	 	$sequence = $prefix.substr($format,0,strlen($next)*-1).$next.$suffix;
	 }
	 else if ($last < $next)
	 {
	 	$sequence = $prefix.$next.$suffix;
	 }
	 $increment=$next+1;
	 $sql = "UPDATE numbersequence SET
				next = '$increment',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE id = 'worker'
				and dataareaid = '$dataareaid'";
	 //mysqli_query($conn,$sql);	
		if(mysqli_query($conn,$sql))
		{
			$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Worker Id" name ="Wid" id="add-wid"  class="textbox text-center width-full" required="required">
				 ';
		}
		else
		{
			$output .= "error".$sql."<br>".$conn->error;
		}
	 
	 /*$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Worker Id" name ="Wid" id="add-wid"  class="textbox text-center width-full" required="required">
				 ';*/
	 echo $output;
	
}
else if($_GET["action"]=="memo"){
	 	
	$id = $_GET["workID"];
	$_SESSION['WKNumMemo'] = $id;
	header('location: workerform.php');
	
}




?>

<!-- <script  type="text/javascript">
		var so='';
	  	var mname;
	  	var lname;
	  	var fname;
	  	var bdate;
	  	var indate;
	  	var inc;
	  	var regdate;
	  	var bankacc;
	  	var addr;
	  	var cont;
	  	var position;
	  	var hiredate;
	  	var empstatus;
	  	var phnum;
	  	var pibignum;
	  	var tinnum;
	  	var sssnum;
	  	var posid;
	  	var empstatusid;
	  	var branch;
	  	var ck;
	  	var internalid;
	  	var bioid;
	  	var dec;
	  	var locbranch;
	  	var locpaygroup;
	  	var locpaygroupVal;

		
</script> -->