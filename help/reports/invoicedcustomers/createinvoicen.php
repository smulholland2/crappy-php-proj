<?php
error_reporting(0); 


$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);


$acct = $_GET["acct"];
$course = $_GET["course"];
$price = $_GET["price"];
$count = $_GET["count"];
$total = $_GET["total"];
$company = $_GET["company"];
$startD = $_GET["startD"];
$endD = $_GET["endD"];

$acct2 = $_GET["acct2"];
$course2 = $_GET["course2"];
$price2 = $_GET["price2"];
$count2 = $_GET["count2"];
$total2 = $_GET["total2"];
$company2 = $_GET["company2"];

$acct3 = $_GET["acct3"];
$course3 = $_GET["course3"];
$price3 = $_GET["price3"];
$count3 = $_GET["count3"];
$total3 = $_GET["total3"];
$company3 = $_GET["company3"];

$acct4 = $_GET["acct4"];
$course4 = $_GET["course4"];
$price4 = $_GET["price4"];
$count4 = $_GET["count4"];
$total4 = $_GET["total4"];
$company4 = $_GET["company4"];

$acct5 = $_GET["acct5"];
$course5 = $_GET["course5"];
$price5 = $_GET["price5"];
$count5 = $_GET["count5"];
$total5 = $_GET["total5"];
$company5 = $_GET["company5"];

$acct6 = $_GET["acct6"];
$course6 = $_GET["course6"];
$price6 = $_GET["price6"];
$count6 = $_GET["count6"];
$total6 = $_GET["total6"];
$company6 = $_GET["company6"];

$acct7 = $_GET["acct7"];
$course7 = $_GET["course7"];
$price7 = $_GET["price7"];
$count7 = $_GET["count7"];
$total7 = $_GET["total7"];
$company7 = $_GET["company7"];

$acct8 = $_GET["acct8"];
$course8 = $_GET["course8"];
$price8 = $_GET["price8"];
$count8 = $_GET["count8"];
$total8 = $_GET["total8"];
$company8 = $_GET["company8"];

$acct9 = $_GET["acct9"];
$course9 = $_GET["course9"];
$price9 = $_GET["price9"];
$count9 = $_GET["count9"];
$total9 = $_GET["total9"];
$company9 = $_GET["company9"];

$acct10 = $_GET["acct10"];
$course10 = $_GET["course10"];
$price10 = $_GET["price10"];
$count10 = $_GET["count10"];
$total10 = $_GET["total10"];
$company10 = $_GET["company10"];

$acct11 = $_GET["acct11"];
$course11 = $_GET["course11"];
$price11 = $_GET["price11"];
$count11 = $_GET["count11"];
$total11 = $_GET["total11"];
$company11 = $_GET["company11"];

$acct12 = $_GET["acct12"];
$course12 = $_GET["course12"];
$price12 = $_GET["price12"];
$count12 = $_GET["count12"];
$total12 = $_GET["total12"];
$company12 = $_GET["company12"];

$acct13 = $_GET["acct13"];
$course13 = $_GET["course13"];
$price13 = $_GET["price13"];
$count13 = $_GET["count13"];
$total13 = $_GET["total13"];
$company13 = $_GET["company13"];

$acct14 = $_GET["acct14"];
$course14 = $_GET["course14"];
$price14 = $_GET["price14"];
$count14 = $_GET["count14"];
$total14 = $_GET["total14"];
$company14 = $_GET["company14"];

$acct15 = $_GET["acct15"];
$course15 = $_GET["course15"];
$price15 = $_GET["price15"];
$count15 = $_GET["count15"];
$total15 = $_GET["total15"];
$company15 = $_GET["company15"];

$acct16 = $_GET["acct16"];
$course16 = $_GET["course16"];
$price16 = $_GET["price16"];
$count16 = $_GET["count16"];
$total16 = $_GET["total16"];
$company16 = $_GET["company16"];

$acct17 = $_GET["acct17"];
$course17 = $_GET["course17"];
$price17 = $_GET["price17"];
$count17 = $_GET["count17"];
$total17 = $_GET["total17"];
$company17 = $_GET["company17"];

$acct18 = $_GET["acct18"];
$course18 = $_GET["course18"];
$price18 = $_GET["price18"];
$count18 = $_GET["count18"];
$total18 = $_GET["total18"];
$company18 = $_GET["company18"];


$date = date("m/d/Y");
$month = $_GET["month"];
$year = $_GET["year"];



$SQL77="SELECT * FROM Invoice2 WHERE UA='$acct' AND Month='$month' AND Year ='$year'";
$resultset77=mssql_query($SQL77, $con); 

	while ($row = mssql_fetch_array($resultset77)) 
			{
				$invoicenum = $row['InvoiceNum'];
			}

//$invoicenum= odbc_result($resultset77, InvoiceNum);




if(!empty($invoicenum)){
	echo "<p style='text-align:center'>You created an invoice for this month and year already</p>";
	echo "<a href='editordeleteinvoice.php?
	acct=$acct&course=$course&price=$price&count=$count&total=$total&invoicenum=$invoicenum&company=$company&month=$month&year=$year&
	acct2=$acct2&course2=$course2&price2=$price2&count2=$count2&total2=$total2&company2=$company2&
	acct3=$acct3&course3=$course3&price3=$price3&count3=$count3&total3=$total3&company3=$company3&
	acct4=$acct4&course4=$course4&price4=$price4&count4=$count4&total4=$total4&company4=$company4&
	acct5=$acct5&course5=$course5&price5=$price5&count5=$count5&total5=$total5&company5=$company5&
	acct6=$acct6&course6=$course6&price6=$price6&count6=$count6&total6=$total6&company6=$company6&
	acct7=$acct7&course7=$course7&price7=$price7&count7=$count7&total7=$total7&company7=$company7&
	acct8=$acct8&course8=$course8&price8=$price8&count8=$count8&total8=$total8&company8=$company8&
	acct9=$acct9&course9=$course9&price9=$price9&count9=$count9&total9=$total9&company9=$company9&
	acct10=$acct10&course10=$course10&price10=$price10&count10=$count10&total10=$total10&company10=$company10&
	acct11=$acct11&course11=$course11&price11=$price11&count11=$count11&total11=$total11&company11=$company11&
	acct12=$acct12&course12=$course12&price12=$price12&count12=$count12&total12=$total12&company12=$company12&
	acct13=$acct13&course13=$course13&price13=$price13&count13=$count13&total13=$total13&company13=$company13&
	acct14=$acct14&course14=$course14&price14=$price14&count14=$count14&total14=$total14&company14=$company14&
	acct15=$acct15&course15=$course15&price15=$price15&count15=$count15&total15=$total15&company15=$company15&
	acct16=$acct16&course16=$course16&price16=$price16&count16=$count16&total16=$total16&company16=$company16&
	acct17=$acct17&course17=$course17&price17=$price17&count17=$count17&total17=$total17&company17=$company17&
	acct18=$acct18&course18=$course18&price18=$price18&count18=$count18&total18=$total18&company18=$company18'>
	<p style='text-align:center'><button>Click here to resend email or delete invoice</button></p></a>";
	
	echo "<p style='text-align:center'><a href='results.html'><button>Go Back</button></a></p>";
}




else{
	

if($month == '' or $year == ''){
	echo "<p style='color:red;text-align:center'>Please go back and enter a month and year</p>";
	
}

	else{
		
			if($total!=0){
			$SQL = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct','$course','$price','$count','$total','$month','$year','no')";			
			$resultset=mssql_query($SQL, $con); 
			}			
			if($total2!=0){
			$SQL2 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct2','$course2','$price2','$count2','$total2','$month','$year','no')";			
			$resultset2=mssql_query($SQL2, $con); 
			}
			if($total3!=0){
			$SQL3 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct3','$course3','$price3','$count3','$total3','$month','$year','no')";			
			$resultset3=mssql_query($SQL3, $con); 
			}
			if($total4!=0){
			$SQL4 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct4','$course4','$price4','$count4','$total4','$month','$year','no')";			
			$resultset4=mssql_query($SQL4, $con); 		
			}
			if($total5!=0){
			$SQL5 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct5','$course5','$price5','$count5','$total5','$month','$year','no')";			
			$resultset5=mssql_query($SQL5, $con); 		
			}
			if($total6!=0){
			$SQL6 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct6','$course6','$price6','$count6','$total6','$month','$year','no')";			
			$resultset6=mssql_query($SQL6, $con); 		
			}
			if($total7!=0){
			$SQL7 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct7','$course7','$price7','$count7','$total7','$month','$year','no')";			
			$resultset7=mssql_query($SQL7, $con); 		
			}
			if($total8!=0){
			$SQL8 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct8','$course8','$price8','$count8','$total8','$month','$year','no')";			
			$resultset8=mssql_query($SQL8, $con); 		
			}
			if($total9!=0){
			$SQL9 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct9','$course9','$price9','$count9','$total9','$month','$year','no')";			
			$resultset9=mssql_query($SQL9, $con); 		
			}
			if($total10!=0){
			$SQL10 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct10','$course10','$price10','$count10','$total10','$month','$year','no')";			
			$resultset10=mssql_query($SQL10, $con); 		
			}
			if($total11!=0){
			$SQL11 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct11','$course11','$price11','$count11','$total11','$month','$year','no')";			
			$resultset11=mssql_query($SQL11, $con); 		
			}
			if($total12!=0){
			$SQL12 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct12','$course12','$price12','$count12','$total12','$month','$year','no')";			
			$resultset12=mssql_query($SQL12, $con); 		
			}
			if($total13!=0){
			$SQL13 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct13','$course13','$price13','$count13','$total13','$month','$year','no')";			
			$resultset13=mssql_query($SQL13, $con); 		
			}
			if($total14!=0){
			$SQL14 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct14','$course14','$price14','$count14','$total14','$month','$year','no')";			
			$resultset14=mssql_query($SQL14, $con); 		
			}
			if($total15!=0){
			$SQL15 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct15','$course15','$price15','$count15','$total15','$month','$year','no')";			
			$resultset15=mssql_query($SQL15, $con); 		
			}
			if($total16!=0){
			$SQL16 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct16','$course16','$price16','$count16','$total16','$month','$year','no')";			
			$resultset16=mssql_query($SQL16, $con); 		
			}
			if($total17!=0){
			$SQL17 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct17','$course17','$price17','$count17','$total17','$month','$year','no')";			
			$resultset17=mssql_query($SQL17, $con); 		
			}
			if($total18!=0){
			$SQL18 = "INSERT INTO Invoice2 (Date,UA,Course,Price,Qty,Total,Month,Year,Paid)
			VALUES ('$date','$acct18','$course18','$price18','$count18','$total18','$month','$year','no')";			
			$resultset18=mssql_query($SQL18, $con); 		
			}
			
			
			$SQLINV="SELECT * FROM Invoice2 
			WHERE UA='$acct'
			AND Month='$month' AND Year ='$year'
			ORDER BY InvoiceNum ASC ";
			$resultsetINV=mssql_query($SQLINV, $con); 	
			
			while ($row = mssql_fetch_array($resultsetINV)) 
			{
				 $invoicenum = $row['InvoiceNum'];
			}
			


			header("Location: invoicesender.php?acct=$acct&course=$course&price=$price&count=$count&total=$total&invoicenum=$invoicenum&company=$company&month=$month&year=$year&acct2=$acct2&course2=$course2&price2=$price2&count2=$count2&total2=$total2&company2=$company2&acct3=$acct3&course3=$course3&price3=$price3&count3=$count3&total3=$total3&company3=$company3&acct4=$acct4&course4=$course4&price4=$price4&count4=$count4&total4=$total4&company4=$company4&acct5=$acct5&course5=$course5&price5=$price5&count5=$count5&total5=$total5&company5=$company5&acct6=$acct6&course6=$course6&price6=$price6&count6=$count6&total6=$total6&company6=$company6&acct7=$acct7&course7=$course7&price7=$price7&count7=$count7&total7=$total7&company7=$company7&acct8=$acct8&course8=$course8&price8=$price8&count8=$count8&total8=$total8&company8=$company8&acct9=$acct9&course9=$course9&price9=$price9&count9=$count9&total9=$total9&company9=$company9&acct10=$acct10&course10=$course10&price10=$price10&count10=$count10&total10=$total10&company10=$company10&acct11=$acct11&course11=$course11&price11=$price11&count11=$count11&total11=$total11&company11=$company11&acct12=$acct12&course12=$course12&price12=$price12&count12=$count12&total12=$total12&company12=$company12&acct13=$acct13&course13=$course13&price13=$price13&count13=$count13&total13=$total13&company13=$company13&acct14=$acct14&course14=$course14&price14=$price14&count14=$count14&total14=$total14&company14=$company14&acct15=$acct15&course15=$course15&price15=$price15&count15=$count15&total15=$total15&company15=$company15&acct16=$acct16&course16=$course16&price16=$price16&count16=$count16&total16=$total16&company16=$company16&acct17=$acct17&course17=$course17&price17=$price17&count17=$count17&total17=$total17&company17=$company17&acct18=$acct18&course18=$course18&price18=$price18&count18=$count18&total18=$total18&company18=$company18");		
			//header("Location: invoicesender.php");		

	}
}



?>