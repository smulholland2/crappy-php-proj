<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/tools/profile/ProfileController.php";

    /*if(!isset($_SESSION['region']))
        $hiddenregion = true;*/

    $profile = new ProfileController();
    if(isset($_POST['password']))
    {
        ob_start();
        $response = $profile -> Edit();
        ob_end_clean();
        echo json_encode($response);
        exit;
    }
    else
    {
        $user = $profile -> CurrentProfile();
    }

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Multi Unit Administration Menu&nbsp;<small>Edit Unit</small></h1>
            </div>
			<br />
            <div class="row">
                <div class="alert alert-success alert-dismissible admin-ok fade in hidden" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p><strong>SUCCESS</strong> You have successfully edited the admin account information. You can now re-edit the admin below.
                </div>
            </div>
            <div class="row">
                <div class="alert alert-danger alert-dismissible admin-errors fade in hidden" role="alert">                
                    <p><strong>ERROR</strong> You have errors in your submission. Please fix the following items and try again.</p>
                    <ul class="errlist"></ul>
                </div>
            </div>
            <div class="row">
                 <form id="editform">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>User Name:</label>
                            <p class="form-control-static"><?php echo trim($user['UserName']); ?></p>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="input" class="form-control password" name="password" value="<?php echo trim($user['Password']); ?>" required/>
                        </div>
                        <div class="form-group">
                            <label for="verify">Verify Password:</label>
                            <input type="input" class="form-control verify" name="verify" value="<?php echo trim($user['Password']); ?>" required/>
                        </div>
                        <div class="form-group">
                            <label for="firstname">First Name:</label>
                            <input type="input" class="form-control firstname" name="firstname" value="<?php echo trim($user['FirstName']); ?>" required/>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name:</label>
                            <input type="input" class="form-control lastname" name="lastname" value="<?php echo trim($user['LastName']); ?>" required/>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="input" class="form-control email" name="email" value="<?php echo trim($user['Email']); ?>" required/>
                        </div>
                        <div class="form-group">
                            <label for="company">Company:</label>
                            <input type="input" class="form-control company" name="company" value="<?php echo trim($user['Company']); ?>" required/>
                        </div>
                    </div><!-- column 1 -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="address1">Address Line 1:</label>
                            <input type="input" class="form-control address1" name="address1" value="<?php echo trim($user['Address1']); ?>" required/>
                        </div>
                        <div class="form-group">
                            <label for="address2">Address Line 2:</label>
                            <input type="input" class="form-control address2" name="address2" value="<?php echo trim($user['Address2']); ?>" />
                        </div>
                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="input" class="form-control city" name="city" value="<?php echo trim($user['City']); ?>" required/>
                        </div>
                        <div class="form-group">
                            <label for="state">State:</label>
                            <input type="input" class="form-control state" name="state" value="<?php echo trim($user['State']); ?>" required/>
                        </div>
                        <div class="form-group">
                            <label for="zip">Zip:</label>
                            <input type="input" class="form-control zip" name="zip" value="<?php echo trim($user['Zip']); ?>" required/>
                        </div>
                        <div class="form-group">
                            <label for="country">Country:</label>
                            <input type="input" class="form-control country" name="country" value="<?php echo trim($user['Country']); ?>" required/>
                        </div>                    
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="input" class="form-control phone" name="phone" value="<?php echo trim($user['Phone']); ?>" required/>
                        </div>
                        <div class="form-group">
                            <label for="fax">Fax:</label>
                            <input type="input" class="form-control fax" name="fax" value="<?php echo trim($user['Fax']); ?>" />
                        </div>
                    </div><!-- column 2 -->
                    <div class="clearfix"></div>
			        <hr>
                    <div class="form-group">
                        <div class="btn-group" role="group" aria-label="...">
                            <input type="button" class="btn btn-success submit" value="Submit" />
                            <a href="<?php echo $_SESSION['menu']; ?>" class="btn btn-primary">Return To Menu</a>
                        </div>
                    </div>
                 </form>
            </div>
        </div>        
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
<script>
    $('document').ready(function() {
        if($('input[name="regionopt"]').val() != undefined)
            $('.regionid').val($('input[name="regionopt"]').val());
    });

    $('.submit').click(function(e) {
        e.preventDefault();
        var password = $('.password').val();
        var verify = $('.verify').val();
        var company = $('.company').val();
        var address1 = $('.address1').val();
        var address2 = $('.address2').val();
        var firstname = $('.firstname').val();
        var lastname = $('.lastname').val();
        var email = $('.email').val();
        var city = $('.city').val();
        var state = $('.state').val();
        var country = $('.country').val();
        var zip = $('.zip').val();
        var phone = $('.phone').val();
        var fax = $('.fax').val();
        var data = {
            password: password,
            verify: verify,
            company: company,
            address1: address1,
            address2: address2,
            firstname: firstname,
            lastname: lastname,
            email: email,
            city: city,
            state: state,
            country: country,
            zip: zip,
            phone: phone,
            fax: fax
        }

        $.ajax({
            type: 'POST',
            url: '/admin/tools/profile/edit',
            data: data,
            dataType: "json",
            success: function(response) {
                window.scrollTo(500, 0);
                if(response.length > 0){
                    $('.admin-ok').addClass('hidden');
                    $('.admin-errors').removeClass('hidden');
                    for (var index = 0; index < response.length; index++) {
                        $('.errlist').append('<li>' + response[index] + '</li>');
                    }
                } else {
                    $('.admin-errors').addClass('hidden');
                    $('.admin-ok').removeClass('hidden');
                }
            }
        });
    });
</script>
</body>
</html>