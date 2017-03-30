<?php
    //clear the session variables
    session_start();
    unset($_SESSION["student"]);
    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/tools/students/StudentsController.php';

    $student = new StudentsController();
    $courses = $student -> GetCourseList();
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Add New Student</h1>
            </div>
			<br />
            <div class="row">
                 <form action="/admin/tools/students/single" method="POST">
                    <div class="form-group col-md-5">
                        <label for="productid">Please select a Training Program for the training you purchased:</label>
                        <select name="productid" size="11" class="form-control course-list">
                            <?php
                                // Fill the select box.
                                foreach ($courses as $course) {
                                    $option = "<option value='" . $course['id'] . "'>" . $course['ProductName'] ."</option>";
                                    echo $option;
                                }

                            ?>                            
                        </select>
                        <br />
                        <div class="row">
                            <div class="alert alert-info alert-dismissible fade in" role="alert">                                
                                <strong>NOTICE:</strong><div class="remain-msg"> Once you've selected a course, your remaining licenses will show here.</div>
                            </div>
                        </div>
                        <?php
                                // Add the messages for remaining licenses
                                foreach ($courses as $course) {                                    
                                    $msg = "<span id='msg-" . $course['id'] . "' class='msg hidden'>" . $course['LicensesRemaining'] . "</span>";
                                    echo $msg;
                                }
                            ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">                        
                        <input type="submit" class="btn btn-primary" value="Continue" />
                    </div>
                </form>
            </div>
			<br />
        </div>        
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
</body>
</html>