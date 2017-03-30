<?php
error_reporting(0); 

    $user=$_SERVER['DB_USERNAME'];
    $password=$_SERVER['DB_PASSWORD'];
    $server=$_SERVER['DB_HOSTNAME'];
    $database='newtap';
    

$uname = $_POST["uname"];
$lname = $_POST["lname"];
$UA = $_POST["UA"];
$course = $_POST["course"];



//echo $course;
//echo "<br>";

//echo $uname;
//echo $lname;
//echo $UA;


$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');

mssql_select_db($database, $con) or die('Could not select a database.');
									 

// FSM & Food Safety Handlers
if($course == "FSCourses"){
	$table = "01D";
	$tablelesson = "01P";
}

// Re-certification
if($course == "FSMRC"){
	$table = "02D";
	$tablelesson = "02P";
}

// Cooking-Basics
if($course == "CB"){
	$table = "03D";
	$tablelesson = "03P";
}

// HACCP
if($course == "HACCP"){
	$table = "04D";
	$tablelesson = "04P";
}

// Strategies for Increasing Sales
if($course == "SFIS"){
	$table = "05D";
	$tablelesson = "05P";
}

// Earn More with Service
if($course == "EMWS"){
	$table = "06D";
	$tablelesson = "06P";
}

// Allergen Awareness
if($course == "AA"){
	$table = "09D";
	$tablelesson = "09P";
}

// Allergen Development
if($course == "AD"){
	$table = "10D";
	$tablelesson = "10P";
}

// Allergen Specialist
if($course == "AS"){
	$table = "11D";
	$tablelesson = "11P";
}

// ******** THE CODE BELOW CHECKS IF THE STUDENT'S INFORMATION WAS CORRECT, FIRST NAME, LAST NAME, COURSE NAME, IF NOT THE ADMINISTRATOR WILL SEE A MESSAGE ON THE SCREEN SAYING THAT THE INFORMATION WAS INCORRECT

		$SQL0 = "SELECT *  
				FROM [$table]
				WHERE UA= '$UA' 
				AND UU = '$uname'
				AND NL = '$lname'";

		$resultset0=mssql_query($SQL0, $con) or die ( 'Query Error line 91' ); 
		

		    while ($row = mssql_fetch_array($resultset0)) 
		    {
		        $DA = $row['DA'];
		    }
		 
					
		
		if($DA == ""){
		echo "<p style='text-align:center;margin-top:100px;color:white'>We couldn't find the student, please make sure you entered the correct first name and last name, also make sure you selected the correct course name.</p>";
		echo "<p style='text-align:center'><button onclick='goBack()'>Go Back</button></p>";
	}
	
	// IF STUDENT WAS FOUND GO TO THE NEXT PART OF THE SCRIPT	

	else{


		
		//CHECKS IF STUDENT EXISTS AND IF HE/SHE WAS ENROLL LESS THAN 30 DAYS AGO
		$SQL1 = "SELECT *  
				FROM [$table]
				WHERE UA= '$UA' 				
				AND UU = '$uname'
				AND NL = '$lname'
				AND DATEDIFF(day,DA,getdate()) < 31";
												
			//	print $SQL1;
			//	echo "<br>";

				
				$resultset1=mssql_query($SQL1, $con)  or die ( 'Query Error' ); 
								
							
		    while ($row = mssql_fetch_array($resultset1)) 
		    {
		        $UU = $row['UU'];
		        $DA = $row['DA'];
		        $fname = $row['NF'];
		        $lname = $row['NL'];
		        $ME = $row['ME'];
		    }
										


	if($UU == ""){
		echo "<p style='text-align:center;margin-top:100px'>Student doesn't qualify, student was enrolled more than 30 days ago.</p>";
		echo "<p style='text-align:center'><button onclick='goBack()'>Go Back</button></p>";
	}

	//IF STUDENT WAS ENRROLL WITHIN 30 DAYS IT WILL GO TO THE NEXT PART OF THE SCRIPT WHERE IT WILL CHECK IF STUDENT DIDN'T START LESSON 2
	
else{
		$SQL2 = "SELECT *  
				FROM [$tablelesson]
				WHERE UU= '$UU' 
				AND NUM = '02'										
				";		
	//echo $SQL2;
	//echo "<br>";
	
	$resultset2=mssql_query($SQL2, $con); 
	
	 	    while ($row = mssql_fetch_array($resultset2)) 
		    {
		        $DS = $row['DS'];
		    }
		    
	

	if($DS == ""){
		
		$DA = date("m/d/Y", strtotime($DA));
		
		
	echo "<div id='main'>";	
		
		echo "<p style='margin-left:10px'>The student can be deleted. Deletion is permanet and cannot be reversed. Once the student is deleted the license will be credited to your account to add another student.</p>";	

		echo "<p id='textdelete' style='margin-left:10px'>Are you sure you want to delete this student? <br>
Are you sure you want to permanently delete this student?
</p>";
		
			echo "<form action='deletestudent.php' method='post'>";
	
				echo "<table style='margin:auto'>";
	
					echo "<tr>";
					echo "<th>Select</th>";
					echo "<th>Username</th> ";
					echo "<th>First Name</th> ";
					echo" <th>Last Name</th>";
					//echo" <th>Course</th>";
					echo" <th style='display:none'>ME</th>";
					echo" <th>User Account</th>";
					echo" <th>Date Added</th>";
					echo "</tr>";		
					echo "<tr>";
					echo "<td style='text-align:center'><input type='radio' value='" . $UU. "' name='UUX' required></td>";
					echo "<td style='text-align:center'>$UU</td>"; 
					echo "<td style='text-align:center'>$fname</td>";
					echo "<td style='text-align:center'>$lname</td>";
					//echo "<td style='text-align:center'>$course</td>";
					echo "<td style='display:none'><input type='text' value='" . $ME. "' name='MEX'></td>";
					echo "<td style='text-align:center'>$UA</td>";
					echo "<td style='text-align:center'>$DA</td>";
					echo "<td style='display:none'><input type='text' value='" . $course. "' name='courseX'></td>";
					echo "<td style='display:none'><input type='text' value='" . $UA. "' name='UAX'></td>";
					echo "</tr>";
				
				echo "</table>";
				
				echo "<br>";
				echo "<div id='buttons' style='margin-left:100px'>";
				
				echo "<button type='submit' id='delete2' style='background-color:red;float:left;width:50px;height:22px;border:1px solid red;color:white;cursor:pointer' value='submit'>Yes</button>";
								
				echo "<div id='goback2'  style='margin-left:10px;width:50px;height:20px;border:1px solid black;float:left;text-align:center;cursor:pointer'>No</div>";
				
				echo "</div>";
			echo "</form>";
			
		
		echo "<button id='delete1' style='margin-left:100px'>Delete Student</button>";	
		echo "<button style='margin-left:10px' id='goback1' onclick='goBack()'>Go Back</button>";	
		
		echo "<br><br><br>";
		
	echo "</div>";	
		
	}
	else{
		echo "<p style='text-align:center;margin-top:100px'>Student doesn't qualify, student studied more than 1 lesson</p>";
		
		echo "<p style='text-align:center'><button onclick='goBack()'>Go Back</button></p>";
	}
	
}

	}
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<style>
#main{
	max-width:900px;
	height:auto;
	border:1px solid #004a91;
	margin:50px auto;
	border-radius:10px;
	background-color:white;
}

table{
	width:90%;
	margin:50px auto;
}

table, th, td {
    border: 1px solid #ddd;
    border-collapse: collapse;
}


body{
	background-color: #004a91;
	font-family: 'Open Sans', sans-serif;
}
	
	</style>
	<script>
function goBack() {
    window.history.back();
}
</script>
	
	<script>
	$(document).ready(function(){
	
	$('#delete1').show();
	$('#delete2').hide();
	$('#textdelete').hide();
	$('#goback1').show();
	$('#goback2').hide();
	
	$('#delete1').click(function(){
	$('#textdelete').show();
	$('#delete1').hide();
	$('#delete2').show();
	$('#goback2').show();
	$('#goback1').hide();
});


$('#goback2').click(function(){
	$('#textdelete').hide();
	$('#delete1').show();
	$('#delete2').hide();
	$('#textdelete').hide();
	$('#goback1').show();
	$('#goback2').hide();
});


});
	</script>
</head>
<body>

</body>
</html>
