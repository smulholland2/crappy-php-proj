<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/admin/tools/trackprogress/scorereport/ScoreReportController.php";
    
    if(!isset($_SESSION))
        session_start();

    if(isset($_POST['newemail']))
    {        
        $progress = new ScoreReportController();
        if(isset($_POST['newfirstname']) && isset($_POST['newlastname']))
        {
            if(strlen($_POST['newfirstname']) > 0 || strlen($_POST['newlastname']) > 0 )
                return $progress -> ChangeStudentInfo();    
        }
        else
            return $progress -> ChangeStudentEmail();        
    }

    if(isset($_POST['resend']))
    {        
        $progress = new ScoreReportController();        
        return $progress -> ResendCredentials();        
    }

    if(isset($_GET['studentid']) && strlen($_GET['studentid']) > 0)
    {
        $productid = $_GET['productid'];
        $_SESSION['scorereport'] = array(
            "studentid" => $_GET['studentid'], "tablecode" => $_GET['tablecode'], "productid" => $_GET['productid']
        );
        
        exit;
    }
    
    if(isset($_SESSION['scorereport']))
    {        
        $_POST['studentid'] = $_SESSION['scorereport']['studentid'];
        $_POST['tablecode'] = $_SESSION['scorereport']['tablecode'];
        $productid = $_POST['productid'] = $_SESSION['scorereport']['productid'];
    }

    if(isset($_POST['studentid']) && strlen($_POST['studentid']) > 0)
    {        
        unset($_SESSION['scorereport']);

        $progress = new ScoreReportController();        

        $productid = $_POST['productid'];

        $studentinfo = $progress -> StudentInfo();
        $editableStudent = $progress -> IsStudentEditable();
        $showtime = $progress -> IsTimeTracked();
        $scorereport = $progress -> ScoreReport($showtime);

        if(isset($_SESSION['enrollment']) && $_SESSION['enrollment'] == 1)
            $classmates = $progress -> SelfEnrollClassMates();
        else        
            $classmates = $progress -> ClassMates();
            
        if($showtime)
            $totaltime = $progress -> TotalTime($studentinfo['username']);        

        $firstname = $studentinfo['firstName'];
        $lastname = $studentinfo['lastName'];
        $password = $studentinfo['password'];

        if($editableStudent)
            $editStudentFields = 
            "<label for='newfirstname'>Student's First Name</label><input type='text' name='newfirstname' class='form-control newfirstname' value='".$firstname."'/>
            <label for='newlastname'>Student's Last Name</label><input type='text' name='newlastname' class='form-control newlastname' value='".$lastname."'/>
            <label for='newpassword'>Student's Password</label><input type='text' name='newpassword' class='form-control newpassword' value='".$password."'/>";

        $completed = isset($studentinfo['dateEnded']) ? $studentinfo['dateEnded'] : "In Progress";
    }
    else
        //header('Location:/admin/tools/trackprogress');

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Student Score Report</h1>
            </div>
            <div class="row well">
                <div><h3>Student Information &nbsp;&nbsp;</h3></div>
                <div>
                    <div class="col-sm-6">
                        <label>Student Name:&nbsp;&nbsp;</label><span class="fullname"><?php echo $studentinfo['name']; ?></span><br />
                        <label>Student User Name:&nbsp;&nbsp;</label><span><?php echo $studentinfo['username']; ?></span><br />
                        <label>Student Password:&nbsp;&nbsp;</label><span><?php echo $studentinfo['password']; ?></span>
                    </div>
                    <div class="col-sm-6">
                        <label>Date Added:&nbsp;&nbsp;</label><span><?php echo $studentinfo['dateAdded']; ?></span><br />
                        <label>Date Completed:&nbsp;&nbsp;</label><span><?php echo $completed; ?></span><br />
                        <label>Student Email:&nbsp;&nbsp;</label><a class="emaillabel" href="mailto:<?php echo $studentinfo['email']; ?>"><?php echo $studentinfo['email']; ?></a></span>
                    </div>
                    <input type='hidden' name='productid' class='productid' value='<?php echo $productid; ?>'>
                </div>
                <div class="clearfix"></div>                
            </div>
            <div class="btn-group">
                <button class="btn btn-primary change-email">Change Student's Information</button>
                <button class="btn btn-primary resend-creds">Resend Student's Login Information</button>
            </div>            
            <hr>
            <div clas="row">
                <h4>Supplementary Study Materials</h4>
                <ul>
                    <li><a href="/home/courselit" target="new">Post training reference materials</a></li>
                </ul>
            </div>
            <hr>
            <div class="row">
                <div class="button-group col-sm-4">
                    <button class="btn btn-primary prev-student col-sm-5">Previous Student</button>
                    <div class="col-sm-offset-1"></div>
                    <button class="btn btn-primary next-student col-sm-5">Next Student</button>
                </div>
                <div class="alert alert-info col-sm-5 prev-next-help" role="alert">
                    <strong>NOTICE:</strong> Students are shown in order of last name.
                </div>
                <form class="prev-next-form" action="/admin/tools/trackprogress/scorereport/index.php" method="post">
                    <input name="prev" class="prev" type="hidden" value="<?php echo $classmates['Prev']; ?>"/>
                    <input name="next" class="next" type="hidden" value="<?php echo $classmates['Next']; ?>"/>
                    <input name="studentid" class="classmate" type="hidden" />
                    <input name="tablecode" class="tablecode" type="hidden" value="<?php echo $_POST['tablecode']; ?>"/>
                    <input name="productid" class="productid" type="hidden" value="<?php echo $_POST['productid']; ?>"/>
                </form>
            </div>
            <div clas="row">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Lesson</th>
                            <th>Lesson Title</th>
                            <th>Lesson Status</th>
                            <th>On Date</th>
                            <?php echo $showtime ? "<th>Lesson Time</th>" : ""; ?>
                            <th>Lesson Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //die(print(count($scorereport)));
                            for ($i = 0; $i < count($scorereport); $i++)
                            {
                                $row = "<tr>";
                                $row .= "<td>".$scorereport[$i]['Lesson']."</td>";
                                $row .= "<td>".$scorereport[$i]['LessonTitle']."</td>";
                                $row .= "<td>".$scorereport[$i]['LessonStatus']."</td>";
                                $row .= "<td>".$scorereport[$i]['EndDate']."</td>";
                                $row .= $showtime ? "<td>" . $scorereport[$i]['LessonTime'] . "</td>" : "";
                                $row .= "<td>".$scorereport[$i]['LessonScore']."</td>";
                                $row .= "</tr>";
                                echo $row;
                            }
                        ?>
                    </tbody>
                </table>
                <?php 
                    if($showtime)
                        echo "<p class='pull-right'><strong>Total Time Spent: " . $totaltime . "</strong></p>";
                ?>

                <a href="/admin/tools/trackprogress/scores" class="btn btn-primary">Return to list</a>
            </div>
        </div>
    </div>
</div>
<!-- Student EMail Change Form  -->
<div class="modal fade change-email-prompt" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalLabel">Enter the Student's New Information</h4>
            </div>
            <div class="modal-body">
                <form class="change-email-form">
                    <div class="alert alert-danger alert-dismissible fade in change-email-fail hidden" role="alert">
                        <strong>ERROR:</strong><div class="fail-msg"></div>
                    </div>
                    <div class="form-group">
                        <label for="newemail">New Email:</label>
                        <input class="newemail form-control" type="text" name="newemail" />
                        <?php echo isset($editStudentFields) ? $editStudentFields : ''; ?>
                        <input class="studentid" type="hidden" name="studentid" value="<?php echo $_POST['studentid']; ?>"/>
                        <input class="tablecode" type="hidden" name="tablecode" value="<?php echo $_POST['tablecode']; ?>"/>
                    </div>
                </form>
                <div class="alert alert-success alert-dismissible fade in change-email-success hidden" role="alert">
                    <strong>THANK YOU:</strong> The student's information has been updated.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success email-yes">Change</button>
                <button class="btn btn-danger email-no" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Resend Credentials Modal -->
<div class="modal fade resend-creds-confirm" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalLabel">Email Sent</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade in resend-creds-success" role="alert">
                    <strong>SUCCESS:</strong> Login credentials and course information have been resent to your student.
                </div>
                <div class="alert alert-danger alert-dismissible fade in resend-creds-fail hidden" role="alert">
                    <strong>ERROR:</strong> Sorry, something went wrong. Please try again or call tehical support: 888-826-5222.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
<script>
$(function () {
    $('.prev-student').click(function(e) {
        e.preventDefault();        
        if($('.prev').val() != '')
        {
            $('.classmate').val($('.prev').val());
            $('.prev-next-form').submit();
        }
    });
    $('.next-student').click(function(e) {
        e.preventDefault();
        if($('.next').val() != '')
        {
            $('.classmate').val($('.next').val());
            $('.prev-next-form').submit();
        }
    });
});
</script>
</body>
</html