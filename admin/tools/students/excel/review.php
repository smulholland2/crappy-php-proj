<?php

    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/tools/students/StudentsController.php';
    if(!isset($_FILES["fileToUpload"]))
        $excel = false;
    else 
    {
        //session_start();
        //$_SESSION["queued"];
        $excel = true;
        $students = new StudentsController();
        $students -> GetCourseData();
        $addedstudents = $students -> LoadExcel();
    }

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Add New Students</h1>
            </div>
			<br />
            <div class="row">
                <p>Review the students you have selected to add to the course.</p>
                <p>Uncheck any students you do not wish to add.</p>
            </div>
            <div class="row">
                <input type="hidden" name="productid" value="<?php echo $students -> productid; ?>"/>
                <input type="hidden" name="tablecode" value="<?php echo $students -> tablecode; ?>"/>
                <input type="hidden" name="courselink" value="<?php echo $students -> courselink; ?>"/>
                <input type="hidden" name="scourselink" value="<?php echo $students -> scourselink; ?>"/>
                <input type="hidden" name="coursename" value="<?php echo $students -> coursename; ?>"/>
                <table class="table table-condensed student-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="fnhead">First Name</th>
                            <th class="lnhead">Last Name</th>
                            <th class="uehead">User Email</th>
                            <th class="aehead">Admin Email</th>
                            <th class="unhead">User Name</th>
                            <th class="pwhead">Password</th>
                            <th class="lnhead">Language</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($addedstudents as $student) {
                                $row = "<tr>";
                                $row .= "<td class='first'><input class='selected' type='checkbox' checked/></td>";
                                $row .= "<td class='firstname'><p class='editable'>".$student["firstname"]."</p></td>";
                                $row .= "<td class='lastname'><p class='editable'>".$student["lastname"]."</p></td>";
                                $row .= "<td class='email'><p class='editable'>".$student["email"]."</p></td>";
                                $row .= "<td class='adminemail'><p class='editable'>".$student["adminemail"]."</p></td>";
                                $row .= "<td class='username'><p class='editable'>".$student["username"]."</p></td>";
                                $row .= "<td class='password'><p class='editable'>".$student["password"]."</p></td>";
                                $row .= "<td class='lang'><p class='editable'>".$student["lang"]."</p></td>";
                                $row .= "</tr>";
                                echo $row;
                            } 
                        ?>
                    </tbody>
                </table>
            </div>
			<br />
            <button class="btn btn-primary submit">Submit</button>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
<script>
    var shift = false;
    $(document).keydown(function(e){
        
        var $focused = $(':focus');
        var key = e.which;
        if(key == 9 && !shift) { // tab only
                if(($focused).parent('td').attr('class') == 'first'){
                    e.preventDefault();
                    console.log($focused.parent('td').next('td').children('p').attr('class'));
                    $focused.parent('td').next('td').children('p').click();
                }
            }
            if(key == 9 && shift ){ //shit + tab
                if(($focused).parent('td').attr('class') == 'first'){
                    e.preventDefault();
                    console.log("first one");
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
        $rows.each(function(){
            var firstname = $(this).find('.firstname .editable').html();
            var lastname = $(this).find('.lastname .editable').html();
            var email = $(this).find('.email .editable').html();
            var adminemail = $(this).find('.adminemail .editable').html();
            var username = $(this).find('.username .editable').html();
            var password = $(this).find('.password .editable').html();
            var lang = $(this).find('.lang .editable').html();

            $.ajax({
                url:'/admin/tools/students/queue',
                type: "POST",
                data: { 
                    firstname: firstname,
                    lastname: lastname,
                    email: email,
                    adminemail: adminemail,
                    username: username,
                    password: password,
                    lang: lang,
                },
                success: function(data){
                    console.log("ok:" + data);
                },
                failure: function(data) {
                    consol.log("fail:" + data);
                }
            });
        });
    });

</script>
</body>
</html>