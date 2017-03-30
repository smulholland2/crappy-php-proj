<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

session_start();

$UN = $_GET["UN"];

$NF = $_GET["NF"];
$NL = $_GET["NL"];
$AA1 = $_GET["AA1"];
$AA2 = $_GET["AA2"];
$ACI = $_GET["ACI"];
$AST = $_GET["AST"];
$AZ = $_GET["AZ"];
$AP = $_GET["AP"];
$AM = $_GET["AM"];

$NCON = $NF." ".$NL;
$DIV_NAME = $NF."_".$NL;

$SQL =" UPDATE [07O6] 
        SET 
        NF='$NF',
        NL='$NL',
        AA1='$AA1',
        AA2='$AA2',
        ACI='$ACI',
        AST='$AST',
        AZ='$AZ',
        AP='$AP',
        AM='$AM',
        NCON='$NCON',
        DIV_NAME='$DIV_NAME'
        WHERE AN='$UN'
    ";

    $resultset=mssql_query($SQL, $con); 
    if($resultset){
        $_SESSION["info_updated"] = "yes";
        header("Location: qk_verify_store.php?UN=$UN");
    }
    else{
        $_SESSION["info_updated"] = "no";
        header("Location: qk_verify_store.php?UN=$UN");
    }


?>