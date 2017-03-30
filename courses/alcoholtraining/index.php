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
		.disabled {
			background-color: #ccc;
			color: #acacac;
		}
	</style>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="page-header text-center">
                <h1>Select the State Where You Work</h1>
				<p>Already paid for the course? <a href="/training">Login to course.</a></p>
            </div>            
			<br />
            <div class="row">
                <div id="collapsing-bordered-table" class="collapsing-bordered-table state-list" style="margin-top: 30px">
					<div>
						<div class="col-sm-12 col-md-3 disabled">Alaska</div>
						<div class="col-sm-12 col-md-2 disabled">Alabama</div>
						<div class="col-sm-12 col-md-2 disabled">Arkansas</div>
						<div class="col-sm-12 col-md-2 disabled">Arizona</div>
						<div class="col-sm-12 col-md-3" id="ca">California</div>
					</div>
					<div>
						<div class="col-sm-12 col-md-3 disabled">Colorado</div>
						<div class="col-sm-12 col-md-2 disabled">Conneticut</div>
						<div class="col-sm-12 col-md-2 disabled">District of Columbia</div>
						<div class="col-sm-12 col-md-2 disabled">Delaware</div>
						<div class="col-sm-12 col-md-3" id="fl">Florida</div>
					</div>
					<div>
						<div class="col-sm-12 col-md-3" id="ga">Georgia</div>
						<div class="col-sm-12 col-md-2" id="hi">Hawaii</div>
						<div class="col-sm-12 col-md-2 disabled">Iowa</div>
						<div class="col-sm-12 col-md-2" id="id">Idaho</div>
						<div class="col-sm-12 col-md-3" >Illinois</div>
					</div>
					<div>
						<div class="col-sm-12 col-md-3 disabled">Indiana</div>
						<div class="col-sm-12 col-md-2" id="ks">Kansas</div>
						<div class="col-sm-12 col-md-2" id="ky">Kentucky</div>
						<div class="col-sm-12 col-md-2 disabled">Louisiana</div>
						<div class="col-sm-12 col-md-3" id="ma">Massachusetts</div>
					</div>
					<div>
						<div class="col-sm-12 col-md-3 disabled">Maryland</div>
						<div class="col-sm-12 col-md-2 disabled">Maine</div>
						<div class="col-sm-12 col-md-2" id="mi">Michigan</div>
						<div class="col-sm-12 col-md-2 disabled">Minnesota</div>
						<div class="col-sm-12 col-md-3" id="mo">Missouri</div>
					</div>
					<div>
						<div class="col-sm-12 col-md-3" id="ms">Mississippi</div>
						<div class="col-sm-12 col-md-2" id="mn">Montana</div>
						<div class="col-sm-12 col-md-2" id="nc">North Carolina</div>
						<div class="col-sm-12 col-md-2" id="nd">North Dakota</div>
						<div class="col-sm-12 col-md-3" id="ne">Nebraska</div>
					</div>
					<div>
						<div class="col-sm-12 col-md-3 disabled">New Hampshire</div>
						<div class="col-sm-12 col-md-2 disabled">New Jersey</div>
						<div class="col-sm-12 col-md-2 disabled">New Mexico</div>
						<div class="col-sm-12 col-md-2 disabled">Nevada</div>
						<div class="col-sm-12 col-md-3" >New York</div>
					</div>
					<div>
						<div class="col-sm-12 col-md-3" id="oh">Ohio</div>
						<div class="col-sm-12 col-md-2" id="ok">Oklahoma</div>
						<div class="col-sm-12 col-md-2 disabled">Oregon</div>
						<div class="col-sm-12 col-md-2" id="pa">Pennsylvania</div>
						<div class="col-sm-12 col-md-3 disabled">Rhode Island</div>
					</div>
					<div>
						<div class="col-sm-12 col-md-3" id="sc">South Carolina</div>
						<div class="col-sm-12 col-md-2" id="sd">South Dakota</div>
						<div class="col-sm-12 col-md-2 disabled">Tennessee</div>
						<div class="col-sm-12 col-md-2 disabled">Texas</div>
						<div class="col-sm-12 col-md-3" >Utah</div>
					</div>
					<div>
						<div class="col-sm-12 col-md-3" id="va">Virginia</div>
						<div class="col-sm-12 col-md-2 disabled">Vermont</div>
						<div class="col-sm-12 col-md-2 disabled">Washington</div>
						<div class="col-sm-12 col-md-2 disabled">Wisconsin</div>
						<div class="col-sm-12 col-md-3" id="wv">West Virginia</div>
					</div>
					<div style="border:1px solid white">
						<div class="col-sm-12 col-md-3" id="wy">Wyoming</div>
					</div>
                </div>
            </div>
			<br />
        </div>        
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
<script>
	$('.state-list div div').click(function(e){
		var state = $(this).attr('id');
		var disabled = $(this).hasClass('disabled');
		if (state == undefined && !disabled)
		{
			window.location = 'https://www5.myvlp.com/v1-3/index__tapseries.php';
		}
		else if(disabled){
			e.preventDefault();
			alert("This course is not available in this state.");
		}
		else
		{
			$.ajax({
				type: 'POST',
				url: '/courses/alcoholtraining/buy',
				data: {state: state},
				success: function(response){
					window.location = '/courses/shop/alcohol/alc';
				}
			});
		}		
	});
</script>
</body>
</html>