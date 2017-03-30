<?php

$response = array();
$posts = array();


$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 


$startD=$_GET['startDate'];
$endD=$_GET['endDate'];
$lang=$_GET['strLang']; 


	$arrStorage=array();
	for ($i = 0; $i <= 120; $i++) {
		$arrStorage[$i][1] = 0;
		$arrStorage[$i][2] = 0;
		$arrStorage[$i][3] = 0;
	}

		$rowCount = 0;
		$qCount = 0;
		$stuCount = 0;
		$place="";
		$intquestnum=0;
		$intCorrect=0;
		$strPreStu="";
		
		
		//get students in qbank A and save to array
		$SQL = "SELECT UU FROM [01D] WHERE (ME=3  OR ME=20 OR ME=21 OR ME=4 OR ME=7) AND QBANK='A' AND ES='$lang' AND DE>='$startD' AND DE<='$endD' ";
		
		// Execute query:
		$resultset=mssql_query($SQL, $con); 

		while ($row = mssql_fetch_array($resultset)) 
			{
			     $aresults[] = $row['UU'];
			}  

		$total_num_studentsA = count($aresults);


			
		//get students in qbank B and save to array
		$SQL = "SELECT UU FROM [01D] WHERE (ME=3  OR ME=20 OR ME=21 OR ME=4 OR ME=7) AND QBANK='B' AND ES='$lang' AND DE>='$startD' AND DE<='$endD' ";
		
		// Execute query:
		$resultset=mssql_query($SQL, $con); 

		while ($row = mssql_fetch_array($resultset)) 
			{
			     $bresults[] = $row['UU'];
			}  	


		$total_num_studentsB = count($bresults);
		$total_num_students = $total_num_studentsA + $total_num_studentsB;

		
	
	for ($intquestnum = 1; $intquestnum <= 120; $intquestnum++) {
		

		if ($intquestnum==1) {
	 		$L11num=11;
	 		$strTestCat="A";
	 	}

	 	if ($intquestnum==2) {
	 		$L11num=2;
	 		$strTestCat="A";
	 	}

	 	 if ($intquestnum==3) {
		 		$L11num=8;
		 		$strTestCat="A";
	 	}

	 	 if ($intquestnum==4) {
		 		$L11num=9;
		 		$strTestCat="A";
	 	}

	 	 if ($intquestnum==5) {
		 		$L11num=32;
		 		$strTestCat="A";
	 	}

	 	 if ($intquestnum==6) {
		 		$L11num=36;
		 		$strTestCat="A";
	 	}

	 	 if ($intquestnum==7) {
			 		$L11num=29;
			 		$strTestCat="F";
	 	}

	 	 if ($intquestnum==8) {
				 		$L11num=12;
				 		$strTestCat="A";
	 	}
	 	if ($intquestnum==9) {
					 		$L11num=30;
					 		$strTestCat="A";
	 	}
	 	if ($intquestnum==10) {
						 		$L11num=6;
						 		$strTestCat="A";
	 	}
	 	if ($intquestnum==11) {
						 		$L11num=26;
						 		$strTestCat="A";
	 	}
	 	if ($intquestnum==12) {
						 		$L11num=37;
						 		$strTestCat="A";
	 	}
	 	if ($intquestnum==13) {
						 		$L11num=3;
						 		$strTestCat="A";
	 	}
	 	if ($intquestnum==14) {
						 		$L11num=9;
						 		$strTestCat="E";
	 	}
	 	if ($intquestnum==15) {
						 		$L11num=17;
						 		$strTestCat="A";
	 	}
	 	if ($intquestnum==16) {
						 		$L11num=23;
						 		$strTestCat="A";
	 	}
	 	if ($intquestnum==17) {
						 		$L11num=28;
						 		$strTestCat="A";
	 	}
	 	if ($intquestnum==18) {
							 		$L11num=38;
							 		$strTestCat="A";
	 	}
	 	if ($intquestnum==19) {
						 		$L11num=5;
						 		$strTestCat="A";
	 	}
	 	if ($intquestnum==20) {
							 		$L11num=18;
							 		$strTestCat="A";
	 	}
	 	if ($intquestnum==21) {
							 		$L11num=24;
							 		$strTestCat="A";
	 	}

	 	if ($intquestnum==22) {
							 		$L11num=33;
							 		$strTestCat="A";
	 	}
	 	if ($intquestnum==23) {
								 		$L11num=39;
								 		$strTestCat="A";
	 	}
	 	if ($intquestnum==24) {
								 		$L11num=15;
								 		$strTestCat="A";
	 	}
	 	if ($intquestnum==25) {
								 		$L11num=27;
								 		$strTestCat="A";
	 	}
	 	if ($intquestnum==26) {
								 		$L11num=1;
								 		$strTestCat="A";
	 	}
	 	if ($intquestnum==27) {
								 		$L11num=4;
								 		$strTestCat="A";
	 	}
	 	if ($intquestnum==28) {
								 		$L11num=7;
								 		$strTestCat="A";
	 	}
	 	if ($intquestnum==29) {
								 		$L11num=10;
								 		$strTestCat="A";
	 	}
	 	if ($intquestnum==30) {
								 		$L11num=13;
								 		$strTestCat="D";
	 	}
	 	if ($intquestnum==31) {
								 		$L11num=25;
								 		$strTestCat="A";
	 	}
	 	if ($intquestnum==32) {
								 		$L11num=19;
								 		$strTestCat="A";
	 	}
	 	 	if ($intquestnum==33) {
									 		$L11num=22;
									 		$strTestCat="B";
		 	}
		  	if ($intquestnum==34) {
		 							 		$L11num=25;
		 							 		$strTestCat="D";
		  	}
			  	if ($intquestnum==36) {
			 							 		$L11num=31;
			 							 		$strTestCat="A";
		  	}
		  	if ($intquestnum==37) {
		 							 		$L11num=34;
		 							 		$strTestCat="A";
		  	}
		  		  	if ($intquestnum==38) {
				 							 		$L11num=14;
				 							 		$strTestCat="A";
		  	}
		  	if ($intquestnum==39) {
		 							 		$L11num=20;
		 							 		$strTestCat="A";
		  	}
		  	if ($intquestnum==40) {
		 							 		$L11num=35;
		 							 		$strTestCat="F";
		  	}
		  	if ($intquestnum==41) {
				 							 		$L11num=16;
				 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==42) {
						 							 		$L11num=3;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==43) {
						 							 		$L11num=9;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==44) {
						 							 		$L11num=19;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==45) {
						 							 		$L11num=32;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==46) {
						 							 		$L11num=38;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==47) {
						 							 		$L11num=20;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==48) {
				 							 		$L11num=21;
				 							 		$strTestCat="D";
		  	}
			if ($intquestnum==49) {
				 							 		$L11num=21;
				 							 		$strTestCat="A";
		  	}
		  	if ($intquestnum==50) {
						 							 		$L11num=5;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==51) {
						 							 		$L11num=28;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==52) {
						 							 		$L11num=39;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==53) {
						 							 		$L11num=8;
						 							 		$strTestCat="D";
		  	}
		  	if ($intquestnum==54) {
						 							 		$L11num=15;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==55) {
						 							 		$L11num=18;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==56) {
						 							 		$L11num=25;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==57) {
						 							 		$L11num=36;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==58) {
						 							 		$L11num=40;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==59) {
						 							 		$L11num=6;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==60) {
						 							 		$L11num=13;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==61) {
						 							 		$L11num=26;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==62) {
						 							 		$L11num=31;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==63) {
						 							 		$L11num=23;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==64) {
						 							 		$L11num=12;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==65) {
						 							 		$L11num=35;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==66) {
						 							 		$L11num=1;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==67) {
						 							 		$L11num=11;
						 							 		$strTestCat="C";
		  	}
		  	if ($intquestnum==68) {
						 							 		$L11num=7;
						 							 		$strTestCat="E";
		  	}
		  	if ($intquestnum==69) {
						 							 		$L11num=10;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==70) {
						 							 		$L11num=14;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==71) {
						 							 		$L11num=40;
						 							 		$strTestCat="A";
		  	}
		  	if ($intquestnum==72) {
						 							 		$L11num=24;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==73) {
						 							 		$L11num=22;
						 							 		$strTestCat="A";
		  	}
		  	if ($intquestnum==74) {
						 							 		$L11num=29;
						 							 		$strTestCat="A";
		  	}
		  	if ($intquestnum==75) {
						 							 		$L11num=16;
						 							 		$strTestCat="A";
		  	}
		  	if ($intquestnum==76) {
						 							 		$L11num=33;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==77) {
						 							 		$L11num=35;
						 							 		$strTestCat="C";
		  	}
		  	if ($intquestnum==78) {
						 							 		$L11num=11;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==79) {
						 							 		$L11num=35;
						 							 		$strTestCat="A";
		  	}
		  	if ($intquestnum==80) {
						 							 		$L11num=34;
						 							 		$strTestCat="B";
		  	}
		  	if ($intquestnum==81) {
						 							 		$L11num=2;
						 							 		$strTestCat="C";
		  	}
		  	if ($intquestnum==82) {
								 							 		$L11num=3;
								 							 		$strTestCat="C";
		  	}
		  	if ($intquestnum==84) {
								 							 		$L11num=23;
								 							 		$strTestCat="C";
		  	}
		  	if ($intquestnum==85) {
						 							 		$L11num=30;
						 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==86) {
								 							 		$L11num=36;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==87) {
								 							 		$L11num=8;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==88) {
								 							 		$L11num=16;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==89) {
								 							 		$L11num=27;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==90) {
								 							 		$L11num=10;
								 							 		$strTestCat="F";
		  	}
		  		  	if ($intquestnum==91) {
								 							 		$L11num=19;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==92) {
								 							 		$L11num=33;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==93) {
								 							 		$L11num=6;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==94) {
								 							 		$L11num=12;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==95) {
								 							 		$L11num=21;
								 							 		$strTestCat="B";
		  	}
		  		  	if ($intquestnum==96) {
								 							 		$L11num=2;
								 							 		$strTestCat="B";
		  	}
		  		  	if ($intquestnum==97) {
								 							 		$L11num=26;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==98) {
								 							 		$L11num=40;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==99) {
								 							 		$L11num=5;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==100) {
								 							 		$L11num=18;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==101) {
								 							 		$L11num=24;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==102) {
								 							 		$L11num=32;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==103) {
								 							 		$L11num=39;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==104) {
								 							 		$L11num=40;
								 							 		$strTestCat="D";
		  	}
		  		  	if ($intquestnum==105) {
								 							 		$L11num=29;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==106) {
								 							 		$L11num=7;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==107) {
								 							 		$L11num=1;
								 							 		$strTestCat="F";
		  	}
		  		  	if ($intquestnum==108) {
								 							 		$L11num=10;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==109) {
								 							 		$L11num=14;
								 							 		$strTestCat="C";
		  	}
		  	if ($intquestnum==110) {
						 							 		$L11num=13;
						 							 		$strTestCat="A";
		  	}
		  	if ($intquestnum==111) {
						 							 		$L11num=17;
						 							 		$strTestCat="B";
		  	}
		  		  	if ($intquestnum==112) {
								 							 		$L11num=28;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==113) {
								 							 		$L11num=25;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==114) {
								 							 		$L11num=31;
								 							 		$strTestCat="C";
		  	}
		  	if ($intquestnum==115) {
						 							 		$L11num=30;
						 							 		$strTestCat="B";
		  	}
		  		  	if ($intquestnum==116) {
								 							 		$L11num=37;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==117) {
								 							 		$L11num=37;
								 							 		$strTestCat="B";
		  	}
		  		  	if ($intquestnum==118) {
								 							 		$L11num=9;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==119) {
								 							 		$L11num=22;
								 							 		$strTestCat="C";
		  	}
		  		  	if ($intquestnum==120) {
								 							 		$L11num=38;
								 							 		$strTestCat="C";
		  	}
		

		$getplace="A" . $L11num;


		if ($strTestCat<>"A" AND $strTestCat<>"B") {
			$SQL = "SELECT UU FROM [01D] WHERE (ME=3  OR ME=20 OR ME=21 OR ME=4 OR ME=7) AND QBANK='$strTestCat' AND ES='$lang' AND DE>='$startD' AND DE<='$endD' ";
			
			// Execute query:
			$resultset=mssql_query($SQL, $con); 
			// other banks use statement below
			
		
		while ($row = mssql_fetch_array($resultset)) 
			{
			    $strStudentUsr = $row['UU'];
						
				$SQL2 = "SELECT C FROM [01A] WHERE NUM=11 AND Q='$L11num' AND UU='$strStudentUsr' ";
				$resultset2=mssql_query($SQL2, $con); 
				//echo $strTestCat . " " . $SQL2 . "<br>";
				// Fetch rows:

			while ($row = mssql_fetch_array($resultset2)) 
				{
					$intCorrect = $row['C'];

					$rowCount = $rowCount + 1;
					$qCount = $qCount + 1;
				//	echo "correct=".$intCorrect;
					$strCurStu = $strStudentUsr;

					if( $strCurStu != $strPreStu ) {
							$stuCount = $stuCount + 1;
					}
				
					if( $intCorrect>=0 AND $intCorrect<=3 ) {
						//echo "correct=".$intCorrect;
						//echo "correct2=".$intquestnum;
							if( $intquestnum>=1 AND $intquestnum<=120 ){
								
								$tmpHold = $arrStorage[$intquestnum][$intCorrect];
								$tmpHold = $tmpHold + 1;
								$arrStorage[$intquestnum][$intCorrect] = $tmpHold;
								//echo "tmphold=" . $tmpHold;
							} else {
								//Do nothing - in DB there are 42, Danny: ignore last 2'
							}
							$strPreStu = $strStudentUsr;
							//echo $arrStorage[$$intquestnum][$intCorrect];
					}
				}
			}
		}
		
		//use a-array not database
		if ($strTestCat=="A") {
			foreach ($aresults as $strStudentUsr) {
			//if ($L11num!=0) {
				$SQL2 = "SELECT C FROM [01A] WHERE NUM=11 AND Q='$L11num' AND UU='$strStudentUsr' ";
				$resultset2=mssql_query($SQL2, $con); 
			//echo $intquestnum . " " . $SQL2 . "<br>";
				// Fetch rows:


			while ($row = mssql_fetch_array($resultset2)) 
				{
					$intCorrect = $row['C'];

					$rowCount = $rowCount + 1;
					$qCount = $qCount + 1;

					$strCurStu = $strStudentUsr;

					if( $strCurStu != $strPreStu ) {
							$stuCount = $stuCount + 1;
					}
				
					if( $intCorrect>=0 AND $intCorrect<=3 ) {
						//echo $intquestnum . " " . $intCorrect . "<br>";
							if( $intquestnum>=1 AND $intquestnum<=120 ){
								$tmpHold = $arrStorage[$intquestnum][$intCorrect];
								$tmpHold = $tmpHold + 1;
								$arrStorage[$intquestnum][$intCorrect] = $tmpHold;
								//echo "tmphold=" . $tmpHold . ",correct=".$intCorrect;
							} else {
								//Do nothing - in DB there are 42, Danny: ignore last 2'
							}
							$strPreStu = $strStudentUsr;
							//echo $arrStorage[$$intquestnum][$intCorrect];
					}
				}
			}
			//}
		}
		
		if ($strTestCat=="B") {
			foreach ($bresults as $strStudentUsr) {
			
				$SQL2 = "SELECT C FROM [01A] WHERE NUM=11 AND Q='$L11num' AND UU='$strStudentUsr' ";
				$resultset2=mssql_query($SQL2, $con); 
				//echo $strTestCat . " " . $SQL2 . "<br>";
				// Fetch rows:

			while ($row = mssql_fetch_array($resultset2)) 
				{
					$intCorrect = $row['C'];

					$rowCount = $rowCount + 1;
					$qCount = $qCount + 1;

					$strCurStu = $strStudentUsr;

					if( $strCurStu != $strPreStu ) {
							$stuCount = $stuCount + 1;
					}
				
					if( $intCorrect>=0 AND $intCorrect<=3 ) {
							if( $intquestnum>=1 AND $intquestnum<=120 ){
								$tmpHold = $arrStorage[$intquestnum][$intCorrect];
								$tmpHold = $tmpHold + 1;
								$arrStorage[$intquestnum][$intCorrect] = $tmpHold;
								//echo "tmphold=" . $tmpHold . ",correct=".$intCorrect;
							} else {
								//Do nothing - in DB there are 42, Danny: ignore last 2'
							}
							$strPreStu = $strStudentUsr;
							//echo $arrStorage[$$intquestnum][$intCorrect];
					}
				}
			}
		}
	}
	
	for ($i = 1; $i <= 120; $i++) {
		if ($i==35) {
		$arrStorage[$i][1]=0;
		$arrStorage[$i][3]=0;
		}

		if ($i==83) {
		$arrStorage[$i][1]=0;
		$arrStorage[$i][3]=0;
		}
	//	echo $i . "=" . $arrStorage[$i][1] . "," . $arrStorage[$i][3] . "<br>";
	
	$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'QNum'=> $i,'Correct'=>$arrStorage[$i][1],'Wrong'=>$arrStorage[$i][3],'Lang'=>$lang,'TotalNumberStudents'=>$total_num_students);
	}
	 mssql_free_result($resultset);

	mssql_close($con); 
$response['posts'] = $posts;

$fp = fopen('resultsstats.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);
 

header('Location: resultsstats2.html');


?>
	
