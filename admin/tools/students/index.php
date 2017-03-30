<?php
    //clear the session variables
    if(!isset($_SESSION))
        session_start();
    unset($_SESSION["student"]);
    unset($_SESSION["studentErrors"]);
    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/tools/students/StudentsController.php';

    if(isset($_SESSION["exceeded"]))
    {
        $err = "Your Excel file exceedes the maximum amount of licenses for your account. ";
        $err .= "Please reduce the number of students in your excel file or "; 
        $err .= "<a href='' target='new'>Purchase more licenses.</a>.";
    }

    if(isset($_POST['unitid']))
    {
        if(isset($_SESSION['unit']))
        {
            if($_SESSION['unit'] != $_POST['unitid'])
            {
                unset($_SESSION['unit']);
                $_SESSION['unit'] = $_POST['unitid'];
            }
        }

        $_SESSION['unit'] = $_POST['unitid'];
    }

    $student = new StudentsController();
    // TEMPORARY WORK AROUND FOR SPECIAL CORPORTATE ACCOUNTS
    // Store all the corp discode accounts in an array.
    const CORPACCOUNTS = ["tj", "tjh", "tcoam", "tcoah"];
    // Search the session for the array value.
    if(isset($_SESSION['discode']))
    {
        $discode = trim($_SESSION['discode']);

        $key = array_search($discode, CORPACCOUNTS);
        if($key !== false)
            $courses = $student -> CorpCourseList($discode);
        else
            $courses = $student -> CourseList();    
    }
    else
    {
        $courses = $student -> CourseList();
    }   

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Add New Student(s)</h1>
            </div>
            <div class="row"><a href="/account/login" class="btn btn-primary">Main Menu</a></div>
            <div <?php echo isset($err) ? "class='row'" : "class='row hidden'"; ?>>
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <strong>ERROR:</strong><?php echo isset($err) ? $err : "" ?>
                </div>
            </div>
            <div class="row">
                <form method="POST" class="col-md-5 course-opts" enctype="multipart/form-data">
                    <div class="form-group">
                        <?php
                            if(count($courses) == 0)
                                echo '<p>You do not have any available licenses or vouchers. <a href="/courses/shop/products">Click here</a> to purchase more courses.</p>';
                            if(isset($courses[0]["id"]))
                            {
                                echo '<label for="productid">Please select the training program that you purchased:</label>';
                                echo '<select name="productid" size="11" class="form-control course-list" required>';
                                // Fill the select box.
                                foreach ($courses as $course) {
                                    $option = "<option value='" . $course['id'] . "'>" . $course['ProductName'] ."</option>";
                                    echo $option;
                                }
                                echo '</select>';
                            }
                            else
                            {
                                echo '<label for="productid">Please select the training program that you purchased:</label>';
                                echo '<select name="productid" size="11" class="form-control course-list" required>';
                                // Fill the select box.
                                echo "<option value='" . $courses['id'] . "'>" . $courses['ProductName'] ."</option>";
                                echo '</select>';
                            }                            
                        ?>
                    </div>
                    <?php echo count($courses) > 0 ? '<p>If the course you are looking for is not listed, <a href="/courses/shop/products">click here</a> to purchase more courses.</p>' : ''; ?>
                    <div class="row">
                        <div class="alert alert-info alert-dismissible fade in" role="alert">
                            <strong>NOTICE:</strong><div class="remain-msg"> Once you've selected a course, your remaining licenses will show here.</div>
                        </div>
                    </div>
                    <?php
                        if(isset($courses[0]["id"]))
                        {
                            // Add the messages for remaining licenses
                            foreach ($courses as $course) {
                                $msg = "<span id='msg-" . $course['id'] . "' class='msg hidden'>" . $course['LicensesRemaining'] . "</span>";
                                echo $msg;
                            }
                        }
                        else
                        {
                            echo "<span id='msg-" . $courses['id'] . "' class='msg hidden'>" . $courses['LicensesRemaining'] . "</span>";
                        }
                    ?>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label for="numstudents">Number of students to add:</label>
                        <input name="numstudents" type="number" value="0" disabled class="numstudents form-control"/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group uploader">
                        <label for="fileToUpload">Select Excel file to upload (optional): <a href="excelinst.php" target="_blank">Click here for templates</a></label>
                        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" disabled>
                    </div>
                    <div class="clearfix"></div>
                </form>
                <div class="col-md-6 col-md-offset-1">
                    <div class="row">
                        <div class="alert alert-info alert-dismissible fade in" role="alert">
                            <strong>Instructions:</strong>
                            <div class="clearfix"></div>
                            <ul>
                                <li>Select which course you will add new students.</li>
                                <li>Choose the number of students you want to add. (Default is 1)</li>
                                <li>If adding more than one student, you can choose to upload an Excel file.  <a href="excelinst.php" target="_blank">Click here for instructions</a></li>
                                <li>Press continue below to begin adding the new students.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row well">
                        <h3>Terms of Enrollment</h3>
                        <p>Credit(s) to your account if returned within 30 days of enrollment, and if no more than lesson 1 has been studied. Students are single use enrollments. Each lesson allows up to 5 reviews. After 5 reviews the lesson is closed. Courses are active for 180 days from date of enrollment and will stop functioning 180 days after the enrollment. Within the 180 day active period, the name of the student can be changed for a $20 fee for all courses except Food Handler, if a TAP Certificate of Achievement has NOT been awarded. Changing of the name will not re-activate any inactive, closed or ended functions. We reserve the right to charge a $5 fee for Food Handler name changes. To submit a name change form, <a href="/certificate/namechange" target="new">click here.</a></p>
                        <a href="/home/privacyh" target="new">Click here for privacy policy</a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
			<hr>
            <div class="form-group">
                <div class="btn-group" role="group" aria-label="...">
                    <input type="button" class="btn btn-success submit" value="Continue" />
                    <a href="/admin/company" class="btn btn-primary">Return To Menu</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
<?php unset($_SESSION["exceeded"]);unset($_SESSION["mismatch"]); ?>
</body>
</html>