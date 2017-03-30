<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 


$PRO = $_GET["PRO"];
$CA = $_GET["CA"];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Locations</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
  
<div class="container" style="margin-top:30px">
<h3>Please select your store location from the list below.</h3> 

<?php
// regular acct
if($PRO){
    $SQL = "SELECT [07L3].AN, [07O6].NCPY
            FROM [07L3] 
            INNER JOIN [07O6] 
            ON [07L3].AN = [07O6].AN
            WHERE ([07L3].PRO = $PRO)
            ORDER BY [07O6].NCPY";
}
//corp acct

if($CA && $CA != 1177){
    $SQL = "SELECT [07L3].AN, [07O6].NCPY
            FROM [07L3] 
            INNER JOIN [07O6] 
            ON [07L3].AN = [07O6].AN
            WHERE ([07L3].CA = $CA AND [07L3].AN <> 'pinrest')
            ORDER BY [07O6].NCPY";
}

if($CA && $CA == 1177){
    $SQL = "SELECT [07L3].AN, [07O6].NCPY
            FROM [07L3] 
            INNER JOIN [07O6] 
            ON [07L3].AN = [07O6].AN
            WHERE ([07L3].CA >= $CA AND [07L3].CA <= 1181)
            ORDER BY [07O6].NCPY";
}

    $resultset=mssql_query($SQL, $con); 
    while ($row = mssql_fetch_array($resultset)) 
    {
        $AN = $row['AN'];
        $NCPY = $row['NCPY'];
        session_start();
        $_SESSION['displayname'] = $NCPY;
        echo "<a href='4u_locations_session_ecm.php?account_username=$AN'>$NCPY</a><br>";
    }

?>

</div>
<?php session_start(); 
//print_r($_SESSION); 
?>
</body>
</html>