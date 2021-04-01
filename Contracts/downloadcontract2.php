<?php
include("../dbconn.php");
require_once 'vendor/autoload.php';

if(isset($_POST["saveUpload"])){
 
        $filename = $_FILES['myfile']['name'];

            // destination of the file on the server
            $destination = '../Contracts/' . $filename;

            // get the file extension
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            echo $filename;
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
$workerid = $_POST["uploadworkerid"];
$contractid = $_POST["uploadcontractid"];
//$filepath = $_GET["filepath"];
//replace word docx
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($filename);


//code here

$resqry = "SELECT 
w.name as name,
w.address,
p.name as pos,
c.fromdate,
(case when c.todate = '1900-01-01' then 'no fixed date' else c.todate end) as todate,
(CASE
    WHEN w.payrollgroup = 1 THEN CONCAT('Php ', FORMAT(c.mrate, 2), ' per month')
    ELSE CONCAT('Php ', FORMAT(rh.rate, 2), ' per day')
    END) AS type
    FROM
    worker w
    LEFT JOIN
    contract c ON c.workerid = w.workerid
    LEFT JOIN
    dataarea d ON d.dataareaid = w.dataareaid
    LEFT JOIN
    position p ON p.positionid = w.position
    LEFT JOIN
    ratehistory rh ON rh.contractid = c.contractid
    WHERE
    w.workerid = '$workerid' and c.contractid = '$contractid';";
    $result = $conn->query($resqry);
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc())
        {
            $templateProcessor->setValue('{Company}', 'Workflow Solutions');
            $templateProcessor->setValue('{Company Address}', 'Quezon City, Philippines');
            $templateProcessor->setValue('{Employee Name}', $row["name"]);
            $templateProcessor->setValue('{Employee Address}', $row["address"]);
        //new
            $templateProcessor->setValue('{Position}', $row["pos"]);
            $templateProcessor->setValue('{Start Date}', $row["fromdate"]);
            $templateProcessor->setValue('{End Date}', $row["todate"]);
            $templateProcessor->setValue('{Rate}', $row["type"]);
        }
    }
    
    $templateProcessor->saveAs('./'.$workerid.'_'.$contractid.'.docx');
//end of code


//saves to word

    $objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
    $contents=$objReader->load($workerid.'_'.$contractid.'.docx');



//convert to pdf
    $rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;

    $renderLibrary="TCPDF";
    $renderLibraryPath=''.$renderLibrary;
    if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibrary)){
     die("Provide Render Library And Path");
 }
 $renderLibraryPath=''.$renderLibrary;
 $objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'PDF');
 $objWriter->save($workerid.'_'.$contractid.'.pdf');



//open pdf
/*$file = "newcontract.pdf";
$filename = "newcontract.pdf";

    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));
    header('Accept-Ranges: bytes');

    @readfile($file);*/

    $file = $workerid.'_'.$contractid.'.docx';
    $filename = $workerid.'_'.$contractid.'.docx';

   /* header('Content-type: word/docx');
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));
    header('Accept-Ranges: bytes');*/

    header('Content-Description: File Transfer');
    header('Content-Type: application/force-download');
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    @readfile($file);
                } 
                else {
                    echo "Failed to upload file.";
                }
            }
//header('location: contractform.php');
}


?>