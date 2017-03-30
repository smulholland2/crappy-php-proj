<?php
error_reporting(0);

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);

$invoicenum = $_GET["invoicenum"];
$month = $_GET["month"];
$year = $_GET["year"];
$emailx = $_GET["emailx"];
$comment1 = $_GET["comment1"];
$comment2 = $_GET["comment2"];
$comment3 = $_GET["comment3"];

$acct = $_GET["acct"];
$course = $_GET["course"];
$price = $_GET["price"];
$count = $_GET["count"];
$total = $_GET["total"];
$company = $_GET["company"];

$course2 = $_GET["course2"];
$price2 = $_GET["price2"];
$count2 = $_GET["count2"];
$total2 = $_GET["total2"];
$company2 = $_GET["company2"];

$course3 = $_GET["course3"];
$price3 = $_GET["price3"];
$count3 = $_GET["count3"];
$total3 = $_GET["total3"];
$company3 = $_GET["company3"];

$course4 = $_GET["course4"];
$price4 = $_GET["price4"];
$count4 = $_GET["count4"];
$total4 = $_GET["total4"];
$company4 = $_GET["company4"];

$course5 = $_GET["course5"];
$price5 = $_GET["price5"];
$count5 = $_GET["count5"];
$total5 = $_GET["total5"];
$company5 = $_GET["company5"];

$course6 = $_GET["course6"];
$price6 = $_GET["price6"];
$count6 = $_GET["count6"];
$total6 = $_GET["total6"];
$company6 = $_GET["company6"];

$course7 = $_GET["course7"];
$price7 = $_GET["price7"];
$count7 = $_GET["count7"];
$total7 = $_GET["total7"];
$company7 = $_GET["company7"];

$course8 = $_GET["course8"];
$price8 = $_GET["price8"];
$count8 = $_GET["count8"];
$total8 = $_GET["total8"];
$company8 = $_GET["company8"];

$course9 = $_GET["course9"];
$price9 = $_GET["price9"];
$count9 = $_GET["count9"];
$total9 = $_GET["total9"];
$company9 = $_GET["company9"];

$course10 = $_GET["course10"];
$price10 = $_GET["price10"];
$count10 = $_GET["count10"];
$total10 = $_GET["total10"];
$company10 = $_GET["company10"];

$course11 = $_GET["course11"];
$price11 = $_GET["price11"];
$count11 = $_GET["count11"];
$total11 = $_GET["total11"];
$company11 = $_GET["company11"];

$course12 = $_GET["course12"];
$price12 = $_GET["price12"];
$count12 = $_GET["count12"];
$total12 = $_GET["total12"];
$company12 = $_GET["company12"];

$course13 = $_GET["course13"];
$price13 = $_GET["price13"];
$count13 = $_GET["count13"];
$total13 = $_GET["total13"];
$company13 = $_GET["company13"];

$course14 = $_GET["course14"];
$price14 = $_GET["price14"];
$count14 = $_GET["count14"];
$total14 = $_GET["total14"];
$company14 = $_GET["company14"];

$course15 = $_GET["course15"];
$price15 = $_GET["price15"];
$count15 = $_GET["count15"];
$total15 = $_GET["total15"];
$company15 = $_GET["company15"];

$course16 = $_GET["course16"];
$price16 = $_GET["price16"];
$count16 = $_GET["count16"];
$total16 = $_GET["total16"];
$company16 = $_GET["company16"];

$course17 = $_GET["course17"];
$price17 = $_GET["price17"];
$count17 = $_GET["count17"];
$total17 = $_GET["total17"];
$company17 = $_GET["company17"];

$course18 = $_GET["course18"];
$price18 = $_GET["price18"];
$count18 = $_GET["count18"];
$total18 = $_GET["total18"];
$company18 = $_GET["company18"];


$truetotal= $total +$total2 +$total3 +$total4 +$total5 +$total6 +$total7 +$total8 +$total9 +$total10 +$total11 +$total12 +$total13 +$total14 +$total15 +$total16 +$total17 +$total18; 
$english_format_number = number_format($truetotal, 2, '.', '');


$SQL="UPDATE Invoice2
		SET Paid='email'
		WHERE UA='$acct' AND Month = '$month' AND Year = '$year' ";
		$resultset=mssql_query($SQL, $con); 


$SQL3="UPDATE Invoice2
	   SET comment1='$comment1', comment2='$comment2', comment3='$comment3'
	   WHERE UA='$acct' AND Month = '$month' AND Year = '$year' AND InvoiceNum = '$invoicenum' ";
		$resultset3=mssql_query($SQL3, $con); 
			

$emailinfo="$acct|$course|$price|$total|$invoicenum|$company|$month|$year|$total2|$company2|$total3|$company3|$total4|$company4|$total5|$company5|$total6|$company6|$total7|$company7|$total8|$company8|$total9|$company9|$total10|$company10|$total11|$company11|$total12|$company12|$total13|$company13|$total14|$company14|$total15|$company15|$total16|$company16|$total17|$company17|$total18|$company18";


$to = $emailx;
         $subject = "TAP Series Invoice";
         
         $message = "<p style='text-align:center;font-size:30px;font-family:Verdana, Geneva, sans-serif'>Thank you for your Business!</p>";
		 
         $message .= "<p style='font-family:Verdana, Geneva, sans-serif'>Your current TAP Series invoice is available.<br>If you have any questions, give us a call Monday through Friday, between the hours of 8:00AM and 5:30PM Pacific Time at 1-888-826-5222 or email us anytime at info@tapseries.com.</p>";
         
		 $message .= "<p style='font-family:Verdana, Geneva, sans-serif'>We appreciate you and your business!</p>";
		 
         $message .= "<p style='font-family:Verdana, Geneva, sans-serif'>Invoice Number: $invoicenum <br>Amount Due: $ $english_format_number </p>";
		 		 
         $message .= "<a href='http://www.tapseries.com/invoicedcustomers/viewinvoiceandpay.php?emailinfo=$emailinfo'> View Invoice </a>";
		 //$message .= "<br><br>";
		 
         //$message .= "<a href='http://www.tapseries.xyz/invoicedcustomers/viewinvoiceandpay.php?emailinfo=$emailinfo'>Pay Now</a>";
         
        $header = "From:techsupport@tapseries.com \r\n";
        $header .= "Cc:sk@tapseries.com \r\n";
        $header .= "Cc:mg@tapseries.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
		 
		 echo "<p style='text-align:center;margin-top:50px'>The email was sent to  $emailx, every time you refresh the page the email will be re-sent</p>";
		 
		 echo "<p style='text-align:center'><a href='results.html'><button>Go back to the report</button></a></p>";

	 
		
		 
 ?>