<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/admin/tools/trackprogress/totalenrollment/TotalEnrollmentController.php";
    
    if(isset($_POST['productid']) && strlen($_POST['productid']) > 0)
    {
        $progress = new TotalEnrollmentController();

        $programinfo = $progress -> ProgramInfo();
        $students = $progress -> TotalEnrollment($_POST['tablecode']);
    }
    else if(isset($_POST['to']) && strlen($_POST['to']) > 0)
    {
        $message = new TotalEnrollmentController();
        echo $message -> MessageStudent();
    }
    else if(isset($_POST['type']) && strlen($_POST['type']) > 0)
    {
        $report = new TotalEnrollmentController();
        echo $report -> CreateExcel();
    }
    else
        die('err');
        //header('Location:/admin/tools/trackprogress');

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<link rel="stylesheet" type="text/css" href="/wwwroot/lib/css/bootstrap-sortable.min.css">
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Total Enrollment - <small><?php echo $programinfo['CourseTitle'] ?></small></h1>
            </div>
            <div class="row"><a href="/admin/tools/trackprogress" class="btn btn-primary">Go Back</a></div>
            <div class="row well">
                <div><h3>Program Information</h3></div>
                <div>
                    <div class="col-sm-6">
                        <label>Organization:&nbsp;&nbsp;</label><span class="organization"><?php echo $programinfo['Organization']; ?></span><br />
                        <label>Instructor:&nbsp;&nbsp;</label><span class="instructor"><?php echo $programinfo['InstructorName']; ?></span><br />
                        <label>Dates:&nbsp;&nbsp;</label><span class="dates"><?php echo $programinfo['Dates']; ?></span><br />
                        <label>Program:&nbsp;&nbsp;</label><span class="program"><?php echo $programinfo['CourseTitle']; ?></span>
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
                <table id="report" class="table table-striped table-condensed sortable">
                    <thead>
                        <tr>
                            <th data-defaultsort='disabled'>#</th>
                            <th class="select-all"><span class="glyphicon glyphicon-ok"></span></th>
                            <th class="ln">Last Name</th>
                            <th class="fn">First Name</th>
                            <th class="un">User Name</th>
                            <th class="em">E-Mail</th>
                            <th class="da">Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            for ($i = 0; $i < count($students); $i++)
                            {
                                $rownum = $i + 1;
                                $row = "<tr>";
                                $row .= "<td>$rownum</td>";
                                $row .= "<td><input type='checkbox' class='email-select' /></td>";
                                $row .= "<td>".$students[$i]['LastName']."</td>"; // Table D
                                $row .= "<td>".$students[$i]['FirstName']."</td>"; // Table D
                                $row .= "<td>".$students[$i]['UserName']."</td>"; // Table D  
                                $row .= "<td class='emailaddress'>".$students[$i]['Email']."</td>"; // Table D
                                $row .= "<td>".$students[$i]['DateAdded']."</td>"; // Table D
                                $row .= "</tr>";
                                echo $row;
                            }
                        ?>
                    </tbody>
                </table>
                <?php 

                    if(count($students) < 1)
                        echo "No students found within that date range.<br />";

                ?>
                <hr>
                <div class="row">
                    <form action="/admin/tools/trackprogress/totalenrollment/download" method="POST" class="excel-form">
                        <div class="btn-group" role="group" aria-label="...">
                            <button type="button" class="btn btn-primary send-email">Send Email to Marked Students</button>
                            <input type="submit" class="btn btn-default save-file" data-toggle="tooltip" data-placement="top" 
                            title="This data will be saved to a file that can be viewed in Microsoft Excel." value="Save This Data to File" />                            
                        </div>
                    </form>
                </div>				
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
<script src="/wwwroot/lib/js/tabletojson.min.js"></script>
<script>
    $('.save-file').click(function(e)
    {
        e.preventDefault();
                
        // The type of Excel file we are going to download.
        //  0 for Total Enrollment and 1 for Quick Track.
        var type = 0;
        var organization = $('.organization').html();
        var instructor = $('.instructor').html();
        var dates = $('.dates').html();        
        var program = $('.program').html();

        var headers = getHeaders();
        var table = $('#report').tableToJSON();

        $form = $('.excel-form');
        var $type = $('<input type="hidden" name="type" class="type" />').val(0);
        var $organization = $('<input type="hidden" name="organization" class="organization" />').val(0);
        var $instructor = $('<input type="hidden" name="instructor" class="instructor" />').val(0);
        var $dates = $('<input type="hidden" name="dates" class="dates" />').val(0);
        var $program = $('<input type="hidden" name="program" class="program" />').val(0);
        var $headers = $('<input type="hidden" name="headers" class="headers" />').val(0);
        var $table = $('<input type="hidden" name="table" class="table" />').val(0);
        $form.append($type);
        $form.append($organization);
        $form.append($instructor);
        $form.append($dates);
        $form.append($program);
        $form.append($headers);
        $form.append($table);
        $form.submit();

    });

    function getHeaders()
    {
        var headers = {
            lastname: $('.ln').html(), 
            firstname: $('.fn').html(),
            username: $('.un').html(),
            email: $('.em').html(),
            dateadded: $('.da').html(),
        };

        return headers;
    }
</script>
</body>
</html>