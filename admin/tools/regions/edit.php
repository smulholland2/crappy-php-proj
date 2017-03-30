<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/tools/regions/RegionsController.php";

    /*if(!isset($_SESSION['region']))
        $hiddenregion = true;*/

    $region = new RegionsController();
    if(isset($_POST['password']))
    {
        ob_start();
        $response = $region -> ValidateRegion(1);
        ob_end_clean();
        echo json_encode($response);
        exit;
    }
    else
    {
        $info = $region -> CurrentRegion();
    }

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Multi Unit Administration Menu&nbsp;<small>Edit Region</small></h1>
            </div>
			<br />
            <div class="row">
                <div class="alert alert-success alert-dismissible admin-ok fade in hidden" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p><strong>SUCCESS</strong> You have successfully editted the region information. You can now re-edit the region below.
                </div>
            </div>
            <div class="row">
                <div class="alert alert-danger alert-dismissible admin-errors fade in hidden" role="alert">                
                    <p><strong>ERROR</strong> You have erros in your submission. Please fix the following items and try again.</p>
                    <ul class="errlist"></ul>
                </div>
            </div>
            <div class="row">
                 <form id="editform">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Region ID:</label>
                            <p class="form-control-static regionid"><?php echo trim($info['RegionID']); ?></p>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="input" class="form-control password" name="password" value="<?php echo trim($info['Password']); ?>" required/>
                        </div>
                        <div class="form-group">
                            <label for="verify">Verify Password:</label>
                            <input type="input" class="form-control verify" name="verify" value="<?php echo trim($info['Password']); ?>" required/>
                        </div>
                        <div class="form-group">
                            <label for="firstname">First Name:</label>
                            <input type="input" class="form-control firstname" name="firstname" value="<?php echo trim($info['FirstName']); ?>" required/>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name:</label>
                            <input type="input" class="form-control lastname" name="lastname" value="<?php echo trim($info['LastName']); ?>" required/>
                        </div>
                        <div class="checkbox">                            
                            <label for="addpermission"><input type="checkbox" class="addunit" name="addunit" <?php echo trim($info['AddUnit']); ?> />Has permission to add units/classes</label>
                        </div>
                        <div class="checkbox">                            
                            <label for="addpermission"><input type="checkbox" class="addstudent" name="addstudent" <?php echo trim($info['AddStudent']); ?> />Has permission to add students</label>
                        </div>
                    </div><!-- column 1 -->
                    <div class="clearfix"></div>
			        <hr>
                    <div class="form-group">
                        <div class="btn-group" role="group" aria-label="...">
                            <input type="button" class="btn btn-success submit" value="Submit" />
                            <a href="/admin/tools/regions" class="btn btn-primary">Return To Region List</a>
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
        var regionid = $('.regionid').html();
        var password = $('.password').val();
        var verify = $('.verify').val();
        var firstname = $('.firstname').val();
        var lastname = $('.lastname').val();
        var addstudent = $('.addstudent').is(':checked');
        var addunit = $('.addunit').is(':checked');
        var data = {
            regionid: regionid,
            password: password,
            verify: verify,
            firstname: firstname,
            lastname: lastname,
            addstudent: Number(addstudent),
            addunit: Number(addunit),
        };
        
        $.ajax({
            type: 'POST',
            url: '/admin/tools/regions/edit',
            data: data,
            dataType: "json",
            success: function(response) {
                window.scrollTo(500, 0);
                console.log(response)
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