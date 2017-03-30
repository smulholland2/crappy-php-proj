<?php 

    if(!isset($_SESSION))
        session_start();
    isset($_SESSION["student"]["success"]) ? true : header("Location:/admin/tools/students/single");
    unset($_SESSION["studentErrors"]);

?>
<?php
    if(isset($_SESSION['Serial']))
    {
        include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';
        // Destroy new licesnse key session.
        unset($_SESSION["Serial"]);
    }        
    else
        include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';
?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Add New Student <small>Confirmation</small></h1>
            </div>
			<br />
            <div class="row">
                <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Success!</strong> This student has been added to <strong><?php echo $_SESSION["student"]["coursename"]; ?></strong>.
                </div>                 
            </div>
            <br />
            <div class="row">
                 <ul>
                    <li>The student listed below is now registered. The information below has been sent to the student by e-mail, along with directions on how to start the course. You can also print this page and give it to the student directly.</li>
                    <li>A full refund will be provided if only Lesson 1 has been started, materials are returned undamaged, and/or it has not been longer than 30 days from the date on the Order Form. If lesson 2 has not been started, the course can be assigned to another person for up to one year for a $20 name change fee. We reserve the right to charge a $5 fee for Food Handler name changes.</li>
                 </ul>
            </div>
            <br />
            <div class="row">
                 <table class="table table-responsive">
                    <tr><td>First Name:</td><td><?php echo $_SESSION["student"]["firstname"]; ?></td></tr>
                    <tr><td>Last Name:</td><td><?php echo $_SESSION["student"]["lastname"]; ?></td></tr>
                    <tr><td>Student Email:</td><td><?php echo $_SESSION["student"]["email"]; ?></td></tr>
                    <tr><td>User Name:</td><td><?php echo $_SESSION["student"]["username"]; ?></td></tr>                    
                    <tr><td>Password:</td><td><?php echo $_SESSION["student"]["password"]; ?></td></tr>
                    <tr><td>Training Program:</td><td><?php echo $_SESSION["student"]["coursename"]; ?></td></tr>
                    <tr><td>Language:</td><td><?php echo $_SESSION["student"]["language"]; ?></td></tr>
                    <tr><td>Date of Birth:</td><td><?php echo $_SESSION["student"]["dob"] == 0 ? "N/A" : $_SESSION["student"]["dob"]; ?></td></tr>
                    <tr><td>Manager Email:</td><td><?php echo $_SESSION["student"]["adminemail"]; ?></td></tr>                    
                 </table>
            </div>
			<br />
            <div class="row">
                <div class="btn-group" role="group" aria-label="Please select from the following options:">
                    <a href="/training" class="btn btn-success">Start Online Training</a>
                    <a href="/admin/tools/students" class="btn btn-primary" <?php if($_SESSION["discode"]){echo "style='display:none'";}?>>Add More Students</a>
                    <a href="<?php echo $_SESSION['menu']; ?>" class="btn btn-primary" <?php if($_SESSION["discode"]){echo "style='display:none'";}?>>Main Menu</a>                    
                </div> 
            </div>
        </div>        
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
<?php unset($_SESSION["student"]); ?>
</body>
</html>