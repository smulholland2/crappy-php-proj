<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);

$UA = $_GET["UA"];
$UU = $_GET["UU"];
$DATE_EXPIRE = $_GET["DATE_EXPIRE"];
$Amount = $_GET["Amount"];
$DaysExtend = $_GET["DaysExtend"];
?>

<!DOCTYPE html>
<html>
<head>
	<title>JW Expired Course</title>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans" />

</head>
<body>
<div id="header" style="background-color:white">
<h1 style="text-align:center">Student Class Transfer</h1>
<p style="text-align:center">The course stays open for 12 months. Course expired on  <b><?php echo $DATE_EXPIRE;?></b>.</p>
<p style="text-align:center;font-weight:bold">Student qualifies for re-enrollment discount price of $20.</p>
<br>
</div>

<div id="wrapper">


<form action="billing.php" method="get">

<p style="float:right;margin-right:40px">Previous Class Section: <input type="text" value="<?php echo $UA;?>" disabled><input type="text" value="<?php echo $UA;?>" name="OldUA"  style="display:none"> </p>
<p style="float:right;margin-right:40px">New Class Section: 
	
<!--<input type="text" name="NewUA">-->

<?php

$SQL="SELECT DISTINCT  UA FROM [01D]
		WHERE UA LIKE 'fsmcc%' 
		OR UA LIKE 'fsmhd%' 
		OR UA LIKE 'fsmhp%' 
		OR UA LIKE 'fsmcp%'
		OR UA LIKE 'fsmhm%'
		
	 ";
		
		$resultset=mssql_query($SQL, $con); 
		
echo "	<select name='NewUA'>";
		
		while ($row = mssql_fetch_array($resultset)) 
		{
			$UAcct[] = $row['UA'];
		}
natcasesort($UAcct);
		foreach ($UAcct as $item) 
		{
			$item = strtolower($item);
			echo "<option value='$item'>$item</option>";	
		}
		
echo "	</select>";		

?>



</p>





<p style="float:right;margin-right:40px">New Semester Date: <span><select name="month">
					  <option value="" selected="selected">Month</option>
					  <option value="01">January (1)</option>
					  <option value="02">February (2)</option>
					  <option value="03">March (3)</option>
					  <option value="04">April (4)</option>
					  <option value="05">May (5)</option>
					  <option value="06">June (6)</option>
					  <option value="07">July (7)</option>
					  <option value="08">August (8)</option>
					  <option value="09">September (9)</option>
					  <option value="10">October (10)</option>
					  <option value="11">November (11)</option>
					  <option value="12">December (12)</option>
					</select>
					<select name="day">
					  <option value="" selected="selected">Day</option>
					  <option value="01">1</option>
					  <option value="02">2</option>
					  <option value="03">3</option>
					  <option value="04">4</option>
					  <option value="05">5</option>
					  <option value="06">6</option>
					  <option value="07">7</option>
					  <option value="08">8</option>
					  <option value="09">9</option>
					  <option value="10">10</option>
					  <option value="11">11</option>
					  <option value="12">12</option>
					  <option value="13">13</option>
					  <option value="14">14</option>
					  <option value="15">15</option>
					  <option value="16">16</option>
					  <option value="17">17</option>
					  <option value="18">18</option>
					  <option value="19">19</option>
					  <option value="20">20</option>
					  <option value="21">21</option>
					  <option value="22">22</option>
					  <option value="23">23</option>
					  <option value="24">24</option>
					  <option value="25">25</option>
					  <option value="26">26</option>
					  <option value="27">27</option>
					  <option value="28">28</option>
					  <option value="29">29</option>
					  <option value="30">30</option>
					  <option value="31">31</option>
					</select>
					<select name="year">
					  <option value="" selected="selected">Year</option> 
					  <option value="2016">2016</option>					 
					  <option value="2017">2017</option>					 
					  <option value="2018">2018</option>					 
					</select>	
			</span></p>
<p style="float:right;margin-right:40px">Student's Username: <input type="text" value="<?php echo $UU;?>" disabled> <input type="text" value="<?php echo $UU;?>" name="UU" style="display:none"></p>
<p style="float:right;margin-right:40px">Student's New Password: <input type="text" name="NewPW"></p>

<input type="hidden" name="Amount" value="<?php echo $Amount;?>">
<input type="hidden" name="DaysExtend" value="<?php echo $DaysExtend;?>">
<br>
<p style="float:right;margin-right:150px"><input type="submit" value="Pay to re-enroll now" style="background-color:#004a91;color:white;border:none;width:200px;height:35px"></p>
</form>



<!--<p style='text-align:center;margin-top:50px;margin-bottom:50px'><button onclick="goBack()" style="background-color:#004a91;color:white;border:none;width:100px;height:35px;cursor:pointer">Go Back</button></p>-->
</div>

</body>
<style>
#wrapper{
	max-width:500px;
	height:350px;
	border:1px solid black;
	border-radius:10px;
	margin:20px auto;
	background-color:#e8f1f5;
}
body *{
	font-family: 'Open Sans', sans-serif;
	}
body{
	background-color:#004a91;
}		
</style>	

<script>
function goBack() {
    window.history.back();
}
</script>
</html>
