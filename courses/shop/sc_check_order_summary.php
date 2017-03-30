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
		
		
session_start();

	 $realTotal = $_SESSION["realTotal"];
	 $realTotalQTY = $_SESSION["realTotalQTY"];

echo "
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans' />
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<div id='wrapper'>

<h3 style='text-align:center'>ORDER SUMMARY (Check)</h3>

<a href='sc_shopping_cart.php' style='text-decoration:none'><div id='shc'>


<p style='text-align:center;margin-top:10px'><img src='images/shoppingc.png' width='21'>
&nbsp;&nbsp;$$realTotal
</p>
</div>
</a>

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
	if(in_array($key, $ProIDDB))
	{
		$sessionm[] = $val[2];
	}
	

}



 foreach($sessionm as $valm)
 {

$session=$_SESSION[$valm];




   
 
 echo "
 <tr>
    <td>
	<p style='text-align:center;margin-top:10px'><img src='images/$session[2].png' style='width:100px'></p>
	<p style='text-align:center;margin-top:-10px;font-weight:bold'>$session[0]</p>
	</td>
	
	<td>
		<p style='text-align:center;margin-top:20px'>$session[1]</p>
	</td>

    <td><p style='text-align:center;font-weight:bold'>$$session[3]</p></td>
   
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
    <th>Total</th> 
    <th>$$realTotal</th>

</tr>	
</table>



<form action='sc_checkvar.php' method='post'>
		<input type='hidden' value='$realTotal' name='totaltobecharged'>
		<button type='submit' id='confirm_order_btn'>Confirm Order</button>
		</form>

<br>
<p style='text-align:center'><strong>&#169; Copyright $cyear TAP Series, LLC <br><a style='text-decoration:none' href='/home/privacy'>Privacy Policy</a></strong></p>

</div>


";




//print_r($_SESSION);
?>




<style>
#confirm_order_btn:hover {
    background-color: #182234;
}
#confirm_order_btn{
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
	margin:50px auto;
}

table, th, td {
    border: 1px solid #ddd;
    border-collapse: collapse;
}
#wrapper{
	max-width:1000px;
	height:auto;
	border:1px solid transparent;
	background-color:white;
	margin:30px auto;
	border-radius:5px;
	text-align:center;
	
}
body{
	background-color:white;
	font-family: 'Open Sans', sans-serif;  
	font-size:20px;
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
