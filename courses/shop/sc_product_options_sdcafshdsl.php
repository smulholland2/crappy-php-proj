<?php
$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
   
// Connect to the database (host, username, password)
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 
session_start();
$discode=$_SESSION["discode"];
	//set discode to tapseries if discode is empty
if($discode == '')
{
	$SQL = "SELECT [01SDEC]  FROM [07SL1] WHERE VC = 'tapseries' ";				
	$resultset=mssql_query($SQL, $con); 	
	
		while ($row = mssql_fetch_array($resultset)) 
		{
		     $ProPrice = $row['01SDEC'];
		}    
}
		//if discode is not empty get specific ProPrice from database
else
{
	$SQL2 = "SELECT [01SDEC]  FROM [07SL1] WHERE VC = '$discode' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	
		while ($row = mssql_fetch_array($resultset2)) 
		{
		     $ProPrice = $row['01SDEC'];
		}  
}
if($ProPrice == '')
{
	$SQL = "SELECT [01SDEC]  FROM [07SL1] WHERE VC = 'tapseries' ";				
	$resultset=mssql_query($SQL, $con); 	
		while ($row = mssql_fetch_array($resultset)) 
		{
		     $ProPrice = $row['01SDEC'];
		}  
	
}
$ProPrice = number_format($ProPrice,2);
?>





<!DOCTYPE html>
<html>
<head>
<title>San Diego Food Handler</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans" />
<style>
body{
	background-color:#1E2B41;
	font-family: 'Open Sans', sans-serif;  
	font-size:20px;
}
#wrapper{
	max-width:1000px;
	height:auto;
	border:1px solid white;
	background-color:white;
	margin:auto;
	border-radius:5px;
}
button{
	background-color:#31b0d5;
	border:3px solid #2aabd2;
	color:white;
	font-size:25px;
	font-weight:bold;
	cursor:pointer;
	border-radius:3px;
}
 img{
	 max-width:100%;
	 border-radius:3px;
 }
</style>
</head>
<body>

<div id="wrapper">

<h2 style="text-align:center;color:#1E2B41">San Diego Food Handler</h2>
<p style="text-align:center"><img src="../images/califsh.png"></p>

<form method="get" action="sc_shopping_cart.php">
	<input type="hidden" name="Qty" value="1">
	<input type="hidden" name="ProName" value="San Diego Food Handler">
	<input type="hidden" name="ProID" value="casd">
	<input type="hidden" name="ProPrice" value="<?php echo $ProPrice; ?>">
	<p style="text-align:center"><button tyle="submit">Buy Now</button></p>
</form>

<p style="margin-left:20px"><strong>Course:</strong> San Diego Food Handler</p>
<p style="margin-left:20px"><strong>Price:</strong> $<?php  echo $ProPrice; ?></p>
<p style="margin-left:20px"><strong>Certificate Valid for:</strong> 3 years</p>
<p style="margin-left:20px"><strong>Approximate Time:</strong> 1.5-2 hours</p>
<p style="margin-left:20px"><strong>Compatible with:</strong> PCs, Macs, tablets and smartphones.</p>
<p style="margin-left:20px;margin-right:20px"><strong>Description:</strong> Add description.</p>

<br>
<p style="text-align:center"><strong>Copyright &#169; TAP Series, LLC <br><a style="text-decoration:none" href="https://www.tapseries.com/privacy">Privacy Policy</a></strong></p>
</div>
<br>
</body>
</html>
