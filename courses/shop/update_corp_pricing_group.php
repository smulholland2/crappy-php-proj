<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.');
?>

<!DOCTYPE html>
<html>
<head>
<title>Update Corporate Pricing Group</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="page-header">
        <h1>Update Corporate Pricing Group</h1>
    </div>

    <form class="form-horizontal" action='update_corp_pricing_group_list.php' method='get'>
    <div class='form-group'>
        <label>Select Corporate Pricing Group:</label>

        <?php
            $SQL1="SELECT NC, VC FROM [07SL1C]";				
            $resultset1=mssql_query($SQL1, $con);

                        echo "<select name='VC'  class='form-control'>";
                while ($row = mssql_fetch_array($resultset1)) 
                    {
                            $NC = $row['NC'];
                            $VC = $row['VC'];
                        echo "<option value='$VC'>$NC ($VC)</option>";
                    }
                        echo "</select>";
        ?>
    </div>    
    <div class="form-group">
    <button type="submit" class="btn btn-primary">Submit</button>
    </div>    
    </form>    

</div>

</body>
</html>