<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
   
// Connect to the database (host, username, password)
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

$SQL = "SELECT ProID FROM [07DS2] ";		
	$resultset=mssql_query($SQL, $con); 
	
	
		while ($row = mssql_fetch_array($resultset)) 
		{
		     $ProIDDB[] = $row['ProID'];
		}   
	
		
$cyear = date("Y");		
$ProName = $_POST["ProName"];
$Qty = $_POST["Qty"];
$ProID = $_POST["ProID"];
$ProPrice = $_POST["ProPrice"];
$SameCourseTotal= $Qty * $ProPrice;

$deleteitem = $_GET["deleteitem"];


session_start();
$discode = $_SESSION["discode"];

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

$corporate_username=$_SESSION["corporate_username"];
$corpVC=$_SESSION["corpVC"];

$newusername=$_SESSION["newusername"];
$existingusername=$_SESSION["existingusername"];



$_SESSION[$ProID]=array(); // Declaring session array
array_push($_SESSION[$ProID],$ProName,$Qty,$ProID,$ProPrice, $SameCourseTotal); // Items added to cart

if($Qty<=0 or $Qty==''){
	unset ($_SESSION[$ProID]); 
}

// deletes specific session array
unset ($_SESSION[$deleteitem]);


//make array with product names to display on description
    foreach ($_SESSION as $key=>$val)
	{
		     //here we are checking if the array name is on the table where we have all the course names
		if(in_array($key, $ProIDDB))
		{
			$productsname[] = $val[0];
		}
    	
	}
	$_SESSION["productsname"] = $productsname;
	



//this part sets session total price in shopping cart 
    foreach ($_SESSION as $key=>$val)
	{
		
		     //here we are checking if the array name is on the table where we have all the course names
		if(in_array($key, $ProIDDB))
		{
			$totalsarray[] = $val[4];
		}
	}
	//print_r ($totalsarray);
	$realTotal= array_sum($totalsarray);
	$realTotal = number_format($realTotal,2);
	$_SESSION["realTotal"] = $realTotal;
	
	
	
  //this part sets total session quantity in shopping cart, the total qty of all the courses in SC
  foreach ($_SESSION as $key=>$val)
	{
		if(in_array($key, $ProIDDB))
		{
			$QtyArray[] = $val[1];
		}		

	}
	//print_r ($QtyArray);
	$totalQTY= array_sum($QtyArray);
	$realTotalQTY = number_format($totalQTY,0);
	$_SESSION["realTotalQTY"] = $realTotalQTY;

	


echo "
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans' />
<meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

<div id='wrapper'>

<h3 style='text-align:center'>Shopping Cart</h3>

<table>
  <tr>
    <th>Product</th>
    <th>Qty</th> 
    <th>Price</th>
    <th>Remove</th>
  </tr>
  
 "; 
 

//shows all the session variables/arrays and display them, except discode or empty spaces, after that creates an array with those results	
foreach ($_SESSION as $key=>$val)
{
	if(in_array($key, $ProIDDB)){
		$sessionm[] = $key;
		$sessioncourse[] = $val[2];
	}

}

	$numofcourses = count($sessionm);
	$_SESSION["numofcourses"] = $numofcourses;


 foreach($sessionm as $valm)
 {

$session=$_SESSION[$valm];

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
	<p style='text-align:center;margin-top:10px'><img src='images/$img_var.png'></p>
	<p style='text-align:center;margin-top:-10px;font-weight:bold'>$session[0] $lk_text</p>
	</td>
	
	<td>
		<form method='post' action='sc_shopping_cart.php'>
		<input type='hidden' name='ProName' value='$session[0]'>
		<input type='hidden' name='ProID' value='$session[2]'>
		<input type='hidden' name='ProPrice' value='$session[3]'>
		<p style='text-align:center;margin-top:20px'><input type='number' name='Qty' style='width:50px' value='$session[1]' autocomplete='off'>
		<br><br>
		<button type='submit' style='border:none;background-color:#2e6da4;color:white;border-radius:3px;height:30px'>update</button>
		</p>
		</form>
	</td>

    <td><p style='text-align:center;font-weight:bold'>$$session[3]</p></td>
    <td>
	<form method='get' action='sc_shopping_cart.php'>
		<input type='hidden' name='deleteitem' value='$session[2]'>
		<p style='text-align:center'><button id='deletebtn' type='submit'>x</button></p>
		</form>
	</td>
</tr>
";		


 }

		
echo "		
</table>
<p style='text-align:center;font-weight:bold;'> Total: $$realTotal<p>
";



// dynamuc continue shopping link
if($corporate_username){
	$continue_shopping_link = "/courses/shop/sc_product_options_corporate.php";
}
elseif($_SESSION["user"]){
	$continue_shopping_link = "/courses/shop/products";
}
else{
	$continue_shopping_link = '/#our_courses';
}





if( $realTotal > 0 || $state_fee_only)
{

	if($newusername || $existingusername)
	{
		echo "<form action='sc_info.php'>";
	}
	elseif ($corporate_username && $corpVC)
	{
		echo "<form action='sc_infovar.php'>";
	}
	else
	{	
		echo "<form action='sc_sign_in.php'>";
	}

		echo "
		<p style='text-align:center;font-size:18px'> I have read and accept the <a href='#' data-toggle='modal' data-target='#myModal'>Terms of Purchase</a> <input type='checkbox' required><p>
		<br>
		";
		
		if($sessioncourse[0]=='akan'){
			echo "
			<p style='text-align:center;font-size:18px;margin-top:-40px;margin-bottom:40px'>The Municipality of Anchorage does not allow refunds. This sale is final.&nbsp;<input type='checkbox' required><p>
			";
		}
		

		echo"
		<p style='text-align:center;'><button type='submit' id='checkout'>Proceed to Checkout</button></p>
		</form>
		";

		if(!$discode && $realTotal>0 || $_SESSION["admintable"]=="07L3"){

			echo "<p style='text-align:center;'><a href='$continue_shopping_link' style='text-decoration:none'><button type='button' id='checkout'>Continue Shopping</button></a></p>";

		}

}
else{

	echo "<p style='text-align:center;'><a href='$continue_shopping_link' style='text-decoration:none'><button id='checkout'>Click here to select a course</button></a></p>";

}

echo "
<br>


  <!-- Modal -->
  <div class='modal fade' id='myModal' role='dialog'>
    <div class='modal-dialog'>
    
      <!-- Modal content-->
      <div class='modal-content'>
        <div class='modal-header'>
          <button type='button' class='close' data-dismiss='modal'>&times;</button>
          <h4 class='modal-title'><strong>Terms of Purchase</strong></h4>
        </div>
        <div class='modal-body'>
          <p>100% money back of the purchase price, or credit to your corporate account, if returned within 30 days of enrollment, and if no more than lesson 1 has been studied. If you have any questions or comments on our return policy/terms of purchase, please feel free to contact us at 888-826-5222.</p>
		  <br>
		  <p>Courses are purchased as single use enrollments. Each lesson allows up to 5 reviews. After 5 reviews the lesson is closed. Courses are active for 180 days from date of enrollment and will stop functioning 180 days after the enrollment. Within the 180 day active period, the name of the student can be changed for a $20 fee for all courses except Food Handler, if a TAP Certificate of Achievement has NOT been awarded. Changing of the name will not re-activate any inactive, closed or ended functions.</p>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
<p style='text-align:center'><strong>&#169; Copyright $cyear TAP Series, LLC <br><a style='text-decoration:none' href='/home/privacy'>Privacy Policy</a></strong></p>
</div>
";


//print_r($_SESSION);
?>

<style>
th{
	text-align:center;
}
img{
	width:200px;
}
#selectc{
	width:80%;
	height:60px;
	border:1px solid #3899fa;
	margin:auto;
	background-color:#3899fa;
	cursor:pointer;
	color:white;
	font-size:20px;
	font-weight:bold;
}
/*
#selectc:hover{
	background-color:#66b3ff;
}
*/
#deletebtn{
	background-color:#ff4d4d;
	width:40px;
	height:40px;
	color:white;
	border:none;
	margin-top:15px;
	border-radius:5px;
	font-weight:bold;
	font-size:20px;
}
#deletebtn:hover{
	background-color:#ff6666;
}
button{
	cursor:pointer;
}
#checkout{
	width:80%;
	height:60px;
	border:1px solid #1E2B41;
	margin:auto;
	background-color:#1E2B41;
	cursor:pointer;
	color:white;
	font-size:20px;
	font-weight:bold;
}
#checkout:hover{
	background-color:#182234;
}
body{
	background-color:white;
	font-family: 'Open Sans', sans-serif;  
	font-size:20px;
}
#wrapper{
	max-width:1000px;
	height:auto;
	border:1px solid white;
	background-color:white;
	margin:30px auto;
	border-radius:5px;
}

table{
	width:90%;
	margin:50px auto;
}

table, th, td {
    border: 1px solid #ddd;
    border-collapse: collapse;
}

@media only screen and (max-width: 410px) {
img{
	width:95%;
}
}

</style>
<script>
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

