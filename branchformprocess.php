<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $id=$_GET["BranchId"];
	 $name=$_GET["name"];
	 
	 if($id != ""){
	 $sql = "INSERT INTO branch (branchcode,name,dataareaid,createdby,createddatetime)
			values 
			('$id', '$name', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: branchform.php');
	
}
else if(isset($_GET["update"])) {

	 $id=$_GET["BranchId"];
	 $name=$_GET["name"];
	 
	 if($id != ""){
	 $sql = "UPDATE branch SET
				branchcode = '$id',
				name = '$name',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE branchcode = '$id'
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
	 
	header('location: branchform.php');
	
}
else if(isset($_POST["saveUpload"])){
 
 		$cnt=0;
 		//echo "asd";
		//echo $filename=$_FILES["myfile"]["tmp_name"];
 		$filename=$_FILES["myfile"]["tmp_name"];
 
		 if($_FILES["myfile"]["size"] > 0)
		 {
 
		  	$file = fopen($filename, "r");
	         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {
 				$cnt++;
 				echo $cnt;
	          //It wiil insert a row to our subject table from our csv file`
	         	$sql = "INSERT INTO branch (branchcode,name,dataareaid,createdby,createddatetime)
						values 
						('$emapData[0]','$emapData[1]','$emapData[2]', '$userlogin', now())";
	         //we are using mysql_query function. it returns a resource on true else False on error
	          $result = mysqli_query( $conn, $sql );
				if(! $result )
				{
					//echo $result;

					/*echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"branchform.php\"
						</script>";*/
 
				}
 
	         }
	         fclose($file);
	         //throws a message if data successfully imported to mysql database from excel file
	        /* echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"branchform.php\"
					</script>";*/
 
 
 
			 //close of connection
			mysqli_close($conn); 
 
 
 
		 }
		 //header('location: branchform.php');
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["BranchId"];

		if($id != ""){
			$sql = "DELETE from branch where branchcode = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: branchform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["BranchId"];
		$name=$_GET["name"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM branch where dataareaid = '$dataareaid' and (branchcode like '%$id%') and (name like '%$name%')";
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
			<tr id="'.$row["branchcode"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:50%;">'.$row["branchcode"].'</td>
				<td style="width:50%;">'.$row["name"].'</td>
			</tr>';
			//echo $row["name"];
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}


?>
<!-- <script src="js/ajax.js"></script>
<script  type="text/javascript">
		var locname='';
	  	var so='';
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			so = usernum.toString();
			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);	
						  
				});
			});
</script> -->