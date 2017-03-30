<?php
error_reporting(0); 

$NF = $_GET["NF"];
$NL = $_GET["NL"];
$NewUA = $_GET["NewUA"];
$UU = $_GET["UU"];
$NewPW = $_GET["NewPW"];
$NewSD = $_GET["NewSD"];
$NewExpDate = $_GET["NewExpDate"];
$id = $_GET["id"];

$NewSD = date("m/d/Y", strtotime($NewSD));
$NewExpDate = date("m/d/Y", strtotime($NewExpDate));

	echo "<div id='wrapper' >";
	echo "<br>";
	echo "<p style='text-align:center;margin-top:20px'><b>Congratulations you succesfully transferred the student to a new class!</b></p>";
	echo "<p style='text-align:center'>Student's Name: <b>$NF $NL</b></p>";
	echo "<p style='text-align:center'>New Class Section: <b>$NewUA</b></p>";
	echo "<p style='text-align:center'>Student's Username: <b>$UU</b></p>";
	echo "<p style='text-align:center'>Student's Password: <b>$NewPW</b></p>";
	echo "<p style='text-align:center'>New Start Date: <b>$NewSD</b></p>";
	echo "<p style='text-align:center'>New Expiration Date: <b>$NewExpDate</b></p>";
	echo "<p style='text-align:center'><a href='http://www.tapseries.com/jw/index.php'><button style='background-color:#004a91;color:white;border:none;width:200px;height:35px'>Reactivate another student</button></a></p>";
	echo "<p style='text-align:center'><a href='http://www.tapseries.com/jw/printreceipt.php?NF=$NF&NL=$NL&NewUA=$NewUA&UU=$UU&NewPW=$NewPW&NewSD=$NewSD&NewExpDate=$NewExpDate' target='_blank'><button style='background-color:#004a91;color:white;border:none;width:200px;height:35px'>Print</button></a></p>";
	echo "<p style='text-align:center'><a href='http://www.tapseries.com'><button style='background-color:#004a91;color:white;border:none;width:100px;height:35px'>Close</button></a></p>";
	echo "<br>";
	echo "</div>";
?>

<style>
#wrapper{
	width:600px;	
	border-radius:10px;
	margin:20px auto;
	background-color:#e8f1f5;
	height:auto;
}
body *{
	font-family: 'Open Sans', sans-serif;
}
body{
	background-color:#004a91;
}	
</style>


