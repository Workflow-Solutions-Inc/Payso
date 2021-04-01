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

$query = "SELECT 
    wk.name wkname,
    DATE(wk.datehired) datefrom,
    DATE(wk.inactivedate) dateto,
    ps.name psname,
    dt.name as dataname,
    dt.dataarealogo,
    dt.address
FROM
    worker wk
        LEFT JOIN
    position ps ON wk.position = ps.positionid
        AND wk.dataareaid = ps.dataareaid
  left join dataarea dt on
    dt.dataareaid = wk.dataareaid
where wk.workerid = '".$wkid."'";

     $result = $conn->query($query);
        $row = $result->fetch_assoc();

        $name = $row["wkname"];
        $datefrom = $row["datefrom"];
        $dateto = $row["dateto"];
        $psname = $row["psname"];
        $dataURI = $row["dataarealogo"];
        $dataname = $row["dataname"];
        $address = $row["address"];
   

  $pdf = new \setasign\Fpdi\Fpdi();
    require_once "FPDI/src/autoload.php";
  $pdf = new FPDI('P','mm','Legal');

  /* <Virtual loop> */
  $pdf->AddPage();
  $pdf->setSourceFile('COE.pdf');
  $tplIdx = $pdf->importPage(1);

  $pdf->useTemplate($tplIdx, -1,1, 230);

    const TEMPIMGLOC = 'tempimg.png';
  const TEMPIMGLOC2 = 'tempimg.jpg';

    $dataPieces = explode(',',$dataURI);
  $encodedImg = $dataPieces[1];
  $decodedImg = base64_decode($encodedImg);

//  Check if image was properly decoded
  if($dataPieces[0]=="data:image/png;base64"){
    if( $decodedImg!==false )
    {
        //  Save image to a temporary location
        if( file_put_contents(TEMPIMGLOC,$decodedImg)!==false )
        {
            $pdf->Image(TEMPIMGLOC,29,17,35,25);
            
            //  Delete image from server
            unlink(TEMPIMGLOC);
        }
    }
  }else if($dataPieces[0]=="data:image/jpg;base64"){
    if( $decodedImg!==false )
    {
        //  Save image to a temporary location
        if( file_put_contents(TEMPIMGLOC2,$decodedImg)!==false )
        {
            $pdf->Image(TEMPIMGLOC2);

            //  Delete image from server
            unlink(TEMPIMGLOC2);
        }
    }
  }

  $pdf->SetFont('Times','B',12);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(100, 90);
  $pdf->Write(0,   $name );

  $pdf->SetFont('Times','B',20);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(75, 25);
  $pdf->Write(0,   $dataname );

  $pdf->SetFont('Times','B',12);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(75, 35);
  $pdf->Write(0,   $address );


  $pdf->SetFont('Times','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(100, 95);
  $pdf->Write(0,  $datefrom);

  $pdf->SetFont('Times','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(140, 95);
  $pdf->Write(0,  $dateto  == '1900-01-01' ? 'Present' :  $dateto);

  $pdf->SetFont('Times','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(59.6, 100);
  $pdf->Write(0,  $psname);


  $pdf->SetFont('Times','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(75, 137);
  $pdf->Write(0,  date("d"));


  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(105, 137);
  $pdf->Write(0,  date("M-Y"));



  
  $pdf->Output('newpdf1.pdf', 'I');

?>