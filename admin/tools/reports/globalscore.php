<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>

<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
$corp_user = $_SESSION['user']; 
$admintable = $_SESSION['admintable'];
if($_SESSION['region']){
    $region = $_SESSION['region'];
}
$todaysdate = date('m/d/Y');

if($admintable=="07L3"){
    $view_report = "globalscore_list.php";
} 
if($admintable=="07L2" && $region == 1){
    $view_report = "region_globalscore_list.php";
}
if($admintable=="07L2" && $region != 1){
    $view_report = "multi_globalscore_list.php";
} 

?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Global Score Report</h1>
            </div>
            <a href="/account/login" class="btn btn-primary">Main Menu</a>
            <div class="report-search-form">
                <div class="row">
                    <p <?php if($admintable=="07L3" or $region==1){echo "style='display:none'";}else{echo "style='display:block'";}?>><strong>This report only contains score results for each student.<br>To view a simple Global Progress Report, <a href="globalprogress.php">click here</a>.</strong></p>
                    <br />
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <form class="form" action="<?php echo $view_report;?>" method="get">                        
                            <div class="form-group">
                                <label for="searchTo">Search Dates:</label>
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control date" name="start" placeholder="Click here to open the 'from' calendar"/>
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control date" value="<?php echo $todaysdate;?>" name="end" placeholder="Click here to open the 'to' calendar"/>
                                </div>
                            </div>                        
                            <div class="form-group">
                                <label for="productid">Under Training Achievement Program:</label>
                                <select name="productid" size="8" class="form-control" required>
                                    <option value="aa">Allergen Awareness</option>
                                    <option value="21">Arizona Food Handler Training</option>
                                    <option value="3">California Food Handler Training</option>
                                    <option value="17">Florida Food Worker Training Program</option>
                                    <option value="2">Food Handler Training (all other states)</option>
                                    <option value="1">Food Safety Manager Certification Training</option>
                                    <option value="nhaccp">HACCP Managers Certificate Course</option>
                                    <option value="20">Illinois Food Handler Training</option>
                                    <option value="22">Jackson County MO Food Handler Training</option>
                                    <option value="10">Ohio Level One Certification</option>
                                    <option value="fsrt">Retail Food Safety Manager Certification Training</option>
                                    <option value="7">Texas Food Handler Training</option>
                                    <option value="19">Utah Food Handler Training</option>
                                    <option value="18">Wichita Food Handler</option>
                                </select>
                            </div>
                            <p <?php if($admintable=="07L3" || $region==1){echo "style='display:none'";}else{echo "style='display:block'";}?>><strong>Select Region: &nbsp;</strong>
                                <select name="corp_sub_acct_id">
                                <?php
                                $SQL = "SELECT UU, id FROM [07L2] WHERE SUB='$corp_user' AND UU='$corp_user' ";		
                                $resultset=mssql_query($SQL, $con); 
                                while ($row = mssql_fetch_array($resultset)) 
                                {
                                    $corp_sub_accts = $row['UU'];
                                    $corp_sub_accts_id = $row['id'];
                                    echo "<option value='$corp_sub_accts_id' selected>$corp_sub_accts (Show all regions)</option>";
                                }

                                $SQL1 = "SELECT UU, id FROM [07L2] WHERE SUB='$corp_user' AND UU<>'$corp_user' ";		
                                $resultset1=mssql_query($SQL1, $con); 
                                while ($row = mssql_fetch_array($resultset1)) 
                                {
                                    $corp_sub_accts = $row['UU'];
                                    $corp_sub_accts_id = $row['id'];
                                    echo "<option value='$corp_sub_accts_id'>$corp_sub_accts</option>";
                                }
                                ?>
                                
                                </select>
                            </p>                    
                            <input type="submit" class="btn btn-success" value="Submit"/>
                            <br />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //print_r($_SESSION);?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
</body>
</html>