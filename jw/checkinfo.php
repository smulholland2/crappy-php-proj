<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);


$UA = $_GET["UA"];
$UU = $_GET["UU"];
$lname = $_GET["lname"];
$month = $_GET["month"];
$day = $_GET["day"];
$year = $_GET["year"];

$examtaken = $_GET["examtaken"];

$dateexam = $month ."/".$day ."/".$year;
$dateexam2 = $month ."/".$day ."/".$year;

if($examtaken=="no")
{
	$dateexam = "12/30/1950";
	$dateexam2 = "12/30/1950";
}



	$dateexam = date("m/d/Y", strtotime($dateexam));
	$dateexam = strtotime($dateexam);


	$today = date("m/d/Y");


// if the professor did NOT fill up the form it will take him to the previous page
if($UA=="" or $UU=="" or $lname=="")
{
	header( "Location: index.php?errormessage=Please fill up the form completely" ) ;
}

else
{

	//this grabs the student's expiration date
	$SQL="SELECT DATE_EXPIRE FROM [01D] WHERE UA='$UA' AND UU='$UU' AND NL ='$lname'";
	$resultset=mssql_query($SQL, $con); 
		while ($row = mssql_fetch_array($resultset)) 
		{
			$DATE_EXPIRE = $row['DATE_EXPIRE'];
		}	

	//$DATE_EXPIRE= odbc_result($resultset, DATE_EXPIRE);

	//if expiration date is empty it means the professor either entered the wrong info or the stud. account doesn't exists
	if($DATE_EXPIRE=="")
	{
		header( "Location: index.php?errormessage=The student was not found, please enter the correct information" ) ;
	}

	else
	{

		$DATE_EXPIRE = date("m/d/Y", strtotime($DATE_EXPIRE));

		// if course is expired do this
		if(strtotime($today) > strtotime($DATE_EXPIRE))
		{
			// expired accounts need to repurchase a boucher header( "Location: expiredaccounts.php?UA=$UA&UU=$UU&DATE_EXPIRE=$DATE_EXPIRE&Amount=40&DaysExtend=365" ) ;
			header( "Location: expiredaccounts.php?UA=$UA&UU=$UU&DATE_EXPIRE=$DATE_EXPIRE&Amount=20&DaysExtend=365" ) ;
		}

		//if course is NOT expired do this
		else
		{
			$SQL77="SELECT FIN FROM [01D] WHERE UA='$UA' AND UU='$UU' AND NL ='$lname' ";
			$resultset77=mssql_query($SQL77, $con); 

			while ($row = mssql_fetch_array($resultset77)) 
			{
				$FIN = $row['FIN'];
			}

			//$FIN= odbc_result($resultset77, FIN);

			// if student didn't complete the course and course is NOT EXPIRED
			if($FIN==0)
			{
				header( "Location: warrantyaccounts.php?UA=$UA&UU=$UU&reason=coursenotcompleted&DATE_EXPIRE=$DATE_EXPIRE" ) ;
			}

			// if student completed the course BUT acct is NOT EXPIRED
			else
			{

				$SQL1="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=01 ";
				$resultset1=mssql_query($SQL1, $con); 
				while ($row = mssql_fetch_array($resultset1)) 
				{
					$PER1 = $row['PER'];
				}
				//$PER1= odbc_result($resultset1, PER);

				$SQL2="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=02 ";
				$resultset2=mssql_query($SQL2, $con); 
				while ($row = mssql_fetch_array($resultset2)) 
				{
					$PER2 = $row['PER'];
				}	
				//$PER2= odbc_result($resultset2, PER);

				$SQL3="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=03 ";
				$resultset3=mssql_query($SQL3, $con);
				while ($row = mssql_fetch_array($resultset3)) 
				{
					$PER3 = $row['PER'];
				}	
				//$PER3= odbc_result($resultset3, PER);

				$SQL4="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=04 ";
				$resultset4=mssql_query($SQL4, $con);
				while ($row = mssql_fetch_array($resultset4)) 
				{
					$PER4 = $row['PER'];
				}
				//$PER4= odbc_result($resultset4, PER);

				$SQL5="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=05 ";
				$resultset5=mssql_query($SQL5, $con); 
				while ($row = mssql_fetch_array($resultset5)) 
				{
					$PER5 = $row['PER'];
				}	
				//$PER5= odbc_result($resultset5, PER);

				$SQL6="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=06 ";
				$resultset6=mssql_query($SQL6, $con);
				while ($row = mssql_fetch_array($resultset6)) 
				{
					$PER6 = $row['PER'];
				}
				//$PER6= odbc_result($resultset6, PER);

				$SQL7="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=07 ";
				$resultset7=mssql_query($SQL7, $con); 
				while ($row = mssql_fetch_array($resultset7)) 
				{
					$PER7 = $row['PER'];
				}
				//$PER7= odbc_result($resultset7, PER);

				$SQL8="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=08 ";
				$resultset8=mssql_query($SQL8, $con); 
				while ($row = mssql_fetch_array($resultset8)) 
				{
					$PER8 = $row['PER'];
				}
				//$PER8= odbc_result($resultset8, PER);

				$SQL9="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=09 ";
				$resultset9=mssql_query($SQL9, $con);
				while ($row = mssql_fetch_array($resultset9)) 
				{
					$PER9 = $row['PER'];
				}
				//$PER9= odbc_result($resultset9, PER);

				$SQL10="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=10 ";
				$resultset10=mssql_query($SQL10, $con); 
				while ($row = mssql_fetch_array($resultset10)) 
				{
					$PER10 = $row['PER'];
				}
				//$PER10= odbc_result($resultset10, PER);

				$SQL11="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=11 ";
				$resultset11=mssql_query($SQL11, $con); 
				while ($row = mssql_fetch_array($resultset11)) 
				{
					$PER11 = $row['PER'];
				}
				//$PER11= odbc_result($resultset11, PER);

				$SQL12="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=12 ";
				$resultset12=mssql_query($SQL12, $con); 
				while ($row = mssql_fetch_array($resultset12)) 
				{
					$PER12 = $row['PER'];
				}
				//$PER12= odbc_result($resultset12, PER);

				$SQL13="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=13 ";
				$resultset13=mssql_query($SQL13, $con); 
				while ($row = mssql_fetch_array($resultset13)) 
				{
					$PER13 = $row['PER'];
				}
				//$PER13= odbc_result($resultset13, PER);

				$SQL14="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=14 ";
				$resultset14=mssql_query($SQL14, $con);
				while ($row = mssql_fetch_array($resultset14)) 
				{
					$PER14 = $row['PER'];
				}	
				//$PER14= odbc_result($resultset14, PER);

				$SQL15="SELECT PER FROM [01P] WHERE UU='$UU' AND Num=15 ";
				$resultset15=mssql_query($SQL15, $con);
				while ($row = mssql_fetch_array($resultset15)) 
				{
					$PER15 = $row['PER'];
				}
				//$PER15= odbc_result($resultset15, PER);

				$SQL16="SELECT DE FROM [01P] WHERE UU='$UU' AND Num=15 ";
				$resultset16=mssql_query($SQL16, $con); 
				while ($row = mssql_fetch_array($resultset16)) 
				{
					$DE = $row['DE'];
				}
				//$DE= odbc_result($resultset16, DE);



				//if students scored 90% or better do this	
				if ($PER1 >= 90 and  $PER2 >= 90 and $PER3 >= 90 and  $PER4 >= 90 and  $PER5 >= 90 and  $PER6 >= 90 and  $PER7 >= 90 and  $PER8 >= 90 and  $PER9 >= 90 and  $PER10 >= 90 and  $PER11 >= 90 and  $PER12 >= 90 and  $PER13 >= 90 and  $PER14 >= 90 and  $PER15 >= 90)
				{

					$DE = strtotime($DE);		
					$difference =  $dateexam - $DE;
					$daysdiff = floor($difference / (60*60*24) );
					echo $daysdiff;		

					//if they scored 90% or better but its been more than 48hrs after Prac. Exam
					if($daysdiff > 2)
					{
						header( "Location: notwarrantyaccounts.php?UA=$UA&UU=$UU&dateexam=$dateexam2&reason=practiceexamdate&Amount=20&DaysExtend=365" ) ;
					}

					// if they meet both requierements for WARRANTY
					else
					{
					header( "Location: warrantyaccounts.php?UA=$UA&UU=$UU&reason=warranty&DATE_EXPIRE=$DATE_EXPIRE" ) ;
					}
				} // IF closer line 124

					// when students don't score 90% or better
				else
				{		

					header( "Location: notwarrantyaccounts.php?UA=$UA&UU=$UU&dateexam=$dateexam2&reason=coursescores&Amount=20&DaysExtend=365" ) ;

				}


			}


		}

	} 

} 
?>
