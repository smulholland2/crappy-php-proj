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

$acct = $_GET["acct"];
$course = $_GET["course"];
$price = $_GET["price"];
$count = $_GET["count"];
$total = $_GET["total"];
$company = $_GET["company"];

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




if($company == 'Barnes and Noble'){
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


$SQL = "SELECT *  FROM [07DS2]	WHERE ProID = '$course' ";				
$resultset=mssql_query($SQL, $con);

	while ($row = mssql_fetch_array($resultset)) 
				{
					$ProductName = $row['ProductName'];
				}
					

//GETS THE INFOR FOR CSUB ACCOUNTS
$SQL2 = "SELECT *  FROM [07L2]	WHERE UU = '$acct' ";				
$resultset2=mssql_query($SQL2, $con); 

	while ($row = mssql_fetch_array($resultset2)) 
				{
					$companyrealname = $row['UA'];
					$AA1 = $row['AA1'];
					$AA2 = $row['AA2'];
					$ACI = $row['ACI'];
					$AST = $row['AST'];
					$AZ = $row['AZ'];
					$ACO = $row['ACO'];
					$UM = $row['UM'];
				}

					



//GETS THE INFO FOR SUB ACCOUNTS
if ($companyrealname == ''){
	$SQL3 = "SELECT *  FROM [07O6]	WHERE AN = '$acct' ";				
	$resultset3=mssql_query($SQL3, $con);

	while ($row = mssql_fetch_array($resultset3)) 
			{
				$companyrealname = $row['NCPY'];
				$AA1 = $row['AA1'];
				$AA2 = $row['AA2'];
				$ACI = $row['ACI'];
				$AST = $row['AST'];
				$AZ = $row['AZ'];
				$ACO = $row['ACO'];
				$UM = $row['AM'];
			}
	
		
}

if($companyrealname == 'Peninsula Petroleum'){
	$companyrealname = 'Humboldt Petroleum Inc';
}


?>

<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
	<script src="scripts/results.js"></script>



</head>
<body ng-app="myApp" ng-controller="customersCtrl">




<div id="wrapper">
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
	<td><input type="text" value='{{names[0].StartDate}} - {{names[0].EndDate}}' style="border:none"></td>
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
    <!--<td><?php echo $duedate . ", " .$year; ?></td>--> 
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
    <td style="width:560px;"></td>
  </tr>
  <tr>
    <td style="width:560px;height:50px">
	<input type="text" style="width:550px;border:none" maxlength="90" ng-model="comment1" ng-init="comment1='TAP Series Food Safety Manager Course is approved by ODH for the'">
	<input type="text" style="width:550px;border:none" maxlength="90" ng-model="comment2" ng-init="comment2='15 hours of instruction required by the new Ohio Uniform Food Safety'" >
	<input type="text" style="width:550px;border:none" maxlength="90" ng-model="comment3" ng-init="comment3='Code Chapter 3717-1 that became effective on 3/31/2016.'">
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

<?php 
echo "
<p  style='text-align:center'><a href='sendinvtoemail.php?acct=$acct&course=$course&price=$price&count=$count&total=$total&invoicenum=$invoicenum&company=$company&month=$month&year=$year&emailx={{emailx}}&comment1={{comment1}}&comment2={{comment2}}&comment3={{comment3}}&course2=$course2&price2=$price2&count2=$count2&total2=$total2&company2=$company2&course3=$course3&price3=$price3&count3=$count3&total3=$total3&company3=$company3&course4=$course4&price4=$price4&count4=$count4&total4=$total4&company4=$company4&course5=$course5&price5=$price5&count5=$count5&total5=$total5&company5=$company5&course6=$course6&price6=$price6&count6=$count6&total6=$total6&company6=$company6&course7=$course7&price7=$price7&count7=$count7&total7=$total7&company7=$company7&course8=$course8&price8=$price8&count8=$count8&total8=$total8&company8=$company8&course9=$course9&price9=$price9&count9=$count9&total9=$total9&company9=$company9&course10=$course10&price10=$price10&count10=$count10&total10=$total10&company10=$company10&course11=$course11&price11=$price11&count11=$count11&total11=$total11&company11=$company11&course12=$course12&price12=$price12&count12=$count12&total12=$total12&company12=$company12&course13=$course13&price13=$price13&count13=$count13&total13=$total13&company13=$company13&course14=$course14&price14=$price14&count14=$count14&total14=$total14&company14=$company14&course15=$course15&price15=$price15&count15=$count15&total15=$total15&company15=$company15&course16=$course16&price16=$price16&count16=$count16&total16=$total16&company16=$company16course17=$course17&price17=$price17&count17=$count17&total17=$total17&company17=$company17&course18=$course18&price18=$price18&count18=$count18&total18=$total18&company18=$company18'><button>Send Invoice</button></a></p>
"
 ?>
 
 <!--<p style="text-align:center">mg@tapseries.com<input type="radio" ng-model="emailx" value="mg@tapseries.com" ></p>-->
 <p style="text-align:center">sk@tapseries.com<input type="radio" ng-model="emailx" value="sk@tapseries.com" ></p>
<p style="text-align:center"><?php echo $UM; ?><input type="radio" ng-model="emailx" value="<?php echo $UM; ?>" ></p>

{{emailx}}


</body>
<style>
#comment{
	width:560px;
	height:70px;
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

	body *{
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