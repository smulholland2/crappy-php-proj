<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

session_start();
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
$minimumScore = $_GET['minimumScore'];
$type = $_GET['type'];
$corp_user = $_SESSION['user'];

$SQL1 = "SELECT corp FROM colorCodedProgress WHERE corp='$corp_user' ";
$resultset1=mssql_query($SQL1, $con);
while ($row = mssql_fetch_array($resultset1)) 
{
     $corp_username_exists_school = $row['corp'];
}

if(isset($corp_username_exists_school)){
    $SQL ="UPDATE colorCodedProgress SET startDate='$startDate', endDate='$endDate', minimumScore='$minimumScore' WHERE corp='$corp_user' ";
    $resultset=mssql_query($SQL, $con); 
    if($resultset){
        $_SESSION["colorCodedProgress_updated"] = 1;
        header('Location: schoolprogress.php');
    }
    else{
        echo "There was a problem Updating the table colorCodedProgress.";
    }
}
else{
    $SQL2 = "INSERT INTO colorCodedProgress (corp, startDate, endDate, minimumScore, type)
             VALUES ('$corp_user', '$startDate', '$endDate', '$minimumScore', '$type')";
    $resultset2=mssql_query($SQL2, $con);
    if($resultset2){
        $_SESSION["colorCodedProgress_updated"] = 1;
        header('Location: schoolprogress.php');
    }
    else{
        echo "there was an error inserting data on colorCodedProgress";
    }
}
?>