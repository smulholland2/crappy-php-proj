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
?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<!--<script src="../wwwroot/js/courses/foodsafetymanager/index.js"></script>-->
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
            <div class="page-header text-center">
                <h1>Select the State Where You Work</h1>
				<p>Already paid for the course? <a href="/training">Login to course.</a></p>
            </div>            
            <div class="row">
                <div id="collapsing-bordered-table" class="collapsing-bordered-table state-list">
					<a href="/courses/shop/foodsafetymanager/fs" class="btn btn-primary" role="button">Other Countries</a>
			<br><br>
					<div>
						<div id="ak" class="col-sm-12 col-md-3 usern">Alaska
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="al" class="col-sm-12 col-md-2 usern">Alabama
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="ar" class="col-sm-12 col-md-2 usern">Arkansas
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="az" class="col-sm-12 col-md-2 dob">Arizona
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="ca" class="col-sm-12 col-md-3 dob">California
						<a class="course-id hidden" href="#2"></a>
						</div>
					</div>
					<div>
						<div id="co" class="col-sm-12 col-md-3 usern">Colorado
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="ct" class="col-sm-12 col-md-2 usern">Conneticut
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="dc" class="col-sm-12 col-md-2 usern">District of Columbia
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="de" class="col-sm-12 col-md-2 usern">Delaware
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="fl" class="col-sm-12 col-md-3 dob">Florida
						<a class="course-id hidden" href="#2"></a>
						</div>
					</div>
					<div>
						<div id="ga" class="col-sm-12 col-md-3 usern">Georgia
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="hi" class="col-sm-12 col-md-2 usern">Hawaii
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="ia" class="col-sm-12 col-md-2 usern">Iowa
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="id" class="col-sm-12 col-md-2 dob">Idaho
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="il" class="col-sm-12 col-md-3 dob">Illinois
						<a class="course-id hidden" href="#2"></a>
						</div>
					</div>
					<div>
						<div id="in" class="col-sm-12 col-md-3 usern">Indiana
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="ks" class="col-sm-12 col-md-2 usern">Kansas
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="ky" class="col-sm-12 col-md-2 usern">Kentucky
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="la" class="col-sm-12 col-md-2 usern">Louisiana
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="ma" class="col-sm-12 col-md-3 usern">Massachusetts
						<a class="course-id hidden" href="#2"></a>
						</div>
					</div>
					<div>
						<div id="md" class="col-sm-12 col-md-3 usern">Maryland
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="me" class="col-sm-12 col-md-2 usern">Maine
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="mi" class="col-sm-12 col-md-2 usern">Michigan
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="mn" class="col-sm-12 col-md-2 usern">Minnesota
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="mo" class="col-sm-12 col-md-3 dob">Missouri
						<a class="course-id hidden" href="#2"></a>
						</div>
					</div>
					<div>
						<div id="ms" class="col-sm-12 col-md-3 usern">Mississippi
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="mt" class="col-sm-12 col-md-2 usern">Montana
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="nc" class="col-sm-12 col-md-2 usern">North Carolina
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="nd" class="col-sm-12 col-md-2 usern">North Dakota
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="ne" class="col-sm-12 col-md-3 usern">Nebraska
						<a class="course-id hidden" href="#2"></a>
						</div>
					</div>
					<div>
						<div id="nh" class="col-sm-12 col-md-3 usern">New Hampshire
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="nj"class="col-sm-12 col-md-2 usern">New Jersey
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="nm" class="col-sm-12 col-md-2 dob">New Mexico
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="nv" class="col-sm-12 col-md-2 usern">Nevada
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="ny" class="col-sm-12 col-md-3 usern">New York
						<a class="course-id hidden" href="#2"></a>
						</div>
					</div>
					<div>
						<div id="oh" class="col-sm-12 col-md-3 dob">Ohio
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="ok" class="col-sm-12 col-md-2 dob">Oklahoma
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="or"class="col-sm-12 col-md-2 usern">Oregon
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="pa" class="col-sm-12 col-md-2 usern">Pennsylvania
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="ri" class="col-sm-12 col-md-3 usern">Rhode Island
						<a class="course-id hidden" href="#2"></a>
						</div>
					</div>
					<div>
						<div id="sc" class="col-sm-12 col-md-3 usern">South Carolina
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="sd" class="col-sm-12 col-md-2 usern">South Dakota
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="tn" class="col-sm-12 col-md-2 usern">Tennessee
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="tx" class="col-sm-12 col-md-2 dob">Texas
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="ut" class="col-sm-12 col-md-3 dob">Utah
						<a class="course-id hidden" href="#2"></a>
						</div>
					</div>
					<div>
						<div id="va" class="col-sm-12 col-md-3 usern">Virginia
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="vt" class="col-sm-12 col-md-2 usern">Vermont
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="wa" class="col-sm-12 col-md-2 usern">Washington
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="wi" class="col-sm-12 col-md-2 usern">Wisconsin
						<a class="course-id hidden" href="#2"></a>
						</div>
						<div id="av" class="col-sm-12 col-md-3 dob">West Virginia
						<a class="course-id hidden" href="#2"></a>
						</div>
					</div>
					<div style="border:1px solid white">
						<div id="wy" class="col-sm-12 col-md-3 usern">Wyoming
						<a class="course-id hidden" href="#2"></a>
						</div>
					</div>
                </div>
            </div>
			<br />
        </div>        
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>