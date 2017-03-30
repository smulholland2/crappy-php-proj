<?php

    session_start();
    if(isset($_SESSION["TrainingLogin"]))
        header("Location:/training");

    if(isset($_SESSION["postpurchase"]))
        unset($_SESSION['AC']);unset($_SESSION['postpurchase']);
    
    if(isset($_SESSION["account_username"]))
    {
        session_unset();     // unset $_SESSION variable for the run-time 
    	session_destroy();
    }


?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="page-header">
            <h1>Login</h1>
        </div>
        <div class="row col-md-6 col-md-offset-3 <?php echo isset($_SESSION["error"]) ? 'error': 'hidden' ?>">
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>ERROR:</strong> Login information incorrect. Please try again.
            </div>
        </div>
        <div class="clearfix"></div>
        <ul class="nav nav-pills logintabs">                    
            <li role="presentation" class="active">
                <a href="#individual" data-toggle="tab" href="#" role="tab" class="07O6">Individual Accounts</a>
            </li>
            <li role="presentation">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="account-type">School Accounts</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li role="presentation">
                        <a href="#classselfenrolled" aria-controls="classselfenrolled" role="tab" data-toggle="tab" class="07SL4">Students are self-enrolled</a>
                    </li>
                    <li role="presentation">
                        <a href="#classadminenrolled" aria-controls="classadminenrolled" role="tab" data-toggle="tab" class="07O6">Students are enrolled by admin/instructor</a>
                    </li>
                </ul>
            </li>
            <li role="presentation">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="account-type">Business Accounts</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li role="presentation">
                        <a href="#busselfenrolled" aria-controls="busselfenrolled" role="tab" data-toggle="tab" class="07SL4">Students are self-enrolled</a>
                    </li>
                    <li role="presentation">
                        <a href="#busadminenrolled" aria-controls="busadminenrolled" role="tab" data-toggle="tab" class="07O6">Students are enrolled by admin/instructor</a>
                    </li>
                </ul>
            </li>
            <li role="presentation">
                <a href="" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="account-type">Multi Level Accounts</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li role="presentation">
                        <a href="#corpadmin" aria-controls="corpadmin" role="tab" data-toggle="tab" class="07L2">Corporate Account</a>
                    </li>
                    <li role="presentation">
                        <a href="#regionadmin" aria-controls="regionadmin" role="tab" data-toggle="tab" class="07L2">Region Administrator</a>
                    </li>
                    <li role="presentation">
                        <a href="#classadmin" aria-controls="classadmin" role="tab" data-toggle="tab" class="07O6">Unit/Class Administrator</a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="clearfix"></div>
        <div class="well">
            <div class="col-md-5">
                <div class="row col-md-11">
                    <div class="alert alert-info alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>NOTICE:</strong> Corporate Accounts have been renamed to Multi-Accounts.
                    </div>
                </div>
                <div class="row col-md-12">
                    <p>You need to login to access this area of the site. <br /><small class="text-danger">User names and passwords are case sensitive.</small></p>
                </div>
                <br />
                <hr class="row col-md-12" style="color:red;">
                <br />
                <div class="row col-md-12">
                    <strong>This page is for administration only.<br />To login to your online course, <a href="/training">click here</a>.</strong>
                </div>                                        
            </div>            
            <div class="col-md-7">
                <div class="row">
                    <h3><span class="form-title">Individual Account Login</span><span class="type-dash"> - </span><small class="form-sub"></small></h3>
                    <!-- Tab panes -->
                    <div class="">
                        <div class="tab-content">
                            
                            <div role="tabpanel" class="tab-pane fade in active" id="individual">
                                <br />
                                <!-- Individual Accounts -->
                                <form method="POST" action="/account/login/company">
                                    <input type="hidden" name="enrollment" value="0" />
                                    <div class="form-group col-md-8">
                                        <label for="username">User Name</label>
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <label for="password">Password <small>(Click the eye to show password)</small></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control password" name="password" aria-describedby="basic-addon1">
                                            <span class="input-group-addon show-pass" id="basic-addon1" data-toggle="tooltip" data-placement="bottom" title="Click here to show password.">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="#" data-toggle="modal" data-target="#forgot-password" class="forgotpass">
                                            <u>Forgot Password</u>
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <!-- /Individual Accounts -->
                            <!-- Class Accounts: Students are self enrolled -->
                            <div role="tabpanel" class="tab-pane fade" id="classselfenrolled">
                                <br />
                                <form method="POST" action="/account/login/instructor">
                                    <input type="hidden" name="enrollment" value="1" />
                                    <div class="form-group col-md-8">
                                        <label for="username">User Name</label>
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <label for="password">Password <small>(Click the eye to show password)</small></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control password" name="password" aria-describedby="basic-addon2">
                                            <span class="input-group-addon show-pass" id="basic-addon2" data-toggle="tooltip" data-placement="bottom" title="Click here to show password.">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="#" data-toggle="modal" data-target="#forgot-password" class="forgotpass">
                                            <u>Forgot Password</u>
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <!-- /Class Accounts: Students are self enrolled -->
                            <!-- Class Accounts: Students are enrolled by administrator -->
                            <div role="tabpanel" class="tab-pane fade" id="classadminenrolled">
                                <br />
                                <form method="POST" action="/account/login/company">
                                    <input type="hidden" name="enrollment" value="0" />
                                    <div class="form-group col-md-8">
                                        <label for="username">User Name</label>
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <label for="password">Password <small>(Click the eye to show password)</small></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control password" name="password" aria-describedby="basic-addon3">
                                            <span class="input-group-addon show-pass" id="basic-addon3" data-toggle="tooltip" data-placement="bottom" title="Click here to show password.">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="#" data-toggle="modal" data-target="#forgot-password" class="forgotpass">
                                            <u>Forgot Password</u>
                                        </a>
                                    </div>
                                </form>
                            </div>
                             <!-- /Class Accounts: Students are enrolled by administrator -->
                            <!-- Business Accounts: Students are self enrolled -->
                            <div role="tabpanel" class="tab-pane fade" id="busselfenrolled">
                                <br />
                                <form method="POST" action="/account/login/instructor">
                                <input type="hidden" name="enrollment" value="1" />
                                    <div class="form-group col-md-8">
                                        <label for="username">User Name</label>
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <label for="password">Password <small>(Click the eye to show password)</small></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control password" name="password" aria-describedby="basic-addon4">
                                            <span class="input-group-addon show-pass" id="basic-addon4" data-toggle="tooltip" data-placement="bottom" title="Click here to show password.">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="#" data-toggle="modal" data-target="#forgot-password" class="forgotpass">
                                            <u>Forgot Password</u>
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <!-- /Business Accounts: Students are self enrolled -->
                            <!-- Business Accounts: Students are enrolled by administrator -->
                            <div role="tabpanel" class="tab-pane fade" id="busadminenrolled">
                                <br />
                                <form method="POST" action="/account/login/company">
                                    <input type="hidden" name="enrollment" value="0" />
                                    <div class="form-group col-md-8">
                                        <label for="username">User Name</label>
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <label for="password">Password <small>(Click the eye to show password)</small></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control password" name="password" aria-describedby="basic-addon5">
                                            <span class="input-group-addon show-pass" id="basic-addon5" data-toggle="tooltip" data-placement="bottom" title="Click here to show password.">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="#" data-toggle="modal" data-target="#forgot-password" class="forgotpass">
                                            <u>Forgot Password</u>
                                        </a>
                                    </div>
                                </form>
                            </div> 
                            <!-- /Business Accounts: Students are enrolled by administrator -->
                            <!-- Multi-Unit Admins -->
                            <div role="tabpanel" class="tab-pane fade" id="corpadmin">
                                <br />                                
                                <form method="POST" action="/account/login/multi_unit">
                                    <input type="hidden" name="enrollment" value="0" />
                                    <input type="hidden" name="account_type" value="corporate_admin_logon" />
                                    <div class="form-group col-md-8">
                                        <label for="username">User Name</label>
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <label for="password">Password <small>(Click the eye to show password)</small></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control password" name="password" aria-describedby="basic-addon6">
                                            <span class="input-group-addon show-pass" id="basic-addon6" data-toggle="tooltip" data-placement="bottom" title="Click here to show password.">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="#" data-toggle="modal" data-target="#forgot-password" class="forgotpass">
                                            <u>Forgot Password</u>
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <!-- /Multi-Unit Admins -->
                            <!-- Region Admins -->
                            <div role="tabpanel" class="tab-pane fade" id="regionadmin">
                                <br />
                                <form method="POST" action="/account/login/region">
                                    <input type="hidden" name="account_type" value="region_admin_logon" />
                                    <input type="hidden" name="enrollment" value="1" />
                                    <div class="form-group col-md-8">
                                        <label for="username">User Name</label>
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <label for="password">Password <small>(Click the eye to show password)</small></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control password" name="password" aria-describedby="basic-addon7">
                                            <span class="input-group-addon show-pass" id="basic-addon7" data-toggle="tooltip" data-placement="bottom" title="Click here to show password.">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="#" data-toggle="modal" data-target="#forgot-password" class="forgotpass">
                                            <u>Forgot Password</u>
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <!-- /Region Admins -->
                            <!-- Unit / Class Administrators -->
                            <div role="tabpanel" class="tab-pane fade" id="classadmin">
                                <br />
                                <form method="POST" action="/account/login/company">
                                    <input type="hidden" name="enrollment" value="1" />
                                    <div class="form-group col-md-8">
                                        <label for="username">User Name</label>
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <label for="password">Password <small>(Click the eye to show password)</small></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control password" name="password" aria-describedby="basic-addon8">
                                            <span class="input-group-addon show-pass" id="basic-addon8" data-toggle="tooltip" data-placement="bottom" title="Click here to show password.">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group col-md-8">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="#" data-toggle="modal" data-target="#forgot-password" class="forgotpass">
                                            <u>Forgot Password</u>
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <!-- Unit / Class Administrators -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="forgot-password" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="forgotPasswordLabel">Forgot Password</h4>
      </div>
      <div class="modal-body">
        <div class="forgotform">
            <p>
                Enter your e-mail address that you used when purchasing the course.Your account administrator user name and a password reset link will be e-mailed to you.
            </p>
            <br />
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control email" name="email" required />
                    <input type="hidden" class="type" name="type" value="" />
                </div>
            </form>
        </div>
        <div class="thankyou hidden">
            <h2>Success!</h2>
            <p>Thank you, your password reset link has been emailed to <span class="sentto"></span>.</p>
            <p>Please check your email and follow the instructions to reset your password.</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger submit-close" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success submitpass">Submit</button>
      </div>
    </div>
  </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
<?php unset($_SESSION["error"]); ?>
<script>
    $('document').ready(function(){
        $('.type').val('07O6');
        $('.type-dash').hide();
    });    
    $('.logintabs li a').click(function() {
        $(this).tab('show');
        var table = $(this).attr('class');
        var form = $(this).attr('href');
        // Change the h3 form title when a new form is clicked
        setFormTitle(form);
        
        // We want to change the value of the reset password hidden input which tells the reset method which table to use.
        // We need to ignore clicks on dropdown-toggles.
        if(table != 'dropdown-toggle')
        {
            // The class will be the name of the table.
            $('.type').val(table);
        }
    });

    $('.show-pass').click(function() {
        console.log($(this).find('span'));
        // this will contain a reference to the checkbox   
        if ($(this).find('span').hasClass('glyphicon-eye-open')) {
            $('.password').attr('type','text');
            $(this).find('span').removeClass('glyphicon-eye-open')
            $(this).find('span').addClass('glyphicon-eye-close')
        } else {
            $('.password').attr('type','password');
            $(this).find('span').removeClass('glyphicon-eye-close')
            $(this).find('span').addClass('glyphicon-eye-open')
        }
    });

    $('.forgotpass').click(function(){
        $('.submitpass').removeClass('hidden');
        $('.forgotform').removeClass('hidden');
        $('.thankyou').addClass('hidden');
        $('.submit-close').html('Cancel');
        $('.sentto').html();
    });

    $('.submitpass').click(function(e){
        e.preventDefault();

        var admininfo = [];
        admininfo["email"] = $('.email').val();
        admininfo["type"] = $('.type').val();
        console.log()
        $.ajax({
            url:'/account/resetrequest',
            type: "POST",
            data: { 
                email: admininfo["email"],
                type: admininfo["type"]
            },
            success: function(data){
                console.log(data);
                $('.forgotform').addClass('hidden');
                $('.thankyou').removeClass('hidden');
                $('.submit-close').html('Close');
                $('.submitpass').addClass('hidden');
                $('.sentto').html(admininfo["email"]);
            },
            failure: function(data) {
                consol.log("fail:" + data);
            }
        });
    });

    function setFormTitle(form)
    {
        switch (form)
        {
            case '#individual':
                $('.form-title').html('Individual Account Login');
                $('.form-sub').html('');
                $('.type-dash').hide();
                break;
            case '#classselfenrolled':
                $('.form-title').html('School Account Login');
                $('.form-sub').html('Self Enrolled');
                $('.type-dash').show();
                break;
            case '#classadminenrolled':
                $('.form-title').html('School Account Login');
                $('.form-sub').html('Enrolled by Administrator');
                $('.type-dash').show();
                break;
            case '#busselfenrolled':
                $('.form-title').html('Business Account Login');
                $('.form-sub').html('Self Enrolled');
                $('.type-dash').show();
                break;
            case '#busadminenrolled':
                $('.form-title').html('Business Account Login');
                $('.form-sub').html('Enrolled by Administrator');
                $('.type-dash').show();
                break;
            case '#corpadmin':
                $('.form-title').html('Corporate Account Login');
                $('.form-sub').html('');
                $('.type-dash').hide();
                break;
            case '#regionadmin':
                $('.form-title').html('Region Administration Login');
                $('.form-sub').html('');
                $('.type-dash').hide();
                break;
            case '#classadmin':
                $('.form-title').html('Unit / Class Account Login');
                $('.form-sub').html('');
                $('.type-dash').hide();
                break;
            default:
                break;
        }
    }    
</script>
</body>
</html>