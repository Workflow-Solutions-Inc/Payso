<?php


    set_time_limit(0);
    function MakePropertyValue($name,$value,$osm){
    $oStruct = $osm->Bridge_GetStruct("com.sun.star.beans.PropertyValue");
    $oStruct->Name = $name;
    $oStruct->Value = $value;
    return $oStruct;
    }
    function word2pdf($doc_url, $output_url){

    //Invoke the OpenOffice.org service manager
    $osm = new COM("com.sun.star.ServiceManager") or die ("Please be sure that OpenOffice.org is installed.\n");
    //Set the application to remain hidden to avoid flashing the document onscreen
    $args = array(MakePropertyValue("Hidden",true,$osm));
    //Launch the desktop
    $oDesktop = $osm->createInstance("com.sun.star.frame.Desktop");
    //Load the .doc file, and pass in the "Hidden" property from above
    $oWriterDoc = $oDesktop->loadComponentFromURL($doc_url,"_blank", 0, $args);
    //Set up the arguments for the PDF output
    $export_args = array(MakePropertyValue("FilterName","writer_pdf_Export",$osm));
    //print_r($export_args);
    //Write out the PDF
    $oWriterDoc->storeToURL($output_url,$export_args);
    $oWriterDoc->close(true);
    }

    $output_dir = "D:/xampp/htdocs/PaySo Payroll System Web App-1/payroll/Contracts/";
    $doc_file = "D:/xampp/htdocs/PaySo Payroll System Web App-1/payroll/Contracts/simple-word_2007.docx";
    $pdf_file = "simple-word_2007.pdf";
    $output_file = $output_dir . $pdf_file;
    $doc_file = "file:///" . $doc_file;
    $output_file = "file:///" . $output_file;
    word2pdf($doc_file,$output_file);
#$result = exec('"C:\Program Files (x86)\OpenOffice 4\program\python.exe" D:\wamp\www\doc_to_pdf\libobasis4.4-pyuno\unoconv -f pdf -o D:/wamp/www/doc_to_pdf/files/'.$pdf_File_name.' D:/wamp/www/doc_to_pdf/files/'.$doc_file_name);
?>

