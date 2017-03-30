<?php
error_reporting(0); 

$message = $_GET["message"];
$UA = $_GET["UA"];

if($message=="NORMALmessage"){
	$message="The student was successfully deleted and a license has been added to your account.";
}
if($message=="SUBmessage"){
	$message="The student was successfully deleted";
}

echo "
	<div id='wrapper'>
	<p style='text-align:center'>$message</p>
	<p style='text-align:center'><a href='main.php?acctname=$UA'><button>Go Back</button></a></p>
	</div>
";

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<style>
body{
font-family: 'Open Sans', sans-serif;
background-color: #004a91;
}

#wrapper{
max-width:700px;
height:auto;
border:1px solid transparent;
border-radius:10px;
margin:50px auto;
background-color:white;
}	
	
</style>
	

</head>
<body>

</body>
</html>
