<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>TAP Series Password Retrieval</h1>
            </div>
			<br />
            <div class="row">
                <span class="forgot-pass-warning">
                    This page will only work if either you have purchased the course yourself or someone has already given you a user name and password. If you need to purchase the course, click here.
                </span>
            </div>
            <br />
            <div class="row forgotform">
                <div class="well">
                    <form>
                        <input type="hidden" name="type" id="type"/>
                        <div class="form-group">
                            <label for="producttable">Choose your enrolled course.</label>
                            <select name="producttable" size="9" class="form-control producttable">
                                <option value="01d" class="dobopt">Food Handler (All states)</option>
                                <option value="01d">Food Safety Manager</option>
                                <option value="02d">Food Safety Recertification</option>
                                <option value="03d">Cooking Basics</option>
                                <option value="04d">HACCP</option>
                                <option value="05d">Strategies for Increasing Sales</option>
                                <option value="06d">Earn More With Service</option>
                                <option value="09d" class="dobopt">Allergen Awareness</option>
                                <option value="10d" class="dobopt">Allergen Development</option>
                                <option value="11d" class="dobopt">Allergen Specialist</option>
                                <option value="12d" class="dobopt">Alcohol Training</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="lastname"><span class="text-danger"></span>Last Name (Apellido):</label>
                            <input type="text" name="lastname" class="form-control lastname"/>
                        </div>
                        <div class="form-group">
                            <label for="firstname"><span class="text-danger"></span>First Name (Apellido):</label>
                            <input type="text" class="form-control firstname" name="firstname"/>
                        </div>
                        <div class="form-group">
                            <label for="dob"><span class="text-danger"></span>Birth Date [mm/dd/yyyy] (Fecha de Nacimiento):</label>
                            <input type="date" class="form-control dob" name="dob"/>
                        </div>
                        <div class="form-group">
                            <label for="username"><span class="text-danger"></span>UserName (Nombre de usario):</label>
                            <input type="text" class="form-control username" name="username"/>
                        </div>
                        <div class="form-group">
                            <div><i>Enter the email address you want the password to be sent to.</i></div>
                            <label for="email"><span class="text-danger">* </span>Email Address:</label>
                            <input type="text" class="form-control email" name="email" required/>
                        </div>
                        <button type="submit" class="btn btn-primary submitpass">Submit</button>
                    </form>
                </div><!-- /END WELL -->
            </div><!-- /END ROW -->
			<br />
            <div class="row thankyou hidden">
                <h2>Success!</h2>
                <p>Thank you, your password reset link has been emailed to <span class="sentto"></span>.</p>
                <p> If you do not receieve an email within a few minutes, check your spelling and try again.</p>
                <p>Please check your email and follow the instructions to reset your password.</p>
            </div>
            <div class="row notfound hidden">
                <h2>We're Sorry.</h2>
                <p>No student was found that matches that information. Please <a href="/account/forgotpass">GO BACK</a>&nbsp; and try again.</p>
                <p>If you need further assistance, please call technical support: 888-826-5222. Or visit our <a href="/home/troubleshooting">help page.</a></p>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
<script>
    $('.producttable').change(function(){
        var type = $('.producttable option:selected').attr('class');
        if(type == "dobopt")
        {
            $('.username').attr('required', 'false');
            $('.dob').attr('required', 'true');
            $('.firstname').attr('required', 'true');
            $('.lastname').attr('required', 'true');
            $('.username').parent('div').find('.text-danger').html('');
            $('.dob').parent('div').find('.text-danger').html('* ');
            $('.firstname').parent('div').find('.text-danger').html('* ');
            $('.lastname').parent('div').find('.text-danger').html('* ');
            $('#type').val('dob');
        }
        else
        {
            $('.username').attr('required', 'true');
            $('.dob').attr('required', 'false');
            $('.firstname').attr('required', 'false');
            $('.lastname').attr('required', 'false');
            $('.username').parent('div').find('.text-danger').html('* ');
            $('.dob').parent('div').find('.text-danger').html('');
            $('.firstname').parent('div').find('.text-danger').html('');
            $('.lastname').parent('div').find('.text-danger').html('');
            $('#type').val('usern');
        }
    });

    $('.submitpass').click(function(e){
        e.preventDefault();

        var studentinfo = [];
        var dob = $('.dob').val();

        if(dob.length > 0)
            studentinfo["login"] = $('.dob').val(); 
        else
            studentinfo["login"] = $('.username').val(); 

        studentinfo["firstname"] = $('.firstname').val();
        studentinfo["lastname"] = $('.lastname').val();
        studentinfo["email"] = $('.email').val();        
        studentinfo["producttable"] = $('.producttable').val();
        studentinfo["logintype"] = $('#type').val();

        $.ajax({
            url:'/account/resetrequest',
            type: "POST",
            data: { 
                firstname: studentinfo["firstname"],
                lastname: studentinfo["lastname"],
                email: studentinfo["email"],
                login: studentinfo["login"],
                producttable: studentinfo["producttable"],
                logintype: studentinfo["logintype"]
            },
            success: function(data) {
                if(data == 0)
                {
                    $('.notfound').removeClass('hidden');
                    $('.forgotform').addClass('hidden');
                }
                else
                {
                    $('.forgotform').addClass('hidden');
                    $('.thankyou').removeClass('hidden');
                    $('.sentto').html(studentinfo["email"]);
                }                
            }
        });
    });
</script>
</body>
</html>