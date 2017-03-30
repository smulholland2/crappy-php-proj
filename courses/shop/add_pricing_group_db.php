<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

session_start();
$company_name = $_GET["company_name"];
$company_code = $_GET["company_code"];

if($company_name =="" || $company_code =="")
{
    echo"Please go back and fill up the form completely.";
}
else
{
    $SQL1="SELECT VC FROM [07SL1] WHERE VC = '$company_code' ";				
    $resultset1=mssql_query($SQL1, $con); 

    while ($row = mssql_fetch_array($resultset1)) 
        {
           $VC_taken = $row['VC'];
        }

    if($VC_taken)
    {
        $_SESSION["VC_error"] = "Please try a different <strong>Pricing Group Code/User Name</strong>, the one you entered exists in the database.";
        $_SESSION["company_name_session"] = "$company_name";
	    header("Location: add_pricing_group.php");
    }
    else
    {
        $SQL2 = "INSERT INTO [07SL1] (NC, VC) VALUES ('$company_name', '$company_code') ";
	    $resultset2=mssql_query($SQL2, $con);
        echo "The Pricing Group was successfully added to the database.";
        echo "<br>";
        echo "<a href='/discode/add'><button>Go to the 4u maker</button></a>";
    }    

}




?>