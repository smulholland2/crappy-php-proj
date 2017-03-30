<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.');

$VC = $_GET["VC"];
$NC = $_GET["NC"];

            $SQL2="SELECT * FROM [07SL1WV] WHERE VC='tapseries' ";				
            $resultset2=mssql_query($SQL2, $con);
                while ($row = mssql_fetch_array($resultset2)) 
                {
                    $wvch_price = $row['01WVCHEC'];
                    $wvmn_price = $row['01WVMNEC'];
                    $wvpe_price = $row['01WVPEEC'];
                    $wvpo_price = $row['01WVPOEC'];
                    $wvup_price = $row['01WVUPEC'];
                    $wvwa_price = $row['01WVWAEC'];
                    $wvba_price = $row['01WVBAEC'];
                    $wvoh_price = $row['01WVOHEC'];
                }


?>





<!DOCTYPE html>
<html>
<head>
<title>West Virginia Pricing Group</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="page-header">
        <h1>West Virginia Pricing Group</h1>
    </div>

    <form class="form-horizontal" action='addupdate_pricing_group_wv_db.php' method='get'>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Cabell-Huntington County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvch" value="<?php echo $wvch_price; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Monroe County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvmn" value="<?php echo $wvmn_price; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Pendleton County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvpe" value="<?php echo $wvpe_price; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Pocahontas County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvpo" value="<?php echo $wvpo_price; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Upshur County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvup" value="<?php echo $wvup_price; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Wayne County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvwa" value="<?php echo $wvwa_price; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Barbour County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvba" value="<?php echo $wvba_price; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Wheeling-Ohio County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvoh" value="<?php echo $wvoh_price; ?>">
                        </div>
                    </div>

                    <input type="hidden" name="VC" value="<?php echo $VC;?>">
                    <input type="hidden" name="NC" value="<?php echo $NC;?>">

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Create Pricing Group for WV</button>
                    </div>                    

    </form>    


</div>    

</body>
</html>