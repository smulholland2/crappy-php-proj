
<?php

    $host = "tapseries-qa.ckxc7bgyoazb.us-west-2.rds.amazonaws.com";
    $usrn = "awsuser";
    $pass = "rJYb99iN5Rp4";
    $mydb = "newtap";

    $conn = mssql_connect($host, $usrn, $pass);
    mssql_select_db($mydb, $conn);

    
    ini_set('memory_limit', '-1');
    echo "Begin license update: " . time() . "\r\n";
    // Dump the data from [07DS1] into [Licenses] with a new structure.    
    $records = 0;
    //$sql = "TRUNCATE TABLE [newtap].[dbo].[Licenses]";
    //$stmt = mssql_query($sql, $conn);
    for ($i = 0; $i < 500; $i++) {        
        $lower = ($i * 500) + 1;
        $upper = $lower + 500 - 1;
        $sql = "SELECT [UA],[FSTXGENNum] ";
        $sql .= "FROM (SELECT ROW_NUMBER() OVER(ORDER BY (select NULL as noorder)) AS RowNum, * ";
        $sql .= "FROM [07DS1TX]";
        $sql .= ") as alias ";
        $sql .= "WHERE RowNum BETWEEN ".$lower." AND ".$upper;
        //$sql .= "WHERE RowNum BETWEEN 135079 AND 191505";
        $stmt = mssql_query ( $sql , $conn );
        $companylisc = [];
        while($row = mssql_fetch_assoc($stmt)) {
            if(count($row) > 0)
                array_push($companylisc, $row);
        }

        echo "License Table Loaded\r\n";
        foreach ($companylisc as $user)
        {         
            // FIRST COLUMN   
            if($user["FSTXGENNum"] > 0 && $user["FSTXGENNum"] != "")
            {          
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',21,'".$user["FSTXGENNum"]."')";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSTXGENNum"] == -1)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',21,-1)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSTXGENNum"] == -2)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',21,-2)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSTXGENNum"] == -3)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',21,-3)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }

           

            echo $records . "\r\n";
        }
    }

    echo "License Table Updated: " .time();

?>