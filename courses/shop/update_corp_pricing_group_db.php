<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

$VC = $_GET["VC"];

$fs = $_GET["fs"];
$fsrt = $_GET["fsrt"];
$nfon = $_GET["nfon"];
$refs = $_GET["refs"];
$rewi = $_GET["rewi"];
$nhaccp = $_GET["nhaccp"];
$emws = $_GET["emws"];
$cb = $_GET["cb"];
$sfis = $_GET["sfis"];
$califsh = $_GET["califsh"];
$idfsh = $_GET["idfsh"];
$nmfsh = $_GET["nmfsh"];
$vaccfsh = $_GET["vaccfsh"];
$flfsh = $_GET["flfsh"];
$ksfsh = $_GET["ksfsh"];
$ohfsh = $_GET["ohfsh"];
$utfsh = $_GET["utfsh"];
$ilfsh = $_GET["ilfsh"];
$azfsh = $_GET["azfsh"];
$mofsh = $_GET["mofsh"];
$txfsh = $_GET["txfsh"];
$WVMV = $_GET["WVMV"];
$aa = $_GET["aa"];
$ad = $_GET["ad"];
$as = $_GET["as"];

$wvch = $_GET["wvch"];
$wvmn = $_GET["wvmn"];
$wvpe = $_GET["wvpe"];
$wvpo = $_GET["wvpo"];
$wvup = $_GET["wvup"];
$wvwa = $_GET["wvwa"];
$wvba = $_GET["wvba"];
$wvoh = $_GET["wvoh"];



$SQL = " UPDATE [07SL1C] 
          SET 
          [01C]='$fs', 
          [01RC]='$fsrt', 
          [01EC]='$nfon', 
          [02C]='$refs', 
          [01RWEC]='$rewi', 
          [04C]='$nhaccp', 
          [06C]='$emws', 
          [03C]='$cb', 
          [05C]='$sfis', 
          [01CAEC]='$califsh', 
          [01IDEC]='$idfsh', 
          [01NMEC]='$nmfsh', 
          [01VACCEC]='$vaccfsh', 
          [01FLEC]='$flfsh', 
          [01KSEC]='$ksfsh', 
          [01OHEC]='$ohfsh', 
          [01UTEC]='$utfsh', 
          [01ILEC]='$ilfsh', 
          [01AZEC]='$azfsh', 
          [01MOEC]='$mofsh', 
          [01TXEC]='$txfsh', 
          [01WVMVEC]='$WVMV',
          [09C]='$aa', 
          [10C]='$ad', 
          [11C]='$as' 
          WHERE VC='$VC' 

        ";

        $resultset=mssql_query($SQL, $con);

        if($resultset){
            echo "The price group was successfully updated.";
        }
        else{
            echo "There was an error updating the price group.";
        }


$SQL2 = " UPDATE [07SL1WV] 
          SET 
          [01WVCHEC]='$wvch', 
          [01WVMNEC]='$wvmn', 
          [01WVPEEC]='$wvpe', 
          [01WVPOEC]='$wvpo', 
          [01WVUPEC]='$wvup', 
          [01WVWAEC]='$wvwa', 
          [01WVBAEC]='$wvba', 
          [01WVOHEC]='$wvoh' 
          WHERE VC='$VC' 

        ";

        $resultset2=mssql_query($SQL2, $con);


        








?>