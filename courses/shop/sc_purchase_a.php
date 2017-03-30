<?php
session_start();

echo $discode = $_GET["discode"];
echo "<br>";

//$_SESSION["corporate_super_admin"] = "corpmydennys";

// only fsm
if($discode == "MSU" || $discode == "NDU" || $discode == "FDI" || $discode == "CRA" || $discode == "CRN" || $discode == "WEC" || $discode == "GSU" || $discode == "HMI" || $discode == "NSU" || $discode == "SPC" || $discode == "MCDFS" || $discode == "cfcc" || $discode == "iddba" || $discode == "fcc" || $discode == "jjc" || $discode == "usfs" || $discode == "usfsdis" || $discode == "msum" || $discode == "widener" || $discode == "esu" || $discode == "mcc" || $discode == "NR" || $discode == "wscc" || $discode == "madison" || $discode == "UMA" || $discode == "NWMSU" || $discode == "orick" || $discode == "ocph" ){
	$_SESSION["discode"] = "$discode";
	header("Location: sc_product_options_aa.php?ProID=fs");
}
if($discode == "friendly"){
	$_SESSION["discode"] = "$discode";
	$_SESSION["corporate_super_admin"] = "friendlycorp";
	header("Location: sc_product_list.php");
}
if($discode == "brass"){
	$_SESSION["discode"] = "$discode";
	$_SESSION["region"] = "brasstap";
	$_SESSION["corporate_super_admin"] = "familysports";
	header("Location: sc_product_list.php");
}
if($discode == "cali"){
	$_SESSION["discode"] = "$discode";
	header("Location: sc_product_options_aa.php?ProID=califsh");
}
if($discode == "tandt"){
	header("Location: fhstates.php");
}
if ($discode == "abp"){
	$_SESSION["UA"] = "abplink";
	header("Location: add_student_abp.asp");
}
if ($discode == "Marriott"){
	$_SESSION["corporate_super_admin"] = "marriott";
	header("Location: sc_products_m.asp");
}
if ($discode == "schefs"){
	header("Location: sc_product_list_schefs.asp");
}
if ($discode == "txfsh"){
	header("Location: sc_product_list_txfsh.asp");
}

else{
	echo "discode not found";
	echo "<br>";
	print_r($_SESSION);
}

?>