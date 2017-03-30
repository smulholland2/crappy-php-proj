<?php

const SINGLEBUYER = "single";
const MULTIPLEBUYER = "multiple";
const NOWHOSBUYING = "Please select a buyer type.";

session_start(); 	

echo $newusername = $_POST["newusername"];
echo $newpassword = $_POST["newpassword"];
echo $whosbuying = $_POST["whosbuying"];

if(isset($_POST["PRO_4u"])){
	echo $PRO_4u = $_POST["PRO_4u"];
}


echo "$existingusername= ";
echo $existingusername = $_POST["existingusername"];
echo "$existingpassword= ";
echo $existingpassword = $_POST["existingpassword"];
echo "<br>";

echo $corporate_username=$_SESSION["corporate_username"];
echo $corpVC=$_SESSION["corpVC"];
$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
   
// Connect to the database (host, username, password)
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

// corporate_username accounts purchasing from corporate place order page
if($corporate_username && $corpVC)
{
	$_SESSION["whosbuying"] ="multiple";
	header('Location: sc_info.php');
}
else
{
	// new customers
	if($newusername && $existingusername == "")
	{
		
		if($whosbuying == 'single')
		{

			$SQL1 = "SELECT AN FROM [07L3] WHERE AN='$newusername' ";		
			$resultset1=mssql_query($SQL1, $con); 
			
			while ($row = mssql_fetch_array($resultset1)) 
			{
				$t07L3 = $row['AN'];
			}    
			
			
			if($t07L3)
			{
				//echo "username found in 07L3 single";
				$_SESSION["unmessage"] = "Please try another Username. Unfortunately the one you chose is already in use.";
				$_SESSION["newpasswordused"] = $newpassword;
				header("Location: sc_sign_in.php");
			}
			else
			{
				
				$SQL2 = "SELECT UU FROM [01D] WHERE UU='$newusername' ";		
				$resultset2=mssql_query($SQL2, $con); 
				
				while ($row = mssql_fetch_array($resultset2)) 
				{
					$t01D = $row['UU'];
				}   


				if($t01D)
				{
					//echo "username found in 01D single";
				$_SESSION["unmessage"] = "Please try another Username. Unfortunately the one you chose is already in use.";
				$_SESSION["newpasswordused"] = $newpassword;
				header("Location: sc_sign_in.php");
				}
				else
				{
					unset ($_SESSION['existingusername']);
					unset ($_SESSION['existingpassword']);
					$_SESSION["newusername"] =$newusername;
					$_SESSION["newpassword"] =$newpassword;
					$_SESSION["whosbuying"] =$whosbuying;
					if($PRO_4u){
						$_SESSION["PRO_4u"] =$PRO_4u;
					}
					header('Location: sc_info.php');
				}
				
			}
		
		}

		if($whosbuying == 'multiple')
		{
			$SQL3 = "SELECT AN FROM [07L3] WHERE AN='$newusername' ";		
			$resultset3=mssql_query($SQL3, $con); 
			
		while ($row = mssql_fetch_array($resultset3)) 
		{
			$t07L3 = $row['AN'];
		} 		
			
					
			if($t07L3)
			{
				//echo "username found in 07L3 multiple";
				$_SESSION["unmessage"] = "Please try another Username. Unfortunately the one you chose is already in use.";
				$_SESSION["newpasswordused"] = $newpassword;
				header("Location: sc_sign_in.php");
			}
			else
			{
				unset ($_SESSION['existingusername']);
				unset ($_SESSION['existingpassword']);
				$_SESSION["newusername"] =$newusername;
				$_SESSION["newpassword"] =$newpassword;
				$_SESSION["whosbuying"] =$whosbuying;
				if($PRO_4u){
					$_SESSION["PRO_4u"] =$PRO_4u;
				}
				header('Location: sc_info.php');
			}
		}

	}	



	//===============================================================================================================================================================================================




	//existing customers
	if($existingusername && $newusername =="")
	{
		
		$SQL3 = "SELECT AN FROM [07L3] WHERE AN='$existingusername' AND AC='$existingpassword' ";		
			$resultset3=mssql_query($SQL3, $con); 
			
		while ($row = mssql_fetch_array($resultset3)) 
		{
			$t07L3res = $row['AN'];
		}   	
		
		
			if($t07L3res)
			{
				unset ($_SESSION['newusername']);
				unset ($_SESSION['newpassword']);
				unset ($_SESSION['whosbuying']);
				$_SESSION["existingusername"] =$existingusername;
				$_SESSION["existingpassword"] =$existingpassword;
				header('Location: sc_info.php');
			}
			else
			{
				header("Location: sc_sign_in.php?wrongextun=Sorry we couldn't find your account, please type in your username and password again!");
			}
			
			
			
	}


}










//header('Location: sc_info.php');
//print_r($_SESSION);
?>





