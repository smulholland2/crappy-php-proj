<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

session_start();
$AN = trim($_SESSION['user']);

$start = $_GET['start']; 
$end = $_GET['end']; 
$productid = $_GET['productid']; 

//course name
if($productid==2 || $productid==4 || $productid==5 || $productid==7 || $productid==10 || $productid==13 || $productid==16 || $productid==17 || $productid==18 || $productid==19 || $productid==20 || $productid==21 || $productid==22){

    $SQL7 = "SELECT ProductName FROM [07DS2] WHERE JobType='$productid' ";
    $resultset7=mssql_query($SQL7, $con); 
    while ($row = mssql_fetch_array($resultset7)) 
    {
        $course_name = $row['ProductName'];
    }

    $student_table = "01D";
    $scores_table = "01P";
}
if($productid==1){
    $course_name = "Food Safety Manager Certification Training";
    $student_table = "01D";
    $scores_table = "01P";
}
if($productid==3){
    $course_name = "California Food Handler Training";
    $student_table = "01D";
    $scores_table = "01P";
}
if($productid=="fsrt"){
    $course_name = "Retail Food Safety Manager Certification Training";
    $student_table = "01D";
    $scores_table = "01P";
}
if($productid=="refs"){
    $course_name = "Food Safety Re-Certification Training";
    $student_table = "02D";
    $scores_table = "02P";
}
if($productid=="rewi"){
    $course_name = "Wisconsin Re-Certification Training";
    $student_table = "02D";
    $scores_table = "02P";
}
if($productid=="cb"){
    $course_name = "Cooking Basics";
    $student_table = "03D";
    $scores_table = "03P";
}
if($productid=="cf"){
    $course_name = "Chef Fundamentals";
    $student_table = "03D";
    $scores_table = "03P";
}
if($productid=="nhaccp"){
    $course_name = "HACCP Managers Certificate Course";
    $student_table = "04D";
    $scores_table = "04P";
}
if($productid=="sfis"){
    $course_name = "Strategies for Increasing Sales";
    $student_table = "05D";
    $scores_table = "05P";
}
if($productid=="emws"){
    $course_name = "Earn More With Service";
    $student_table = "06D";
    $scores_table = "06P";
}
if($productid=="aa"){
    $course_name = "Allergen Awareness";
    $student_table = "09D";
    $scores_table = "09P";
}
if($productid=="ad"){
    $course_name = "Allergen Plan Development";
    $student_table = "10D";
    $scores_table = "10P";
}
if($productid=="as"){
    $course_name = "Allergen Plan Specialist";
    $student_table = "11D";
    $scores_table = "11P";
}


?>

<div class="container" style="margin-top:90px;margin-bottom:90px">
    <div class="page-header">
        <h1>Global Score Report</h1>
    </div>
    <input type="button" value="Go Back" onclick="goBack()" class="btn btn-primary">
    <p><strong>Date range of report:</strong> <?php echo $start;?> - <?php echo $end;?></p>
    <p><strong>Course Name:</strong> <?php echo $course_name;?></p>
    <p><strong>Unit/Class Administrator:</strong> <?php echo $AN;?></p>
    <br><br>

      

<?php

        $count=1;

            
            echo "<table class='table table-striped table-hover'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>Last Name</th>";
            echo "<th>First Name</th>";
            echo "<th>Username</th>";
            echo "<th>Password</th>";
            echo "<th>Email</th>";
            echo "<th>L1</th>";
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<th>L2</th>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<th>L3</th>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<th>L4</th>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<th>L5</th>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<th>L6</th>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<th>L7</th>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<th>L8</th>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<th>L9</th>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<th>L10</th>";
            }
            if($productid!=2 && $productid!="nhaccp" && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<th>L11</th>";
            }
            if($productid==1 || $productid=="refs" || $productid=="fsrt"){
            echo "<th>L12</th>";
            }
            if($productid==1 || $productid=="refs" || $productid=="fsrt"){
            echo "<th>L13</th>";
            }
            if($productid==1 || $productid=="refs" || $productid=="fsrt"){
            echo "<th>L14</th>";
            }
            if($productid==1 || $productid=="fsrt"){
            echo "<th <?php>L15</th>";
            }
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            

        if($productid=="aa" || $productid=="ad" || $productid=="as"  || $productid=="cb"  || $productid=="cf" || $productid=="refs" || $productid=="rewi" || $productid=="nhaccp" || $productid=="sfis" || $productid=="emws" || $productid=="fsrt"){
        $SQL3 = "SELECT NF, NL, UU, UC, UM FROM [$student_table] WHERE UA='$AN' AND DA >= '$start' AND  DA <= '$end' ORDER BY NL";
        }
        else{
        $SQL3 = "SELECT NF, NL, UU, UC, UM FROM [$student_table] WHERE UA='$AN' AND ME='$productid' AND DA >= '$start' AND  DA <= '$end' ORDER BY NL";		
        }
        $resultset3=mssql_query($SQL3, $con); 
        while ($row = mssql_fetch_array($resultset3)) 
        {
            

            $NF = $row['NF'];
            $NL = $row['NL'];
            $UU = $row['UU'];
            $UC = $row['UC'];
            if($UC == "expired"){
                $UC = "**expired**";
            }
            $UM = $row['UM'];

                $PER01 = "-";
                $PER02 = "-";
                $PER03 = "-";
                $PER04 = "-";
                $PER05 = "-";
                $PER06 = "-";
                $PER07 = "-";
                $PER08 = "-";
                $PER09 = "-";
                $PER10 = "-";
                $PER11 = "-";
                $PER12 = "-";
                $PER13 = "-";
                $PER14 = "-";
                $PER15 = "-";

                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=01";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER01 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=02";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER02 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=03";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER03 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=04";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER04 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=05";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER05 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=06";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER06 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=07";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER07 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=08";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER08 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=09";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER09 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=10";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER10 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=11";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER11 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=12";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER12 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=13";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER13 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=14";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER14 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=15";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER15 = $row['PER'];
                }


            echo "<tr>";

            
            echo "<td>$count</td>";
            echo "<td>$NL</td>";
            echo "<td>$NF</td>";
            echo "<td>$UU</td>";
            echo "<td>$UC</td>";
            echo "<td>$UM</td>";
            echo "<td>$PER01</td>";
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<td>$PER02</td>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<td>$PER03</td>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<td>$PER04</td>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<td>$PER05</td>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<td>$PER06</td>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<td>$PER07</td>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<td>$PER08</td>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<td>$PER09</td>";
            }
            if($productid!=2 && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<td>$PER10</td>";
            }
            if($productid!=2 && $productid!="nhaccp" && $productid!=5 && $productid!=13 && $productid!=18){
            echo "<td>$PER11</td>";
            }
            if($productid==1 || $productid=="refs" || $productid=="fsrt"){
            echo "<td>$PER12</td>";
            }
            if($productid==1 || $productid=="refs" || $productid=="fsrt"){
            echo "<td>$PER13</td>";
            }
            if($productid==1 || $productid=="refs" || $productid=="fsrt"){
            echo "<td>$PER14</td>";
            }
            if($productid==1  || $productid=="fsrt"){ 
            echo "<td>$PER15</td>";
            }
            echo "</tr>";
            




            $count=$count+1;
        }
            
            echo "</tbody>";
            echo "</table>";
    

?>

      

</div>

<script>
function goBack() {
    window.history.back()
}
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>