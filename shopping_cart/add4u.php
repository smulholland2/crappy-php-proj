<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/Helper.php";

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

session_start();

$sanitizer = new Helper();

$discode = $sanitizer -> mssql_escape($_GET["discode"]);
$logo = $sanitizer -> mssql_escape($_GET["logo"]);
$htmlcodes = $sanitizer -> mssql_escape($_GET["htmlcodes"]);

// Javascript and CSS are optional. If they are entered, we can reduce their load time 
// on the page by removing the white space. If they aren't entered, set them to NULL.
$customjs = isset($_GET["customjs"]) ? str_replace (' ', '', $sanitizer -> mssql_escape($_GET["customjs"])) : null;
$customcss = isset($_GET["customcss"]) ? str_replace (' ', '', $sanitizer -> mssql_escape($_GET["customcss"])) : null;

/*
if($htmlcodes=="")
{
    $_SESSION["htmlcodes_error"] = "HTML box must be filled out.";
    $_SESSION["discode"] = $discode;
    $_SESSION["logo"] = $logo;
    
}
*/

if($discode && $logo && $htmlcodes)
{
    $SQL1="SELECT discode FROM [4upages] WHERE discode = $discode ";				
    $resultset1=mssql_query($SQL1, $con); 

        while ($row = mssql_fetch_array($resultset1)) 
        {
            $discode_taken = $row['discode'];
        }

    if(isset($discode_taken))
    {
        $_SESSION["discode_error"] = "Please try a different discode, the one you entered exists in the database.";
        $_SESSION["logo"] = $logo;
        $_SESSION["htmlcodes"] = $htmlcodes;
        $_SESSION["customjs"] = isset($customjs) ? $customjs : null;
        $_SESSION["customcss"] = isset($customcss) ? $customcss : null; 
	    header("Location: 4u_maker.php");
    }
    else
    {
        $SQL = "INSERT INTO [4upages] (discode, logo, html, js, css) VALUES ($discode, $logo, $htmlcodes, $customjs, $customcss) ";
	    $resultset=mssql_query($SQL, $con);

        echo "The 4u page was successfully added to the database.";
        echo "The 4u page was successfully added to the database.";
    }    
}
else{
    echo "New 4u page wasn't added to the table, because one of the variables was empty.";
}


?>