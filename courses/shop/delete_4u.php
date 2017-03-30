<?php
$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.');

$discode = $_GET["discode"];

$SQL = "DELETE FROM discodes WHERE discode='$discode' ";
$resultset=mssql_query($SQL, $con);

if($resultset){
    echo "The 4u page with the discode '$discode' was successfully deleted, click <a href='edit_4u.php'>here</a> to return to the previous table. ";
}
else{
    echo "There was an error deleting this 4u page.";
}

?>