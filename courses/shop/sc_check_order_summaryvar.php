<?php
$checkfn = $_POST["checkfn"];
$checkln = $_POST["checkln"];
$checkcn = $_POST["checkcn"];
$checkadd1 = $_POST["checkadd1"];
$checkadd2 = $_POST["checkadd2"];
$checkci = $_POST["checkci"];
$checkst = $_POST["checkst"];
$checkzip = $_POST["checkzip"];
$checkcou = $_POST["checkcou"];
$checkphone = $_POST["checkphone"];
$checkem = $_POST["checkem"];

session_start();

$_SESSION["checkfn"] = "$checkfn";
$_SESSION["checkln"] = "$checkln";
$_SESSION["checkcn"] = "$checkcn";
$_SESSION["checkadd1"] = "$checkadd1";
$_SESSION["checkadd2"] = "$checkadd2";
$_SESSION["checkci"] = "$checkci";
$_SESSION["checkst"] = "$checkst";
$_SESSION["checkzip"] = "$checkzip";
$_SESSION["checkcou"] = "$checkcou";
$_SESSION["checkphone"] = "$checkphone";
$_SESSION["checkem"] = "$checkem";



header('Location: sc_check_order_summary.php');

?>
