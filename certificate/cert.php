<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/FPDF/fpdf.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/config/connection.php";
error_reporting(0);

$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

//student not found function
function student_not_found($string){
    echo "
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
            <div class='container' style='margin-top:100px'>
                <div class='well text-center'>
                <h1 class='text-center'>Invalid information, please try again!</h1>
                <a href='/certificate/$string/' class='btn btn-primary' role='button'>Go Back</a>
                </div>
            </div>        
            ";
    die;
}

//empty DE
function empty_DE(){
    echo "
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
            <div class='container' style='margin-top:100px'>
                <div class='well text-center'>
                <h1 class='text-center'>You haven't completed the course.<br>Please login to the course and complete all the lessons and the final exam.</h1>
                <a href='/training/' class='btn btn-primary' role='button'>Login to Course</a>
                </div>
            </div>
            ";
    die;
}

//student didn't pass the test
function exam_failed(){
    echo "
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
            <div class='container' style='margin-top:100px'>
                <div class='well text-center'>
                <h1 class='text-center'>You scored less that 70% on the exam, please login to the course and re-take the exam.</h1>
                <a href='/training/' class='btn btn-primary' role='button'>Login to Course</a>
                </div>
            </div>
        ";
    die;
}

// alcohol certificate
if($_POST["ProID"]=="alc" && $_POST["lname"] && $_POST["month"] && $_POST["day"] && $_POST["year"]){
    $search_lname = $_POST["lname"];
    $search_BD = $_POST["month"]."/".$_POST["day"]."/".$_POST["year"];

    //first, check on 12C for DOB and student information
    $SQL4 = "SELECT [12D].NL,[12D].NF, [12D].UU, [12D].DE, [12C].BD, [12C].id
            FROM [12D] 
            INNER JOIN [12C] 
            ON [12D].UU = [12C].UU
            WHERE ([12D].NL = ".mssql_escape($search_lname).") 
            AND ([12C].BD = '$search_BD')
            ORDER BY DE 
        ";
    $resultset4=mssql_query($SQL4, $con);
    while ($row = mssql_fetch_array($resultset4)) 
    {
        $UU = $row['UU'];
        $cert_firstname = $row['NF'];
        $cert_lastname = $row['NL'];
        $cert_id = $row['id'];
        $cert_id = "AL".$cert_id;
    }

    if(!$UU){
        //if student information wasn't found on 12C, check on 01C
        $SQL = "SELECT [12D].NL,[12D].NF, [12D].UU, [12D].DE, [01C].BD, [01C].id
                FROM [12D] 
                INNER JOIN [01C] 
                ON [12D].UU = [01C].UU
                WHERE ([12D].NL = ".mssql_escape($search_lname).") 
                AND ([01C].BD = '$search_BD') 
                ORDER BY DE
                ";
        $resultset=mssql_query($SQL, $con);
        while ($row = mssql_fetch_array($resultset)) 
        {
            $UU = $row['UU'];
            $cert_firstname = $row['NF'];
            $cert_lastname = $row['NL'];
            $cert_id = $row['id'];
            $cert_id = "AL".$cert_id;
        }
    }

    




    // if student wasn't' not found, display error message, there is probably a typo
    if(!$UU){
        student_not_found("alcoholtraining");
    }

    // checks if there is a date on column DE (date ended), if not, display error message
    $SQL3 = "SELECT DE FROM [12D] WHERE UU='$UU' ";
    $resultset3=mssql_query($SQL3, $con);
    while ($row = mssql_fetch_array($resultset3)) 
    {
         $check_DE = $row['DE'];
    }
    if(!$check_DE){
        empty_DE();
    }

    // checks if student got 70% or better on exam (L06), if not, display error message 
    $SQL2 = "SELECT PER, DE FROM [12P] WHERE UU='$UU' AND NUM=06 AND DE<>'' ";
    $resultset2=mssql_query($SQL2, $con);
    while ($row = mssql_fetch_array($resultset2)) 
    {
         $PER = $row['PER'];
         $cert_completeddate = $row['DE'];
         $cert_completeddate = strtotime($cert_completeddate);
         $cert_completeddate = date('F d, Y', $cert_completeddate);
    }

    if($PER < 70){
        exam_failed();    
    }

    $cert_fullname = $cert_firstname ." ".  $cert_lastname;
    $pdf_name = $cert_id.".pdf";

    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->Image('alcoholtraining/certificate_file_alcohol.jpg',10,10,-340);
    $pdf->SetFont('Helvetica','B');
    $pdf->Text(120 , 68 , $cert_completeddate);
    $pdf->Cell(190,135.5,$cert_fullname,0,1,'C');
    $pdf->Text(89, 102 , "Alcohol Training" );
    $pdf->Text(95 , 136 , $cert_id);
    $pdf->SetFont('Helvetica','B','9');
    $pdf->Output("$pdf_name", 'I');

}

// alaska food handler
if(($_POST["course"]== 24 && $_POST["lname200"] && $_POST["month"] && $_POST["day"] && $_POST["year"]) || isset($_GET)){

    if($_POST["month"] == "January")
        $month = 1;

    if($_POST["month"] == "February")
        $month = 2;

    if($_POST["month"] == "March")
        $month = 3;

    if($_POST["month"] == "April")
        $month = 4;

    if($_POST["month"] == "May")
        $month = 5;
        
    if($_POST["month"] == "June")
        $month = 6;

    if($_POST["month"] == "July")
        $month = 7;

    if($_POST["month"] == "August")
        $month = 8;

    if($_POST["month"] == "September")
        $month = 9;

    if($_POST["month"] == "October")
        $month = 10;

    if($_POST["month"] == "November")
        $month = 11;

    if($_POST["month"] == "December")
        $month = 12;
    
    $search_lname = $_POST["lname200"];
    $search_BD = $month."/".$_POST["day"]."/".$_POST["year"];

    if(empty($_GET))
    {
        $SQL = "SELECT [01D].NL,[01D].NF, [01D].UU, [01D].DE, [01C].BD, [01C].id
            FROM [01D] 
            INNER JOIN [01C] 
            ON [01D].UU = [01C].UU
            WHERE ([01D].NL = ".mssql_escape($search_lname).") 
            AND ([01C].BD = '$search_BD')
            AND  ([01D].ME = ".$_POST['course'].")
            ORDER BY DE";

            $resultset=mssql_query($SQL, $con);

        while ($row = mssql_fetch_array($resultset)) 
        {
            $UU = $row['UU'];
            $cert_firstname = $row['NF'];
            $cert_lastname = $row['NL'];
            $cert_id = $row['id'];
            $cert_id2 = $row['id'];
            $cert_id = "AK".$cert_id;
        }
    }
    else
    {
        $search_lname = $_GET["lname200"];
        $student = $_GET["ctname933"];   

        $context = new Db();

        $proc = 'GetAlaskaCertData';

        $row = $context -> ExecuteProcedure($proc,$student);

        $UU = $row['UU'];
        $cert_firstname = $row['NF'];
        $cert_lastname = $row['NL'];
        $cert_id = $row['id'];
        $cert_id2 = $row['id'];
        $cert_id = "AK".$cert_id;
    }

    // if student wasn't not found, display error message, there is probably a typo
    if(!$UU)
        student_not_found("foodhandler");

    // checks if there is a date on column DE (date ended), if not, display error message
    $SQL3 = "SELECT DE FROM [01D] WHERE UU='$UU' ";
    $resultset3=mssql_query($SQL3, $con);

    while ($row = mssql_fetch_array($resultset3)) 
        $check_DE = $row['DE'];

    if(!$check_DE)
        empty_DE();

    // checks if student got 70% or better on exam (L06), if not, display error message 
    $SQL2 = "SELECT PER, DE FROM [01P] WHERE UU='$UU' AND NUM=12 AND DE<>'' ";
    $resultset2=mssql_query($SQL2, $con);

    while ($row = mssql_fetch_array($resultset2)) 
    {
        $PER = $row['PER'];
        $cert_completeddate = $row['DE'];
        $DE_compare = $row['DE'];
        $DE_compare2 = $row['DE'];
        $cert_completeddate = strtotime($cert_completeddate);
        $cert_completeddate = date('F d, Y', $cert_completeddate);
    }

    if($PER < 70){
        exam_failed();
    }

    // Get number of days since the course was completed
    $now = time();
    $DE_compare = strtotime($DE_compare);
    $datediff  = $now - $DE_compare;
    $days_since_completion = floor($datediff / (60 * 60 * 24));

    // If the students passed the course more than 30 days ago, they have to pay $5 every time they want to re-print it
    // Send the student to the page below to pay the fee and re-print certificate 
    if($days_since_completion > 30)
        header("Location: /certificate/anchorage_reprint.php?UU=$UU");

    //add 3 years to date ended
    $y = date('Y',strtotime($DE_compare2));
    $y = $y + 3;
    $y = substr($y, -2);

    //created new format for certificate number YY-XXXXXX
    $cert_id_format = $y."-".$cert_id2;
        
    $cert_fullname = $cert_firstname ." ".  $cert_lastname;
    $pdf_name = $cert_id.".pdf";

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
    $pdf->Output("$pdf_name", 'I');
}
else
    echo "There was an error with the information sent to this page.";

function mssql_escape($data)
{
    if(is_numeric($data))
        return "'".$data."'";

    $unpacked = unpack('H*hex', $data);

    return '0x' . $unpacked['hex'];

}

?>

