<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
$corp_user = $_SESSION['user'];
$admintable = $_SESSION['admintable'];

if($admintable=="07L3"){
    $view_report = "schoolprogress_view.php";
    $type = "a";
}
if($admintable=="07SL4"){
    $view_report = "instructor_schoolprogress_view.php";
    $type = "v";
}
if($admintable=="07L2"){
    $view_report = "multi_schoolprogress_view.php";
    $type = "c";
}


$SQL="SELECT * FROM colorCodedProgress WHERE corp='$corp_user' ";
$resultset=mssql_query($SQL, $con); 
while ($row = mssql_fetch_array($resultset)) 
{
    $startDate = $row['startDate'];
    $startDate = date("m/d/Y", strtotime($startDate));
    $endDate = $row['endDate'];
    $endDate = date("m/d/Y", strtotime($endDate));
    $minimumScore = $row['minimumScore'];
 }
?>

<div class="container" style="margin-top:120px;margin-bottom:100px">
    <div class="page-header">
        <h1>Color Coded Progress Report - <small>School</small></h1>
    </div>
    <a href="/account/login" class="btn btn-primary">Main Menu</a>
    <!-- message after updating or creating record -->
    <div class="alert alert-success" <?php if($_SESSION["colorCodedProgress_updated"]){echo "style='display:block'";}else{echo "style='display:none'";}?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>The information was successfully updated!</strong>
    </div>

    <!-- message after updating or creating record -->
    <div class="alert alert-success" <?php if($_SESSION["colorCodedProgress_deleted"]){echo "style='display:block'";}else{echo "style='display:none'";}?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>The information was successfully deleted!</strong>
    </div>

    <div class="alert alert-info alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>Specialized for Schools that enroll groups of students at a time. For example, a quarterly class.</strong>
    </div>
    <p><strong>Instructions:</strong><br>Enter the required information below to receive a weekly color coded progress report via email.</p>
    <p><strong>Minimum date range is one week.</strong> There are 15 lessons in the course. The number of lessons required to be completed each week will be a division of the number of weeks of the selected date range. Example: If the date range set is 4 weeks the number of lessons required to be completed each week would be 4 lessons. Eight weeks would be 2 lessons, and so on.</p>
    <br>
    <form action="schoolprogress_save.php" method="get">
        <div class="well">
            <div class="input-daterange input-group" id="datepicker">
                <p><strong>TAP Course Start Date:</strong><br>(Date Students will Start Course)</p>
                <input type="text" class="input-sm form-control date" name="startDate" placeholder="Click here to open the 'from' calendar" style="max-width:300px" value="<?php echo $startDate;?>" />
                <br><br><br>
                <p><strong>TAP Course End Date:</strong><br>(Date Students will End Course)</p>
                <input type="text" class="input-sm form-control date" name="endDate" placeholder="Click here to open the 'to' calendar" style="max-width:300px" value="<?php echo $endDate;?>" />
            </div>
            <br>
            <p><strong>What is the minimum score requirement on the practice test?</strong><br><input type="number" name="minimumScore" style="width:50px" value="<?php echo $minimumScore;?>"><strong> %</strong></p>
            <input type="hidden" value="<?php echo $type;?>" name="type">
            <br>
            <input type="submit" class="btn btn-success" value="Save">
        </div>        
    </form>
    <br>
    <a href="<?php echo $view_report;?>" class="btn btn-primary" role="button">View Report</a>
    <br>
    <span>(Must save the report first, then click here to view a copy of the report)</span>
    <br><br>
    <a href="schoolprogress_delete.php" class="btn btn-primary" role="button">Stop Report</a>
    <br>
    <span>(This will delete the report and stop the weekly emails)</span>
</div>

<?php unset($_SESSION["colorCodedProgress_updated"]); ?>
<?php unset($_SESSION["colorCodedProgress_deleted"]); ?>
<?php //print_r($_SESSION);?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
