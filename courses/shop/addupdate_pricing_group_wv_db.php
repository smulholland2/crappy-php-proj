<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

$VC = $_GET["VC"];
$NC = $_GET["NC"];

$wvch = $_GET["wvch"];
$wvmn = $_GET["wvmn"];
$wvpe = $_GET["wvpe"];
$wvpo = $_GET["wvpo"];
$wvup = $_GET["wvup"];
$wvwa = $_GET["wvwa"];
$wvba = $_GET["wvba"];
$wvoh = $_GET["wvoh"];

$SQL1="SELECT VC FROM [07SL1WV] WHERE VC = '$VC' ";				
    $resultset1=mssql_query($SQL1, $con); 

    while ($row = mssql_fetch_array($resultset1)) 
        {
           $VC_taken = $row['VC'];
        }

    if($VC_taken)
    {
        echo "Please check table 07SL1WV, the code exists on the database.";
    }
    else
    {

        $SQL = "INSERT INTO [07SL1WV] (NC, VC, [01WVCHEC], [01WVMNEC], [01WVPEEC], [01WVPOEC], [01WVUPEC], [01WVWAEC], [01WVBAEC], [01WVOHEC]) VALUES ('$NC', '$VC', '$wvch', '$wvmn', '$wvpe', '$wvpo', '$wvup', '$wvwa', '$wvba', '$wvoh') ";
        $resultset=mssql_query($SQL, $con);

        if($resultset){
            echo "The Pricing Group for West Virginia was successfully added to the database.";
            echo "<br>";
            echo "<a href='/discode/add'><button>Go to the 4u maker</button></a>";
        }
        else{
            echo "There was an error adding the Pricing Group";
        }
    }
    


?>