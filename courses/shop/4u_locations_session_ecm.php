<?php
error_reporting(0); 

$account_username = $_GET["account_username"];

session_start();
$_SESSION["user"] = $account_username;
$_SESSION["admintable"] = "07L3";




    header("Location: /admin/company");


//print_r($_SESSION);
?>