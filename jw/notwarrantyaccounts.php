<?php 
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);

$reason = $_GET["reason"];
$UA = $_GET["UA"];
$UU = $_GET["UU"];
$dateexam = $_GET["dateexam"];
$Amount = $_GET["Amount"];
$DaysExtend = $_GET["DaysExtend"];


	$SQL22="SELECT UC FROM [01D] WHERE UU='$UU'";
	$resultset22=mssql_query($SQL22, $con); 
	while ($row = mssql_fetch_array($resultset22)) 
	{
		$UC = $row['UC'];
	}

	$SQL1="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=01 ";
	$resultset1=mssql_query($SQL1, $con); 
	while ($row = mssql_fetch_array($resultset1)) 
	{
		$PER1 = $row['PER'];
	}
	
	$SQL2="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=02 ";
	$resultset2=mssql_query($SQL2, $con); 
	while ($row = mssql_fetch_array($resultset2)) 
	{
		$PER2 = $row['PER'];
	}	
	
	$SQL3="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=03 ";
	$resultset3=mssql_query($SQL3, $con);
	while ($row = mssql_fetch_array($resultset3)) 
	{
		$PER3 = $row['PER'];
	}	
	
	$SQL4="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=04 ";
	$resultset4=mssql_query($SQL4, $con);
	while ($row = mssql_fetch_array($resultset4)) 
	{
		$PER4 = $row['PER'];
	}
	
	$SQL5="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=05 ";
	$resultset5=mssql_query($SQL5, $con); 
	while ($row = mssql_fetch_array($resultset5)) 
	{
		$PER5 = $row['PER'];
	}	
	
	$SQL6="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=06 ";
	$resultset6=mssql_query($SQL6, $con);
	while ($row = mssql_fetch_array($resultset6)) 
	{
		$PER6 = $row['PER'];
	}
	
	$SQL7="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=07 ";
	$resultset7=mssql_query($SQL7, $con); 
	while ($row = mssql_fetch_array($resultset7)) 
	{
		$PER7 = $row['PER'];
	}
	
	$SQL8="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=08 ";
	$resultset8=mssql_query($SQL8, $con); 
	while ($row = mssql_fetch_array($resultset8)) 
	{
		$PER8 = $row['PER'];
	}
	
	$SQL9="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=09 ";
	$resultset9=mssql_query($SQL9, $con);
	while ($row = mssql_fetch_array($resultset9)) 
	{
		$PER9 = $row['PER'];
	}
	
	$SQL10="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=10 ";
	$resultset10=mssql_query($SQL10, $con); 
	while ($row = mssql_fetch_array($resultset10)) 
	{
		$PER10 = $row['PER'];
	}
	
	$SQL11="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=11 ";
	$resultset11=mssql_query($SQL11, $con); 
	while ($row = mssql_fetch_array($resultset11)) 
	{
		$PER11 = $row['PER'];
	}
	
	$SQL12="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=12 ";
	$resultset12=mssql_query($SQL12, $con); 
	while ($row = mssql_fetch_array($resultset12)) 
	{
		$PER12 = $row['PER'];
	}
	
	$SQL13="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=13 ";
	$resultset13=mssql_query($SQL13, $con); 
	while ($row = mssql_fetch_array($resultset13)) 
	{
		$PER13 = $row['PER'];
	}
	
	$SQL14="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=14 ";
	$resultset14=mssql_query($SQL14, $con);
	while ($row = mssql_fetch_array($resultset14)) 
	{
		$PER14 = $row['PER'];
	}	
	
	$SQL15="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=15 ";
	$resultset15=mssql_query($SQL15, $con);
	while ($row = mssql_fetch_array($resultset15)) 
	{
		$PER15 = $row['PER'];
	}

	$SQL16="SELECT DE FROM [01P] WHERE UU='$UU' AND Num=15 ";
	$resultset16=mssql_query($SQL16, $con); 
	while ($row = mssql_fetch_array($resultset16)) 
	{
		$DE = $row['DE'];
	}

	$DE = date("m/d/Y", strtotime($DE));
	
	if($DE=="12/31/1969"){
		$DE="NOT TAKEN";
	}




if($reason=='practiceexamdate'){
	$reasonmessage="practice exam was not taken and successfully passed within 48 hours of taken the certification examination.";
}
if($reason=='coursescores'){
	$reasonmessage="lesson scores and/or practice exam score were below 90%.";
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>JW Course Reactivation</title>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
			
		<script>
		$(document).ready(function(){
			$("#studinfo").hide();
			$("#hidetablebtn").hide();
					
			$("#showtablebtn").click(function(){
			$("#studinfo").show();
			$("#hidetablebtn").show();
			$("#showtablebtn").hide();			
			});
			
			$("#hidetablebtn").click(function(){
			$("#studinfo").hide();
			$("#hidetablebtn").hide();
			$("#showtablebtn").show();			
			});
			
			
			
		});	
		</script>
</head>
<body>
<div id="header" style="background-color:white">
<h1 style="text-align:center">Student Class Transfer</h1>
<p style="text-align:center">Student did not qualify for Warranty because: <b><?php echo $reasonmessage;?></b></p>

<?php 

if($reason=='practiceexamdate')
{
	echo "
		<p style='text-align:center'>Practice exam was completed on: <b>$DE</b></p>
		<p style='text-align:center'>Proctor exam was taken on: <b>$dateexam</b></p>
	";
}
?>

<p style="text-align:center;font-weight:bold">Student qualifies for re-enrollment discount price of $20.</p>



<?php 

if($reason=='coursescores')
{
	echo "
		<p style='text-align:center'><button id='showtablebtn' style='background-color:#004a91;color:white;border:none;width:100px;height:35px'>See Scores</button></p>
		<p style='text-align:center'><button id='hidetablebtn' style='background-color:#004a91;color:white;border:none;width:100px;height:35px'>Hide Scores</button></p>

		<div id='studinfo'>



		<table style='margin:auto'>
		  <tr style='background-color:#004a91;color:white'>
			<td style='width:100px'>Lesson #</td>
			<td style='width:100px'>Score</td> 
		  </tr>
		  <tr>
			<td>1</td>
			<td>$PER1%</td> 
		  </tr>
		  <tr>
			<td>2</td>
			<td>$PER2%</td> 
		  </tr>
		  <tr>
			<td>3</td>
			<td>$PER3%</td> 
		  </tr>
		  <tr>
			<td>4</td>
			<td>$PER4%</td> 
		  </tr>
		  <tr>
			<td>5</td>
			<td>$PER5%</td> 
		  </tr>
		  <tr>
			<td>6</td>
			<td>$PER6%</td> 
		  </tr>
		  <tr>
			<td>7</td>
			<td>$PER7%</td> 
		  </tr>
		  <tr>
			<td>8</td>
			<td>$PER8%</td> 
		  </tr>
		  <tr>
			<td>9</td>
			<td>$PER9%</td> 
		  </tr>
		  <tr>
			<td>10</td>
			<td>$PER10%</td> 
		  </tr>
		  <tr>
			<td>11</td>
			<td>$PER11%</td> 
		  </tr>
		  <tr>
			<td>12</td>
			<td>$PER12%</td> 
		  </tr>
		  <tr>
			<td>13</td>
			<td>$PER13%</td> 
		  </tr>
		  <tr>
			<td>14</td>
			<td>$PER14%</td> 
		  </tr>
		  <tr>
			<td>Practice Exam</td>
			<td>$PER15%</td>
		  </tr>
		</table>
		</div>

	";
}
?>


<br>


</div>



<div id="wrapper">
<form action="billing.php" method="get">

<p style="float:right;margin-right:40px">Previous Class Section: <input type="text" value="<?php echo $UA;?>" disabled><input type="text" value="<?php echo $UA;?>" name="OldUA"  style="display:none"> </p>
<p style="float:right;margin-right:40px">Select New Class Section: 


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
					</select>	
			</span></p>
<p style="float:right;margin-right:40px">Student's Username: <input type="text" value="<?php echo $UU;?>" disabled> <input type="hidden" value="<?php echo $UU;?>" name="UU"></p>
<p style="float:right;margin-right:40px">Student's Password: <input type="text" value="<?php echo $UC;?>" disabled><input type="hidden" value="<?php echo $UC;?>" name="NewPW"></p>

<input type="text" name="Amount" value="<?php echo $Amount;?>" style="display:none">
<input type="text" name="DaysExtend" value="<?php echo $DaysExtend;?>" style="display:none">

<br>
<p style="float:right;margin-right:150px"><input type="submit" value="Pay to re-enroll now" style="background-color:#004a91;color:white;border:none;width:200px;height:35px"></p>
</form>
</div>

</body>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
	text-align:center;
}
#wrapper{
	width:500px;
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
</html>
