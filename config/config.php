<?php 
    
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/Helper.php";

    //QA CONNECTION CREDENTIALS
    $user = $_SERVER['DB_USERNAME'];
    $password = $_SERVER['DB_PASSWORD'];
    $server = $_SERVER['DB_HOSTNAME'];
    $database = 'newtap';

    $conn = mssql_connect($_SERVER['DB_HOSTNAME'], $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD']);
    mssql_select_db($database, $conn);

    // Geo Location helper
    if(isset($_POST["location"])) {        
        $geohelper = new Helper();
        $geohelper -> set_location($_POST["location"]); 
    } else {
        $geohelper = new Helper();
        $geohelper -> set_location(null);
    }

    // Geo Location checker
    if(isset($_POST["loccheck"])) {
        echo isset($_SESSION["location"]) ? 1 : 0;
    }
    
?>