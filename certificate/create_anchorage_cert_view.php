<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/FPDF/fpdf.php";

$cert_fn = $_POST["cert_fn"];
$cert_ln = $_POST["cert_ln"];
$cert_number = $_POST["cert_number"];
$completion_month = $_POST["completion_month"];
$completion_day = $_POST["completion_day"];
$completion_year = $_POST["completion_year"];
$cert_completeddate = $completion_month."/".$completion_day."/".$completion_year;

$cert_fullname = $cert_fn ." ".  $cert_ln;
$pdf_name = "anchoragereprint.pdf";

$pdf = new FPDF();
$pdf->AddPage();

$pdf->Image('foodhandler/certificate_file_akan.jpg',10,10,-340);
$pdf->SetFont('Helvetica','B');
$pdf->Text(120 , 68 , $cert_completeddate);
$pdf->Cell(190,135.5,$cert_fullname,0,1,'C');
$pdf->Text(65, 105 , "Municipality of Anchorage Food Handler" );
$pdf->Text(95 , 136 , $cert_number);
$pdf->SetFont('Helvetica','B','9');
$pdf->Text(27 , 180 , $cert_fullname);
$pdf->Text(27 , 187.5 , $cert_completeddate);
$pdf->Text(31 , 195 , $cert_number);
$pdf->Output("$pdf_name", 'I');
?>