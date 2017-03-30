<?php 
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

$bandn = ["bnd100", "bnd101", "bnd102", "bnd103", "bnd107","bnd109", "bnd110", "bnd111", "bnd112", "bnd114", "bnd115", "bnd116", "bnd117", "bnd118", "bnd119", "bnd120", "bnd121", "bnd124", "bnd125", "bnd126", "bnd127", "bnd128", "bnd129", "bnd130", "bnd134", "bnd135", "bnd136", "bnd137", "bnd138", "bnd139", "bnd140", "bnd142", "bnd143", "bnd144", "bnd145", "bnd146", "bnd147", "bnd148", "bnd149", "bnd60", "bnd61", "bnd62", "bnd63", "bnd65", "bnd66", "bnd68", "bnd71", "bnd72", "bnd73", "bnd83", "bnd85", "bnd86", "bnd87", "bnd88", "bnd89", "bnd90", "bnd91", "bnd92", "bnd94", "bnd95", "bnd96", "bnd98", "bnd97", "bnd00"];

/*
foreach ($bandn as $AN) {

//fs
$SQL = "INSERT INTO Licenses (UserId, ProductId, LicensesRemaining) 
        VALUES ('$AN', 2, -1) ";
        $resultset=mssql_query($SQL, $con);

// recert rhode island
$SQL2 = "INSERT INTO Licenses (UserId, ProductId, LicensesRemaining) 
        VALUES ('$AN', 180, -1) ";
        $resultset=mssql_query($SQL2, $con);

// recert minessota
$SQL3 = "INSERT INTO Licenses (UserId, ProductId, LicensesRemaining) 
        VALUES ('$AN', 181, -1) ";
        $resultset=mssql_query($SQL3, $con);

// allergen
$SQL4 = "INSERT INTO Licenses (UserId, ProductId, LicensesRemaining) 
        VALUES ('$AN', 166, -1) ";
        $resultset=mssql_query($SQL4, $con);

// california fh
$SQL5 = "INSERT INTO Licenses (UserId, ProductId, LicensesRemaining) 
        VALUES ('$AN', 16, -1) ";
        $resultset=mssql_query($SQL5, $con);

// texas fh
$SQL6 = "INSERT INTO Licenses (UserId, ProductId, LicensesRemaining) 
        VALUES ('$AN', 21, -1) ";
        $resultset=mssql_query($SQL6, $con);

// illinois fh
$SQL7 = "INSERT INTO Licenses (UserId, ProductId, LicensesRemaining) 
        VALUES ('$AN', 162, -1) ";
        $resultset=mssql_query($SQL7, $con);

// new mexico fh
$SQL8 = "INSERT INTO Licenses (UserId, ProductId, LicensesRemaining) 
        VALUES ('$AN', 18, -1) ";
        $resultset=mssql_query($SQL8, $con);

// florida fh
$SQL9 = "INSERT INTO Licenses (UserId, ProductId, LicensesRemaining) 
        VALUES ('$AN', 75, -1) ";
        $resultset=mssql_query($SQL9, $con);

// arizona fh
$SQL10 = "INSERT INTO Licenses (UserId, ProductId, LicensesRemaining) 
        VALUES ('$AN', 163, -1) ";
        $resultset=mssql_query($SQL10, $con);

// ohio level 1 fh
$SQL11 = "INSERT INTO Licenses (UserId, ProductId, LicensesRemaining) 
        VALUES ('$AN', 24, -1) ";
        $resultset=mssql_query($SQL11, $con);

// ohio level 2
$SQL12 = "INSERT INTO Licenses (UserId, ProductId, LicensesRemaining) 
        VALUES ('$AN', 179, -1) ";
        $resultset=mssql_query($SQL12, $con);



}

*/
?>