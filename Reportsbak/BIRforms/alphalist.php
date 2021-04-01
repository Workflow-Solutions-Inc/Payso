	<?php
// Include PHPExcel library and create its object
include(__DIR__ . '/PHPExcel/Classes/PHPExcel/IOFactory.php');
include(__DIR__ . '/PHPExcel/Classes/PHPExcel.php');
include('dbconn2.php');
$myFile = __DIR__ . '/1604.xlsx';
echo $myFile;
$myCounter = 16;
$excel2 = PHPExcel_IOFactory::createReader('Excel2007');
$excel2 = $excel2->load($myFile); // Empty Sheet
$excel2->setActiveSheetIndex(0);
$cur_year = $_GET['selectedyear'];


$sql = "call Sp_generateAlphalist('DC','".$cur_year."')";
					$result = $conn->query($sql);
					//$users[] = '';
					if ($result->num_rows > 0)
					{
						while ($row = $result->fetch_assoc())
						{
							$myCounter++;
							$cellA = 'A'.$myCounter;
							$cellB = 'B'.$myCounter;
							$cellC = 'C'.$myCounter;
							$cellD = 'D'.$myCounter;
							$cellE = 'E'.$myCounter;
							$cellF = 'F'.$myCounter;
							$cellG = 'G'.$myCounter;
							$cellH = 'H'.$myCounter;
							$cellI = 'I'.$myCounter;
							$cellJ = 'J'.$myCounter;
							$cellK = 'K'.$myCounter;
							$cellL = 'L'.$myCounter;
							$cellM = 'M'.$myCounter;
							$cellQ = 'Q'.$myCounter;
							$cellR = 'R'.$myCounter;
							$cellS = 'S'.$myCounter;
							$cellT = 'T'.$myCounter;
							$cellU = 'U'.$myCounter;
							$cellV = 'V'.$myCounter;
							$cellW = 'W'.$myCounter;
							//echo $cellA."<br>";
							//echo  $cellA;
							$excel2->getActiveSheet()->setCellValue($cellA, $row['ic'])
									    ->setCellValue($cellB, $row['tinnum'])
									    ->setCellValue($cellC, $row['name'])       
									    ->setCellValue($cellD, $row['gpay'])
									    ->setCellValue($cellE, $row['tmth'])
									    ->setCellValue($cellF, $row['dmnms'])
									    ->setCellValue($cellG, $row['bnfts'])
									    ->setCellValue($cellH, $row['oslry'])
									    ->setCellValue($cellI, $row['total_non_tax'])
									    ->setCellValue($cellJ, $row['taxable'])
									    ->setCellValue($cellK, $row['tax_tmth'])
									    ->setCellValue($cellL, $row['oslrytax'])
									    ->setCellValue($cellM, $row['total_tax'])
									    ->setCellValue($cellQ, $row['net_tax'])
									    ->setCellValue($cellR, $row['tax_due'])
									    ->setCellValue($cellS, $row['tax_withheld'])
									    ->setCellValue($cellT, $row['net_tax_due'])
									    ->setCellValue($cellU, $row['net_tax_refund'])
									    ->setCellValue($cellV, $row['amount_withheld'])
									    ->setCellValue($cellW, $row['substituted_filling']);

						}
		
					}




$objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
$objWriter->save( __DIR__ . '/1604NEW.xlsx');
$file = "1604NEW.xlsx";
// define file $mime type here
/*ob_end_clean(); // this is solution
header('Content-Description: File Transfer');
header('Content-Type: ' . $file);
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . basename($file) . "\"");
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
readfile($file);*/



	header('Content-Description: File Transfer');
		    header('Content-Type: application/force-download');
		    header("Content-Disposition: attachment; filename=\"" . basename("1604NEW.xlsx") . "\";");
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize( __DIR__ . '/1604NEW.xlsx'));
		    ob_clean();
		    flush();
		    readfile( __DIR__ . '/1604NEW.xlsx');


//header("Content-Type: application/xlsx");
//header("Content-Disposition: attachment; filename=1604NEW.xlsx");
//echo("<script type='text/javascript'> alert('Alphalist is now generated file name: ".__DIR__ ."1604NEW.xlsx'); </script>");
//$objWriter->save('php://output');
?>