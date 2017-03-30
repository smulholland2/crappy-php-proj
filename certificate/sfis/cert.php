<?php

include_once $_SERVER['DOCUMENT_ROOT']."/lib/FPDF/fpdf.php";

error_reporting(0);

$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

/*
session_start();
 $cert_lastname = $_SESSION["cert_lastname"];
 $cert_lastname = strtoupper($cert_lastname);
 $cert_firstname = $_SESSION["cert_firstname"];
 $cert_firstname = strtoupper($cert_firstname);
 $cert_fullname = $cert_firstname ." ".  $cert_lastname;
 $cert_course = $_SESSION["cert_course"];
 $cert_region = $_SESSION["cert_region"];
 $cert_completeddate = $_SESSION["cert_completeddate"];
 $cert_completeddate = strtotime($cert_completeddate);
 $cert_completeddate = date('F d, Y', $cert_completeddate);
 */

if($_POST["ProID"]=="alc" && $_POST["lname"]){

    $search_lname = $_POST["lname"];
    $cert_lastname = $_POST["lname"];

    $search_BD = $_POST["month"]."/".$_POST["day"]."/".$_POST["year"];

    $SQL = "SELECT [12D].NL,[12D].NF, [12D].UU, [12D].DE, [01C].BD, [01C].id
            FROM [12D] 
            INNER JOIN [01C] 
            ON [12D].UU = [01C].UU
            WHERE ([12D].NL = '$search_lname') 
            AND ([01C].BD = '$search_BD') 
            AND ([12D].DE <> '') 
            ";
    $resultset=mssql_query($SQL, $con);
    while ($row = mssql_fetch_array($resultset)) 
    {
         $UU = $row['UU'];
         $cert_firstname = $row['NF'];
         $cert_id = $row['id'];
         $cert_id = "AL".$cert_id;
    }

    if(!$UU){
        echo "Invalid information, try again!";
        die;
    }

    $SQL2 = "SELECT PER, DE FROM [12P] WHERE UU='$UU' AND NUM=06 AND DE<>'' ";
    $resultset2=mssql_query($SQL2, $con);
    while ($row = mssql_fetch_array($resultset2)) 
    {
         $PER = $row['PER'];
         $cert_completeddate = $row['DE'];
         $cert_completeddate = strtotime($cert_completeddate);
         $cert_completeddate = date('F d, Y', $cert_completeddate);
    }

        if($PER < 69){
        echo "You scored less that 70% on the exam, please re-take the exam.";
        die;
    }



$cert_fullname = $cert_firstname ." ".  $cert_lastname;

$pdf = new FPDF();
$pdf->AddPage();

//alcohol
if($_POST["ProID"]=="alc"){
$pdf->Image('alcoholtraining/certificate_file_alcohol.jpg',10,10,-340);
$pdf->SetFont('Helvetica','B');
$pdf->Text(120 , 68 , $cert_completeddate);
$pdf->Cell(190,135.5,$cert_fullname,0,1,'C');
$pdf->Text(89, 102 , "Alcohol Training" );
$pdf->Text(95 , 136 , $cert_id);
$pdf->SetFont('Helvetica','B','9');
}

$pdf->Output("myPFD.pdf", 'I');

}




?>