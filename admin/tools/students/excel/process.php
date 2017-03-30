<?php
$filename=$_POST['filename'];
//$filename2=urldecode($filename);
$product_id=$_POST['product_id'];
$num_stu=$_POST['num_stu'];
$whole_byLesson=$_POST['whole_byLesson'];
$selectLesson=$_POST['selectLesson'];
$region=$_POST['region'];
$fn="exceldump/$filename";
echo "hello";
echo $filename;
echo $product_id;
echo $num_stu;
echo $whole_byLesson;
echo $selectLesson;
//build a form
//call replace w/ form
//submit form to excelasp

//"
include 'PHPExcel-1.7.7/tests/replace.php';
header("Location:http://tapseries-asp-prod.us-west-2.elasticbeanstalk.com/add_student_excelasp.asp?filename=$filename&product_id=$product_id&num_stu=$num_stu&whole_byLesson=$whole_byLesson&selectLesson=$selectLesson&region=$region");
?>
