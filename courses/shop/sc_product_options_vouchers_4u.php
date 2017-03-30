<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

session_start();
$discode = $_SESSION["discode"];
$_SESSION["purchase_license_keys"] = "yes";

    $SQL = "SELECT * FROM [07SL1] WHERE VC = '$discode' ";				
	$resultset=mssql_query($SQL, $con); 	
		while ($row = mssql_fetch_array($resultset)) 
		{
            $valid_VC = $row['VC'];

		    $flfsh_price = $row['01FLEC'];
			$flfsh_price = number_format($flfsh_price,2);
        }
        if(!$valid_VC){
            $SQL = "SELECT * FROM [07SL1] WHERE VC = 'tapseries' ";				
	        $resultset=mssql_query($SQL, $con); 	
		    while ($row = mssql_fetch_array($resultset)) 
		    {
                $valid_VC = $row['VC'];

		        $flfsh_price = $row['01FLEC'];
			    $flfsh_price = number_format($flfsh_price,2);
            } 
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>License Keys</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<body>

<div class="container">
    <div class="page-header">
    <h1>Purchase License Keys</h1>
    </div>

    <p>Please click on the course you want to purchase.</p>
    <br>

    <table class="table" style="max-width:600px">
    <thead>
      <tr>
        <th>Course Name</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
      <tr <?php if($discode!="gcfm"){echo"style='display:none'";}?>>
        <td><a href='sc_product_options_aa.php?ProID=flfsh'>Florida Food Worker Training</a></td>
        <td>$<?php echo "$flfsh_price"; ?></td>
      </tr>
    </tbody>
  </table>

</div>

</body>
</html>