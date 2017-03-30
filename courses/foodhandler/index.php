<?php

	ob_start();
	if(isset($_POST) && count($_POST) > 0)
	{
		include_once $_SERVER['DOCUMENT_ROOT']."/lib/Helper.php";

		$helper = new Helper();

		if(!isset($_SESSION))
			session_start();

		$_SESSION['course'] = [];
		$_SESSION['course'] = array('state' => $helper -> FindFullName($_POST['state']));
		ob_end_clean();
	}

session_start();
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

$SQL = "SELECT ProID FROM [07DS2] ";		
$resultset=mssql_query($SQL, $con); 
while ($row = mssql_fetch_array($resultset)) 
{
	$ProIDDB[] = $row['ProID'];
}  

foreach ($_SESSION as $key=>$val)
{
	if(in_array($key, $ProIDDB)){
		$sessionm[] = $val[2];
	}
}

?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Select the State Where You Work</h1>
				<p>Already paid for the course? <a href="/training"><span class="clicktap">Click</span> here to login to course.</a></p>
            </div>
			          
			
            <div class="row">
						
                <div id="collapsing-bordered-table" class="collapsing-bordered-table state-list">
								<a href="/courses/shop/foodhandler/nfon" class="btn btn-primary" role="button">Other Countries</a>
			<br><br>
					<div>
						<div id="ak" class="col-sm-12 col-md-3">Alaska
						<a class="course-id hidden" href="#alaska"></a>
						</div>
						<div id="al" class="col-sm-12 col-md-2">Alabama
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="ar" class="col-sm-12 col-md-2">Arkansas
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="az" class="col-sm-12 col-md-2">Arizona
						<a class="course-id hidden" href="#21"></a>
						</div>
						<div id="ca" class="col-sm-12 col-md-3">California
						<a class="course-id hidden" href="#california"></a>
						</div>
					</div>
					<div>
						<div id="co" class="col-sm-12 col-md-3">Colorado
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="ct" class="col-sm-12 col-md-2">Conneticut
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="dc" class="col-sm-12 col-md-2">District of Columbia
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="de" class="col-sm-12 col-md-2">Delaware
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="fl" class="col-sm-12 col-md-3">Florida
						<a class="course-id hidden" href="#75"></a>
						</div>
					</div>
					<div>
						<div id="ga" class="col-sm-12 col-md-3">Georgia
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="hi" class="col-sm-12 col-md-2">Hawaii
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="ia" class="col-sm-12 col-md-2">Iowa
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="id" class="col-sm-12 col-md-2">Idaho
						<a class="course-id hidden" href="#13"></a>
						</div>
						<div id="il" class="col-sm-12 col-md-3">Illinois
						<a class="course-id hidden" href="#162"></a>
						</div>
					</div>
					<div>
						<div id="in" class="col-sm-12 col-md-3">Indiana
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="ks" class="col-sm-12 col-md-2">Kansas
						<a class="course-id hidden" href="#76"></a>
						</div>
						<div id="ky" class="col-sm-12 col-md-2">Kentucky
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="la" class="col-sm-12 col-md-2">Louisiana
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="ma" class="col-sm-12 col-md-3">Massachusetts
						<a class="course-id hidden" href="#3"></a>
						</div>
					</div>
					<div>
						<div id="md" class="col-sm-12 col-md-3">Maryland
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="me" class="col-sm-12 col-md-2">Maine
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="mi" class="col-sm-12 col-md-2">Michigan
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="mn" class="col-sm-12 col-md-2">Minnesota
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="mo" class="col-sm-12 col-md-3">Missouri
						<a class="course-id hidden" href="#164"></a>
						</div>
					</div>
					<div>
						<div id="ms" class="col-sm-12 col-md-3">Mississippi
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="mt" class="col-sm-12 col-md-2">Montana
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="nc" class="col-sm-12 col-md-2">North Carolina
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="nd" class="col-sm-12 col-md-2">North Dakota
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="ne" class="col-sm-12 col-md-3">Nebraska
						<a class="course-id hidden" href="#3"></a>
						</div>
					</div>
					<div>
						<div id="nh" class="col-sm-12 col-md-3">New Hampshire
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="nj" class="col-sm-12 col-md-2">New Jersey
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="nm" class="col-sm-12 col-md-2">New Mexico
						<a class="course-id hidden" href="#18"></a>
						</div>
						<div id="nv" class="col-sm-12 col-md-2">Nevada
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="ny" class="col-sm-12 col-md-3">New York
						<a class="course-id hidden" href="#3"></a>
						</div>
					</div>
					<div>
						<div id="oh" class="col-sm-12 col-md-3">Ohio
						<a class="course-id hidden" href="#24"></a>
						</div>
						<div id="ok" class="col-sm-12 col-md-2">Oklahoma
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="or" class="col-sm-12 col-md-2">Oregon
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="pa" class="col-sm-12 col-md-2">Pennsylvania
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="ri" class="col-sm-12 col-md-3">Rhode Island
						<a class="course-id hidden" href="#3"></a>
						</div>
					</div>
					<div>
						<div id="sc" class="col-sm-12 col-md-3">South Carolina
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="sd" class="col-sm-12 col-md-2">South Dakota
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="tn" class="col-sm-12 col-md-2">Tennessee
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="tx" class="col-sm-12 col-md-2">Texas
						<a class="course-id hidden" href="#105"></a>
						</div>
						<div id="ut" class="col-sm-12 col-md-3">Utah
						<a class="course-id hidden" href="#80"></a>
						</div>
					</div>
					<div>
						<div id="va" class="col-sm-12 col-md-3">Virginia
						<a class="course-id hidden" href="#virginia"></a>
						</div>
						<div id="vt" class="col-sm-12 col-md-2">Vermont
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="wa" class="col-sm-12 col-md-2">Washington
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="wi" class="col-sm-12 col-md-2">Wisconsin
						<a class="course-id hidden" href="#3"></a>
						</div>
						<div id="av" class="col-sm-12 col-md-3">West Virginia
						<a class="course-id hidden" href="#wvirginia"></a>
						</div>
					</div>
					<div style="border:1px solid white">
						<div id="wy" class="col-sm-12 col-md-3">Wyoming
						<a class="course-id hidden" href="#3"></a>
						</div>
					</div>
                </div>
            </div>
			<br />
        </div>        
    </div>
</div>
<!-- Modals -->
<div class="modal fade ca-opts" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Please select your course</h4>
      </div>
      <div class="modal-body">
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="califsh" checked>
            California Food Handler
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="casd">
            San Diego Food Handler
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success ca-yes">Ok</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade ak-opts" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Please select your course</h4>
      </div>
      <div class="modal-body">
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="nfon" checked>
            Alaska Food Handler
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="akan">
            Anchorage, AK Food Handler
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success ak-yes">Ok</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Kansas Only uses Wichita, no need to select a fh
<div class="modal fade ks-opts" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Please select your course</h4>
      </div>
      <div class="modal-body">
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="nfon" checked>
            Kansas Food Handler
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="ksfsh">
            Witchita Food Handler
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success ks-yes">Ok</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
-->
<div class="modal fade va-opts" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel">Please select your course</h4>
      </div>
      <div class="modal-body">
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="nfon" checked>
            Virginia Food Handler
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="vaccfsh">
            Norfolk Virginia Food Handler
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success va-yes">Ok</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade wv-opts" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel" <?php if($sessionm[0]=='WVBA' || $sessionm[0]=='WVCH' || $sessionm[0]=='WVMV' || $sessionm[0]=='WVMN' || $sessionm[0]=='WVPE' || $sessionm[0]=='WVPO' || $sessionm[0]=='WVUP' || $sessionm[0]=='WVWA' || $sessionm[0]=='WVOH'){echo "style='display:none'";}else{echo "style='display:block'";}?>>Please select your county</h4>
      </div>
			<div class="modal-body text-center" <?php if($sessionm[0]=='WVBA' || $sessionm[0]=='WVCH' || $sessionm[0]=='WVMV' || $sessionm[0]=='WVMN' || $sessionm[0]=='WVPE' || $sessionm[0]=='WVPO' || $sessionm[0]=='WVUP' || $sessionm[0]=='WVWA' || $sessionm[0]=='WVOH'){echo "style='display:block'";}else{echo "style='display:none'";}?>>
				<p>We see that you already have a West Virginia course in your shopping cart. You can only purchase one West Virginia course at a time. Click below to continue your purchase.</p>
				<a href="/courses/shop/sc_shopping_cart.php" class="btn btn-primary" role="button">Go to Shopping Cart</a>
			</div>	 
      <div class="modal-body" <?php if($sessionm[0]=='WVBA' || $sessionm[0]=='WVCH' || $sessionm[0]=='WVMV' || $sessionm[0]=='WVMN' || $sessionm[0]=='WVPE' || $sessionm[0]=='WVPO' || $sessionm[0]=='WVUP' || $sessionm[0]=='WVWA' || $sessionm[0]=='WVOH'){echo "style='display:none'";}else{echo "style='display:block'";}?>>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVBA" checked>
             Barbour County
          </label>
        </div>
				<div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVMV">
              Calhoun County
          </label>
        </div>
				<div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVCH">
            Cabell-Huntington County
          </label>
        </div>
				<div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVMN">
             Monroe County
          </label>
        </div>
				<div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVPE">
          	Pendleton County
          </label>
        </div>
				<div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVMV">
            Pleasants County
          </label>
        </div>
				<div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVPO">
            Pocahontas County
          </label>
        </div>
				<div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVRN">
            Randolph-Elkins County
          </label>
        </div>
				<div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVMV">
            Ritchie County
          </label>
        </div>
				<div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVMV">
            Roane County
          </label>
        </div>
				<div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVUP">
            Upshur County
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVWA">
            Wayne County 
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVOH">
             Wheeling-Ohio County
          </label>
        </div>
				<div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVMV">
            Wirt County
          </label>
        </div>
				<div class="radio">
          <label>
            <input type="radio" name="course-opts" value="WVMV">
            Wood County
          </label>
        </div>


      </div>
      <div class="modal-footer" <?php if($sessionm[0]=='WVBA' || $sessionm[0]=='WVCH' || $sessionm[0]=='WVMV' || $sessionm[0]=='WVMN' || $sessionm[0]=='WVPE' || $sessionm[0]=='WVPO' || $sessionm[0]=='WVUP' || $sessionm[0]=='WVWA' || $sessionm[0]=='WVOH'){echo "style='display:none'";}else{echo "style='display:block'";}?>>
        <button class="btn btn-success wv-yes">Ok</button>
        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modals-->
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>