<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/admin/tools/trackprogress/TrackProgressController.php";
    
    if(!isset($_SESSION))
        session_start();

    if(isset($_POST['to']) && strlen($_POST['to']) > 0)
    {        
        $message = new TrackProgressController();
        echo $message -> MessageStudent();
        exit;
    }

    if(isset($_POST['productid']) && strlen($_POST['productid']) > 0)
    {
        $progress = new TrackProgressController();

        $programinfo = $progress -> ProgramInfo();
        
        $showCompany = false;

        if(isset($_SESSION['enrollment']))
            if($_SESSION['enrollment'] == 1)
                $showCompany = true;

        $students = $progress -> ProgressReport($showCompany);
        $emailReq = $progress -> IsEmailRequired($_POST['productid']);        

        $_SESSION['track']['fromdate'] = $_POST['fromdate'];
        $_SESSION['track']['todate'] = $_POST['todate'];
        $_SESSION['track']['tablecode'] = $_POST['tablecode'];
        $_SESSION['track']['productid'] = $_POST['productid'];

    }
    else if(isset($_SESSION['track']) && count($_SESSION['track']) == 4)
    {
        $_POST['fromdate'] = $_SESSION['track']['fromdate'];
        $_POST['todate'] = $_SESSION['track']['todate'];
        $_POST['tablecode'] = $_SESSION['track']['tablecode'];
        $_POST['productid'] = $_SESSION['track']['productid'];

        $progress = new TrackProgressController();

        $programinfo = $progress -> ProgramInfo();
        $showCompany = false;

        if(isset($_SESSION['enrollment']))
            if($_SESSION['enrollment'] == 1)
                $showCompany = true;

        $students = $progress -> ProgressReport($_POST['tablecode'],$showCompany);
        $emailReq = $progress -> IsEmailRequired($_POST['productid']);

    }
    else
    {        
        header('Location:/admin/tools/trackprogress');
    }        

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<link rel="stylesheet" type="text/css" href="/wwwroot/lib/css/bootstrap-sortable.min.css">
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Quick Track - <small><?php echo $programinfo['CourseTitle'] ?></small></h1>
            </div>
            <div class="row"><a href="/admin/tools/trackprogress" class="btn btn-primary">Go Back</a></div>
            <div class="row well">
                <div><h3>Program Information</h3></div>
                <div>
                    <div class="col-sm-6">
                        <label>Organization:&nbsp;&nbsp;</label><span><?php echo $_SESSION["displayname"]; ?></span><br />
                        <label>Instructor:&nbsp;&nbsp;</label><span><?php echo $programinfo['InstructorName']; ?></span><br />
                        <label>Dates:&nbsp;&nbsp;</label><span><?php echo $programinfo['Dates']; ?></span><br />
                        <label>Program:&nbsp;&nbsp;</label><span><?php echo $programinfo['CourseTitle']; ?></span>
                    </div>
                </div>
            </div>
            <hr>            
            <div clas="row">
                <div class="alert alert-info alert-dismissible fade in" role="alert">
                    <strong>TIP:</strong>&nbsp;You can click on any column title to sort the table. 
                    Click the <span class="glyphicon glyphicon-ok"></span> to select all students.
                    Click the <span class="glyphicon glyphicon-remove"></span> to deselect all students.
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <table id="track-prog-table" class="table table-striped table-condensed sortable">
            <thead>
                <tr>
                    <th data-defaultsort='disabled'>#</th>
                    <th class="select-all"><span class="glyphicon glyphicon-ok"></span></th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Username</th>
                    <th>E-Mail</th>
                    <?php echo $showCompany ? '<th>Company Name</th>' : ''; ?>
                    <th data-dateformat='YYYY-M-D'>Date Added</th>
                    <th data-dateformat='D-M-YYYY' data-defaultsign="month">Completed</th>
                    <th>Progress</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($students)
                    {
                        for ($i = 0; $i < count($students); $i++)
                        {
                            if(strlen($students[$i]['Cert']) > 0)
                                $cert = "<td><a href=" . $students[$i]['Cert'] . " target='new'>Print Certificate</a></td>";
                            else
                                $cert = "<td>Not Available</td>";

                            $rownum = $i + 1;
                            $row = "<tr>";
                            // Put an exclamation point next to names without an email.
                            if($emailReq && ($students[$i]['Email'] == null || $students[$i]['Email'] == ''))
                                $row .= "<td class='rownum'><span style='color:red'>!</span>$rownum</td>";
                            else
                                $row .= "<td class='rownum'>$rownum</td>";
                                $row .= "<td><input type='checkbox' class='email-select' /></td>";
                                $row .= "<td>".$students[$i]['LastName']."</td>"; // Table D
                                $row .= "<td>".$students[$i]['FirstName']."</td>"; // Table D
                                $row .= "<td>".$students[$i]['UserName']."</td>"; // Table D                                    
                                $row .= "<td class='emailaddress'>".$students[$i]['Email']."</td>"; // Table D
                                $row .= $showCompany ? '<td>'.$students[$i]['CompanyName'] .'</td>': '';
                                $row .= "<td>".$students[$i]['DateAdded']."</td>"; // Table D
                                $row .= "<td>".$students[$i]['Completed']."</td>"; // Table D
                                $row .= "<td>".$students[$i]['Progress']."</td>"; // Table S
                                $row .= "<td><a class='view-score' href='#";
                                $row .= $students[$i]['id']."-";
                                $row .= $_POST["tablecode"]."-";
                                $row .= $_POST["productid"];
                                $row .= "'>View Scores</a></td>";
                                $row .= $cert;
                                $row .= "</tr>";
                                echo $row;
                        }
                    }                            
                ?>
            </tbody>
        </table>
        <?php 
            if(!$students)
                echo "No students found within that date range.<br />";
        ?>
        <hr>
        <div class="row">
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-primary send-email">Send Email to Marked Students</button>
                <button type="button" class="btn btn-default save-data" data-toggle="tooltip" data-placement="top" 
                title="This data will be saved to a file that can be viewed in Microsoft Excel.">
                    Save This Data to File
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Send Email  -->
<div class="modal fade send-email-prompt" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
    <div class="modal-dialog" role="document">		  	
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalLabel">Create a new email to send to your student(s).</h4>
            </div>
            <div class="modal-body">
                <form class="send-email-form">
                    <div class="alert alert-danger alert-dismissible fade in send-email-fail hidden" role="alert">                        
                        <strong>ERROR:</strong><ul class="fail-msg"></ul>
                    </div>
                    <div class="form-group">
                        <label for="from"><span class="text-danger">*</span>From:</label>
                        <input class="from form-control" type="text" name="from" value="<?php echo $programinfo['InstructorEmail']; ?>" required/>
                    </div>
                    <div class="form-group">
                        <label for="to"><span class="text-danger">*</span>To:</label>
                        <input class="to form-control" type="text" name="to" required/>
                    </div>
                    <div class="form-group">
                        <label for="bcc">CC:</label>
                        <input class="cc form-control" type="text" name="cc"/>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input class="subject form-control" type="text" name="subject" />
                    </div>
                    <div class="form-group">
                        <label for="message"><span class="text-danger">*</span>Message:</label>
                        <textarea class="message form-control" type="text" name="message" rows="10" required></textarea>
                    </div>
                </form>
                <div class="alert alert-success alert-dismissible fade in send-email-success hidden" role="alert">                        
                    <strong>THANK YOU:</strong>&nbsp;Your emails has been delivered to your students.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success email-yes">Send</button>
                <button class="btn btn-danger email-no" data-dismiss="modal">Cancel</button>
            </div>      							
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
<script src="/wwwroot/lib/js/bootstrap-sortable.min.js"></script>
<script src="/wwwroot/lib/js/moment.min.js"></script>
<script src="/wwwroot/lib/js/FileSaver.min.js"></script>
<script src="/wwwroot/lib/js/xlsx.core.min.js"></script>
<script src="/wwwroot/lib/js/tableExport.min.js"></script>
<script>

(function () {
    var $table = $('table');

    $table.on('sorted', function() { 
        var count = $('tr').length;
        var $rows = $('tr');
        for(var i = 1; i < count; i++)
        {
            $($rows[i]).find('.rownum').html(i);
        }
    });

}());

</script>
</body>
</html>