<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/admin/tools/trackprogress/TrackProgressController.php";

     if(!isset($_SESSION))
        session_start();

    if(isset($_SESSION['track']))
        unset($_SESSION['track']);

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
    
    if(isset($_POST['productid']) && strlen($_POST['productid']) > 0)
    {
        // If the table code is set, we are looking for the students list.
        // Otherwise, we need to first retrieve the table code.
        if(!isset($_POST['tablecode']) || strlen($_POST['tablecode']) == 0)
        {
            ob_start();
            header('Content-Type: application/json');
            $progress = new TrackProgressController();
            $tablecode = $progress -> TableCode($_POST['productid']);
            ob_end_clean();
            echo json_encode($tablecode);
            exit;
        }
        else if(isset($_POST['tablecode']) && strlen($_POST['tablecode']) > 0)
        {
            ob_start();
            header('Content-Type: application/json');
            $progress = new TrackProgressController();
            $students = $progress -> GetStudents($_POST['tablecode']);
            ob_end_clean();
            echo json_encode($students);
            exit;
        }
    }    
    else
    {
        $progress = new TrackProgressController();
        $courses = $progress -> ListCourses();
    }
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<link rel="stylesheet" href="/wwwroot/lib/css/chosen.min.css">
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Track Progress</h1>
            </div>
            <div class="row"><a href="/account/login" class="btn btn-primary">Main Menu</a></div>
            <div class="row well">
                <strong>How to Use:</strong>
                <ol>
                    <li>To view the progress of students, you can either:
                        <ul>
                            <li>Enter the date you purchased the program, or</li>
                            <li>Enter the date you added your students.</li>
                            <li>Enter this date into the "Search From" boxes below.</li>
                        </ul>
                    <li>Enter the date you wish to stop your search into the "To" boxes.  If you want to list all students to date, enter today's date.</li>
                    <li>Click the training program the students are taking and click Submit.</li>
                </ol>
            </div>
            <br />
            <div class="row">
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>NOTICE:</strong>&nbsp;You can also select the date range automatically by clicking the circles below.
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="alert alert-danger alert-dismissible hidden form-errs" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error:</strong><ul class="err-msg"></ul>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <form method="POST" action="/admin/tools/trackprogress/scores" class="trackform">
                        <input type="hidden" name="studentid" class="studentid" />
                        <input type="hidden" name="tablecode" class="tablecode" />
                        <div class="col-sm-6">
                            <br />
                            <label>Step 1: Choose the report type.</label>
                            <div class="form-group col-sm-12">
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="progresstype" name="progresstype" value="scores" data-toggle="tooltip" title="Check this box to view student training details."/>
                                        Detailed Current Training Report (Quick Track)
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="progresstype" name="progresstype" value="totalenrollment/index.php" data-toggle="tooltip" title="Click this box to only show the total amount of students." />
                                        Only show the total amount of students.
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="progresstype" name="progresstype" value="singlestudent" data-toggle="tooltip" title="Click this box to show progress for one student." />
                                        Look up a single student.
                                    </label>
                                </div>
                            </div>
                            <div class="datepicker">
                                <p><strong>Search Dates</strong></p>
                                <label for="searchFrom">From:</label>
                                <div class="clearfix"></div>
                                <div class="date-picker from track"></div>
                                <input type="hidden" name="fromdate" />
                                <label for="searchTo">To:</label>
                                <div class="clearfix"></div>
                                <div class="date-picker to track"></div>
                                <input type="hidden" name="todate" />
                            </div>
                            <div class='clearfix'></div>
                            <div class="alert alert-info alert-dismissible single-student-info hidden" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>NOTICE:</strong>&nbsp;Please select a course from the list and then press Submit to view your student list.
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <br />
                            <div class="form-group col-sm-12">
                                <label for="productid">Step 2: Highlight the training program below and click Submit.</label>
                                <select name="productid" size="11" class="form-control courselist" required>
                                    <?php
                                        // Fill the select box.
                                        foreach ($courses as $course)
                                        {
                                            /*if($course['id']==179){
                                                $course['id'] = 2;
                                            }*/
                                            $option = "<option value='" . $course['id'] . "'>" . $course['ProductName'] ."</option>";
                                            echo $option;
                                        }
                                    ?>
                                    <!--<option value="2">Ohio Level 2 Foodservice Food Safety Manager Certification Training</option>
                                    <option value="169">Ohio Level 2 Retail Food Safety Manager Certification Training</option>-->
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="form-group col-sm-12">
                            <input type="submit" class="btn btn-primary submit" value="Submit"/>
                        </div>
                    </form>
                </div>
                <div class="modal fade student-list" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="modalLabel">Please select a student:</h4>
                            </div>
                            <div class="modal-body">                            
                                <div class="alert alert-info alert-dismissible single-student-info hidden" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>NOTICE:</strong>&nbsp;Click the box below to see a list of all students. You can search for a student by typing their name in the search box that will appear.
                                </div>
                                <div class="searchable"></div>
                            <div class='clearfix'></div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success student-ok">Ok</button>
                                <button class="btn btn-danger student-no" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
</body>
</html>