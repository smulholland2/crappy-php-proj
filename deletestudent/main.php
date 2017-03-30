<?php
error_reporting(0); 

$acctname = $_GET["acctname"];

?>


<!DOCTYPE html>
<html>
<head>
	<title>Delete Student</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans" />
	
	<style>
#findbtn{
width:80%;
height:40px;
margin-top:30px;
background-color:#3079ed;
border:none;
color:white;
cursor:pointer;
}

#findbtn:hover{
	background-color:#318fed;
}

body{
font-family: 'Open Sans', sans-serif;
background-color: #004a91;
}

#wrapper{
max-width:400px;
height:auto;
border:1px solid #004a91;
border-radius:10px;
margin:30px auto;
background-color: white;
}

	
	</style>
</head>
<body>

<div id="wrapper">


<h3 style="text-align:center">Please Enter the Student's Information</h3>

<p style="font-size:14px;margin: 0px 30px 0px 30px">Your student can be automatically deleted by you if the student was not added more than 30 days from the enrollment date and if no more than lesson 1 has been studied. A training credit  will automatically be added to your account. </p>

<form action="index.php" method="post">

<p style="float:right;margin-right:40px">Username: <input type="text" name="uname" ></p>

<p style="float:right;margin-right:40px">Last Name: <input type="text" name="lname"></p>

<p style="float:right;margin-right:40px"><select name="course">
  <option value="">Course</option>
  
  <option value="FSCourses">Food Safety Manager</option>
  <option value="FSCourses">Retail Food Safety Manager</option>
  <option value="FSCourses">Arizona Food Handler</option>
  <option value="FSCourses">California Food Handler</option>
  <option value="FSCourses">Florida Food Handler</option>
  <option value="FSCourses">Food Handler Training (All other states)</option>
  <option value="FSCourses">Idaho Food Handler</option>
  <option value="FSCourses">Illinois Food Handler</option>
  <option value="FSCourses">Jackson County MO Food Handler</option>
  <option value="FSCourses">Norfolk VA Food Handler</option>
  <option value="FSCourses">Ohio Level One Certification</option>
  <option value="FSCourses">Tulsa Food Handler</option>
  <option value="FSCourses">Texas Food Handler</option>
  <option value="FSCourses">Utah Food Handler</option>
  <option value="FSCourses">Wichita KS Food Handler</option>
  
  <option value="FSMRC">Food Safety Manager Re-Certification</option>
  <option value="CB">Cooking Basics</option>
  <option value="HACCP">HACCP</option>
  <option value="SFIS">Strategies for Increasing Sales</option>
  <option value="EMWS">Earn More with Service</option>
  <option value="AA">Allergen Awareness</option>
  <option value="AD">Allergen Plan Development</option>
  <option value="AS">Allergen Plan Specialist</option>
</select></p>

<input type="hidden" value="<?php echo $acctname; ?>" name="UA">
<p style='text-align:center'><button type="submit"id='findbtn' >Find Student</button></p>
<br>

</form>

</div>


</body>

<style>


	
</style>


</html>
