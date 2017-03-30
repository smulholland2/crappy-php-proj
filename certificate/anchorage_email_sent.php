<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
error_reporting(0);

$invoice = $_POST["invoice"];

if($invoice){

    $SQL = "UPDATE [anchorage_invoices]
            SET EMAIL_SENT='yes'
            WHERE id='$invoice' ";
    $resultset=mssql_query($SQL, $con);
    if($resultset){
        echo "Certificate was marked as being sent.";
    }
}


?>

