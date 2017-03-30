<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

session_start();

$discode = $_GET["discode"];
$price_discode = $_GET["price_discode"];
$logo = $_GET["logo"];
$corporate_username = $_GET["corporate_username"];
$region_username = $_GET["region_username"];
$coursesarray = $_GET["coursesarray"];
$add_stud_id = $_GET["add_stud_id"];
$UA_add = $_GET["UA_add"];
$htmlcodes = $_GET["htmlcodes"];


if($discode!="" && $htmlcodes!="")
{
    $SQL1="SELECT discode FROM discodes WHERE discode = '$discode' ";				
    $resultset1=mssql_query($SQL1, $con); 

        while ($row = mssql_fetch_array($resultset1)) 
        {
            $discode_taken = $row['discode'];
        }

    if($discode_taken)
    {
        $_SESSION["discode_error"] = "Please try a different discode, the one you entered exists in the database.";
        $_SESSION["logo"] = $logo;
        $_SESSION["htmlcodes"] = $htmlcodes;
	    header("Location: /discode/add");
    }
    else
    {
        $SQL = "INSERT INTO discodes (discode, price_discode, logo, html, active, corporate_username, region_username, account_username, add_id) VALUES ('$discode', '$price_discode', '$logo', '$htmlcodes', 1, '$corporate_username', '$region_username', '$UA_add', '$add_stud_id') ";
	    $resultset=mssql_query($SQL, $con);
        if($resultset){ 
        echo "The 4u page was successfully added to the database.";
        echo "<br>";
        echo "See page <a href='/4u/$discode'>tapseries.com/4u/$discode</a>";
        echo "<br>";
        echo "<a href='/discode/add'>Create another page</a>";}
        else{
            echo "There was an error adding the 4u page to the database.";
        }

        foreach ($coursesarray as $course) 
        {
            $SQL2 = "INSERT INTO [4u_Page_Menu] (discode, ProID) VALUES ('$discode', '$course') ";
	        $resultset2=mssql_query($SQL2, $con);
        }

        
    }    
}
else{
    echo "New 4u page wasn't added to the database, because one of the variables was empty.";
}


?>