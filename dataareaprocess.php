<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $id=$_GET["DataId"];
	 $name=$_GET["name"];
	 $address=$_GET["DataAddress"];
	 $tin=$_GET["tin"];
	 
	 if($id != ""){
	 $sql = "INSERT INTO dataarea (dataareaid,name,address,companytin,createdby,createddatetime)
			values 
			('$id', '$name', '$address', '$tin', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: dataarea.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $id=$_GET["DataId"];
	 $name=$_GET["name"];
	 $address=$_GET["DataAddress"];
	 $tin=$_GET["tin"];
	 
	 if($id != ""){
	 $sql = "UPDATE dataarea SET
				dataareaid = '$id',
				name = '$name',
				address = '$address',
				companytin = '$tin',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE dataareaid = '$id'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: dataarea.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["DataId"];

		if($id != ""){
			$sql = "DELETE from dataarea where dataareaid = '$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: dataarea.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["DataId"];
		$name=$_GET["name"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM dataarea where (dataareaid like '%$id%') and (name like '%$name%') ";
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
			<tr id="'.$row["dataareaid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:25%;">'.$row["dataareaid"].'</td>
				<td style="width:25%;">'.$row["name"].'</td>
				<td style="width:25%;">'.$row["address"].'</td>
				<td style="width:25%;">'.$row["companytin"].'</td>
			</tr>';
		
			//echo $row["dataareaid"];
			
		}

		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}

//code added by jonald

else if($_GET["action"]=="getlogo"){
	$id = $_GET["so"];
	$query = "SELECT * FROM dataarea where dataareaid = '$id' ";
	$output1 = "";
	$output2 = "";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{ 
			$output1 = $row["dataarealogo"];
			$output2 = $row["name"];
		}
		//$output .= '</tbody>';
		
		echo $output1."|".$output2;
}
//end of code
?>
