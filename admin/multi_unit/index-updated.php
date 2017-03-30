<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/tools/profile/ProfileController.php";

    if(!isset($_SESSION))
        session_start();

    $controller = new ProfileController();

    if(isset($_POST['forcecor']))
        $profile = $controller -> RequirementChange();

    $profile = $controller -> CorrectAnswersRequired();

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Multi-Unit Dashboard - <small>Please select from options below.</small></h1>
            </div>
			<br />
            <div class="row">
                <div class="lead">Welcome, <?php echo $_SESSION["user"]; ?></div>
                <ul class="list-group">
                    <li class="list-group-item"><a href="/admin/tools/profile/edit">Edit Corporate Administrator</a></li>
                    <li class="list-group-item"><a href="/admin/tools/units">Single Region Administration</a></li>
                    <li class="list-group-item"><a href="/admin/tools/regions">Multiple Region Administration</a></li>
                    <li class="list-group-item"><a href="/admin/tools/">Place Orders</a></li>
                </ul>
            </div>
			<br />
            <div class="row">
                <div class="lead"><u>Reports</u></div>            
                <ul class="list-group">
                    <li class="list-group-item"><a href="/admin/tools/reports/globalscore">Global Score Report</a></li>
                    <li class="list-group-item"><a href="/admin/tools/reports/globalprogress">Global Progress Report</a></li>
                    <li class="list-group-item"><a href="/admin/tools/reports/schoolprorgess">School Color Coded Progress Report</a></li>
                    <li class="list-group-item"><a href="/admin/tools/reports/businessprogress">Business Color Coded Progress Report</a></li>
                    <li class="list-group-item"><a href="/admin/tools/reports/coursepass">Course Pass Report</a></li>
                </ul>
            </div>
			<br />
            <div class="row">
                <div class="lead"><u>Student Management</u></div>
                <ul class="list-group">
                    <li class="list-group-item"><a href="/admin/tools/students/search">Individual Student Search by Last Name</a></li>
                    <li class="list-group-item"><a href="/admin/tools/students/transfer">Transfer Students</a></li>
                </ul>
            </div>
			<br />
            <div class="row">
                <form action="/admin/multi_unit/index" method="POST" class="force-form">
                    <input type="hidden" name="forcecor" value="<?php echo $profile['Change']; ?>" />
                    <div class="lead">Correct Answers are <strong><i><?php echo $profile['EnabledText']; ?></i></strong>.</div>
                    <div><button class="btn btn-primary force-submit">Click to <?php echo $profile['EnabledButton']; ?></a></div>
                </form>
            </div>
			<br />            
            <div class="row">
                <a href="/account/logout/" class="btn btn-primary">Log Out</a>
            </div>
        </div>        
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
<script>
    $('.force-submit').click(function(){
        $('.force-form').submit();
    })
</script>
</body>
</html>