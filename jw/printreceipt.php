<?php
error_reporting(0); 

$NF = $_GET["NF"];
$NL = $_GET["NL"];
$NewUA = $_GET["NewUA"];
$UU = $_GET["UU"];
$NewPW = $_GET["NewPW"];
$NewSD = $_GET["NewSD"];
$NewExpDate = $_GET["NewExpDate"];


	echo "<p style='text-align:center;margin-top:20px'><b>Transfer Confirmation</b></p>";
	echo "<p style='text-align:center'>Student's Name: <b>$NF $NL</b></p>";
	echo "<p style='text-align:center'>New Class Section: <b>$NewUA</b></p>";
	echo "<p style='text-align:center'>Student's Username: <b>$UU</b></p>";
	echo "<p style='text-align:center'>Student's Password: <b>$NewPW</b></p>";
	echo "<p style='text-align:center'>New Start Date: <b>$NewSD</b></p>";
	echo "<p style='text-align:center'>New Expiration Date: <b>$NewExpDate</b></p>";

?>
<style>
body *{
	font-family: 'Open Sans', sans-serif;
}
</style>
<script>
function myFunction() {
    window.print();
}
myFunction();	
</script>
