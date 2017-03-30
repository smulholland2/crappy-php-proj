<?php
$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.');

 $discode = $_GET["discode"];
 $price_discode = $_GET["price_discode"];
 $logo = $_GET["logo"];
 $js = $_GET["js"];
 $css = $_GET["css"];
 $active = $_GET["active"];
 $corporate_username = $_GET["corporate_username"];
 $region_username = $_GET["region_username"];
 $account_username = $_GET["account_username"];
 $add_id = $_GET["add_id"];
 $html = $_GET["html"];

$SQL = "UPDATE discodes
        SET 
        price_discode='$price_discode',
        logo='$logo',
        js='$js',
        css='$css',
        active='$active',
        corporate_username='$corporate_username',
        region_username='$region_username',
        account_username='$account_username',
        add_id='$add_id',
        html='$html'
        WHERE discode='$discode' ";
$resultset=mssql_query($SQL, $con);

if($resultset){
    echo "Congratulations the 4u page was successfully updated, click <a href='edit_4u.php'>here</a> to return to the previous table.";
}
else{
    echo "There was an error updating the information.";
}

?>