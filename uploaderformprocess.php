<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_POST["save"])) {
	 //echo $_POST["myupfile"];
	 $id=$_POST["workid"];
	 //$name=$_POST["myupfile"];
	 $filetype=$_POST["filetype"];
	 
	 if($id != ""){
	 	$filename = $_FILES['myfile']['name'];

		    // destination of the file on the server
		    $destination = 'uploads/' . $filename;

		    // get the file extension
		    $extension = pathinfo($filename, PATHINFO_EXTENSION);

		    // the physical file on a temporary uploads directory on the server
		    $file = $_FILES['myfile']['tmp_name'];
		    $size = $_FILES['myfile']['size'];

		    if (!in_array($extension, ['zip', 'pdf', 'docx', 'csv'])) 
		    {
		        //echo "You file extension must be .zip, .pdf or .docx";

		        //echo "<script type='text/javascript'>alert('You file extension must be .zip, .pdf or .docx');</script>";
		        echo "You file extension must be .zip, .pdf or .docx";
		    } 
		    elseif ($_FILES['myfile']['size'] > 1000000) 
		    { // file shouldn't be larger than 1Megabyte
		        //echo "<script type='text/javascript'>alert('File too large!');</script>";
		        echo "File too large!";
		    }
		    else
		    {
		    	if (move_uploaded_file($file, $destination)) {
			    	$sql = "INSERT INTO filemanagement (workerid,filetype,name,dataareaid,createddatetime)
							values 
							('$id', '$filetype', '$filename', '$dataareaid',now())";
						if(mysqli_query($conn,$sql))
						{
							echo "New Rec Created";

						}
						else
						{
							echo "error".$sql."<br>".$conn->error;
					}
				} 
				else {
		            echo "Failed to upload file.";
				}
		    }
	

	 }
	 
	header('location: uploaderform.php');
	
}

//else if($_GET["action"]=="download") {
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];
   


			header('Content-Description: File Transfer');
		    header('Content-Type: application/force-download');
		    header("Content-Disposition: attachment; filename=\"" . basename($id) . "\";");
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    // header('Content-Length: ' . filesize($id));
		    ob_clean();
		    flush();
		    readfile("../payroll/uploads/".$id); //showing the path to the server where the file is to be download
		    //exit;

		    //header('location: uploaderform.php');

}
?>

