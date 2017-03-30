<?php session_start(); ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Instructor Main Menu - <small>Please select from options below.</small></h1>
            </div>
            <div class="row">
                <a href="/account/logout" class="btn btn-primary">Log Out</a>
            </div>
			<br />
            <div class="row">
                <div class="lead">Welcome, <?php echo $_SESSION["displayname"]; ?></div>
                <ul class="list-group">
                    <!--<li class="list-group-item"><a href="/admin/tools/profile/edit">Edit Profile</a></li>-->
                    <li class="list-group-item"><a href="/admin/tools/trackprogress">Track Progress</a></li>
                    <li class="list-group-item"><a href="/admin/tools/courselit">Course Literature</a></li>
                    <!--<li class="list-group-item"><a href="/admin/tools/sfis">Strategies For Increasing Sales Data Center</a></li>-->
                    <li class="list-group-item"><a href="/admin/tools/reports/schoolprogress">School Color Coded Progress Report</a></li>
                    <li class="list-group-item"><a href="/admin/tools/reports/businessprogress">Business Color Coded Progress Report</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
</body>
</html>