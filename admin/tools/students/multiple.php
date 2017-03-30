<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/tools/students/StudentsController.php';

    $students = new StudentsController();
    $formType = null;

    if(!isset($_FILES["fileToUpload"]) || $_FILES["fileToUpload"]["size"] <= 0)
    {
        $students -> GetCourseData();
        $studentstoadd = (int)trim($_POST["numstudents"]);
        $formType = 'html';
    }
    else
    {
        // This is where we check the number of students requested against the number of students
        // in the excel file, as well as the number of licenses remaining.
        if(!isset($_SESSION))
            session_start();
        
        $students -> GetCourseData();

        $tabletype = null;
        // Set a variable so we know if this is an excel upload or not.
        $formType = 'excel';

        // The number of students the user entered into the number input on the index page.
        $studentsrequested = (int)trim($_POST["numstudents"]);

        // The course list and liceses are stored in session when the class is loaded. Search through
        // the array to find the index of the product id. This index will be used to give us the 
        // value of the remaining licenses in the session array.
        $key = array_search(trim($_POST["productid"]), array_column($_SESSION['courselist'], 'id'));        
        
        // Load the excel file into an array.
        $studentstoadd = $students -> LoadExcel();        

        $tabletype = gettype($studentstoadd) == 'integer' ? 'normal' : 'excel';
        // We will display a warning when the user input number does not match the total number of
        // records in the Excel file.
        if(count($studentstoadd) > $studentsrequested)
            $_SESSION["mismatch"] = true;
        
        // If the Excel file has more records than the user has licenses available, we will redirect
        // back to the index page and display an error there.
        else if(count($studentstoadd) > $_SESSION['courselist'][$key]['LicensesRemaining'])
        {
            if($_SESSION['courselist'][$key]['LicensesRemaining'] === -1 || $_SESSION['courselist'][$key]['LicensesRemaining'] === -3)
                $_SESSION["exceeded"];
            else
            {
                $_SESSION["exceeded"] = true;
                header("Location:/admin/tools/students/index");
            }
        }
    }

    // Set up the optional fields
    $isStoreNum = $students -> CheckStoreNum();        
    if(isset($_SESSION["student"]['productid']))
    {
        $isSpanish = $students -> SpanishAvailable($_SESSION["student"]['productid']);            
        $isDobRequired = $students -> CheckDobRequired($_SESSION["student"]['productid']);
        $isAlaska = $_SESSION["student"]['productid'] == 185 ? true : false;
    }
    else
    {
        $isSpanish = $students -> SpanishAvailable();            
        $isDobRequired = $students -> CheckDobRequired();
        $isAlaska = $_POST['productid'] == 185 ? true : false;
    }

    // This function is called on the page to create the table.
    function makerows($studentstoadd, $isDobRequired = false, $isSpanish = false, $isAlaska = false)
    {
        if(gettype($studentstoadd) == "integer")
        {
            for($i = 1; $i <= $studentstoadd; $i++) {
                $row = "<tr class='undelivered'>";
                $row .= "<td class='first'>#" . $i . "</td>";
                $row .= "<td class='firstname'><p><input name='fn".$i."' type='text' class='fn' maxlength='69'/></p></td>";
                $row .= "<td class='lastname'><p><input name='ln".$i."' type='text' class='ln' maxlength='69'/></p>
                <p class='confirm-email'><label>Confirm Email: </label></p></td>";
                $row .= "<td class='email'><p><input name='ue".$i."' type='text' class='ue' maxlength='69'/></p>
                <p><input name='uec".$i."' type='text' class='ue-confirm' maxlength='69'></p></td>";
                $row .= "<td class='adminemail'><p><input name='ae".$i."' type='text' class='ae' maxlength='69' /></p></td>";
                $row .= "<td class='username'><p><input name='un".$i."' type='text' class='un' maxlength='25'/></p>
                <p class='confirm-pass'><label>Confirm Password: </label></p></td>";
                $row .= "<td class='password'><p><input name='pw".$i."' type='text' class='pw' maxlength=24/></p>
                <p><input name='pwc".$i."' type='text' class='pw-confirm'></p></td>";
                if($isDobRequired)
                    $row .= "<td><p id='dob".$i."' class='dob-holder btn-sm'><a href='#'>Edit</a></p><input name='dob".$i."' type='hidden' class='dob'/></td>";
                //$row .= "<td class='dob'><p></p></td>";
                $row .= "<td class='lang'><p>";
                if($isSpanish && !$isAlaska)
                    $row .= "<select name='la".$i."' class='la'><option>English</option><option>Spanish</option></select>";
                else if($isAlaska)
                    $row .= "<select name='la".$i."' class='la'>
                                <option>English</option>
                                <option>Spanish</option><option>Mandarin</option>
                                <option>Korean</option>
                                <option>Vietnamese</option>
                                <option>Tagalog</option>
                                </select>";
                else
                    $row .= "<select name='la".$i."' class='la'><option>English</option></select>";
                $row .= "</p></td>";
                $row .= "</tr>";
                echo $row;
            }
        }
        else
        {
            foreach($studentstoadd as $student) {
                $row = "<tr class='undelivered'>";
                $row .= "<td class='first'><input class='selected' type='checkbox' checked/></td>";
                $row .= "<td class='firstname'><p class='editable'>".$student["firstname"]."</p></td>";
                $row .= "<td class='lastname'><p class='editable'>".$student["lastname"]."</p></td>";
                $row .= "<td class='email'><p class='editable'>".$student["email"]."</p></td>";
                $row .= "<td class='adminemail'><p class='editable'>".$student["adminemail"]."</p></td>";
                $row .= "<td class='username'><p class='editable'>".$student["username"]."</p></td>";
                $row .= "<td class='password'><p class='editable'>".$student["password"]."</p></td>";
                if($isDobRequired)
                    $row .= "<td class='dob'><p class='editable'>".$student["dob"]."</p></td>";
                    //$row .= "<td class='dob'><p class='editable'><input type='date' name='dob".$i."' value='".$student["dob"]."'/></p></td>";
                $row .= "<td class='lang'><p class='editable'>".$student["lang"]."</p></td>";
                $row .= "</tr>";
                echo $row;
            }
        }
    }
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php'; ?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Add New Students</h1>
                <h3 class="course-name"><?php echo $students -> coursename; ?></h3>
            </div>
            <div class="row"><a href="/admin/tools/students" class="btn btn-primary">Go Back</a></div>
            <div class="row">
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <small><strong>Warning:</strong> This page will time out after 20 minutes. Only add as many students as can be entered within 20 minutes.</small>
                </div>
            </div>
            <div class="row">
                <div class="alert alert-info alert-dismissible fade in" role="alert">
                    <strong>Instructions:</strong>
                    <div class="clearfix"></div>
                    <?php 
                        if($formType == 'excel')
                        {
                            echo '<ul>
                                    <li>Review the students you have selected to add to the course.</li>
                                    <li>Uncheck any students you do not wish to add.</li>
                                    <li>Edit the student information by clicking on the text.</li>
                                    <li>Press "Enter" to save the change.</li>
                                    <li>Press "Tab" to quickly save and go to the next field.</li>
                                    <li>Press "Shift + Tab" to quickly save and go back to the previous field.</li>
                                    <li>Press "Enter" to save the change.</li>
                                    <li>Student rows that have been added successfully will turn green.</li>
                                    <li>Student rows that have information that need to be corrected will turn red.</li>
                                    <li>When all of the student rows are green, click the Main Menu button to continue.</li>
                                </ul>';
                        }
                        else if($formType == 'html')
                        {
                            echo '<ul>
                                    <li>Fill in the information for each student below.  There is one row provided for each student.  When all of the information has been added, click Submit.</li>
                                    <li>Student information that have been added successfully will be highlighted in green.</li>
                                    <li>Student information that needs to be corrected will be highlighted in red.</li>
                                    <li>When all of the student rows are green, click the Main Menu button to continue.</li>
                                </ul>';
                        }
                    ?>
                </div>
            </div>
            <div class="row well students-added hidden">
                <p class="num-students-added hidden">
                    You have successfully added <strong class="numberadded"></strong> students to the <strong><?php echo $students -> coursename; ?></strong> course.
                </p>
                <div class="errors hidden">
                    <strong>There were errors with these submisson:</strong>
                    <div class="clearfix"></div>
                    <ul class="errlist"></ul>
                    <p>Please fix the errors and press "Submit" again.</p>
                </div>                
            </div>
            <div class="row maintable">
                <input type="hidden" name="productid" value="<?php echo $students -> productid; ?>"/>
                <input type="hidden" name="tablecode" value="<?php echo trim($students -> tablecode); ?>"/>
                <input type="hidden" name="courselink" value="<?php echo $students -> courselink; ?>"/>
                <input type="hidden" name="scourselink" value="<?php echo $students -> scourselink; ?>"/>
                <input type="hidden" name="coursename" value="<?php echo $students -> coursename; ?>"/>
                <input type="hidden" name="formtype" value="<?php echo $formType; ?>"/>
                <table class="table table-condensed table-striped student-table" id="<?php print($tabletype); ?>">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="fnhead">First Name</th>
                            <th class="lnhead">Last Name</th>
                            <th class="uehead">Student Email</th>
                            <th class="aehead">Manager Email</th>
                            <th class="unhead">Username</th>
                            <th class="pwhead">Password</th>
                            <?php echo $isDobRequired ? '<th class="dbhead">Date of Birth</th>': ''; ?>
                            <th class="lnhead">Language</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php makerows($studentstoadd, $isDobRequired, $isSpanish, $isAlaska); ?>
                    </tbody>
                </table>
            </div>
			<br />
            <div class="btn-group" role="group" aria-label="...">
                <button class="btn btn-primary submit">Submit</button>
                <a href="<?php echo $_SESSION['menu']; ?>" class="btn btn-primary main-menu hidden">Main Menu</a>
                <a href="/admin/tools/students" class="btn btn-success add-more hidden">Add More Students</a>
                <button class="btn btn-default print-list hidden">Print This List</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="dobmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Enter Date of Birth</h4>
      </div>
      <div class="modal-body">
        <div class="date-picker dob-picker"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
<script src="/wwwroot/lib/js/print-this.min.js"></script>
<script>

    var shift = false;
    $(document).keydown(function(e){
        
        var $focused = $(':focus');
        var key = e.which;
        if(key == 9 && !shift) { // tab only
            if(($focused).parent('td').attr('class') == 'first'){
                e.preventDefault();
                $focused.parent('td').next('td').children('p').click();
            }
        }
        if(key == 9 && shift ){ //shit + tab
            if(($focused).parent('td').attr('class') == 'first'){
                e.preventDefault();
                $focused.parent('td').parent('tr').prev('tr').find('.lang').children('p').click();
            }
        }
    });
    $('.editable').click(function() {
        $(this).removeClass('editable');
        var currenttext = $(this).html();
        $(this).html("");
        if($(this).parent().hasClass('lang'))
            var $tempinput = languageSelect();
        else
            // TODO: Need to add maxlength=24 for password field.
            var $tempinput = $('<input class="tempinput" type="text" />');
        $(this).append($tempinput);
        $('.tempinput').focus();
        saveInput(currenttext);
        $('.tempinput').keydown(function (e) {
            var key = e.which;
            if(key == 13)  // the enter key code
                $('.tempinput').blur();
            if(key == 9 && !shift) { // tab only
                e.preventDefault();
                var $editable = $('.tempinput').parent();
                $('.tempinput').blur();
                $editable.parent('td').next('td').children('p').click();
            }
            if(key == 9 && shift ){ //shit + tab
                e.preventDefault();
                var $editable = $('.tempinput').parent();
                $('.tempinput').blur();
                $editable.parent('td').prev('td').children('p').click();
            }
            if(key == 16){
                shift = true;
            }
        });
        $('.tempinput').keyup(function(e){
            var key = e.which;
            if(key == 16){
                shift = false;
            }
        });
    });

    function languageSelect()
    {
        var $langs = $('<select class="tempinput"></select>');
        $langs.append('<option value="en">English</option>');
        $langs.append('<option value="es">Spansh</option>');
        return $langs;
    }

    function saveInput(text)
    {
        $('.tempinput').blur(function(e) {
            // Check for select or input
            var target = $( e.target );
            if ( target.is( "select" ) )
                var newtext = $(this).find('option:selected').text();
            else
                var newtext = $(this).val();
            if(newtext == text || newtext === '') {
                $(this).parent('p').addClass('editable');
                $(this).parent().html(text);
            } else {
                $(this).parent('p').addClass('editable');
                $(this).parent().html(newtext);
            }
        });
    }

    $('.submit').click(function(){
        var $rows = $('.student-table tbody tr');
        var numrows = $('.student-table tbody tr').length;
        var numerrs = 0;
        $('.errors').addClass('hidden');
        $('.errlist').html("");
        $rows.each(function(){
            // Only send rows that are marked as undelivered.
            if($(this).hasClass('undelivered'))
            {
                var studentinfo = [];
                if($('table').attr('id') == "excel")
                {
                    studentinfo["firstname"] = $(this).find('.firstname p').html();
                    studentinfo["lastname"] = $(this).find('.lastname p').html();
                    studentinfo["email"] = $(this).find('.email p').html();
                    studentinfo["adminemail"] = $(this).find('.adminemail p').html();
                    studentinfo["username"] = $(this).find('.username p').html();
                    studentinfo["password"] = $(this).find('.password p').html();                    
                    studentinfo["lang"] = $(this).find('.lang p').html();
                    studentinfo["dob"] = $(this).find('.dob p').html();
                    studentinfo["productid"] = $( "input[name='productid']" ).val();
                    studentinfo["tablecode"] = $( "input[name='tablecode']" ).val();
                    studentinfo["coursename"] = $( "input[name='coursename']" ).val();
                    studentinfo["courselink"] = $( "input[name='courselink']" ).val();
                    studentinfo["scourselink"] = $( "input[name='scourselink']" ).val();
                    studentinfo["formtype"] = $( "input[name='formtype']" ).val();
                }
                else
                {
                    studentinfo["firstname"] = $(this).find('.firstname input ').val();
                    studentinfo["lastname"] = $(this).find('.lastname input').val();
                    studentinfo["email"] = $(this).find('.email input').val();
                    studentinfo["emailconfirm"] = $(this).find('.ue-confirm').val();
                    studentinfo["adminemail"] = $(this).find('.adminemail input').val();
                    studentinfo["username"] = $(this).find('.username input').val();
                    studentinfo["password"] = $(this).find('.pw-confirm').val();
                    studentinfo["passwordconfirm"] = $(this).find('.password input').val();
                    studentinfo["lang"] = $(this).find('.lang select option:selected').val();
                    studentinfo["dob"] = $(this).find('.dob').val();
                    studentinfo["productid"] = $( "input[name='productid']" ).val();
                    studentinfo["tablecode"] = $( "input[name='tablecode']" ).val();
                    studentinfo["coursename"] = $( "input[name='coursename']" ).val();
                    studentinfo["courselink"] = $( "input[name='courselink']" ).val();
                    studentinfo["scourselink"] = $( "input[name='scourselink']" ).val();
                    studentinfo["formtype"] = $( "input[name='formtype']" ).val();
                }
                // Only insert rows that aren't blank.
                if(studentinfo["firstname"].length == 0 && studentinfo["lastname"].length == 0 && studentinfo["username"].length == 0)
                {
                    $(this).addClass('hidden');
                    $(this).removeClass('undelivered');
                }
                else
                    doInsert($(this), studentinfo);
            }
        });

        function doInsert($row, studentinfo)
        {
            $.ajax({
                url:'/admin/tools/students/queue',
                type: "POST",
                dataType: 'json',
                data: { 
                    firstname: studentinfo["firstname"],
                    lastname: studentinfo["lastname"],
                    email: studentinfo["email"],
                    email2: studentinfo["emailconfirm"],
                    adminemail: studentinfo["adminemail"],
                    username: studentinfo["username"],
                    password: studentinfo["password"],
                    password2: studentinfo["passwordconfirm"],
                    lang: studentinfo["lang"],
                    dob: studentinfo["dob"],
                    productid: studentinfo["productid"],
                    tablecode: studentinfo["tablecode"],
                    coursename: studentinfo["coursename"],
                    courselink: studentinfo["courselink"],
                    scourselink: studentinfo["scourselink"],
                    formtype: studentinfo["formtype"],
                },
                success: function(data) {
                    markRows($row, data);
                },
                failure: function(data) {
                    consol.log("fail:" + data);
                }
            });
        }

        function markRows($row, data)
        {            
            if(data == "Success")
            {
                $('.students-added').removeClass('hidden');
                $row.css("background-color", "#dff0d8");
                $row.find('.first').css("color", "#3c763d");
                $row.find('.first').css("border-color", "#d6e9c6");
                $row.find('.first').css("border-width", "1px");
                $row.find('.first').css("border-style", "solid");
                $row.removeClass('undelivered');
                $row.addClass('delivered');
                $row.addClass('hidden');
                var status = $('.undelivered').length;
                $('.numberadded').html($('.delivered').length);                
                if(status == 0)
                {
                    //$('.numberadded').html();
                    $('.num-students-added').removeClass('hidden');
                    $('.submit').addClass('hidden');
                    $('.main-menu').removeClass('hidden');
                    $('.add-more').removeClass('hidden');
                    $('.print-list').removeClass('hidden');
                    $('.student-table').addClass('hidden');
                }
            }
            else
            {
                $('.students-added').removeClass('hidden');
                $('.errors').removeClass('hidden');                
                for(var i = 0; i < $(data).length; i++)
                {
                    var msg = "Student ";
                    var rownum = $row.find('.first').html();
                    msg = msg + rownum + ": ";
                    $.each(data[i], function( index, value ) {
                        $('.errlist').append("<li>" + msg + value + "</li>");
                    });
                    i++;
                }
                $row.css("background-color", "#fcf8e3");
                $row.css("color", "#8a6d3b");
                $row.css("border-color", "#faebcc");
                $row.css("border-width", "1px");
                $row.css("border-style", "solid");
            }
        }        
    });

    $('.dob-holder').click(function(){
        $('.dob-holder').removeClass('active');
        $(this).addClass('active');
        var olddate = $('.dob-holder').html();
        var dateparts = olddate.split("/");
        /*$('.month option:selected').text(dateparts[0]);
        $('.day option:selected').text(dateparts[1]);
        $('.year option:selected').text(dateparts[2]);*/
        $('#dobmodal').modal('show');
    });
    $('.save').click(function(){
        var newdate = $('.month option:selected').val() + "/" + $('.day option:selected').val() + "/" + $('.year option:selected').val();
        var dobId = $('.dob-holder.active').attr('id');
        $('input[name="'+dobId+'"]').val(newdate);
        $('.active').html(newdate)
        $('#dobmodal').modal('hide');
    });
    $('.print-list').click(function(){
        var course = $('.course-name').html();
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1;
        var yyyy = today.getFullYear();

        if(dd<10) {
            dd='0'+dd
        } 

        if(mm<10) {
            mm='0'+mm
        } 

        today = mm+'/'+dd+'/'+yyyy;
        var $printTable = makePrintTable();
        $printTable.printThis({
            header: "<h4>Students added to "+course+" on "+today+".</h4>"
        });
    });

    function makePrintTable()
    {
        var $table = $('<table class="table table-condensed" style="font-size:12px;"></table>');
        var $headers = $('<thead></thead>');
        var $header = $('<tr></tr>');
        var $rows = $('<tbody></tbody>');
        var $row = null;
        $tableHeader = $('.student-table tr th');
        $tableHeader.each(function(){
            if(this.innerText != '')
                $header.append('<th>' + this.innerText + '</th>');
        });

        $headers.append($header);
        $tableRows = $('.student-table tbody tr');
        $tableRows.each(function()
        {
            $row = $('<tr></tr>');
            $row.append('<td>' + $(this).find('.firstname input ').val() + '</td>');
            $row.append('<td>' + $(this).find('.lastname input').val() + '</td>');
            $row.append('<td style="font-size:10px;">' + $(this).find('.email input').val() + '</td>');
            $row.append('<td style="font-size:10px;">' + $(this).find('.adminemail input').val() + '</td>');
            $row.append('<td>' + $(this).find('.username input').val() + '</td>');
            $row.append('<td>' + $(this).find('.password input').val() + '</td>');
            if($('input.dob').val() != undefined)
                $row.append('<td>' + $(this).find('.dob').val() + '</td>');
            $row.append('<td>' + $(this).find('.lang select option:selected').val() + '</td>');
            $rows.append($row);
        });
        $table.append($headers);
        $table.append($rows);
        return $table;
    }
</script>

</body>
</html>