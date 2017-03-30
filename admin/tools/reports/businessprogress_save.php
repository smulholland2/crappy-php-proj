<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

session_start();
$weeks = $_GET['weeks']; 
$minimumScore = $_GET['minimumScore'];
$type = $_GET['type'];
$corp_user = $_SESSION['user'];

$SQL1 = "SELECT corp FROM CCCR WHERE corp='$corp_user' ";
$resultset1=mssql_query($SQL1, $con);
while ($row = mssql_fetch_array($resultset1)) 
{
     $corp_username_exists = $row['corp'];
}

if(isset($corp_username_exists)){
    $SQL ="UPDATE CCCR SET weeks='$weeks', minimumScore='$minimumScore' WHERE corp='$corp_user' ";
    $resultset=mssql_query($SQL, $con); 
    if($resultset){
        $_SESSION["CCCR_updated"] = 1;
        header('Location: businessprogress.php');
    }
    else{
        echo "There was a problem Updating the table CCCR.";
    }
}
else{
    $SQL2 = "INSERT INTO CCCR (corp, weeks, minimumScore, type)
             VALUES ('$corp_user', '$weeks', '$minimumScore', '$type')";
    $resultset2=mssql_query($SQL2, $con);
    if($resultset2){
        $_SESSION["CCCR_updated"] = 1;
        header('Location: businessprogress.php');
    }
    else{
        echo "there was an error inserting data on CCCR";
    }
}
?>