<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/tools/students/StudentsController.php';
    $student = new StudentsController();
    $courses = $student -> FullCourseList();

    if(!isset($_SESSION))
        session_start();

    if(count($_POST) > 0)
        $student -> Delete();
        
    if(isset($_SESSION['delete']['success']))
    {
        $message = $_SESSION["delete"]["success"];
        $studentun = $_SESSION['delete']['studentun'];
        unset($_SESSION["delete"]);
    }
    else if(isset($_SESSION['delete']['failure']))
    {
        $failed = $_SESSION["delete"]["failure"];
        unset($_SESSION["delete"]);
    }
?>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Delete Students</h1>
            </div>
			<br />
            <div class="row"><a href="/account/login" class="btn btn-primary">Main Menu</a></div>
            <div <?php echo isset($message) ? 'class="row"' : 'class="row hidden"'; ?>>
                <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>SUCCESS!</strong> <?php echo isset($message) ? $message : ''; ?> <br />
                <strong><?php echo isset($studentun) ? $studentun : ''; ?></strong>.
                </div>
            </div>
            <div <?php echo isset($failed) ? 'class="row"' : 'class="row hidden"'; ?>>
                <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>ERROR!</strong> <?php echo isset($failed) ? $failed : ''; ?> <br />
                </div>
            </div>
            <div class="row">
               <form action="/admin/tools/students/delete" class="well" method="POST">
                    <input type="hidden" value="<?php echo $_SESSION['user']; ?>" name="UA">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="uname">Username:</label>
                            <input type ="text" class="uname col-sm-4 form-control" name="uname" />
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <label for="productid">Select Course:</label>
                            <select name="productid" size="11" class="form-control course-list" required>
                                <?php
                                    // Fill the select box.
                                    foreach ($courses as $course) {
                                        $option = "<option value='" . $course['id'] . "'>" . $course['ProductName'] ."</option>";
                                        echo $option;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="alert alert-info alert-dismissible" role="alert">
                            <p><strong>HOW TO DELETE A STUDENT:</strong></p>
                                <p>To delete a student, enter the studens username, select the course that student is registered to, and press the Delete button. A confirmation box will appear and you will be able to finalize your decision.</p>
                                <br>
                                <p><strong>WARRANTY INFORMATION: </strong> In order to recieve your license back the deleted student must fit the following criteria:</p>
                                <ul>
                                    <li>Must have been added within the last 30 days.</li>
                                    <li>Must not have started their second lesson in the course.</li>
                                </ul>
                                <br>
                                <p>If you have any further questions, please call technical support: 888-826-5222.</p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="form-group">                        
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Delete</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Delete Student Confirmation</h4>
                                </div>
                                <div class="modal-body">
                                <p>Are you sure you want to delete the student?</p>
                                </div>
                                <div class="modal-footer">
                                <input type="submit" class="btn btn-danger" value="Delete Student"/>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal ends -->
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
</body>
</html>