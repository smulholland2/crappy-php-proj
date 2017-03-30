<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
error_reporting(0);
session_start();

$username = $_POST["username"];
$password = $_POST["password"];
$id = $_POST["id"];

//get course info
$SQL="SELECT *  FROM [07DS2] WHERE id='$id' ";
$resultset=mssql_query($SQL, $con); 
while ($row = mssql_fetch_array($resultset)) 
{
    $TableCode = trim($row['TableCode']);
    $JobType = $row['JobType'];
    $TotalLessons = $row['TotalLessons'];
    $ProductName = $row['ProductName'];
}

//get score table
$ScoresTable = str_replace('D', 'P', $TableCode);

//check if username, password and course match
if($TableCode == "01D"){
    $SQL2="SELECT *  FROM [$TableCode] WHERE UU='$username' AND UC='$password' AND ME='$JobType' ";
}
else{
    $SQL2="SELECT *  FROM [$TableCode] WHERE UU='$username' AND UC='$password' ";
}

$resultset2=mssql_query($SQL2, $con); 
while ($row = mssql_fetch_array($resultset2)) 
{
    $UU_check = $row['UU'];
    $NF = $row['NF'];
    $NL = $row['NL'];
    $UM = $row['UM'];
    $DA = $row['DA'];
    $DA = strtotime($DA);
    $DA=date('m/d/Y', $DA);
    $DE = $row['DE'];
    if(!$DE){
        $DE = "In Progress";
    }
    else{
        $DE = strtotime($DE);
        $DE=date('m/d/Y', $DE);
    }
}
            

//if something didn't match, take user to previous page
if(!$UU_check){
    $_SESSION["error"] = "Your username and password was not found in the course you selected. Please check the information and try again.";
    header("Location: studentProgress.php");
    die;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student Scores</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>

<div class="container">
  <div class="page-header">
    <h1>Student Scores</h1>
  </div>

  <div class="well">
      <h3 style="margin-top:0px">Student Information</h3>
      <p><strong>Course Name: </strong><?php echo $ProductName;?></p>
      <p><strong>Student Name: </strong><?php echo $NF." ".$NL ;?></p>
      <p><strong>Date Added: </strong><?php echo $DA;?></p>
      <p><strong>Date Completed: </strong><?php echo $DE;?></p>
  </div>

  <h4>Supplementary Study Materials</h4>
  <ul>
      <li><a href="/home/courselit" target="_blank">Post training reference materials</a></li>
  </ul>
  <hr>
  <a href="/" class="btn btn-primary" role="button">Exit</a>
  <br><br>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Lesson</th>
        <th>Lesson Title</th>
        <th>Lesson Status</th>
        <th>On Date</th>
        <th>Lesson Score</th>
      </tr>
    </thead>
    <tbody>
    
    <?php
    //get student scores
    $SQL3="SELECT *  FROM [$ScoresTable] WHERE UU='$username' AND NUM<>'00' ORDER BY NUM ";
    $resultset3=mssql_query($SQL3, $con); 
    for ($x = 1; $x <= $TotalLessons; $x++) 
    {
        $row = mssql_fetch_array($resultset3);
        $PER = $row['PER'];
        $PER_HACCP = $row['PER'];        
        $DE = $row['DE'];
        $DE = strtotime($DE);
        $DE=date('m/d/Y', $DE);
        $DE_HACCP = $DE;
    

        if($DE){
            $status = "Complete";
        }

        //adds a 0 to the string if length is equals to 1
        $LessonNumber = $x;
        if(strlen($LessonNumber) == 1){
            $LessonNumber = "0".$LessonNumber;
        }
        
        //get the title of each lesson
        $SQL4="SELECT LessonTitle  FROM [CourseTitles] WHERE ProductId='$id' AND LessonNumber='$LessonNumber' ";
        $resultset4=mssql_query($SQL4, $con); 
        while ($row = mssql_fetch_array($resultset4)) 
        {
            $LessonTitle = $row['LessonTitle'];
        }

        //show symbol when percentage is greated than 0
        $symbol = "%";

        //$PER == "" means that the student hasn't started the lesson
        if($PER == ""){
            $status = "Not Started";
            $DE = "";
            $symbol = "";
        }

        //$PER == 0 means that the student is currently on that lesson
        if($PER === 0){
            $status = "In Progress";
            $DE = "In Progress";
            $symbol = "";
            $PER = "In Progress";
        }

        //HACCP there is no score on lesson 1
        if($TableCode == "04D" && $LessonNumber == "01" && $PER_HACCP === 0 && $DE_HACCP){
            $status = "Complete";
            $DE = $DE_HACCP;
            $symbol = "%";
            $PER = 0;
        }
        

        echo "<tr>";
        echo "<td> $LessonNumber</td>";
        echo "<td> $LessonTitle</td>";
        echo "<td> $status</td>";
        echo "<td> $DE</td>";
        echo "<td> $PER$symbol</td>";
        echo "</tr>";
    }
    ?>
    
    </tbody>
  </table>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
<style>
.container{
    margin-top:100px;
    height:auto;
    margin-bottom:50px;
}
</style>
</body>
</html>