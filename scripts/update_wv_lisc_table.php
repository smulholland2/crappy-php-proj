
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
        $sql = "SELECT [UA],[FSWVBANum],[FSWVCHNum],[FSWVMNNum],[FSWVOHNum],[FSWVPENum],[FSWVPONum],[FSWVUPNum],[FSWVWANum],[FSWVMVNum] ";
        $sql .= "FROM (SELECT ROW_NUMBER() OVER(ORDER BY (select NULL as noorder)) AS RowNum, * ";
        $sql .= "FROM [07DS1]";
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
            if($user["FSWVBANum"] > 0 && $user["FSWVBANum"] != "")
            {          
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',77,'".$user["FSWVBANum"]."')";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVBANum"] == -1)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',77,-1)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVBANum"] == -2)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',77,-2)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVBANum"] == -3)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',77,-3)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }




            // 2ND COLUMN
            if($user["FSWVCHNum"] > 0 && $user["FSWVCHNum"] != "")
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',83,'".$user["FSWVCHNum"]."')";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVCHNum"] == -1)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',83,-1)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVCHNum"] == -2)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',83,-2)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVCHNum"] == -3)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',83,-3)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }





            if($user["FSWVMNNum"] > 0 && $user["FSWVMNNum"] != "")
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',110,'".$user["FSWVMNNum"]."')";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVMNNum"] == -1)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',110,-1)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVMNNum"] == -2)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',110,-2)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVMNNum"] == -3)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',110,-3)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }






            if($user["FSWVOHNum"] > 0 && $user["FSWVOHNum"] != "")
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',113,'".$user["FSWVOHNum"]."')";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVOHNum"] == -1)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',113,-1)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVOHNum"] == -2)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',113,-2)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVOHNum"] == -3)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',113,-3)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }






            if($user["FSWVPENum"] > 0 && $user["FSWVPENum"] != "")
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',114,'".$user["FSWVPENum"]."')";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVPENum"] == -1)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',114,-1)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVPENum"] == -2)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',114,-2)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVPENum"] == -3)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',114,-3)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }






            if($user["FSWVPONum"] > 0 && $user["FSWVPONum"] != "")
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',115,'".$user["FSWVPONum"]."')";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVPONum"] == -1)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',115,-1)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVPONum"] == -2)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',115,-2)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVPONum"] == -3)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',115,-3)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }






            if($user["FSWVUPNum"] > 0 && $user["FSWVUPNum"] != "")
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',123,'".$user["FSWVUPNum"]."')";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVUPNum"] == -1)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',123,-1)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVUPNum"] == -2)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',123,-2)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVUPNum"] == -3)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',123,-3)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }






            if($user["FSWVWANum"] > 0 && $user["FSWVWANum"] != "")
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',124,'".$user["FSWVWANum"]."')";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVWANum"] == -1)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',124,-1)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVWANum"] == -2)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',124,-2)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVWANum"] == -3)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',124,-3)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }






            if($user["FSWVMVNum"] > 0 && $user["FSWVMVNum"] != "")
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',157,'".$user["FSWVMVNum"]."')";
                
                $stmt = mssql_query ( $sql , $conn );
            }
            else if($user["FSWVMVNum"] == -1)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',157,-1)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }
            else if($user["FSWVMVNum"] == -2)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',157,-2)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            } 
            else if($user["FSWVMVNum"] == -3)
            {
                $sql = "INSERT INTO [Licenses] VALUES ('".$user['UA']."',157,-3)";
                $stmt = mssql_query ( $sql , $conn );
                $records++;
            }

           

            echo $records . "\r\n";
        }
    }

    echo "License Table Updated: " .time();

?>