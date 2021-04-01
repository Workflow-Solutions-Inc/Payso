<?php 
/*require('fpdf/fpdf.php');

$pdf = new FPDF();
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();




$pdf->SetFont('Arial','B',15);
$pdf->Cell(10,10,'',0);
$pdf->Cell(10,10,'',0);
$pdf->Cell(40,10,'',0);
$pdf->Cell(10,10,'Company Name',0);
$pdf->Cell(60,10,'',0,0);
$pdf->Cell(60,10,'',0,0);



$pdf->Cell(60,10,'',0,1);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,10,'',0);
$pdf->Cell(10,10,'',0);
$pdf->Cell(45,10,'',0);
$pdf->Cell(10,10,'Payslip Details',0);
$pdf->Cell(60,10,'',0,0);
$pdf->Cell(60,10,'',0,0);

$pdf->Cell(60,10,'',0,1);


$pdf->SetFont('Arial','B',9);
$pdf->Cell(15,10,'',0);
$pdf->Cell(8,10,'Name:',0);
$pdf->Cell(8,10,'',0);
$pdf->Cell(10,10,'John David Bachao',0);
$pdf->Cell(60,10,'',0,0);
$pdf->Cell(20,10,'Worker No:',0,0);
$pdf->Cell(10,10,'NEW000028',0,0);
$pdf->Cell(10,10,'',0,0);
$pdf->Cell(10,10,'',0,0);


$pdf->Output('','payslip.pdf', false);*/



use setasign\Fpdi\Fpdi;
require_once('fpdf/htmlpdf.php');
include('dbconn.php');
include(__DIR__ . '/FPDI/src/autoload.php');
//$selectedYear = $_GET['selectedyear'];
//$selectedWorker = $_GET['selectedworker'];
//$query = "select * from worker";
$memoid = $_GET['memoid'];

$wkid = $_GET['wkid'];

$tinelineno0 =  '';
$tinelineno1 =  '';
$tinelineno2 =  '';
$tinelineno3 =  '';
$tinelineno4 =  '';
$tinelineno5 =  '';
$tinelineno6 =  '';
$tinelineno7 =  '';
$tinelineno8 =  '';
$tinelineno9 =  '';
$tinelineno10 =  '';
$tinelineno11 =  '';



$query = "SELECT * from memoheader where memoid = '$memoid';";
     $result = $conn->query($query);
        $row = $result->fetch_assoc();

        //$cc = $row["Memocc"];
        //$to = $row["Memoto"];
        $sub = $row["subject"];
        $body = $row["body"];
        $from = $row["memofrom"];
        
  $query2 = "SELECT status from memodetail where memoid = '$memoid' and workerid = '$wkid'";
     $result2 = $conn->query($query2);
     $row2 = $result2->fetch_assoc();
       $status = $row2["status"];

    if ($status != 'CC') {
      $query2 = "SELECT name from worker where  workerid = '$wkid'";
        $result2 = $conn->query($query2);
        $row2 = $result2->fetch_assoc();
        $name = $row2["name"];
    }
    else{
      $name = 'This report is for CC only';
    }
  

   $query3 = "SELECT wk.name as cc from memoheader mh
        left join memodetail md on mh.memoid = md.memoid and mh.dataareaid = md.dataareaid
        left join worker wk on md.workerid = wk.workerid and mh.dataareaid = wk.dataareaid
        where mh.memoid = '$memoid' and md.status = 'CC';";
   $result3 = $conn->query($query3);


  $pdf = new \setasign\Fpdi\Fpdi();
    require_once "FPDI/src/autoload.php";
  $pdf = new FPDI('P','mm','A4');

  /* <Virtual loop> */
  $pdf->AddPage();
  $pdf->setSourceFile('Memorandum.pdf');
  $tplIdx = $pdf->importPage(1);

  $pdf->useTemplate($tplIdx, -1,1, 230);

  $pdf->SetFont('Times','',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(32, 59.5);
  $pdf->Write(0, $name.'.' );



  $pdf->SetFont('Times','',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(32, 66.7);
  $pdf->Write(0,  $from);


  $pdf->SetFont('Times','',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(32,73.9);
  while ($row3 = $result3->fetch_assoc())
  {
    $pdf->Write(0, $row3["cc"].'.    ' );
  }

  $pdf->SetFont('Times','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(35,80.8);
  $pdf->Write(0,  $sub);
/*
  $pdf->SetFont('Times','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(35,95);
  $pdf->Write(0,  substr($body , 0, 120));

  $pdf->SetFont('Times','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(30,100);
  $pdf->Write(0,  substr($body ,121, 120));


  $pdf->SetFont('Times','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(30,105);
  $pdf->Write(0,  substr($body ,261, 120));


  $pdf->SetFont('Times','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(30,110);
  $pdf->Write(0,  substr($body ,382, 120));*/

  $pdf->SetXY(20,110);
$pdf->MultiCell(170, 5, $body, 0);


  
  $pdf->Output('newpdf1.pdf', 'I');

?>