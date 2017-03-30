<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

session_start();
$user = $_SESSION['user'];

$SQL1 = "DELETE FROM CCCR
         WHERE corp='$user' ";
$resultset1=mssql_query($SQL1, $con);
if($resultset1){
    $_SESSION["CCCR_deleted"] = 1;
    header('Location: businessprogress.php');
}
else{
    echo "There was a problem Deleting the report information.";
}
?>