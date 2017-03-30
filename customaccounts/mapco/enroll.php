<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/Mailer.php';
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

error_reporting(0); 
session_start();
$UA = $_SESSION["account_username"];
$todaytime = date("Y-m-d");

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];
$lang = $_POST["lang"];

//check if the username exists on 01D
$SQL = "SELECT UU FROM [01D] WHERE UU=".mssql_escape($username)." ";
$resultset=mssql_query($SQL, $con);
while ($row = mssql_fetch_array($resultset)) 
{
    $UU_check = $row['UU'];
}

if($UU_check){
    $_SESSION["firstname"] = $firstname;
    $_SESSION["lastname"] = $lastname;
    $_SESSION["email"] = $email;
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
    $_SESSION["lang"] = $lang;
    $_SESSION["usernametaken"] = 1;
    header('Location: index.php');
    die;
}

//get training days from databse
$SQL2="SELECT TRAIN_PERIOD FROM [07L3] WHERE AN='$UA' ";
$resultset2=mssql_query($SQL2, $con);
while ($row = mssql_fetch_array($resultset2)) 
{
    $TRAIN_PERIOD = $row['TRAIN_PERIOD'];
}

//calculate expiration date
$expDate = date('Y-m-d', strtotime($todaytime . " + $TRAIN_PERIOD day"));



// insert the student information to the databse 01D and 01S
if($lang=='SPANISH'){
    $FSversion = 'FS8';
}
else{
    $FSversion = 'FS9';
}

$SQL96 = " INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, DATE_EXPIRE, VER) 
           VALUES (".mssql_escape($username).", ".mssql_escape($UA).", ".mssql_escape($password).", ".mssql_escape($firstname).", ".mssql_escape($lastname).", '1', '$lang', '0', '$todaytime', '$email', '$expDate', '$FSversion') ";
$resultset96=mssql_query($SQL96, $con);

$SQL95 = " INSERT INTO [01S] (UU) 
           VALUES (".mssql_escape($username).") ";
$resultset95=mssql_query($SQL95, $con);


//if student typed in an email address, send email to student
if($email){

//email starts
$from = "info@tapseries.com";
$subject = "TAP Series Login Information";
$cc_address = "dp@tapseries.com";
$body = "<span>To start the course, go to <a href='https://www.tapseries.com/'>www.tapseries.com</a></span><br>";
$body .= "<span>Click Login To Course</span><br>";	
$body .= "<span>Enter your username: $username, then your password: $password</span><br>";	
$body .= "<br>";	
$body .= "<span>For technical support, please call 818-889-8799</span><br>";			
$body .= "<span>After hours technical support (8am-8pm Pacific time): 818-809-3762</span><br>";

$smtp = new smtp_class;
$smtp->host_name = 'smtp.gmail.com'; // Google mail host.
$smtp->host_port = 465; // Secure port.
$smtp->ssl = 1;
$smtp->start_tls = 0;
$smtp->localhost = 'tapseries.com';
$smtp->direct_delivery = 0;
$smtp->timeout = 10;
$smtp->data_timeout = 0;
$smtp->debug = 0;
$smtp->html_debug = 0;
$smtp->user = 'info@tapseries.com'; // Or orders@tapseries.com
$smtp->password = 'Training0nline!'; // refer to salesforce or sticky note

// Create a new array.
$recipients = [];
// Push your $email address to the array.
array_push($recipients,$email);

$headers = [];
array_push($headers,"Subject: ". $subject);
array_push($headers,"To: " . $email);
array_push($headers,"Cc: " . $cc_address);
array_push($headers,"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z"));
array_push($headers, "Content-Type: text/html; charset=ISO-8859-1");
// If you are going to send the email to more than one person, 
// $to will need to be an array of the email addresses you want to send.
$sent = $smtp->SendMessage($from, $recipients, $headers, $body); // This sends the email.
/*
if(!$sent)
    die($smtp -> error);
*/
//email ends

}	



// Converts user $_POST data to hexidecimal values that MS SQL Server
// natively converts back to its original value. This is to prevent
// SQL injection and should be used on every $_POST variable in the system.
// Returns a hexidecimal number or int.
function mssql_escape($data)
{
    if(is_numeric($data))
    return "'".$data."'";
    $unpacked = unpack('H*hex', $data);
    return '0x' . $unpacked['hex'];
}

//send student to the congratulations page after the student is added
header("Location: congratulations.php?username=$username");

?>