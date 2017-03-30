<?php
error_reporting(0); 

$account_username = $_GET["account_username"];

session_start();
$_SESSION["user"] = $account_username;
$_SESSION["admintable"] = "07L3";

// fh (all other states)
if($account_username == "ecbal" || $account_username == "ecbal" || $account_username == "ecny" || $account_username == "ecphila" || $account_username == "ecdc"){
    $_SESSION["add_id"] = 3;
}

if($account_username == "ecchi"){
    $_SESSION["add_id"] = 162;
}
if($account_username == "ecfl"){
    $_SESSION["add_id"] = 75;
}

if($account_username == "ecnorfolk"){
    $_SESSION["add_id"] = 74;
}

$add_id = $_SESSION["add_id"];

if($add_id){
    header("Location: /admin/tools/students/single");
}
else{
    header("Location: /admin/tools/students");
}

//print_r($_SESSION);
?>