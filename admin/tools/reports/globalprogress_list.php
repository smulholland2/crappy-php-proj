<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

session_start();
$corp_user = trim($_SESSION['user']);

$start = $_GET['start']; 
$end = $_GET['end']; 
$productid = $_GET['productid']; 
$corp_sub_acct_id = $_GET['corp_sub_acct_id']; 
$count=1;

// gets sub account username using the corp id value
$SQL8 = "SELECT UU FROM [07L2] WHERE id='$corp_sub_acct_id' ";
$resultset8=mssql_query($SQL8, $con); 
while ($row = mssql_fetch_array($resultset8)) 
{
     $sub_UU = $row['UU'];
     $sub_UU = trim($sub_UU);
}

//if corporate username and sub corporate username are the same create an array with all the sub account ids, this will show all the students from all sub accounts
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



//get course name
if($productid==2 || $productid==4 || $productid==5 || $productid==7 || $productid==10 || $productid==13 || $productid==16 || $productid==17 || $productid==18 || $productid==19 || $productid==20 || $productid==21 || $productid==22)
{

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



/*
    $SQL2 = "SELECT AN FROM [07L3] WHERE CA='$corp_sub_acct_id ' ";		
    $resultset2=mssql_query($SQL2, $con); 
    while ($row = mssql_fetch_array($resultset2)) 
    {
        $AN = $row['AN'];
    }
*/


?>

<div class="container" style="margin-top:90px;margin-bottom:90px">
    <div class="page-header">
        <h1>Global Score Report</h1>
    </div>
    <input type="button" value="Go Back" onclick="goBack()" class="btn btn-primary">
    <p><strong>Date range of report:</strong> <?php echo $start;?> - <?php echo $end;?></p>
    <p><strong>Corporate Administrator:</strong> <?php echo $corp_user;?></p>
    <p><strong>Course Name:</strong> <?php echo $course_name;?></p>    
    <br>
    <br>

      

<?php

//for every corporate id in the array run the following code
foreach ($id_array as $id_from_array) 
{
    

    $SQL2 = "SELECT AN FROM [07L3] WHERE CA='$id_from_array' ";		
    $resultset2=mssql_query($SQL2, $con); 
    while ($row = mssql_fetch_array($resultset2)) 
    {
        $count=1;
        $AN = $row['AN'];

        $SQL10 = "SELECT UU, F90 FROM [07L2] WHERE id='$id_from_array' ";
        $resultset10=mssql_query($SQL10, $con); 
        while ($row = mssql_fetch_array($resultset10)) 
        {
            $regional_admin = $row['UU'];
            $F90 = $row['F90'];
            if($F90==1){
                $minimum_fs_test_score=90;
            }
            else{
                $minimum_fs_test_score=75;
            }
        }
            
            echo "<p><strong>Regional administrator:  $regional_admin</p>";
            echo "<p><strong>Unit/Class Administrator: $AN</p>";
            echo "<table class='table table-striped table-hover'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>Last Name</th>";
            echo "<th>First Name</th>";
            echo "<th>Username</th>";
            echo "<th>Password</th>";
            echo "<th>Email</th>";
            echo "<th>Date Added</th>";
            echo "<th>Progress</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            

        if($productid=="aa" || $productid=="ad" || $productid=="as"  || $productid=="cb"  || $productid=="cf" || $productid=="refs" || $productid=="rewi" || $productid=="nhaccp" || $productid=="sfis" || $productid=="emws" || $productid=="fsrt"){
        $SQL3 = "SELECT NF, NL, UU, UC, UM, DA, DE, DS FROM [$student_table] WHERE UA='$AN' AND DA >= '$start' AND  DA <= '$end' ORDER BY NL";
        }
        else{
        $SQL3 = "SELECT NF, NL, UU, UC, UM, DA, DE, DS FROM [$student_table] WHERE UA='$AN' AND ME='$productid' AND DA >= '$start' AND  DA <= '$end' ORDER BY NL";		
        }
        $resultset3=mssql_query($SQL3, $con); 
        while ($row = mssql_fetch_array($resultset3)) 
        {


            $progress = "NA";

            $UM = $row['UM'];
            $NF = $row['NF'];
            $NL = $row['NL'];
            $UU = $row['UU'];
            $UC = $row['UC'];
            $DS = $row['DS'];
            $DE = $row['DE'];
            $DA = $row['DA'];
            $DA = strtotime($DA);
            $DA = date('F d, Y', $DA);




            // gets the score received on exam and checks if the student passed or failed
            if(isset($DE)){
                if($productid==1 || $productid=="fsrt"){
                    $SQL11="SELECT PER FROM [01P] WHERE UU='$UU' AND NUM=15";
                    $resultset11=mssql_query($SQL11, $con);
                    while ($row = mssql_fetch_array($resultset11)) 
                    {
                        $PER_fs = $row['PER'];
                    }
                    if($PER_fs>=$minimum_fs_test_score){
                        $progress = "Passed";
                    }
                    else{
                        $progress = "Failed";
                    }
                }
                //no test
                if($productid=="refs"){
                    $SQL11="SELECT PER FROM [02P] WHERE UU='$UU' AND NUM=15";
                    $resultset11=mssql_query($SQL11, $con);
                    while ($row = mssql_fetch_array($resultset11)) 
                    {
                        $PER_refs = $row['PER'];
                    }
                    if($PER_refs>=80){
                        $progress = "Passed";
                    }
                    else{
                        $progress = "Failed";
                    }
                }
                if($productid==20 || $productid==3 || $productid==7 || $productid==21 || $productid==22 || $productid==10){
                    $SQL11="SELECT PER FROM [01P] WHERE UU='$UU' AND NUM=11";
                    $resultset11=mssql_query($SQL11, $con);
                    while ($row = mssql_fetch_array($resultset11)) 
                    {
                        $PER_reg_fh = $row['PER'];
                    }
                    if($PER_reg_fh>=70){
                        $progress = "Passed";
                    }
                    else{
                        $progress = "Failed";
                    }
                }
                if($productid==2){
                    $SQL11="SELECT PER FROM [01P] WHERE UU='$UU' AND NUM=01";
                    $resultset11=mssql_query($SQL11, $con);
                    while ($row = mssql_fetch_array($resultset11)) 
                    {
                        $PER_nfon = $row['PER'];
                    }
                    if($PER_nfon>=75){
                        $progress = "Passed";
                    }
                    else{
                        $progress = "Failed";
                    }
                }
                if($productid==18){
                    $SQL11="SELECT PER FROM [01P] WHERE UU='$UU' AND NUM=01";
                    $resultset11=mssql_query($SQL11, $con);
                    while ($row = mssql_fetch_array($resultset11)) 
                    {
                        $PER_ksfsh = $row['PER'];
                    }
                    if($PER_ksfsh>=80){
                        $progress = "Passed";
                    }
                    else{
                        $progress = "Failed";
                    }
                }
                if($productid==19){
                    $SQL11="SELECT PER FROM [01P] WHERE UU='$UU' AND NUM=13";
                    $resultset11=mssql_query($SQL11, $con);
                    while ($row = mssql_fetch_array($resultset11)) 
                    {
                        $PER_utfsh = $row['PER'];
                    }
                    if($PER_utfsh>=75){
                        $progress = "Passed";
                    }
                    else{
                        $progress = "Failed";
                    }
                }
                if($productid=="aa"){
                    $SQL11="SELECT PER FROM [09P] WHERE UU='$UU' AND NUM=02";
                    $resultset11=mssql_query($SQL11, $con);
                    while ($row = mssql_fetch_array($resultset11)) 
                    {
                        $PER_aa = $row['PER'];
                    }
                    if($PER_aa>=75){
                        $progress = "Passed";
                    }
                    else{
                        $progress = "Failed";
                    }
                }
                
                // no test
                if($productid=="cb" || $productid=="cf"){
                    $SQL11="SELECT PER FROM [03P] WHERE UU='$UU' AND NUM=19";
                    $resultset11=mssql_query($SQL11, $con);
                    while ($row = mssql_fetch_array($resultset11)) 
                    {
                        $PER_cb = $row['PER'];
                    }
                    if($PER_cb>=70){
                        $progress = "Passed";
                    }
                    else{
                        $progress = "Failed";
                    }
                }
                if($productid=="nhaccp"){
                    $SQL11="SELECT PER FROM [04P] WHERE UU='$UU' AND NUM=10";
                    $resultset11=mssql_query($SQL11, $con);
                    while ($row = mssql_fetch_array($resultset11)) 
                    {
                        echo $PER_nhaccp = $row['PER'];
                    }
                    if($PER_nhaccp>=80){
                        $progress = "Passed";
                    }
                    else{
                        $progress = "Failed";
                    }
                }
                
            }
            //if students doesnt have a Date End it means he hasn't completed the course, so the code below will check on what lesson he is in
            else{
                $SQL13="SELECT MAX(NUM) AS LastCourse FROM [$scores_table] WHERE UU='$UU' AND DE<>''";
                $resultset13=mssql_query($SQL13, $con);
                while ($row = mssql_fetch_array($resultset13)) 
                {
                    $PER_last = $row['LastCourse'];
                }
                    $PER_last = $PER_last+1;
                    $progress = 'Lesson '.$PER_last;
            }

            //if the student doesn't have a
            if(!isset($DS)){
                $progress = "Not Started";
            }


            if($UC == "expired"){
                $UC = "**expired**";
            }

        

            echo "<tr>";
            echo "<td>$count</td>";
            echo "<td>$NL</td>";
            echo "<td>$NF</td>";
            echo "<td>$UU</td>";
            echo "<td>$UC</td>";
            echo "<td>$UM</td>";
            echo "<td>$DA</td>";
            echo "<td>$progress</td>";
            echo "</tr>";

            $count=$count+1;
        }
            
            echo "</tbody>";
            echo "</table>";
    }
}
?>

      

</div>

<script>
function goBack() {
    window.history.back()
}
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>