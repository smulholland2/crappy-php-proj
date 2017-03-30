<?php session_start(); ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<?php $_SESSION['region'] = 1; ?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Regional Main Menu - <small>Please select from options below.</small></h1>
            </div>
            <div class="row">
                <a href="/account/logout" class="btn btn-primary">Log Out</a>
            </div>
			<br />
            <div class="row">
                <div class="lead">Welcome, <?php echo $_SESSION["displayname"]; ?></div>
                <ul class="list-group">
                    <li class="list-group-item"><a href="/admin/tools/units/add">Add Units / Classes</a></li>
					<li class="list-group-item"><a href="/admin/tools/units/index">View/Edit Units / Classes</a></li>
                    <li class="list-group-item"><a href="/admin/tools/reports/globalscore">Student Lesson Summary</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
</body>
</html>