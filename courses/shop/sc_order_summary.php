<?php
error_reporting(0); 


$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
   
// Connect to the database (host, username, password)
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

$cyear = date("Y");

$SQL = "SELECT ProID FROM [07DS2] ";		
	$resultset=mssql_query($SQL, $con); 
	
	
	
		while ($row = mssql_fetch_array($resultset)) 
		{
		     $ProIDDB[] = $row['ProID'];
		}   	


session_start();


	 $discode = $_SESSION["discode"];
	 $realTotal = $_SESSION["realTotal"];
	 $realTotalQTY = $_SESSION["realTotalQTY"];
	 $numofcourses = $_SESSION["numofcourses"];
	 
	 $subTotal = $realTotal;

	$purchase_license_keys=$_SESSION["purchase_license_keys"];
	
if($purchase_license_keys=="yes")
{
	$lk_text = "License Key";

	//check if account only charges for state fee and the rest of the courses are free, we bill them at the end of the month
	$SQL2 = "SELECT state_fee_only FROM [07SL1] WHERE VC='$discode' ";
	$resultset2=mssql_query($SQL2, $con); 					
	while ($row = mssql_fetch_array($resultset2)) 
	{
		$state_fee_only = $row['state_fee_only'];
	}
}
	 
	 //echo $numofcourses;
	 
	 $couponused = $_GET["couponused"];
if($couponused && $discode=='' && $numofcourses==1){
	
	foreach ($_SESSION as $key=>$val)
{
	if(in_array($key, $ProIDDB))
	{
		$courseusedcoupon = $val[2];
	}
}
	
	
	//echo $couponused;
	$SQL0 = "SELECT * FROM couponcodes WHERE coupon='$couponused' and course='$courseusedcoupon' ";
	$resultset0=mssql_query($SQL0, $con); 
	
		while ($row = mssql_fetch_array($resultset0)) 
		{
		     $discount = $row['discount'];
		}   
	
	//$discount= odbc_result($resultset0, discount);
	
	if($discount)
	{
		//echo $realTotal =number_format($realTotal,2);
		//echo "<br>";
		
		 $totaldiscount = $realTotalQTY * $discount;
		 $totaldiscount = number_format($totaldiscount,2);
		// echo $totaldiscount = number_format($totaldiscount,2);
		// echo "<br>";
		 $totalafterdiscount = $realTotal - $totaldiscount;
		//echo $totalafterdiscount = number_format($totalafterdiscount,2);
		//echo "<br>";
		
		if($totalafterdiscount)
		{
			$realTotal=$totalafterdiscount;
		}	
		
	}
	else
	{
		$invcoupmessage = "Invalid Coupon";
	}
	
	
}

echo "
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans' />
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<div id='wrapper'>

<h3 style='text-align:center'>ORDER SUMMARY</h3>


<a href='sc_shopping_cart.php' style='text-decoration:none'><div id='shc'>
<p style='text-align:center;margin-top:10px'><img src='images/shoppingc.png' width='21'>
&nbsp;&nbsp;$$realTotal
</p>
</div>
</a>
";



echo "
<table>
  <tr>
    <th>Product</th>
    <th>Qty</th> 
    <th>Price</th>
  </tr>
  
 "; 
 

	//shows all the session variables/arrays and display them, except discode or empty spaces, after that creates an array with those results
foreach ($_SESSION as $key=>$val)
{
	if(in_array($key, $ProIDDB)){
		$sessionm[] = $val[2];
	}
}


 foreach($sessionm as $valm)
 {

$session=$_SESSION[$valm];



$pricepercourse= number_format($session[3],2);

$img_var = $session[2];
if($img_var == "ad"){
	$img_var = "allergend";
}
else{
	$img_var = $session[2];
}   
 
 echo "
 <tr>
    <td>
	<p style='text-align:center;margin-top:10px'><img id='cimg' src='images/$img_var.png'></p>
	<p style='text-align:center;margin-top:-10px;font-weight:bold'>$session[0] $lk_text</p>
	</td>
	
	<td>
		<p style='text-align:center;margin-top:20px'>$session[1]</p>
	</td>

    <td><p style='text-align:center;font-weight:bold'>$$pricepercourse</p></td>
   
</tr>

";		


 }

		
echo "	
<tr style='background-color:#ddd'>
	<th></th>
    <th></th> 
    <th></th>

</tr>

<tr>
	<th></th>
    <th>Subtotal</th> 
    <th>$$subTotal</th>

</tr>	
";


	if($discount)
		{
			
			echo "	
			

			<tr>
				<th></th>
				<th>Discount</th> 
				<th style='color:red'>- $$totaldiscount</th>

			</tr>	
			";
			
			
		}

//format was conflicting with the shopping cart
//$realTotal= number_format($realTotal,2);


echo "	
<tr style='background-color:#ddd'>
	<th></th>
    <th></th> 
    <th></th>

</tr>

<tr>
	<th></th>
    <th>Total</th> 
    <th>$$realTotal</th>

</tr>	
</table>
";

//coupon 
if(!$discode &&  $numofcourses==1){
	echo "
	<div id='couponcdiv' style='border:1px solid transparent;margin-top:-50px !important;width:90%;margin:auto'>
	<form name='myform' onsubmit='return validateForm()' action='sc_order_summary.php' method='get'>
	<span style='color:red'>$invcoupmessage</span>
	<br>
	
	<input type='text' style='height:30px;font-size:20px;width:150px;text-align:center;float:right;display:block' placeholder='Coupon' id='couponused' name='couponused' autocomplete='off'>
	<button id='coupcodebtn' type='submit' style='float:right'>Apply Coupon</button>
	</form>
	</div>
	";
}



	if($realTotal > 0 || $state_fee_only)
	{
		echo "
		<br><br>
		<form action='sc_credit_card_info_anet.php' method='post'>
		<input type='hidden' value='$realTotal' name='totaltobecharged'>
		<button id='confirmordbtn' type='submit' style='margin-bottom:10px'>Confirm Order</button>
		<a href='sc_shopping_cart.php'><button id='confirmordbtn'  type='button'>Edit Order</button></a>
		</form>
		
		";
	}


echo "
<br>

<p style='text-align:center'><strong>&#169; Copyright $cyear TAP Series, LLC <br><a style='text-decoration:none' href='/home/privacy'>Privacy Policy</a></strong></p>

</div>


";




//print_r($_SESSION);
?>

<script>

function validateForm() {
	
	var a = document.forms["myform"]["couponused"].value;
    if (a == null || a == "") {
        alert("Coupon must be filled out");
		document.getElementById("couponused").focus();
        return false;
    }
	
}


<?php
if($_SESSION["discode"]=="ol2"){
    echo "  
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-90592116-1', 'auto');
            ga('send', 'pageview');
        ";    
}
?>
</script>


<style>
#cimg{
	width:200px;
}

#confirmordbtn:hover {
    background-color: #182234;
}	
#coupcodebtn{
	width:130px;
	font-size:15px;
	height:30px;
	background-color:#3299CC;
	border:none;
	cursor:pointer;
	color:white;
	border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
}
#confirmordbtn{
	width:50%;
	height:50px;
	background-color:#1E2B41;
	border:none;
	border-radius:3px;
	color:white;
	font-size:20px;
	cursor:pointer;
}

#shc{
	border:1px solid transparent;
	background-color:#333;
	height:50px;
	color:white;
	width:150px;
	margin-left:-1px;
	border-top-right-radius:10px;
	border-bottom-right-radius:10px;
	-webkit-transition: width 2s; /* For Safari 3.1 to 6.0 */
    transition: width 2s;
}
#shc:hover{
	background-color:#404040;
	width: 180px;
}
table{
	width:90%;
	margin:30px auto;
}

table, th, td {
    border: 1px solid #ddd;
    border-collapse: collapse;
}
#wrapper{
	max-width:1000px;
	height:auto;
	border:1px solid #333;
	background-color:white;
	margin:30px auto;
	border-radius:5px;
	text-align:center;
	
}
body{
	background-color:#1E2B41;
	font-family: 'Open Sans', sans-serif;  
	font-size:20px;
}

@media only screen and (max-width: 410px) {
#cimg{
	width:95%;
}
}

</style>
