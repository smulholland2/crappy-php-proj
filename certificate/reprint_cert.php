<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/FPDF/fpdf.php";
error_reporting(0);

$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

//invoice number
$id = $_POST["id"];

//get students username
$SQL = "SELECT UN FROM anchorage_invoices WHERE id='$id' ";
$resultset=mssql_query($SQL, $con);
while ($row = mssql_fetch_array($resultset)) 
{
    $UU = $row['UN'];
}

//get students name
$SQL1 = "SELECT NF, NL FROM [01D] WHERE UU='$UU' ";
$resultset1=mssql_query($SQL1, $con);
while ($row = mssql_fetch_array($resultset1)) 
{
    $NF = $row['NF'];
    $NL = $row['NL'];
}

//get course date ended
$SQL2 = "SELECT DE FROM [01P] WHERE UU='$UU' AND NUM=12 AND DE<>'' ";
$resultset2=mssql_query($SQL2, $con);
while ($row = mssql_fetch_array($resultset2)) 
{
    $DE_compare = $row['DE'];
    $cert_completeddate = $row['DE'];
    $cert_completeddate = strtotime($cert_completeddate);
    $cert_completeddate = date('F d, Y', $cert_completeddate);
}

//get certificate number
$SQL3 = "SELECT id FROM [01C] WHERE UU='$UU' ";
$resultset3=mssql_query($SQL3, $con);
while ($row = mssql_fetch_array($resultset3)) 
{
    $cert_id = $row['id'];
}

//add 3 years to date ended
$y = date('Y',strtotime($DE_compare));
$y = $y + 3;
$y = substr($y, -2);

//created new format for certificate number YY-XXXXXX
$cert_id_format = $y."-".$cert_id;

//students full name
$cert_fullname = $NF ." ".  $NL;


//Create certificate
$pdf = new FPDF();
$pdf->AddPage();

$pdf->Image('foodhandler/certificate_file_akan.jpg',10,10,-340);
$pdf->SetFont('Helvetica','B');
$pdf->Text(120 , 68 , $cert_completeddate);
$pdf->Cell(190,135.5,$cert_fullname,0,1,'C');
$pdf->Text(65, 105 , "Municipality of Anchorage Food Handler" );
$pdf->Text(95 , 136 , $cert_id_format);
$pdf->SetFont('Helvetica','B','9');
$pdf->Text(27 , 180 , $cert_fullname);
$pdf->Text(27 , 187.5 , $cert_completeddate);
$pdf->Text(31 , 195 , $cert_id_format);
$pdf->Output("test.pdf", 'I');


?>