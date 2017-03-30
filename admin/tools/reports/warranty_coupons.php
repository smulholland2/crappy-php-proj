<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<?php
error_reporting(0);
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
$user = $_SESSION['user'];
$todaysdate = date('m/d/Y');


?>

<div class="container" style="margin-top:120px;margin-bottom:100px">
    <div class="page-header">
        <h1>Warranty Coupons</h1>
    </div>
    <br>
    <a href="/account/login" class="btn btn-primary">Main Menu</a>
    <form action="warranty_coupons_view.php" method="get">
        <div class="well">
            <div class="input-daterange input-group" id="datepicker">
                <p><strong>TAP Course Start Date:</strong><br>(Date students started course)</p>
                <input type="text" class="input-sm form-control date" name="startDate" placeholder="Click here to open the 'from' calendar" style="max-width:300px"/>
                <br><br><br>
                <p><strong>TAP Course End Date:</strong><br>(Date students ended course)</p>
                <input type="text" class="input-sm form-control date" name="endDate" placeholder="Click here to open the 'to' calendar" style="max-width:300px" value="<?php echo $todaysdate;?>" />
            </div>
            <br>
            <input type="submit" class="btn btn-success" value="Submit">
        </div>        
    </form>
  
</div>

<?php //print_r($_SESSION);?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
