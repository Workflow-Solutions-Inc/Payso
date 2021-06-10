<?php
session_start();
session_regenerate_id();

require_once "BIRforms/PHPExcel/Classes/PHPExcel.php";
include('../dbconn.php');
$dataareaid = $_SESSION["defaultdataareaid"];
$userlogin = $_GET["usr"];
$soc = $dataareaid;
$paydate = $_GET["paydate"];
$usrname =  $_GET["usrname"];


//create phpexcel object
$excel = new PHPExcel();

$id = '';
$start = 2;
$count = 1;
$amount = 0;
//selecting active sheet
//$excel -> setActiveSheetIndex(0);
//PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
//$excel = PHPExcel_IOFactory::load("APPC PROLL TEMPLATE.xls");
/*$inputFileName = 'Book1.xls';
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $excel = $objReader->load($inputFileName);*/

$excel = PHPExcel_IOFactory::load("Digibanker.xlsx");


        $query = "CALL atmreportweb('$soc', '$paydate');";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) 
        { 
            $excel -> setActiveSheetIndex(0)
            -> setCellValue('A'.$start, $row["name"])
            -> setCellValue('B'.$start, $row["workerid"])
            -> setCellValue('C'.$start, number_format($row['Amount'],2));

            $start+=1;
            $count+=1;
            $amount+=$row['Amount'];
        }
        $excel -> setActiveSheetIndex(0)
        -> setCellValue('A'.$start,'Total Amount:')
        -> setCellValue('C'.$start, number_format($amount,2));
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
//redirect browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="PAYSO DIGIBANKER '.date('Y-m-d h:i:sa').'.xlsx"');
header('Cache-Control: max-age=0');

$file = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$file->save('php://output');

//write result to a file
//$filename = date('d-m-Y_H-i-s').".xls";
//$file = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
//$file->save(str_replace('.php', '.xls', $filename));
 //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 //header('Content-type: application/vnd.ms-excel');
 //header('Content-Disposition: attachment; filename='.$filename);
 //$file->save("php://output");
   



?>