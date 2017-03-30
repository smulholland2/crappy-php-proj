<?php
error_reporting(0); 


$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);


$emailinfo = $_GET["emailinfo"];

$emailinfoparts = explode("|", $emailinfo);
$acct = $emailinfoparts[0];	//acct
$course = $emailinfoparts[1];	//course
$price = $emailinfoparts[2];	//price
$total = $emailinfoparts[3];	//total
$invoicenum = $emailinfoparts[4];	//invoicenum
$company = $emailinfoparts[5];	//company
$month = $emailinfoparts[6];	//month
$year = $emailinfoparts[7];	//year
$total2 = $emailinfoparts[8];	//total2
$company2 = $emailinfoparts[9];	//company2
$total3 = $emailinfoparts[10];	//total3
$company3 = $emailinfoparts[11];	//company3
$total4 = $emailinfoparts[12];	//total4
$company4 = $emailinfoparts[13];	//company4
$total5 = $emailinfoparts[14];	//total5
$company5 = $emailinfoparts[15];	//company5
$total6 = $emailinfoparts[16];	//total6
$company6 = $emailinfoparts[17];	//company6
$total7 = $emailinfoparts[18];	//total7
$company7 = $emailinfoparts[19];	//company7
$total8 = $emailinfoparts[20];	//total8
$company8 = $emailinfoparts[21];	//company8
$total9 = $emailinfoparts[22];	//total9
$company9 = $emailinfoparts[23];	//company9
$total10 = $emailinfoparts[24];	//total10
$company10 = $emailinfoparts[25];	//company10
$total11 = $emailinfoparts[26];	//total11
$company11 = $emailinfoparts[27];	//company11
$total12 = $emailinfoparts[28];	//total12
$company12 = $emailinfoparts[29];	//company12
$total13 = $emailinfoparts[30];	//total13
$company13 = $emailinfoparts[31];	//company13
$total14 = $emailinfoparts[32];	//total14
$company14 = $emailinfoparts[33];	//company14
$total15 = $emailinfoparts[34];	//total15
$company15 = $emailinfoparts[35];	//company15
$total16 = $emailinfoparts[36];	//total16
$company16 = $emailinfoparts[37];	//company16
$total17 = $emailinfoparts[38];	//total17
$company17 = $emailinfoparts[39];	//company17
$total18 = $emailinfoparts[40];	//total18
$company18 = $emailinfoparts[41];	//company18




if($total == '' or $total == 0){
	$total=0;
	$visi = false;
}
else {$visi = true;}

if($total2 == '' or $total2 == 0){
	$total2=0;
	$visi2 = false;
}
else {$visi2 = true;}

if($total3 == '' or $total3 == 0){
	$total3=0;
	$visi3 = false;
}
else {$visi3 = true;}

if($total4 == '' or $total4 == 0){
	$total4=0;
	$visi4 = false;
}
else {$visi4 = true;}

if($total5 == '' or $total5 == 0){
	$total5=0;
	$visi5 = false;
}
else {$visi5 = true;}

if($total6 == '' or $total6 == 0){
	$total6=0;
	$visi6 = false;
}
else {$visi6 = true;}

if($total7 == '' or $total7 == 0){
	$total7=0;
	$visi7 = false;
}
else {$visi7 = true;}

if($total8 == '' or $total8 == 0){
	$total8=0;
	$visi8 = false;
}
else {$visi8 = true;}

if($total9 == '' or $total9 == 0){
	$total9=0;
	$visi9 = false;
}
else {$visi9 = true;}

if($total10 == '' or $total10 == 0){
	$total10=0;
	$visi10 = false;
}
else {$visi10 = true;}

if($total11 == '' or $total11 == 0){
	$total11=0;
	$visi11 = false;
}
else {$visi11 = true;}

if($total12 == '' or $total12 == 0){
	$total12=0;
	$visi12 = false;
}
else {$visi12 = true;}

if($total13 == '' or $total13 == 0){
	$total13=0;
	$visi13 = false;
}
else {$visi13 = true;}

if($total14 == '' or $total14 == 0){
	$total14=0;
	$visi14 = false;
}
else {$visi14 = true;}

if($total15 == '' or $total15 == 0){
	$total15=0;
	$visi15 = false;
}
else {$visi15 = true;}

if($total16 == '' or $total16 == 0){
	$total16=0;
	$visi16 = false;
}
else {$visi16 = true;}

if($total17 == '' or $total17 == 0){
	$total17=0;
	$visi17 = false;
}
else {$visi17 = true;}

if($total18 == '' or $total18 == 0){
	$total18=0;
	$visi18 = false;
}
else {$visi18 = true;}




// *********************** KEEP AN EYE ON ANY NAME THAT HAS A SPECIAL CHARACTER	*********************

if($company == 'Barnes and Noble' or $company == 'Barnes '){
	$company = 'Barnes & Noble';
}

if($month == 'JANUARY'){
	$invoicedate = 'February 1';
	$duedate = 'February 29';
}
if($month == 'FEBRUARY'){
	$invoicedate = 'March 1';
	$duedate = 'March 30';
}
if($month == 'MARCH'){
	$invoicedate = 'April 1';
	$duedate = 'April 30';
}
if($month == 'APRIL'){
	$invoicedate = 'May 1';
	$duedate = 'May 30';
}
if($month == 'MAY'){
	$invoicedate = 'June 1';
	$duedate = 'June 30';
}
if($month == 'JUNE'){
	$invoicedate = 'July 1';
	$duedate = 'July 30';
}
if($month == 'JULY'){
	$invoicedate = 'August 1';
	$duedate = 'August 30';
}
if($month == 'AUGUST'){
	$invoicedate = 'September 1';
	$duedate = 'September 30';
}
if($month == 'SEPTEMBER'){
	$invoicedate = 'October 1';
	$duedate = 'October 30';
}
if($month == 'OCTOBER'){
	$invoicedate = 'November 1';
	$duedate = 'November 30';
}
if($month == 'NOVEMBER'){
	$invoicedate = 'December 1';
	$duedate = 'December 31';
}
if($month == 'DECEMBER'){
	$invoicedate = 'January 1';
	$duedate = 'January 30';
}


$truetotal= $total +$total2 +$total3 +$total4 +$total5 +$total6 +$total7 +$total8 +$total9 +$total10 +$total11 +$total12 +$total13 +$total14 +$total15 +$total16 +$total17 +$total18; 



if($invoicenum == ''){
	$invoicenum = 'N/A';
}

//checks if invoice number exists, just in case we create a new one
$SQL100 = "SELECT *  FROM Invoice2	WHERE InvoiceNum = '$invoicenum' ";				
$resultset100=mssql_query($SQL100, $con); 

		while ($row = mssql_fetch_array($resultset100)) 
		{
			$CheckInvoiceNum = $row['InvoiceNum'];
		}
//$CheckInvoiceNum= odbc_result($resultset100, "InvoiceNum");

if($CheckInvoiceNum == ""){
	header( "Location: noinvoice.php" );
}

else{


$SQL = "SELECT *  FROM [07DS2]	WHERE ProID = '$course' ";				
$resultset=mssql_query($SQL, $con); 
		while ($row = mssql_fetch_array($resultset)) 
		{
			$ProductName = $row['ProductName'];
		}
	
//$ProductName= odbc_result($resultset, "ProductName");

//GETS THE INFOR FOR CSUB ACCOUNTS
$SQL2 = "SELECT *  FROM [07L2]	WHERE UU = '$acct' ";	
$resultset2=mssql_query($SQL2, $con);	
	
		while ($row = mssql_fetch_array($resultset2)) 
		{
			$UM = $row['UM'];
			$NF = $row['NF'];
			$NL = $row['NL'];
			$companyrealname = $row['UA'];
			$AA1 = $row['AA1'];
			$AA2 = $row['AA2'];
			$ACI = $row['ACI'];
			$AST = $row['AST'];
			$AZ = $row['AZ'];
			$ACO = $row['ACO'];
		}
	
//$UM= odbc_result($resultset2, "UM");	
//$NF= odbc_result($resultset2, "NF");	
//$NL= odbc_result($resultset2, "NL");	
//$companyrealname= odbc_result($resultset2, "UA");	
//$AA1= odbc_result($resultset2, "AA1");	
//$AA2= odbc_result($resultset2, "AA2");	
//$ACI= odbc_result($resultset2, "ACI");	
//$AST= odbc_result($resultset2, "AST");	
//$AZ= odbc_result($resultset2, "AZ");	
//$ACO= odbc_result($resultset2, "ACO");	


//GETS THE INFO FOR SUB ACCOUNTS
if ($companyrealname == ''){
	$SQL3 = "SELECT *  FROM [07O6]	WHERE AN = '$acct' ";				
	$resultset3=mssql_query($SQL3, $con); 
	
		while ($row = mssql_fetch_array($resultset3)) 
		{
			$UM = $row['AM'];
			$NF = $row['NF'];
			$NL = $row['NL'];
			$companyrealname = $row['NCPY'];
			$AA1 = $row['AA1'];
			$AA2 = $row['AA2'];
			$ACI = $row['ACI'];
			$AST = $row['AST'];
			$AZ = $row['AZ'];
			$ACO = $row['ACO'];
		}
	
	
	//$UM= odbc_result($resultset3, "AM");	
	//$NF= odbc_result($resultset3, "NF");	
	//$NL= odbc_result($resultset3, "NL");
	//$companyrealname= odbc_result($resultset3, "NCPY");	
	//$AA1= odbc_result($resultset3, "AA1");	
	//$AA2= odbc_result($resultset3, "AA2");	
	//$ACI= odbc_result($resultset3, "ACI");	
	//$AST= odbc_result($resultset3, "AST");	
	//$AZ= odbc_result($resultset3, "AZ");	
	//$ACO= odbc_result($resultset3, "ACO");	
}

if($companyrealname == 'Peninsula Petroleum'){
	$companyrealname = 'Humboldt Petroleum Inc';
}

$SQL4 = "SELECT * FROM Invoice2 WHERE InvoiceNum = $invoicenum ";	
		$resultset4=mssql_query($SQL4, $con); 	
		
		while ($row = mssql_fetch_array($resultset4)) 
		{
			$paid = $row['Paid'];
			$comment1 = $row['comment1'];
			$comment2 = $row['comment2'];
			$comment3 = $row['comment3'];

		}
	
		//$paid= odbc_result($resultset4, "Paid");	
		//$comment1= odbc_result($resultset4, "comment1");	
		//$comment2= odbc_result($resultset4, "comment2");	
		//$comment3= odbc_result($resultset4, "comment3");	
		
		if($paid == 'yes'){
			$paidbtn = false;
		}
		else {
			$paidbtn = true;
		}
		
		
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Pay Invoice</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
	<script src='scripts/results<?php echo $month;?><?php echo $year;?>.js'></script>

</head>
<body ng-app="myApp" ng-controller="customersCtrl">




<div id="wrapper" style="margin-top:50px">
<br>
<h1 ><span style="font-size:18px;margin-left:20px;float:left">TAP Series</span>
<span style="font-size:18px;float:right;margin-right:20px">Invoice  <?php echo $invoicenum; ?> </span></h1>
<br><br>

<div id="dateandaddress">
<div id="tapaddress" style="float:left;border:1px solid transparent">
<p>5655 Lindero Canyon Rd., Suit 501 <br>Westlake Village, CA 91362 <br>(888) 826-5222</p>
</div>

<div id="dateinvoice" style="float:right;border:1px solid transparent;margin-top:13px">
<table>
  <tr>
    <td>Invoice Date</td>
	<td>Billing Period</td>
    <td>Invoice #</td> 
  </tr>
  <tr>
    <!--<td><?php echo $invoicedate . ", " .$year; ?></td>-->
    <td><?php echo $invoicedate . ", 2017"; ?></td>
	<td> {{names[0].StartDate}} - {{names[0].EndDate}} </td>
    <td><?php echo $invoicenum; ?></td> 
  </tr>
</table>

</div>
</div>


<div id="address">
<div id="billto">
<div id="billtitle" style="width:100%;border-bottom:1px solid black">
<span>&nbsp;&nbsp;&nbsp;Bill to</span>
</div>
<br>
<span>&nbsp;&nbsp;&nbsp;<?php echo $companyrealname; ?></span>
<br>
<span>&nbsp;&nbsp;&nbsp;<?php echo $AA1 . " " . $AA2; ?></span>
<br>
<span>&nbsp;&nbsp;&nbsp;<?php echo $ACI . ", " . $AST . " " . $AZ ;?></span>
<br>
<span>&nbsp;&nbsp;&nbsp;<?php echo $ACO; ?></span>

</div>

<div id="info">
<table style="float:right">
  <tr>
    <td>Due Date</td> 
  </tr>
  <tr>
    <!--<td><?php echo $duedate . ", " .$year; ?></td> -->
    <td><?php echo $duedate . ", 2017"; ?></td> 
  </tr>
</table>
</div>
</div>


<br><br>

<table class="table table-hover" style="width:560px; margin:auto">
		<tr>
			<th style="width:auto">Region</th>
			<th>Unit Admin</th>
			<th style="width:30px">Course</th>
			<th style="width:50px">Price Each</th>
			<th style="width:50px">Quantity</th>				
			<th >Amount</th>				
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company; ?>' | unique:'Account'" ng-show="<?php echo $visi; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company; ?>')* s.RevenueShare | currency}}</td>			
		</tr>				
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company2; ?>' | unique:'Account'" ng-show="<?php echo $visi2; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company2; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company2; ?>')* s.RevenueShare | currency}}</td>			
		</tr>				
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company3; ?>' | unique:'Account'" ng-show="<?php echo $visi3; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company3; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company3; ?>')* s.RevenueShare | currency}}</td>			
		</tr>			
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company4; ?>' | unique:'Account'" ng-show="<?php echo $visi4; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company4; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company4; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company5; ?>' | unique:'Account'" ng-show="<?php echo $visi5; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company5; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company5; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company6; ?>' | unique:'Account'" ng-show="<?php echo $visi6; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company6; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company6; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company7; ?>' | unique:'Account'" ng-show="<?php echo $visi7; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company7; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company7; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company8; ?>' | unique:'Account'" ng-show="<?php echo $visi8; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company8; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company8; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company9; ?>' | unique:'Account'" ng-show="<?php echo $visi9; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company9; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company9; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company10; ?>' | unique:'Account'" ng-show="<?php echo $visi10; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company10; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company10; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company11; ?>' | unique:'Account'" ng-show="<?php echo $visi11; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company11; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company11; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company12; ?>' | unique:'Account'" ng-show="<?php echo $visi12; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company12; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company12; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company13; ?>' | unique:'Account'" ng-show="<?php echo $visi13; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company13; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company13; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company14; ?>' | unique:'Account'" ng-show="<?php echo $visi14; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company14; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company14; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company15; ?>' | unique:'Account'" ng-show="<?php echo $visi15; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company15; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company15; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company16; ?>' | unique:'Account'" ng-show="<?php echo $visi16; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company16; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company16; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company17; ?>' | unique:'Account'" ng-show="<?php echo $visi17; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company17; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company17; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr ng-repeat="s in names | orderBy:mainOrder| filter: '<?php echo $company18; ?>' | unique:'Account'" ng-show="<?php echo $visi18; ?>">			
			<td>{{s.Region}}</td> 
			<td>{{s.Account}}</td> 
			<td>{{s.CourseName}}</td>
			<td>{{s.RevenueShare | currency}}</td>
			<td>{{count3(s.Account, '<?php echo $company18; ?>')}}</td>	
			<td>{{count3(s.Account, '<?php echo $company18; ?>')* s.RevenueShare | currency}}</td>			
		</tr>
		<tr style="border:1px solid white">			
			<td style="border:1px solid white"></td> 
			<td style="border:1px solid white"></td> 
			<td style="border:1px solid white"></td> 
			<td style="text-align:right;font-weight:bold;border-right:1px solid black;border-bottom:1px solid white"></td>
			<td style="text-align:right;font-weight:bold;border-right:1px solid black">Total &nbsp; &nbsp;</td>	
			<td style="border:1px solid black">{{<?php echo $truetotal; ?> |currency}}</td>			
		</tr>
</table>


<br><br>

<div id="comment">
<table>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td style="width:560px;height:50px">
	<?php echo $comment1; ?>
	<br>
	<?php echo $comment2; ?>
	<br>
	<?php echo $comment3; ?>
	</td>
  </tr>
</table>
</div>
<span style="margin-left:20px">FSM = Food Safety Manager &nbsp;&nbsp; NFON = Food Handler All Other States &nbsp;&nbsp; ILFH = Illinois Food Handler </span>
<br>
<span style="margin-left:20px">MOFH = Jackson County Food Handler &nbsp;&nbsp; TXFH = Texas Food Handler &nbsp;&nbsp; AZFH = Arizona Food Handler</span>
<br>
<span style="margin-left:20px">FSRE = Food Safety Manager Re-Certification &nbsp;&nbsp; RETFSM = Retail Food Safety Manager &nbsp;&nbsp; UTFH = Utah Food Handler</span>
<br>
<span style="margin-left:20px">CAFH = California Food Handler &nbsp;&nbsp; FLFH = Florida Food Handler &nbsp;&nbsp; WVFH = West Virginia Food Handler</span>
<br>
<span style="margin-left:20px">OHLO = Ohio Level One Certification &nbsp;&nbsp; IDFH = Idaho Food Handler &nbsp;&nbsp; KSFH = Wichita Food Handler</span>
<br>
<span style="margin-left:20px">SDFH = San Diego Food Handler</span>
<br><br>

</div> 

<br>
<p style="text-align:center;" ng-show='<?php echo $paidbtn; ?>'><b>Billing Information</b></p>


<form action="payinvoice.php" method="post">

<div id="formm" ng-show='<?php echo $paidbtn; ?>'>

<input type="text"  style="display:none" name="x_amount" value='<?php echo $truetotal; ?>'>
<input type="text"  style="display:none" name="Description" value='<?php echo $companyrealname; ?>'>
<input type="text"  style="display:none" name="x_invoice_num" value='<?php echo $invoicenum; ?>'>
<input type="text" style="display:none" name="ID" value='<?php echo $acct. "|" . $month . "|" . $year . "|" . $UM . "|" . $invoicenum; ?>'>

<table >
  <tr>
    <td>Company Name: </td><td><input  type="text"  name="x_description" value='<?php echo $companyrealname; ?>'></td> 
  </tr>
  <tr>
    <td>First Name: </td><td><input type="text"  name="x_first_name" value='<?php echo $NF; ?>'></td> 
  </tr>
  <tr>
    <td>Last Name: </td><td><input type="text"  name="x_last_name" value='<?php echo $NL; ?>'></td> 
  </tr>
  <tr>
    <td>Address: </td><td><input type="text"  name="x_address" value='<?php echo $AA1 . " " . $AA2; ?>'></td> 
  </tr>
  <tr>
    <td>City: </td><td><input type="text"  name="x_city" value='<?php echo $ACI; ?>'></td> 
  </tr>
  <tr>
    <td>State: </td><td><input type="text"  name="x_state" value='<?php echo $AST; ?>'></td> 
  </tr>
  <tr>
    <td>Zip Code: </td><td><input type="text"  name="x_zip" value='<?php echo $AZ; ?>'></td> 
  </tr>
  <tr>
  <td>Email: </td><td><input type="text"  name="x_email" value='<?php echo $UM; ?>'></td> 
  </tr>
</table>











</div>

<p style="text-align:center" ng-show='<?php echo $paidbtn; ?>'><button type="submit">Pay Now</button></p>

<p style="text-align:center;font-size:14px" ng-hide='<?php echo $paidbtn; ?>'>Paid in full.</p>
</form>




</body>
<style>
#formm td {
	text-align:right;
}
#formm{
	width:300px;
	height:auto;
	border:1px solid transparent;
	margin:auto;
	font-size:16px;
}
#comment{
	width:560px;
	height:80px;
	border:1px solid transparent;
	margin:auto;
}
#dateandaddress{
	width:560px;
	height:70px;
	border:1px solid white;
	margin:auto;
}
#billto{
	width:250px;
	height:80px;
	border:1px solid black;
	float:left;	
}
#info{
	width:250px;
	height:80px;
	border:1px solid transparent;
	float:right;	
}
#address{
	width:560px;
	height:80px;
	border:1px solid white;
	margin:auto;
}
#wrapper{
	margin:auto;
	width:600px;
	min-height:500px;
	border:1px solid black;
	
}
	#wrapper{
	font-family: 'Open Sans', sans-serif;
	font-size:10px;
}		
  table, th , td  {
  border: 1px solid grey;
  border-collapse: collapse;
  padding: 2px;
  max-width: 670px;
  overflow: auto;
}
</style>
</html>
