<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
$corp_user = $_SESSION['user'];
$admintable = $_SESSION['admintable'];

if($admintable=="07L3"){
    $view_report = "businessprogress_view.php";
    $type = "a";
}
if($admintable=="07SL4"){
    $view_report = "instructor_businessprogress_view.php";
    $type = "v";
}
if($admintable=="07L2"){
    $view_report = "multi_businessprogress_view.php";
    $type = "c";
}

$SQL="SELECT weeks, minimumScore FROM CCCR WHERE corp='$corp_user' ";
$resultset=mssql_query($SQL, $con); 
while ($row = mssql_fetch_array($resultset)) 
{
     $weeks = $row['weeks'];
     $minimumScore = $row['minimumScore'];
 }
?>

<div class="container" style="margin-top:120px;margin-bottom:100px">
    <div class="page-header">
        <h1>Color Coded Progress Report - <small>Business</small></h1>
    </div>
    <a href="/account/login" class="btn btn-primary">Main Menu</a>
    <!-- message after updating or creating record -->
    <div class="alert alert-success" <?php if($_SESSION["CCCR_updated"]){echo "style='display:block'";}else{echo "style='display:none'";}?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>The information was successfully updated!</strong>
    </div>

    <!-- message after deleting record -->
    <div class="alert alert-success" <?php if($_SESSION["CCCR_deleted"]){echo "style='display:block'";}else{echo "style='display:none'";}?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>The information was successfully deleted!</strong>
    </div>


    <div class="alert alert-info alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>Specialized for Businesses that enroll their students on an ongoing basis.</strong>
    </div>
    <p><strong>Instructions:</strong><br>Enter the required information below to receive a weekly color coded progress report via email.</p>
    <p><strong>Minimum date range is one week.</strong> There are 15 lessons in the course. The number of lessons required to be completed each week will be a division of the number of weeks selected. Example: If the date range set is 4 weeks the number of lessons required to be completed each week would be 4 lessons. Eight weeks would be 2 lessons, and so on. The report will cover the number of weeks selected below.</p>
    <br>
    <form action="businessprogress_save.php" method="get">
        <div class="well">
        <p><strong>TAP Course Weeks:&nbsp;</strong>(Weeks students should be finished within)<br><input type="number" name="weeks" style="width:50px" value="<?php echo $weeks;?>"><strong> weeks</strong></p>
        <br>
        <p><strong>What is the minimum score requirement on the practice test?</strong><br><input type="number" name="minimumScore" style="width:50px" value="<?php echo $minimumScore;?>"><strong> %</strong></p>
        <input type="hidden" value="<?php echo $type;?>" name="type">
        <br>
        <input type="submit" class="btn btn-success" value="Save">
        </div>
        <br>
    </form>
    <a href="<?php echo $view_report;?>" class="btn btn-primary" role="button">View Report</a>
    <br>
    <span>(Must save the report first, then click here to view a copy of the report)</span>
    <br><br>
    <a href="businessprogress_delete.php" class="btn btn-primary" role="button">Stop Report</a>
    <br>
    <span>(This will delete the report and stop the weekly emails)</span>
  
</div>

<?php unset($_SESSION["CCCR_updated"]); ?>
<?php unset($_SESSION["CCCR_deleted"]); ?>
<?php //print_r($_SESSION);?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
