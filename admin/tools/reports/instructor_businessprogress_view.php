<!DOCTYPE html>
<html lang="en">
<head>
  <title>Business Color-Coded Progress Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body> 
<?php 
if($_GET["emailReport"]){
    include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-nomenu.php';
}
else{
    include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';
}
?>
<?php
error_reporting(0);

$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

$todaysdate = date('m/d/Y');


session_start();
$inst_user = $_SESSION['user'];

// get Proid
$SQL="SELECT id FROM [07SL4] WHERE IU='$inst_user' ";
$resultset=mssql_query($SQL, $con);
while ($row = mssql_fetch_array($resultset)) 
{
     $PROid = $row['id'];
 }

// get info needed to run report
$SQL1="SELECT weeks, minimumScore FROM CCCR WHERE corp='$inst_user' ";
$resultset1=mssql_query($SQL1, $con);
while ($row = mssql_fetch_array($resultset1)) 
{
     $weeks = $row['weeks'];
     $minimumScore = $row['minimumScore'];
 }

$days_added = $weeks*7+1;
$dateweeksago = strtotime($todaysdate  -$days_added .'days');
$dateweeksago=date('m/d/Y', $dateweeksago);
 
?>

<div class="container" style='margin-top:90px;margin-bottom:90px'>
    <div class="page-header text-center">
        <h1>Color-Coded Report - <small>Business</small></h1>
    </div>
    <input type="button" value="Go Back" onclick="goBack()" class="btn btn-primary" <?php if($_GET["emailReport"]){echo "style='display:none'";}?>>
    <div class="well">
    <p><strong>STATUS</strong></p>
    <p style="margin-left:50px"><strong>DATE:</strong> The date the student completed the Test in Lesson 15 with a minimum passing grade of <?php echo $minimumScore;?>%.</p>
    <p style="margin-left:50px"><strong>LESSON NUMBER:</strong> The Lesson number that the student last passed.</p>
    <br>
    <p><strong>REPORT COLORS</strong></p>
     <p><span class="glyphicon glyphicon-stop" style="color:white;border:1px solid #ddd"></span> Students with no color means student is in compliance.</p>
     <p><span class="glyphicon glyphicon-stop" style="color:yellow;border:1px solid #ddd;background-color:yellow"></span> Student is not in compliance with lessons per week.</p>
     <p><span class="glyphicon glyphicon-stop" style="color:#D9534F;border:1px solid #ddd;background-color:#D9534F"></span> Student has completed less than 50% of the required lessons.</p>
     <p><span class="glyphicon glyphicon-stop" style="color:#55D4FF;border:1px solid #ddd;background-color:#55D4FF"></span> Percentage of Students that are current with all lessons.</p>
     </div>
     <br>
     <div class="well">
     <p><strong>Report Date: </strong><?php echo $todaysdate;?></p>
     <p><strong>Class: </strong><?php echo $inst_user;?></p>
     <p><strong>Weeks Selected: </strong><?php echo $weeks;?></p>
     <p><strong>Minimum Score: </strong><?php echo $minimumScore;?>%</p>
     </div>     


<?php


$start = $dateweeksago; 
$end = $todaysdate; 
$productid = 1; 


// get all the AN that share the PROid
$SQL8 = "SELECT AN FROM [07L3] WHERE PRO='$PROid' ";
$resultset8=mssql_query($SQL8, $con); 
while ($row = mssql_fetch_array($resultset8)) 
{
     $sub_AN[] = $row['AN'];
     //$sub_UU = trim($sub_UU);
}

//get course name
    $course_name = "Food Safety Manager Certification Training";
    $student_table = "01D";
    $scores_table = "01P";

?>

<div class="container" style="margin-top:40px">

      

<?php

//for every AN in the array run the following code
foreach ($sub_AN as $individual_sub_AN) 
{

            $count=0;

            echo "<br>";
            echo "<p><strong>Unit/Class Administrator: $individual_sub_AN</strong></p>";
            echo "<table class='table table-striped table-hover'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>Last Name</th>";
            echo "<th>First Name</th>";
            echo "<th>StuID</th>";
            echo "<th>Password</th>";
            echo "<th>Date Added</th>";
            echo "<th>Email</th>";
            
           // echo "<th>Est. Compl. Date</th>";
            //echo "<th>Est. # L Comp Weekly</th>";
            //echo "<th>Weeks since enrrollment</th>";
            //echo "<th>Lessons should be completed</th>";
            //echo "<th>Lessons completed</th>";
            echo "<th>Status</th>";
            //echo "<th>Current %</th>";
            //echo "<th>Color</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            
   
        $SQL3 = "SELECT NF, NL, UU, UC, UM, DA, DE, DS FROM [01D] WHERE UA='$individual_sub_AN' AND ME=1 AND DA >= '$start' AND  DA <= '$end' ORDER BY NL";		
        $resultset3=mssql_query($SQL3, $con); 
        while ($row = mssql_fetch_array($resultset3)) 
        {


            $progress = "NA";
            $color = "NA";
            $PER_last_nowords = 0;

            $UM = $row['UM'];
            $NF = $row['NF'];
            $NL = $row['NL'];
            $UU = $row['UU'];
            $UC = $row['UC'];
            $DS = $row['DS'];
            $DE = $row['DE'];
            $DA = $row['DA'];
            $DA = strtotime($DA);
            //$DA = date('F d, Y', $DA);
            $DA=date('m/d/Y', $DA);


            //if students doesnt have a Date Ended it means he hasn't completed the course, so the code below will check on what lesson he is in
                $SQL13="SELECT MAX(NUM) AS LastCourse FROM [01P] WHERE UU='$UU' AND DE<>''";
                $resultset13=mssql_query($SQL13, $con);
                while ($row = mssql_fetch_array($resultset13)) 
                {
                    $PER_last = $row['LastCourse'];
                    $PER_last_nowords = $row['LastCourse'];
                }

                if($PER_last_nowords==15){
                    
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
                else{
                    $PER_last = $PER_last+1;
                    
                    $progress = 'Lesson '.$PER_last;
                }
    




            if($UC == "expired"){
                $UC = "**expired**";
            }


            // adds weeks to date added 
            $DA_plus_weeks_selectd = strtotime($DA .' +'.$weeks .'weeks');
            $DA_plus_weeks_selectd=date('m/d/Y', $DA_plus_weeks_selectd);

            



            $est_lessons_comp_weekly = 15 / $weeks;

            $PER_last_nowords = ltrim($PER_last_nowords, "0");

            $datetime1 = new DateTime($DA);
            $datetime2 = new DateTime($todaysdate);
            $interval = $datetime1->diff($datetime2);
            $interval = $interval->format('%R%a');
            $num_weeks_since_DA = $interval / 7;

            $lessons_should_be_completed = $num_weeks_since_DA * $est_lessons_comp_weekly;


            if(isset($DS)){
                $SQL12="SELECT PER FROM [01P] WHERE UU='$UU' AND NUM=01";
                $resultset12=mssql_query($SQL12, $con);
                while ($row = mssql_fetch_array($resultset12)) 
                {
                    $check_lesson1 = $row['PER'];
                }
                if(!isset($check_lesson1)){
                    $PER_last_nowords = 0;
                }
            }            

            if(!isset($DS)){
                $progress = "Not Started";
                $PER_last_nowords = 0;
            }

            //if $DA exists but theres no data on 01P
            if($PER_last_nowords == ""){
               $PER_last_nowords = 0; 
            }

            $current_lesson_percentage = $PER_last_nowords / $lessons_should_be_completed * 100;

            if($current_lesson_percentage>=100){
                $color = 1;
            }
            if($current_lesson_percentage<100 && $current_lesson_percentage>50){
                $color = 2;
            }
            if($current_lesson_percentage<50){
                $color = 3;
            }

            if($num_weeks_since_DA==0){
                $color = 1;
            }

            if(strtotime($todaysdate) > strtotime($DA_plus_weeks_selectd) && $progress!= "Passed"){
                $color=3;
            }

            if(strtotime($todaysdate) > strtotime($DA_plus_weeks_selectd) && $progress== "Passed"){
                $color=1;
            }
         

            $SQL14 = "INSERT INTO CCCR_list (lastname, firstname, username, password, email, dateadded, est_completion_date, est_lessons_per_week, weeks_since_enrollment, lessons_should_be_completed, lessons_completed, status, current_percentage, color)
                    VALUES ('$NL', '$NF', '$UU', '$UC', '$UM', '$DA', '$DA_plus_weeks_selectd', '$est_lessons_comp_weekly', '$num_weeks_since_DA', '$lessons_should_be_completed', '$PER_last_nowords', '$progress', '$current_lesson_percentage', '$color')";
            $resultset14=mssql_query($SQL14, $con);
            if(!$resultset14){
                echo "there was an error inserting data on CCCR_list";
            }

            

            
            $PER_last_nowords = 0;
        }

        $SQL17 = "SELECT COUNT(username) AS totalnumberofstudents FROM CCCR_list";
        $resultset17=mssql_query($SQL17, $con);
        while ($row = mssql_fetch_array($resultset17)) 
        {
            $totalnumberofstudents = $row['totalnumberofstudents'];
        }

        
        $SQL18 = "SELECT COUNT(username) AS totalnumberofstudentsahead FROM CCCR_list WHERE color=1 ";
        $resultset18=mssql_query($SQL18, $con);
        while ($row = mssql_fetch_array($resultset18)) 
        {
            $totalnumberofstudentsahead = $row['totalnumberofstudentsahead'];
        }

        $percentage_students_in_compliance = $totalnumberofstudentsahead / $totalnumberofstudents * 100;
        $percentage_students_in_compliance = round($percentage_students_in_compliance, 2);


        $SQL16 = "SELECT * FROM CCCR_list ORDER BY color, lastname";
            $resultset16=mssql_query($SQL16, $con);
            while ($row = mssql_fetch_array($resultset16)) 
            {
                $count=$count+1;

                $lastname_db = $row['lastname'];
                $firstname_db = $row['firstname'];
                $username_db = $row['username'];
                $password_db = $row['password'];
                $email_db = $row['email'];
                $dateadded_db = $row['dateadded'];
                $est_completion_date_db = $row['est_completion_date'];
                $est_lessons_per_week_db = $row['est_lessons_per_week'];
                $weeks_since_enrollment_db = $row['weeks_since_enrollment'];
                $lessons_should_be_completed_db = $row['lessons_should_be_completed'];
                $lessons_completed_db = $row['lessons_completed'];
                $status_db = $row['status'];
                $current_percentage_db = $row['current_percentage'];
                $color_db = $row['color'];

            if($color_db==1){
                $background_color="white";
            }
            if($color_db==2){
                $background_color="#ffff66";
            }
            if($color_db==3){
                $background_color="#D9534F";
            }

            if($status_db=="Passed"){
                $SQL21="SELECT DE FROM [01P] WHERE UU='$username_db' AND NUM=15";
                $resultset21=mssql_query($SQL21, $con);
                while ($row = mssql_fetch_array($resultset21)) 
                {
                    $status_db = $row['DE'];
                    $status_db = date("m/d/Y", strtotime($status_db));
                }
            }

            echo "<tr style='background-color:$background_color;font-weight:bold'>";
            echo "<td>$count</td>";
            echo "<td>$lastname_db</td>";
            echo "<td>$firstname_db</td>";
            echo "<td>$username_db</td>";
            echo "<td>$password_db</td>";
            echo "<td>$dateadded_db</td>";
            echo "<td><a href='mailto:$email_db' style='color:black;text-decoration:underline'>$email_db</a></td>";
            
           // echo "<td>$est_completion_date_db</td>";
           // echo "<td>$est_lessons_per_week_db</td>";
           // echo "<td>$weeks_since_enrollment_db</td>";
           // echo "<td>$lessons_should_be_completed_db</td>";
            //echo "<td>$lessons_completed_db</td>";
            echo "<td>$status_db</td>";
            //echo "<td>$current_percentage_db%</td>";
            //echo "<td>$color_db</td>";
            echo "</tr>";


            }

            


            echo "<tr style='background-color:#55D4FF;font-weight:bold'><td>Percentage of Students in Compliance</td> <td>$percentage_students_in_compliance%</td><td> </td><td>  </td><td></td><td> </td><td> </td><td> </td></tr>";
            echo "</tbody>";
            echo "</table>";

            $SQL15 = "DELETE FROM CCCR_list WHERE username <>'' ";
            $resultset15=mssql_query($SQL15, $con);
            if(!$resultset15){
                echo "there was an error deleting all data on CCCR_list";
            }

            
    
    }


            
   
            
?>

      

</div>
   

</div>
<?php 
if($_GET["emailReport"]){
    include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-nomenu.php';
} 
else{
    include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';
}
?>
<script>
function goBack() {
    window.history.back()
}
</script>

</body>
</html>
