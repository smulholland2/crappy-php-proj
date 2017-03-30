<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);

$errormessage = $_GET["errormessage"];
echo "<p style='text-align:center;color:red'>$errormessage</p>";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Johnson and Wales</title>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	
<script>
$(document).ready(function(){
$("#examdate").hide();
$("#examno").prop( "checked", true );

	$("#examyes").click(function(){
    	$("#examdate").show();
	});
	
	$("#examno").click(function(){
    	$("#examdate").hide();
	});
	
});
</script>
	
</head>
<body>
<p style="text-align:center;background-color:white;margin-top:50px;border:10px solid white;font-weight:bold; font-size:30px">JOHNSON &amp; WALES UNIVERSITY</p>
<p style="text-align:center;margin-top:50px;color:white">Student Class Transfer</p>
<div id="wrapper">
<br>

<form action="checkinfo.php" method="get">
<p style="float:right;margin-right:40px">Previous Class Section: 


<!--<input type="text" name="UA">-->


<?php



$SQL="SELECT DISTINCT  UA FROM [01D]
		WHERE UA LIKE 'fsmcc%' 
		OR UA LIKE 'fsmhd%' 
		OR UA LIKE 'fsmhp%' 
		OR UA LIKE 'fsmcp%'
		OR UA LIKE 'fsmhm%'
		
	 ";
		
		$resultset=mssql_query($SQL, $con); 
		
echo "	<select name='UA'>";
	
	
		while ($row = mssql_fetch_array($resultset)) 
		{
			$UA[] = $row['UA'];
		}



natcasesort($UA);

		foreach ($UA as $item) 
		{
			$item = strtolower($item);
			echo "<option value='$item'>$item</option>";	
		}
		
echo "	</select>";


?>


</p>
<br><br>
<p style="float:right;margin-right:40px">Student's Username: <input type="text" name="UU"></p>
<br><br>
<p style="float:right;margin-right:40px">Last Name: <input type="text" name="lname"></p>
<br><br>
<p style="float:right;margin-right:80px">Did the student take the NRFSP proctored exam?</p> 
<p style="float:right;margin-right:200px">Yes<input type="radio" name="examtaken" value="yes" id="examyes"> No<input type="radio" name="examtaken" value="no" id="examno" checked></p>
	
	
	
	
<p style="float:right;margin-right:40px" id='examdate'>Previous Exam Date: <span><select name="month">
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
					  <option value="2015">2015</option>
					  <option value="2016">2016</option>					 
					  <option value="2017">2017</option>					 
					  <option value="2018">2018</option>					 
					</select>	
			</span>
			</p>
	<br><br><br><br>
	
	<p style="float:right;margin-right:200px"><input type="submit" value="Find Student" style="background-color:#004a91;color:white;border:none;width:100px;height:35px" id="submitbtn"></p>
	
</form>
<br>			
</div>			
			
</body>
<style>
#submitbtn{
	cursor:pointer;
}

#wrapper{
	width:500px;
	height:430px;
	border:1px solid #2489ce;
	border-radius:10px;
	margin:50px auto;
	background-color:#e8f1f5;
}
body *{
	font-family: 'Open Sans', sans-serif;
	
	}
	
body{
	background-color:#004a91;
}	
</style>

</html>
