<?php
error_reporting(0);

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.');

session_start();
$discode = $_SESSION["discode"];
$price_discode = $_SESSION["price_discode"];

if($_GET["discode"]=="ol2"){
	$discode = "ol2";
	$_SESSION["discode"] = "ol2";
}


		if($price_discode){
			$real_price_discode = $price_discode;
			$SQL = "SELECT VC FROM [07SL1] WHERE VC = '$real_price_discode' ";				
			$resultset=mssql_query($SQL, $con); 	
				while ($row = mssql_fetch_array($resultset)) 
				{
					$VC_exists = $row['VC'];
				}
				if(!$VC_exists){
					$real_price_discode = "tapseries";
				}
			
		}
		else{
			$real_price_discode = $discode;
			$SQL = "SELECT VC FROM [07SL1] WHERE VC = '$real_price_discode' ";				
			$resultset=mssql_query($SQL, $con); 	
				while ($row = mssql_fetch_array($resultset)) 
				{
					$VC_exists = $row['VC'];
				}
				if(!$VC_exists){
					$real_price_discode = "tapseries";
				}	
		}



    //Get Course Price
	$SQL = "SELECT * FROM [07SL1] WHERE VC = '$real_price_discode' ";				
	$resultset=mssql_query($SQL, $con); 	
		while ($row = mssql_fetch_array($resultset)) 
		{
		     $fs_price = $row['01C'];
			 $fs_price = number_format($fs_price,2);

		     $fsrt_price = $row['01RC'];
			 $fsrt_price = number_format($fsrt_price,2);

		     $refs_price = $row['02C'];
			 $refs_price = number_format($refs_price,2);
			 
		     $rewi_price = $row['01RWEC'];
			 $rewi_price = number_format($rewi_price,2);

		     $nhaccp_price = $row['04C'];
			 $nhaccp_price = number_format($nhaccp_price,2);

		     $cb_price = $row['03C'];
			 $cb_price = number_format($cb_price,2);

		     $cf_price = $row['03C'];
			 $cf_price = number_format($cf_price,2);

		     $emws_price = $row['06C'];
			 $emws_price = number_format($emws_price,2);

		     $sfis_price = $row['05C'];
			 $sfis_price = number_format($sfis_price,2);

			 $alc_price = $row['12C'];
			 $alc_price = number_format($alc_price,2);

		     $aa_price = $row['09C'];
			 $aa_price = number_format($aa_price,2);

			 $ad_price = $row['10C'];
			 $ad_price = number_format($ad_price,2);

			 $as_price = $row['11C'];
			 $as_price = number_format($as_price,2);

			 $azfsh_price = $row['01AZEC'];
			 $azfsh_price = number_format($azfsh_price,2);

			 $califsh_price = $row['01CAEC'];
			 $califsh_price = number_format($califsh_price,2);

			 $flfsh_price = $row['01FLEC'];
			 $flfsh_price = number_format($flfsh_price,2);

			 $nfon_price = $row['01EC'];
			 $nfon_price = number_format($nfon_price,2);

			 $idfsh_price = $row['01IDEC'];
			 $idfsh_price = number_format($idfsh_price,2);

			 $ilfsh_price = $row['01ILEC'];
			 $ilfsh_price = number_format($ilfsh_price,2);

			 $mofsh_price = $row['01MOEC'];
			 $mofsh_price = number_format($mofsh_price,2);

			 $nmfsh_price = $row['01NMEC'];
			 $nmfsh_price = number_format($nmfsh_price,2);

			 $vaccfsh_price = $row['01VACCEC'];
			 $vaccfsh_price = number_format($vaccfsh_price,2);

			 $ohfsh_price = $row['01OHEC'];
			 $ohfsh_price = number_format($ohfsh_price,2);

			 $sd_price = $row['01SDEC'];
			 $sd_price = number_format($sd_price,2);

			 $utfsh_price = $row['01UTEC'];
			 $utfsh_price = number_format($utfsh_price,2);

			 $ksfsh_price = $row['01KSEC'];
			 $ksfsh_price = number_format($ksfsh_price,2);

			 $wvfsh_price = $row['01WVMVEC'];
			 $wvfsh_price = number_format($wvfsh_price,2); 
		}

	// Get Texas prices	

	$SQL7 = "SELECT VC FROM [07SL1TX] WHERE VC = '$real_price_discode' ";				
	$resultset7=mssql_query($SQL7, $con);
	while ($row = mssql_fetch_array($resultset7)) 
	{
		$VC_TX_exists = $row['VC'];
	}	

	if($VC_TX_exists){
		$SQL6 = "SELECT [01TXGENEC] FROM [07SL1TX] WHERE VC = '$real_price_discode' ";
	}
	else{
		$SQL6 = "SELECT [01TXGENEC] FROM [07SL1TX] WHERE VC = 'tapseries' ";
	}				
	
		$resultset6=mssql_query($SQL6, $con); 	
		while ($row = mssql_fetch_array($resultset6)) 
		{
			$txfsh_price = $row['01TXGENEC'];
			$txfsh_price = number_format($txfsh_price,2);
		}		




	// Get West Virginia prices
	$SQL5 = "SELECT VC  FROM [07SL1WV] WHERE VC = '$real_price_discode' ";				
	$resultset5=mssql_query($SQL5, $con);	
		while ($row = mssql_fetch_array($resultset5)) 
		{
			$VC_WV_exists = $row['VC'];
		}

		if($VC_WV_exists)
		{
			$SQL3 = "SELECT * FROM [07SL1WV] WHERE VC = '$real_price_discode' ";
		}
		else
		{
			$SQL3 = "SELECT * FROM [07SL1WV] WHERE VC = 'tapseries' ";
		}				
			$resultset3=mssql_query($SQL3, $con);	
			while ($row = mssql_fetch_array($resultset3)) 
			{
				$wvba_price = $row['01WVBAEC'];
				$wvba_price = number_format($wvba_price,2);

				$wvch_price = $row['01WVCHEC'];
				$wvch_price = number_format($wvch_price,2);

				$wvmn_price = $row['01WVMNEC'];
				$wvmn_price = number_format($wvmn_price,2);

				$wvpe_price = $row['01WVPEEC'];
				$wvpe_price = number_format($wvpe_price,2);

				$wvpo_price = $row['01WVPOEC'];
				$wvpo_price = number_format($wvpo_price,2);

				$wvup_price = $row['01WVUPEC'];
				$wvup_price = number_format($wvup_price,2);

				$wvwa_price = $row['01WVWAEC'];
				$wvwa_price = number_format($wvwa_price,2);

				$wvoh_price = $row['01WVOHEC'];
				$wvoh_price = number_format($wvoh_price,2);
			}	



    //Get Courses Name
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'fs' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $fs_c_name = $row['Course_Name'];
		}     
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'fsrt' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $fsrt_c_name = $row['Course_Name'];
		}
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'oh2' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $oh2_c_name = $row['Course_Name'];
		}
	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'oh2rt' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $oh2rt_c_name = $row['Course_Name'];
		}
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'remn' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $remn_c_name = $row['Course_Name'];
		} 
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'reri' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $reri_c_name = $row['Course_Name'];
		} 
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'rewi' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $rewi_c_name = $row['Course_Name'];
		}
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'nhaccp' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $nhaccp_c_name = $row['Course_Name'];
		}
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'cb' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $cb_c_name = $row['Course_Name'];
		}
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'cf' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $cf_c_name = $row['Course_Name'];
		}  
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'emws' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $emws_c_name = $row['Course_Name'];
		}   
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'sfis' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $sfis_c_name = $row['Course_Name'];
		}   
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'aa' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $aa_c_name = $row['Course_Name'];
		}
	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'ad' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $ad_c_name = $row['Course_Name'];
		}
	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'as' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $as_c_name = $row['Course_Name'];
		}

    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'azfsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $azfsh_c_name = $row['Course_Name'];
		}

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'califsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $califsh_c_name = $row['Course_Name'];
		}	
	
	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'flfsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $flfsh_c_name = $row['Course_Name'];
		}	

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'nfon' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $nfon_c_name = $row['Course_Name'];
		}

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'idfsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $idfsh_c_name = $row['Course_Name'];
		}	

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'ilfsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $ilfsh_c_name = $row['Course_Name'];
		}	

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'mofsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $mofsh_c_name = $row['Course_Name'];
		}

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'nmfsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $nmfsh_c_name = $row['Course_Name'];
		}	

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'vaccfsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $vaccfsh_c_name = $row['Course_Name'];
		}	

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'ohfsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $ohfsh_c_name = $row['Course_Name'];
		}	

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'casd' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $sd_c_name = $row['Course_Name'];
		}

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'txfsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $txfsh_c_name = $row['Course_Name'];
		}	

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'utfsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $utfsh_c_name = $row['Course_Name'];
		}	

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'ksfsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $ksfsh_c_name = $row['Course_Name'];
		}

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'WVMV' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $wvfsh_c_name = $row['Course_Name'];
		}	

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'wvba' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $wvba_c_name = $row['Course_Name'];
		}

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'wvch' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $wvch_c_name = $row['Course_Name'];
		}

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'wvmn' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $wvmn_c_name = $row['Course_Name'];
		}	

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'wvpe' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $wvpe_c_name = $row['Course_Name'];
		}

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'wvpo' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $wvpo_c_name = $row['Course_Name'];
		}	

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'wvup' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $wvup_c_name = $row['Course_Name'];
		}	

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'wvwa' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $wvwa_c_name = $row['Course_Name'];
		}	

	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'wvoh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $wvoh_c_name = $row['Course_Name'];
		}		




		// hide and show courses depending on discode
	    $SQL1="SELECT ProID FROM [4u_Page_Menu] WHERE discode = '$discode' ";				
        $resultset1=mssql_query($SQL1, $con); 

		while ($row = mssql_fetch_array($resultset1)) 
		{
			$Show_Course = $row['ProID'];

            if($Show_Course=="aa"){
                $Show_AA="yes";
            }
			if($Show_Course=="ad"){
                $Show_AD="yes";
            }
			if($Show_Course=="as"){
                $Show_AS="yes";
            }
			if($Show_Course=="fh"){
                $Show_FH="yes";
            }
            if($Show_Course=="fs"){
                $Show_FS="yes";
            }
            if($Show_Course=="oh2"){
                $Show_OH2="yes";
            }
             if($Show_Course=="oh2rt"){
                $Show_OH2RT="yes";
            }
            if($Show_Course=="nhaccp"){
                $Show_NHACCP="yes";
            }
            if($Show_Course=="fsrt"){
                $Show_FSRT="yes";
            }
            if($Show_Course=="reri"){
                $Show_RERI="yes";
            }
            if($Show_Course=="remn"){
                $Show_REMN="yes";
            }
            if($Show_Course=="rewi"){
                $Show_REWI="yes";
            }
            if($Show_Course=="alc"){
                $Show_ALCOHOL="yes";
            }
            if($Show_Course=="cb"){
                $Show_CB="yes";
            }
            if($Show_Course=="cf"){
                $Show_CF="yes";
            }
            if($Show_Course=="emws"){
                $Show_EMWS="yes";
            }
            if($Show_Course=="sfis"){
                $Show_SFIS="yes";
            }
			if($Show_Course=="azfsh"){
                $Show_azfsh="yes";
            }
			if($Show_Course=="califsh"){
                $Show_califsh="yes";
            }
			if($Show_Course=="flfsh"){
                $Show_flfsh="yes";
            }
			if($Show_Course=="nfon"){
                $Show_nfon="yes";
            }
			if($Show_Course=="idfsh"){
                $Show_idfsh="yes";
            }
			if($Show_Course=="ilfsh"){
                $Show_ilfsh="yes";
            }
			if($Show_Course=="mofsh"){
                $Show_mofsh="yes";
            }
			if($Show_Course=="nmfsh"){
                $Show_nmfsh="yes";
            }
			if($Show_Course=="vaccfsh"){
                $Show_vaccfsh="yes";
            }
			if($Show_Course=="ohfsh"){
                $Show_ohfsh="yes";
            }
			if($Show_Course=="casd"){
                $Show_sd="yes";
            }
			if($Show_Course=="txfsh"){
                $Show_txfsh="yes";
            }
			if($Show_Course=="utfsh"){
                $Show_utfsh="yes";
            }
			if($Show_Course=="ksfsh"){
                $Show_ksfsh="yes";
            }
			if($Show_Course=="WVMV"){
                $Show_wvfsh="yes";
            }
			if($Show_Course=="wvba"){
                $Show_wvba="yes";
            }
			if($Show_Course=="wvch"){
                $Show_wvch="yes";
            }
			if($Show_Course=="wvmn"){
                $Show_wvmn="yes";
            }
			if($Show_Course=="wvpe"){
                $Show_wvpe="yes";
            }
			if($Show_Course=="wvpo"){
                $Show_wvpo="yes";
            }
			if($Show_Course=="wvup"){
                $Show_wvup="yes";
            }
			if($Show_Course=="wvwa"){
                $Show_wvwa="yes";
            }
			if($Show_Course=="wvoh"){
                $Show_wvoh="yes";
            }
		}

		// if no specific course, SHOW ALL
        if($Show_Course=="")
        {
            $Show_AA="yes";
            $Show_AD="yes";
            $Show_AS="yes";
            $Show_FH="yes";
            $Show_FS="yes";
            $Show_OH2="yes";
            $Show_OH2RT="yes";
            $Show_RERI="yes";
            $Show_REMN="yes";
            $Show_REWI="yes";
            $Show_NHACCP="yes";
            $Show_FSRT="yes";
            $Show_ALCOHOL="yes";
            $Show_CB="yes";
            $Show_CF="yes";
            $Show_EMWS="yes";
            $Show_SFIS="yes";
            $Show_azfsh="yes";
            $Show_califsh="yes";
            $Show_flfsh="yes";
            $Show_nfon="yes";
            $Show_idfsh="yes";
            $Show_ilfsh="yes";
            $Show_mofsh="yes";
            $Show_nmfsh="yes";
            $Show_vaccfsh="yes";
            $Show_ohfsh="yes";
            $Show_sd="yes";
            $Show_txfsh="yes";
            $Show_utfsh="yes";
            $Show_ksfsh="yes";
            $Show_wvfsh="yes";
            $Show_wvba="yes";
            $Show_wvch="yes";
            $Show_wvmn="yes";
            $Show_wvpe="yes";
            $Show_wvpo="yes";
            $Show_wvup="yes";
            $Show_wvwa="yes";
            $Show_wvoh="yes";
        }	

        

?>


<!DOCTYPE html>
<html>
<head>
<title>Courses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>

.course_container{
	width: 375px;
	height: 200px;
	border:1px solid #ddd;
	float: left;
	margin-left: 10px;
	margin-top: 10px;
}
#wrapper{
	border:1px solid transparent;
	max-width: 785px;
	height: 4000px;
	margin: auto;
    margin-bottom:100px;
}
.image{
	width: 167px;
	height: 167px;
	float: left;
	margin-top: 13px;
	margin-left: 13px;
	border:1px solid transparent;
	position:relative;
	
}
.image:hover img{
	opacity: 0.5;
}
.image:hover .btns{
    display:block;
}
.content{
	width: 167px;
	height: 167px;
	float: left;
	margin-top: 13px;
	margin-left: 13px;
	border:1px solid transparent;
}
img{
	transition: opacity 0.5s ease;
	width: 100%;
}
.title{
	width: 100%;
	height: 70%;
	border:1px solid transparent;
	text-align: center;
	color: #1E2B41;
}
.title h4{
	margin-top: 0px;
	font-size: 19px;
	cursor: pointer;
}
.title h4 a:hover{
	color:blue;
}
.title h4 a{
    color:#1E2B41;
	transition: all 1s;    
}

.price{
	width: 100%;
	height: 30%;
	border:1px solid transparent;
	background-color: #1E2B41;
	color: white;
	text-align: center;
	cursor: pointer;
}
.price:hover{
	background-color:#182234;
}
.price h4{
	margin-top: 10px;
	font-size: 25px;
}
.price a{
    color:white;
    text-decoration:none;
}
.content a:hover{
    text-decoration:none;
}
.btns{
    display:none;
    position:absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    height:50%;
    text-align: center;
}
.btns a{
	margin-top: 5px;
}
.btn-primary{
    background-color: #1E2B41;
    border-color: #1E2B41;
}



@media only screen and (max-width: 790px) {

.course_container{
    width: 100%;
    margin:10px auto;
    height: 258px;
    }
#wrapper{
	width: 500px;
	height: 10300px;
}
.image{
	margin-left:25px;
	margin-top:20px;
	width: 45%;
	height: 87%;
}
.content{
	margin-top:20px;
	width: 45%;
	height: 87%;
}
.title{
	height: 70%;
}
.title h4{
	font-size: 25px;
	margin-top: 10px;
}
.price{
	height: 30%;
}
.price h4{
	margin-top: 15px;
	font-size: 30px;
}


}	


@media only screen and (max-width: 525px) {

#wrapper{
	width: 300px;
    height: 6500px;
}
.course_container{
	height: 155px;
}
.content{
	margin-top: 10px;
	height: 132px;
}
.image{
	margin-left:10px;
	margin-top:10px;
	margin-bottom: 10px;
}
.title h4{
	font-size: 15.5px;
	margin-top: 0px;
}
.price h4{
	margin-top: 7px;
	font-size: 20px;
}



}


</style>

<script>
$(document).ready(function(){

$("#withoutdetails").css("background-color", "#E6E6E6");

    $("#withoutdetails").click(function(){
    $("#withoutdetails").css("background-color", "#E6E6E6");
    $("#withdetails").css("background-color", "white");
    });

    $("#withdetails").click(function(){
    $("#withdetails").css("background-color", "#E6E6E6");
    $("#withoutdetails").css("background-color", "white");
    });


});
</script>

</head>
<body>
<?php include '../menu.php';?>


<div class="container" style="margin-top:0px">
<div class="page-header">
<h3>Courses</h3>
</div>

<div class='well'>
<h4><strong>Terms of Purchase</strong></h4>
100% money back of the purchase price, or credit to your corporate account, if returned within 30 days of enrollment, and if no more than lesson 1 has been studied. If you have any questions or comments on our return policy/terms of purchase, please feel free to contact us at 888-826-5222.<br><br>Courses are purchased as single use enrollments. Each lesson allows up to 5 reviews. After 5 reviews the lesson is closed. Courses are active for 180 days from date of enrollment and will stop functioning 180 days after the enrollment. Within the 180 day active period, the name of the student can be changed for a $20 fee for all courses except Food Handler, if a TAP Certificate of Achievement has NOT been awarded. Changing of the name will not re-activate any inactive, closed or ended functions. We reserve the right to charge a $5 fee for Food Handler name changes. To submit a name change form, click here.
</div>
    
<!--
<div class="btn-group" style="margin-bottom:30px">
    <button type="button" id="withoutdetails" class="btn btn-default"> <span class="glyphicon glyphicon-th-large"></button>
    <button type="button" id="withdetails" class="btn btn-default"> <span class="glyphicon glyphicon-th-list"></button>
</div>

-->
</div>

<div id="wrapper">

<!-- food handler MAP -->
<div class="course_container" <?php if($Show_FH=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/USA1.png">
        <div class="btns">
			<p><!--<a href = "#" class = "btn btn-default" role = "button">Learn More</a>--><a href = "/courses/foodhandler/" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/foodhandler/">Food Handler Training</a></h4>
		</div>
        <a href = "/courses/foodhandler/">
		<div class="price">
			<h4>Buy Now</h4>
		</div>
        </a>
	</div>
</div>

<!-- Arizona food handler -->
<div class="course_container" <?php if($Show_azfsh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/azfsh" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/azfsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/azfsh"><?php echo $azfsh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/azfsh">
		<div class="price">
			<h4>$<?php echo $azfsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- CA food handler -->
<div class="course_container" <?php if($Show_califsh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/califsh" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/califsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/califsh"><?php echo $califsh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/califsh">
		<div class="price">
			<h4>$<?php echo $califsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- San Diego food handler -->
<div class="course_container" <?php if($Show_sd=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/casd" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/casd" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/casd"><?php echo $sd_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/casd">
		<div class="price">
			<h4>$<?php echo $sd_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Florida food handler -->
<div class="course_container" <?php if($Show_flfsh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/flfsh" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/flfsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/flfsh"><?php echo $flfsh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/flfsh">
		<div class="price">
			<h4>$<?php echo $flfsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- food handler all other states -->
<div class="course_container" <?php if($Show_nfon=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/nfon" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/nfon" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/nfon"><?php echo $nfon_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/nfon">
		<div class="price">
			<h4>$<?php echo $nfon_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Idaho food handler -->
<div class="course_container" <?php if($Show_idfsh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/idfsh" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/idfsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/idfsh"><?php echo $idfsh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/idfsh">
		<div class="price">
			<h4>$<?php echo $idfsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Illinois food handler -->
<div class="course_container" <?php if($Show_ilfsh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/ilfsh" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/ilfsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/ilfsh"><?php echo $ilfsh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/ilfsh">
		<div class="price">
			<h4>$<?php echo $ilfsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Jackson County food handler -->
<div class="course_container" <?php if($Show_mofsh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/mofsh" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/mofsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/mofsh"><?php echo $mofsh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/mofsh">
		<div class="price">
			<h4>$<?php echo $mofsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- New Mexico food handler -->
<div class="course_container" <?php if($Show_nmfsh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/nmfsh" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/nmfsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/nmfsh"><?php echo $nmfsh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/nmfsh">
		<div class="price">
			<h4>$<?php echo $nmfsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Norfolk VA food handler -->
<div class="course_container" <?php if($Show_vaccfsh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/vaccfsh" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/vaccfsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/vaccfsh"><?php echo $vaccfsh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/vaccfsh">
		<div class="price">
			<h4>$<?php echo $vaccfsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Ohio Level 1 food handler -->
<div class="course_container" <?php if($Show_ohfsh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/ohfsh" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/ohfsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/ohfsh"><?php echo $ohfsh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/ohfsh">
		<div class="price">
			<h4>$<?php echo $ohfsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Texas food handler -->
<div class="course_container" <?php if($Show_txfsh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/txfsh" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/txfsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/txfsh"><?php echo $txfsh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/txfsh">
		<div class="price">
			<h4>$<?php echo $txfsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Utah food handler -->
<div class="course_container" <?php if($Show_utfsh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/utfsh" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/utfsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/utfsh"><?php echo $utfsh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/utfsh">
		<div class="price">
			<h4>$<?php echo $utfsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Wichita KS Food Handler Training -->
<div class="course_container" <?php if($Show_ksfsh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/ksfsh" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/ksfsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/ksfsh"><?php echo $ksfsh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/ksfsh">
		<div class="price">
			<h4>$<?php echo $ksfsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Mid-Ohio Valley Health Department West Virginia Food Worker's Permit  -->
<div class="course_container" <?php if($Show_wvfsh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/WVMV" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/WVMV" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/WVMV"><?php echo $wvfsh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/WVMV">
		<div class="price">
			<h4>$<?php echo $wvfsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Barbour County WV -->
<div class="course_container" <?php if($Show_wvba=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/WVBA" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/WVBA" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/WVBA"><?php echo $wvba_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/WVBA">
		<div class="price">
			<h4>$<?php echo $wvba_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Cabell-Huntington County WV  -->
<div class="course_container" <?php if($Show_wvch=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/WVCH" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/WVCH" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/WVCH"><?php echo $wvch_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/WVCH">
		<div class="price">
			<h4>$<?php echo $wvch_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Monroe County, WV Food Handler -->
<div class="course_container" <?php if($Show_wvmn=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/WVMN" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/WVMN" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/WVMN"><?php echo $wvmn_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/WVMN">
		<div class="price">
			<h4>$<?php echo $wvmn_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Pendleton County, WV Food Handler WV  -->
<div class="course_container" <?php if($Show_wvpe=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/WVPE" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/WVPE" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/WVPE"><?php echo $wvpe_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/WVPE">
		<div class="price">
			<h4>$<?php echo $wvpe_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Pocahontas County, WV Food Handler WV  -->
<div class="course_container" <?php if($Show_wvpo=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/WVPO" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/WVPO" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/WVPO"><?php echo $wvpo_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/WVPO">
		<div class="price">
			<h4>$<?php echo $wvpo_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Upshur County, WV Food Handler WV  -->
<div class="course_container" <?php if($Show_wvup=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/WVUP" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/WVUP" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/WVUP"><?php echo $wvup_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/WVUP">
		<div class="price">
			<h4>$<?php echo $wvup_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Wayne County, WV Food Handler WV  -->
<div class="course_container" <?php if($Show_wvwa=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/WVWA" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/WVWA" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/WVWA"><?php echo $wvwa_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/WVWA">
		<div class="price">
			<h4>$<?php echo $wvwa_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- Wheeling-Ohio County, WV Food Handler WV  -->
<div class="course_container" <?php if($Show_wvoh=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/WVOH" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodhandler/WVOH" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodhandler/WVOH"><?php echo $wvoh_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodhandler/WVOH">
		<div class="price">
			<h4>$<?php echo $wvoh_price; ?></h4>
		</div>
        </a>
	</div>
</div>



<!-- fsm --> 
<div class="course_container" <?php if($Show_FS=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/fs1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/fs" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/fs" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/fs"><?php echo $fs_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/fs">
		<div class="price">
			<h4>$<?php echo $fs_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- retail fsm -->
<div class="course_container" <?php if($Show_FSRT=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/fsrt1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/fsrt" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/fsrt" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/fsrt"><?php echo $fsrt_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/fsrt">
		<div class="price">
			<h4>$<?php echo $fsrt_price; ?></h4>
		</div>
        </a>
	</div>
</div>


<!-- allergen awareness -->
<div class="course_container" <?php if($Show_AA=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/aa1.png">
        <div class="btns">
			<p><a href = "/courses/allergenfriendly/description/aa" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/allergenfriendly/aa" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/allergenfriendly/aa"><?php echo $aa_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/allergenfriendly/aa">
		<div class="price">
			<h4>$<?php echo $aa_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- allergen development -->
<div class="course_container" <?php if($Show_AD=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/ad1.png">
        <div class="btns">
			<p><a href = "/courses/allergenfriendly/description/ad" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/allergenfriendly/ad" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/allergenfriendly/ad"><?php echo $ad_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/allergenfriendly/ad">
		<div class="price">
			<h4>$<?php echo $ad_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- allergen specialist -->
<div class="course_container" <?php if($Show_AS=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/as1.png">
        <div class="btns">
			<p><a href = "/courses/allergenfriendly/description/as" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/allergenfriendly/as" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/allergenfriendly/as"><?php echo $as_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/allergenfriendly/as">
		<div class="price">
			<h4>$<?php echo $as_price; ?></h4>
		</div>
        </a>
	</div>
</div>
 

<!-- ohio level 2 -->
<div class="course_container" <?php if($Show_OH2=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/oh21.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/oh2" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/oh2" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/oh2"><?php echo $oh2_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/oh2">
		<div class="price">
			<h4>$<?php echo $fs_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- ohio level 2 Retail-->
<div class="course_container" <?php if($Show_OH2RT=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/oh2rt1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/oh2rt" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/oh2rt" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/oh2rt"><?php echo $oh2rt_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/oh2rt">
		<div class="price">
			<h4>$<?php echo $fsrt_price; ?></h4>
		</div>
        </a>
	</div>
</div>


<!-- haccp --> 
<div class="course_container" <?php if($Show_NHACCP=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/nhaccp1.png">
        <div class="btns">
			<p><a href = "/courses/haccp/description/nhaccp" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/haccp/nhaccp" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/haccp/nhaccp"><?php echo $nhaccp_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/haccp/nhaccp">
		<div class="price">
			<h4>$<?php echo $nhaccp_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- minessota recert -->
<div class="course_container" <?php if($Show_REMN=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/remn1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/remn" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/remn" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/remn"><?php echo $remn_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/remn">
		<div class="price">
			<h4>$<?php echo $refs_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- rhode island recert -->
<div class="course_container" <?php if($Show_RERI=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/reri1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/reri" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/reri" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/reri"><?php echo $reri_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/reri">
		<div class="price">
			<h4>$<?php echo $refs_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- wisconsin recert-->
<div class="course_container" <?php if($Show_REWI=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/rewi1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/rewi" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/rewi" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/rewi"><?php echo $rewi_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/rewi">
		<div class="price">
			<h4>$<?php echo $rewi_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- cooking basics-->
<div class="course_container" <?php if($Show_CB=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/cb1.png">
        <div class="btns">
			<p><a href = "/courses/foodserviceoperations/description/cb" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodserviceoperations/cb" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodserviceoperations/cb"><?php echo $cb_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodserviceoperations/cb">
		<div class="price">
			<h4>$<?php echo $cb_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- chef fundamentals-->
<div class="course_container" <?php if($Show_CF=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/cf1.png">
        <div class="btns">
			<p><a href = "/courses/foodserviceoperations/description/cf" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodserviceoperations/cf" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodserviceoperations/cf"><?php echo $cf_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodserviceoperations/cf">
		<div class="price">
			<h4>$<?php echo $cf_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- earn more with service-->
<div class="course_container" <?php if($Show_EMWS=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/emws1.png">
        <div class="btns">
			<p><a href = "/courses/foodserviceoperations/description/emws" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodserviceoperations/emws" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodserviceoperations/emws"><?php echo $emws_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodserviceoperations/emws">
		<div class="price">
			<h4>$<?php echo $emws_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- strategies for increasing sales-->
<div class="course_container" <?php if($Show_SFIS=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/sfis1.png">
        <div class="btns">
			<p><a href = "/courses/foodserviceoperations/description/sfis" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodserviceoperations/sfis" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodserviceoperations/sfis"><?php echo $sfis_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodserviceoperations/sfis">
		<div class="price">
			<h4>$<?php echo $sfis_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- alcohol -->
<div class="course_container" <?php if($Show_ALCOHOL=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="/courses/shop/images/al1.png">
        <div class="btns">
			<p><a href = "/courses/alcoholtraining/" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/alcoholtraining/" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/alcoholtraining/">Online Alcohol Seller/Server Certification </a></h4>
		</div>
        <a href = "/courses/alcoholtraining/">
		<div class="price">
			<h4>$<?php echo $alc_price; ?></h4>
		</div>
        </a>
	</div>
</div>

</div><!-- #wrapper-->


<?php //print_r($_SESSION); ?>
<?php include '../footer.php';?>
<script>
<?php
if($_SESSION["discode"]=="ol2"){
    echo "  
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-90592116-1', 'auto');
            ga('send', 'pageview');
        ";    
}
?>
</script>
</body>
</html>