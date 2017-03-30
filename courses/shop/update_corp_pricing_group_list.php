<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

$VC = $_GET["VC"];

if($VC != "")
{
    $SQL1="SELECT * FROM [07SL1C] WHERE VC='$VC' ";				
    $resultset1=mssql_query($SQL1, $con);
        while ($row = mssql_fetch_array($resultset1)) 
        {
            $NC = $row['NC'];

            $fs_price = $row['01C'];
			$fs_price = number_format($fs_price,2);

		    $fsrt_price = $row['01RC'];
			$fsrt_price = number_format($fsrt_price,2);

            $nfon_price = $row['01EC'];
			$nfon_price = number_format($nfon_price,2);

		    $refs_price = $row['02C'];
			$refs_price = number_format($refs_price,2);
			 
		    $rewi_price = $row['01RWEC'];
			$rewi_price = number_format($rewi_price,2);

		    $nhaccp_price = $row['04C'];
			$nhaccp_price = number_format($nhaccp_price,2);

            $emws_price = $row['06C'];
			$emws_price = number_format($emws_price,2);

		    $cb_price = $row['03C'];
			$cb_price = number_format($cb_price,2);

		    $sfis_price = $row['05C'];
			$sfis_price = number_format($sfis_price,2);

            $califsh_price = $row['01CAEC'];
			$califsh_price = number_format($califsh_price,2);

            $idfsh_price = $row['01IDEC'];
			$idfsh_price = number_format($idfsh_price,2);

            $nmfsh_price = $row['01NMEC'];
			$nmfsh_price = number_format($nmfsh_price,2);

            $vaccfsh_price = $row['01VACCEC'];
			$vaccfsh_price = number_format($vaccfsh_price,2);

            $flfsh_price = $row['01FLEC'];
			$flfsh_price = number_format($flfsh_price,2);

            $ksfsh_price = $row['01KSEC'];
			$ksfsh_price = number_format($ksfsh_price,2);

            $ohfsh_price = $row['01OHEC'];
			$ohfsh_price = number_format($ohfsh_price,2);

            $utfsh_price = $row['01UTEC'];
			$utfsh_price = number_format($utfsh_price,2);

            $ilfsh_price = $row['01ILEC'];
			$ilfsh_price = number_format($ilfsh_price,2);

            $azfsh_price = $row['01AZEC'];
			$azfsh_price = number_format($azfsh_price,2);

            $mofsh_price = $row['01MOEC'];
			$mofsh_price = number_format($mofsh_price,2);

            $txfsh_price = $row['01TXEC'];
			$txfsh_price = number_format($txfsh_price,2);

            $wvfsh_price = $row['01WVMVEC'];
			$wvfsh_price = number_format($wvfsh_price,2);

		    $aa_price = $row['09C'];
			$aa_price = number_format($aa_price,2);

            $ad_price = $row['10C'];
			$ad_price = number_format($ad_price,2);

            $as_price = $row['11C'];
			$as_price = number_format($as_price,2);

        }



    // get prices for WV courses    
    $SQL2="SELECT * FROM [07SL1WV] WHERE VC='$VC' ";				
    $resultset2=mssql_query($SQL2, $con);
        while ($row = mssql_fetch_array($resultset2)) 
        {
            $VC_WV = $row['VC'];

            $wvch_price = $row['01WVCHEC'];
            $wvmn_price = $row['01WVMNEC'];
            $wvpe_price = $row['01WVPEEC'];
            $wvpo_price = $row['01WVPOEC'];
            $wvup_price = $row['01WVUPEC'];
            $wvwa_price = $row['01WVWAEC'];
            $wvba_price = $row['01WVBAEC'];
            $wvoh_price = $row['01WVOHEC'];
 
        }

        if($VC_WV =="")
        {
            $SQL2="SELECT * FROM [07SL1WV] WHERE VC='tapseries' ";				
            $resultset2=mssql_query($SQL2, $con);
                while ($row = mssql_fetch_array($resultset2)) 
                {
                    $wvch_price = $row['01WVCHEC'];
                    $wvmn_price = $row['01WVMNEC'];
                    $wvpe_price = $row['01WVPEEC'];
                    $wvpo_price = $row['01WVPOEC'];
                    $wvup_price = $row['01WVUPEC'];
                    $wvwa_price = $row['01WVWAEC'];
                    $wvba_price = $row['01WVBAEC'];
                    $wvoh_price = $row['01WVOHEC'];
                }



        } 
    
}
else
{
     echo"The VC wasn't found on the database.";
}


?>


<!DOCTYPE html>
<html>
<head>
<title>Update Pricing Group</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="page-header">
        <h1>Update Pricing Group</h1>
    </div>

    <p><strong>Client Information</strong></p>
    <p><strong>Client Name:</strong> <?php echo $NC;?></p>
    <p><strong>Code:</strong> <?php echo $VC;?></p>
    
    <h3>Product Price</h3>

    <form class="form-horizontal" action='update_corp_pricing_group_db.php' method='get'>


    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse3">Allergen Friendly <span class="caret"></span></a>
                </h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
                    <br>         
                    <div class="form-group">
                        <label class="control-label col-sm-7">Allergen Awareness:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="aa" value="<?php echo $aa_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Allergen Development:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="ad" value="<?php echo $ad_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Allergen Specialist:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="as" value="<?php echo $as_price;?>">
                        </div>
                    </div>       

                    <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Update Prices</button>
                    </div>         

             </div>
        </div>
    </div>


    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse1">Food Handler <span class="caret"></span></a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">

                    <br>     
                    <div class="form-group">
                        <label class="control-label col-sm-7">Food Safety Handler Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="nfon" value="<?php echo $nfon_price;?>">
                        </div>
                    </div>              
                            
                    <div class="form-group">
                        <label class="control-label col-sm-7">California Food Handler Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="califsh" value="<?php echo $califsh_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Idaho Food Handler Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="idfsh" value="<?php echo $idfsh_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">New Mexico Food Handler Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="nmfsh" value="<?php echo $nmfsh_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Norfolk VA Food Handler Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="vaccfsh" value="<?php echo $vaccfsh_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Florida Food Handler Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="flfsh" value="<?php echo $flfsh_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Wichita Food Handler Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="ksfsh" value="<?php echo $ksfsh_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Ohio Level One Certification:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="ohfsh" value="<?php echo $ohfsh_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Utah Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="utfsh" value="<?php echo $utfsh_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Illinois Food Handler Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="ilfsh" value="<?php echo $ilfsh_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Arizona Food Handler Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="azfsh" value="<?php echo $azfsh_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Jackson County MO Food Handler Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="mofsh" value="<?php echo $mofsh_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Texas Food Handler Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="txfsh" value="<?php echo $txfsh_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Mid-Ohio Valley Health Department West Virginia Food Worker's Permit:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="WVMV" value="<?php echo $wvfsh_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Cabell-Huntington County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvch" value="<?php echo $wvch_price;?>" <?php if($VC_WV ==""){ echo "disabled";}?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Monroe County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvmn" value="<?php echo $wvmn_price;?>" <?php if($VC_WV ==""){ echo "disabled";}?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Pendleton County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvpe" value="<?php echo $wvpe_price;?>" <?php if($VC_WV ==""){ echo "disabled";}?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Pocahontas County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvpo" value="<?php echo $wvpo_price;?>" <?php if($VC_WV ==""){ echo "disabled";}?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Upshur County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvup" value="<?php echo $wvup_price;?>" <?php if($VC_WV ==""){ echo "disabled";}?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Wayne County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvwa" value="<?php echo $wvwa_price;?>" <?php if($VC_WV ==""){ echo "disabled";}?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Barbour County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvba" value="<?php echo $wvba_price;?>" <?php if($VC_WV ==""){ echo "disabled";}?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Wheeling-Ohio County, WV Food Handler:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="wvoh" value="<?php echo $wvoh_price;?>" <?php if($VC_WV ==""){ echo "disabled";}?>>
                        </div>
                    </div>

                    <p <?php if($VC_WV =="") {echo "style='display:block;text-align:center'";} else{ echo "style='display:none'";}?>><a href="addupdate_pricing_group_wv.php?VC=<?php echo $VC; ?>&NC=<?php echo $NC; ?>">Add Discount for West Virginia Counties </a></p>

                    <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Update Prices</button>
                    </div>

             </div>
        </div>
    </div>


    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse2">Food Safety Manager <span class="caret"></span></a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">

                    <br>        
                    <div class="form-group">
                        <label class="control-label col-sm-7">Food Safety Managers Certification Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="fs" value="<?php echo $fs_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Retail Food Safety Managers Certification Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="fsrt" value="<?php echo $fsrt_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Food Safety Re-Certification Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="refs" value="<?php echo $refs_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">Wisconsin Recertification Course:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="rewi" value="<?php echo $rewi_price;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-7">HACCP Managers Certification Training:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" name="nhaccp" value="<?php echo $nhaccp_price;?>">
                        </div>
                    </div>       

                    <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Update Prices</button>
                    </div>         

             </div>
        </div>
    </div>





        <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse4">Food Service Operations <span class="caret"></span></a>
                </h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
         <br>    
         <div class="form-group">
            <label class="control-label col-sm-7">Earn More With Service:</label>
            <div class="col-sm-2">
            <input type="text" class="form-control" name="emws" value="<?php echo $emws_price;?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-7">Cooking Basics/Chef Fundamentals:</label>
            <div class="col-sm-2">
            <input type="text" class="form-control" name="cb" value="<?php echo $cb_price;?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-7">Strategies for Increasing Sales:</label>
            <div class="col-sm-2">
            <input type="text" class="form-control" name="sfis" value="<?php echo $sfis_price;?>">
            </div>
        </div>

        <div class="form-group text-center">
        <button type="submit" class="btn btn-primary">Update Prices</button>
        </div>          
                
             </div>
        </div>
    </div>

        <!-- VC needs to go to the next page -->
        <input type="hidden" name="VC" value="<?php echo $VC;?>">


    </form>

<br><br><br><br><br><br>



</div>    

</body>
</html>