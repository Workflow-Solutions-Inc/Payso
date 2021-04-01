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

$wkid = $_GET['worker'];

$query = "select wk.name wkname, date(wk.datehired) datefrom ,date(wk.inactivedate) dateto,ps.name psname from worker wk left join position ps on wk.position = ps.positionid and wk.dataareaid = ps.dataareaid where wk.workerid = '".$wkid."' ";
     $result = $conn->query($query);
        $row = $result->fetch_assoc();

        $name = $row["wkname"];
        $datefrom = $row["datefrom"];
        $dateto = $row["dateto"];
        $psname = $row["psname"];
        
   

  $pdf = new \setasign\Fpdi\Fpdi();
    require_once "FPDI/src/autoload.php";
  $pdf = new FPDI('P','mm','Legal');

  /* <Virtual loop> */
  $pdf->AddPage();
  $pdf->setSourceFile('COEDEMO.pdf');
  $tplIdx = $pdf->importPage(1);

  $pdf->useTemplate($tplIdx, -1,1, 230);

  $pdf->SetFont('Times','B',12);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(100, 108);
  $pdf->Write(0,   $name );


  $pdf->SetFont('Times','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(100, 113);
  $pdf->Write(0,  $datefrom);

  $pdf->SetFont('Times','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(140, 113);
  $pdf->Write(0,  $dateto  == '1900-01-01' ? 'Present' :  $dateto);

  $pdf->SetFont('Times','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(59.6, 118);
  $pdf->Write(0,  $psname);


  $pdf->SetFont('Times','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(75, 155);
  $pdf->Write(0,  date("d"));


  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(105, 155);
  $pdf->Write(0,  date("Y"));



  
  $pdf->Output('newpdf1.pdf', 'I');

?>