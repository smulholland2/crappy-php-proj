<?php
error_reporting(0); 

$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

$UN = trim($_GET["UN"]);
$NF = trim($_GET["NF"]);
$NL = trim($_GET["NL"]);
$AA1 = trim($_GET["AA1"]);
$AA2 = trim($_GET["AA2"]);
$ACI = trim($_GET["ACI"]);
$AST = trim($_GET["AST"]);
$AZ = trim($_GET["AZ"]);
$AP = trim($_GET["AP"]);
$AM = trim($_GET["AM"]);

$NCON = $NF." ".$NL;
$DIV_NAME = $NF."_".$NL;


$SQL1 = "SELECT AN FROM [07O6] WHERE AN='$UN' ";
$resultset1=mssql_query($SQL1, $con);
while ($row = mssql_fetch_array($resultset1)) 
{
    $AN_check = $row['AN'];
}
if($AN_check){
    echo "Sorry this account already exists in the system.";
}
else{

    $SQL = "INSERT INTO [07O6] (AN, NCON, NCPY, OP, AA1, AA2, ACI, AST, AZ, ACO, AP, AM, NF, NL, DIV_NAME) 
            VALUES ('$UN', '$NCON', 'Barnes & Noble', 'Other', '$AA1', '$AA2', '$ACI', '$AST', '$AZ', 'USA', '$AP', '$AM', '$NF', '$NL', '$DIV_NAME') ";
    $resultset=mssql_query($SQL, $con);
}



$SQL2 = "SELECT AN FROM [07L3] WHERE AN='$UN' ";
$resultset2=mssql_query($SQL2, $con);
while ($row = mssql_fetch_array($resultset2)) 
{
    $AN_check2 = $row['AN'];
}
if($AN_check2){
    echo "Sorry this account already exists in the system.";
}
else{

    $SQL3 = "INSERT INTO [07L3] (AN, AC, CA, VC, TRAIN_PERIOD, CTRLEXAM) 
            VALUES ('$UN', 'pending', 605, 'bn', 180, 1) ";
    $resultset3=mssql_query($SQL3, $con);
}


if(!$resultset){
    echo "There was an error inseting the new data 1.";
}
elseif(!$resultset3){
    echo "There was an error inseting the new data 2.";
}
else{
    echo "<h1 style='text-align:center;margin-top:100px'>Your account has been sent to the administrator for approval. You will be notified by email when your account is approved.</h1>";

    			$to = "dp@tapseries.com";
				$subject = "Barnes & Noble New Account Request";

				$message .= "<p>A new account has been requested with this username: $UN</p>";			
						
				$header = "From:techsupport@tapseries.com \r\n";
				$header .= "Cc:mg@tapseries.com \r\n";
				$header .= "MIME-Version: 1.0\r\n";
				$header .= "Content-type: text/html\r\n";

				$retval = mail ($to,$subject,$message,$header);	
}

?>