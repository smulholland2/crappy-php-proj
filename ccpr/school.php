<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

session_start();
$username = $_GET['corpuser'];

// Get type
$SQL="SELECT type FROM [colorCodedProgress] WHERE corp='$username' ";
$resultset=mssql_query($SQL, $con);
while ($row = mssql_fetch_array($resultset)) 
{
     $type = $row['type'];
}

// Regular Accounts
if($type == "a"){
    $_SESSION['user'] = $username;
    header("Location: /admin/tools/reports/schoolprogress_view.php?emailReport=1");
}
// 4u Accounts, students are self enrolled
if($type == "v"){
    $_SESSION['user'] = $username;
    header("Location: /admin/tools/reports/instructor_schoolprogress_view.php?emailReport=1");
}
// Corporate Accounts
if($type == "c"){
    $_SESSION['user'] = $username;
    header("Location: /admin/tools/reports/multi_schoolprogress_view.php?emailReport=1");
}

//print_r($_SESSION);
?>