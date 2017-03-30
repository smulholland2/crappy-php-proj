<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
	<style>
		.collapsing-bordered-table > div > div {
			border:thin solid #ddd;
			padding: 15px;
			text-align: center;	
		}
		.collapsing-bordered-table > div > div:hover {
			background:#1E2B41;
			color:white;
			corder-color:white;
			cursor:pointer;
		}
	</style>
    <div class="container-fluid">
    <div class="col-md-12">
      <div class="page-header">
        <h1>Food Safety Manager Certificate</h1>
      </div>
      <br />
      <!-- if location hasn't been set, hide the shortcut form. -->
      <div class="<?php echo !is_null($_SESSION['location']) ? $geoclass = 'row shortcut' : $geoclass = 'row shortcut hidden'; ?>">
        <p>Our system indicates that you are in
          <?php echo !is_null($_SESSION['location']) ? $_SESSION['location'] : false; ?>.</p>
        <p>Would you like to print your certificate from that state?</p>
        <input class="state-ref" type="hidden" value="<?php echo $_SESSION['abvr'] ?>" />
        <button class="geo-print-yes btn btn-success">Yes</button>
        <button class="geo-print-no btn btn-danger">No</button>
        <button class="geo-print-wrong btn btn-default">That's not my State!</button>
      </div>
      <!-- if location hasn't been set, hide the shortcut form. -->
      <div class="<?php echo is_null($_SESSION['location']) ? $mapclass = 'row map' : $mapclass = 'row map hidden'; ?>">
        <a href="/certificate" class="btn btn-primary">Back to Courses</a>
        <div id="collapsing-bordered-table" class="collapsing-bordered-table" style="margin-top: 30px">
          <div>
            <div id="ak" class="col-sm-12 col-md-3 usern">Alaska
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="al" class="col-sm-12 col-md-2 usern">Alabama
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="ar" class="col-sm-12 col-md-2 usern">Arkansas
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="az" class="col-sm-12 col-md-2 usern">Arizona
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="ca" class="col-sm-12 col-md-3 usern">California
              <a class="course-id hidden" href="#22"></a>
            </div>
          </div>
          <div>
            <div id="co" class="col-sm-12 col-md-3 usern">Colorado
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="ct" class="col-sm-12 col-md-2 usern">Conneticut
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="dc" class="col-sm-12 col-md-2 usern">District of Columbia
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="de" class="col-sm-12 col-md-2 usern">Delaware
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="fl" class="col-sm-12 col-md-3 usern">Florida
              <a class="course-id hidden" href="#22"></a>
            </div>
          </div>
          <div>
            <div id="ga" class="col-sm-12 col-md-3 usern">Georgia
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="hi" class="col-sm-12 col-md-2 usern">Hawaii
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="id" class="col-sm-12 col-md-2 usern">Iowa
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="il" class="col-sm-12 col-md-2 usern">Idaho
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="in" class="col-sm-12 col-md-3 usern">Illinois
              <a class="course-id hidden" href="#22"></a>
            </div>
          </div>
          <div>
            <div id="ia" class="col-sm-12 col-md-3 usern">Indiana
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="ks" class="col-sm-12 col-md-2 usern">Kansas
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="ky" class="col-sm-12 col-md-2 usern">Kentucky
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="la" class="col-sm-12 col-md-2 usern">Louisiana
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="ma" class="col-sm-12 col-md-3 usern">Massachusetts
              <a class="course-id hidden" href="#22"></a>
            </div>
          </div>
          <div>
            <div id="md" class="col-sm-12 col-md-3 usern">Maryland
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="me" class="col-sm-12 col-md-2 usern">Maine
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="mi" class="col-sm-12 col-md-2 usern">Michigan
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="mn" class="col-sm-12 col-md-2 usern">Minnesota
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="mo" class="col-sm-12 col-md-3 usern">Missouri
              <a class="course-id hidden" href="#22"></a>
            </div>
          </div>
          <div>
            <div id="ms" class="col-sm-12 col-md-3 usern">Mississippi
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="mt" class="col-sm-12 col-md-2 usern">Montana
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="nc" class="col-sm-12 col-md-2 usern">North Carolina
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="nd" class="col-sm-12 col-md-2 usern">North Dakota
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="ne" class="col-sm-12 col-md-3 usern">Nebraska
              <a class="course-id hidden" href="#22"></a>
            </div>
          </div>
          <div>
            <div id="nh" class="col-sm-12 col-md-3 usern">New Hampshire
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="nj" class="col-sm-12 col-md-2 usern">New Jersey
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="nm" class="col-sm-12 col-md-2 usern">New Mexico
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="nv" class="col-sm-12 col-md-2 usern">Nevada
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="ny" class="col-sm-12 col-md-3 usern">New York
              <a class="course-id hidden" href="#22"></a>
            </div>
          </div>
          <div>
            <div id="oh" class="col-sm-12 col-md-3 usern">Ohio
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="ok" class="col-sm-12 col-md-2 usern">Oklahoma
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="or" class="col-sm-12 col-md-2 usern">Oregon
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="pa" class="col-sm-12 col-md-2 usern">Pennsylvania
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="ri" class="col-sm-12 col-md-3 usern">Rhode Island
              <a class="course-id hidden" href="#22"></a>
            </div>
          </div>
          <div>
            <div id="sc" class="col-sm-12 col-md-3 usern">South Carolina
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="sd" class="col-sm-12 col-md-2 usern">South Dakota
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="tn" class="col-sm-12 col-md-2 usern">Tennessee
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="tx" class="col-sm-12 col-md-2 usern">Texas
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="ut" class="col-sm-12 col-md-3 usern">Utah
              <a class="course-id hidden" href="#22"></a>
            </div>
          </div>
          <div>
            <div id="va" class="col-sm-12 col-md-3 usern">Virginia
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="vt" class="col-sm-12 col-md-2 usern">Vermont
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="wa" class="col-sm-12 col-md-2 usern">Washington
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="wi" class="col-sm-12 col-md-2 usern">Wisconsin
              <a class="course-id hidden" href="#22"></a>
            </div>
            <div id="av" class="col-sm-12 col-md-3 usern">West Virginia
              <a class="course-id hidden" href="#22"></a>
            </div>
          </div>
          <div style="border:1px solid white">
            <div id="wy" class="col-sm-12 col-md-3 usern">Wyoming
              <a class="course-id hidden" href="#22"></a>
            </div>
          </div>
        </div>
      </div>
      <br />
      <div class="row welcome-msg hidden">
        <button class="btn btn-primary">Go back to map</button>
        <br /><br />
        <p><strong>Please Enter Your Login Information</strong></p>
      </div>
      <br />
      <div class="row well cert-login-forms hidden">
        <form method="POST" action="http://asp.tapseries.com/certificate/ShowCertificate_.asp" class="dobform">
            <input type="hidden" name="lname200" />
            <input type="hidden" name="month" value="Month" />
            <input type="hidden" name="day" value="Day" />
            <input type="hidden" name="year" value="Year" />
            <div class="form-group col-md-6 col-sm-12">
                <label for="lastname">Last Name (Apellido):</label>
                <input type="text" name="lname100" class="form-control"/>
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="username">User Name (Nombre de Usuario):</label>
                <input type="text" class="form-control" name="ctname933"/>
            </div>
            <div class="clearfix"></div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>