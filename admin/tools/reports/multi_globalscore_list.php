<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/config/connection.php';?>

<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

session_start();
$corp_user = trim($_SESSION['user']);

$start = $_GET['start']; 
$end = $_GET['end']; 
$productid = $_GET['productid']; 
$corp_sub_acct_id = $_GET['corp_sub_acct_id'];

$isFranchiseSet = false;
$franchiseCheck = CheckFranchiseSet($corp_user);
if($franchiseCheck['FRANCHISESET'] == 1)
    $isFranchiseSet = true;

$SQL8 = "SELECT UU FROM [07L2] WHERE id='$corp_sub_acct_id' ";
$resultset8=mssql_query($SQL8, $con); 
while ($row = mssql_fetch_array($resultset8)) 
{
     $sub_UU = $row['UU'];
     $sub_UU = trim($sub_UU);
}

if($corp_user == $sub_UU){
    $SQL9 = "SELECT id FROM [07L2] WHERE SUB='$corp_user' ";
    $resultset9=mssql_query($SQL9, $con); 
    while ($row = mssql_fetch_array($resultset9)) 
    {
         $id_array[] = $row['id'];
         //print_r($id_array);
    }
}
else{
    $id_array[] = $corp_sub_acct_id;
    //print_r($id_array);
}

//print_r($id_array);


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




    $SQL2 = "SELECT AN FROM [07L3] WHERE CA='$corp_sub_acct_id ' ";		
    $resultset2=mssql_query($SQL2, $con); 
    while ($row = mssql_fetch_array($resultset2)) 
    {
        $AN = $row['AN'];
    }



?>
<link rel="stylesheet" type="text/css" href="/wwwroot/lib/css/bootstrap-sortable.min.css">
<div class="container" style="margin-top:90px;margin-bottom:90px">
    <div class="page-header text-center">
        <h1>Global Score Report</h1>
    </div>
    <input type="button" value="Go Back" onclick="goBack()" class="btn btn-primary">
    <p><strong>Date range of report:</strong> <?php echo $start;?> - <?php echo $end;?></p>
    <p><strong>Corporate Administrator:</strong> <?php echo $corp_user;?></p>
    <p><strong>Course Name:</strong> <?php echo $course_name;?></p>    
    <br><br>

      

<?php
foreach ($id_array as $id_from_array) {    
    $SQL2 = "SELECT AN FROM [07L3] WHERE CA='$id_from_array' ";		
    $resultset2=mssql_query($SQL2, $con); 
    $index = 0;
    while ($row = mssql_fetch_array($resultset2)) 
    {
        $index++;
        $count=1;
        $AN = $row['AN'];

        $SQL10 = "SELECT UU FROM [07L2] WHERE id='$id_from_array' ";
        $resultset10=mssql_query($SQL10, $con);        
        while ($row = mssql_fetch_array($resultset10)) 
        {
            $regional_admin = $row['UU'];
        }
            
            echo "<p><strong>Regional administrator:  $regional_admin</p>";
            echo "<p><strong>Unit/Class Administrator: $AN</p>";
            echo "<button id='save-btn-".$index."' class='save-data btn btn-primary' data-toggle='tooltip' data-placement='top' 
                title='This data will be saved to a file that can be viewed in Microsoft Excel.'>
                Save This Data to File</button>";
            echo "<table id='report-table-".$index."' class='table table-striped table-hover sortable'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>#</th>";
            if($isFranchiseSet)
                echo "<th>Store Number</th>";
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
        $SQL3 = "SELECT NF, NL, UU, UC, UM, FRANCHNO FROM [$student_table] WHERE UA='$AN' AND DA >= '$start' AND  DA <= '$end' ORDER BY NL";
        }
        else{
        $SQL3 = "SELECT NF, NL, UU, UC, UM, FRANCHNO FROM [$student_table] WHERE UA='$AN' AND ME='$productid' AND DA >= '$start' AND  DA <= '$end' ORDER BY NL";
        }
        $resultset3=mssql_query($SQL3, $con); 
        while ($row = mssql_fetch_array($resultset3)) 
        {
            
            //die('<br>'.var_dump($row).'<br>');
            $NF = $row['NF'];
            $NL = $row['NL'];
            $UU = $row['UU'];
            $UC = $row['UC'];
            if($UC == "expired"){
                $UC = "**expired**";
            }
            $UM = $row['UM'];

            // Set the FRANCHNO to be displayed in the table on accounts that track store numbers.
            if(isset($row['FRANCHNO']))
                $FRANCHNO = $row['FRANCHNO'];

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

            
            echo "<td class='rownum'>$count</td>";
            // Show the store number for accounts that keep track of it.
            if(isset($FRANCHNO) && $isFranchiseSet)
                echo "<td>$FRANCHNO</td>";
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
    }
}
function CheckFranchiseSet($account)
{
    $context = new Db();

    $stmt = 'CheckFranchiseSet';
    $params = '@account';

    return $context -> ExecuteStoredProcedure($stmt,$account,$params);
}
?>

      

</div>

<script>
function goBack() {
    window.history.back()
}
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
<script src="/wwwroot/lib/js/bootstrap-sortable.min.js"></script>
<script src="/wwwroot/lib/js/FileSaver.min.js"></script>
<script src="/wwwroot/lib/js/xlsx.core.min.js"></script>
<script src="/wwwroot/lib/js/tableExport.min.js"></script>
<script>

(function () {
    var $table = $('table');
    console.log($table.length);

    $table.on('sorted', function() { 
        var count = $('tr').length;
        var $rows = $('tr');
        for(var i = 1; i < count; i++)
        {
            $($rows[i]).find('.rownum').html(i);
        }
    });

}());

</script>