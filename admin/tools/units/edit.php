<?php

    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/tools/units/UnitsController.php';

    /*if(!isset($_SESSION['region']))
        $hiddenregion = true;*/

    $unit = new UnitsController();

    if(isset($_POST['password']))
    {
        echo $addedunit = $unit -> AddUnit(true);
        exit;
    }
    else
    {
        $unitregions = $unit -> RegionList();
        $options = "";

        // If the admin has multiple regions, RegionList() will return
        // a multi-dimensional array.
        if(isset($unitregions[0])) {
            for ($i = 0; $i < count($unitregions); $i++) {
                $options .= "<option value = '". $unitregions[$i]['id'] ."'>";
                $options .= $unitregions[$i]['UU'];
                $options .= "</option>";
            }
        // Admin with no regions will return a single dimensional array.
        } else {
            $superuser = trim($unitregions['id']);            
        }

        $singleunit = $unit -> SingleUnit();
    }

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Region Administration Menu&nbsp;<small>Edit Unit</small></h1>
            </div>
            <a href="/admin/tools/units" class="btn btn-primary">Unit List</a>
			<br />
            <div class="row">
                <div class="alert alert-success alert-dismissible unit-ok fade in hidden" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p><strong>SUCCESS</strong> You have successfully editted the unit. Re-edit the unit below, or&nbsp;
                    <a href="/admin/tools/units" class="btn btn-success">go back to the unit list.</a></p>
                </div>
            </div>
            <div class="row">
                 <form id="editform">
                     <div class="form-group">
                         <label for="unitid">Unit / Class Id:</label>
                         <p class="form-control-static"><?php echo $singleunit['AccountName']; ?></p>
                         <input type="hidden" name="unitid" class="unitid" value="<?php echo $singleunit['AccountName']; ?>"/>
                    </div>
                    <div class="form-group">
                         <label for="password">Password:</label>
                         <input type="input" class="form-control password" name="password" value="<?php echo $singleunit['Password']; ?>" required/>
                    </div>
                    <div class="form-group">
                         <label for="verify">Verify Password:</label>
                         <input type="input" class="form-control verify" name="verify" value="<?php echo $singleunit['Password']; ?>" required/>
                    </div>
                    <?php
                        // Display region list or assign super admin as the region id if nothing in the list.
                        if(strlen($options) > 1)
                        {
                            $input = '<div class="form-group">';
                            $input .= '<label for="regionid">Select Region Id:</label>';
                            $input .= '<select class="form-control regionid" name="regionid" required>';
                            $input .= $options;
                            $input .= '</select>';
                            $input .= '<input type="hidden" name="regionopt" value="' . $singleunit['RegionId'] . '"/>';
                            $input .= '</div>';

                            echo $input;
                        }
                        else
                        {
                            $input = '<input type="hidden" class="regionid" name="regionid" value="'. $superuser .'" />';
                            echo $input;
                        }
                    ?>
                    <div class="checkbox">                            
                        <label for="addpermission"><input type="checkbox" class="addpermission" name="addpermission" value="1" />Has permission to add students</label>
                    </div>
                    
                    <div class="form-group">
                         <label for="unitname">Unit Name/Number:</label>
                         <input type="input" class="form-control unitname" name="unitname" value="<?php echo $singleunit['UnitName']; ?>" required />
                    </div>
                    <div class="form-group">
                         <label for="firstname">First Name:</label>
                         <input type="input" class="form-control firstname" name="firstname" value="<?php echo $singleunit['FirstName']; ?>" required/>
                    </div>
                    <div class="form-group">
                         <label for="lastname">Last Name:</label>
                         <input type="input" class="form-control lastname" name="lastname" value="<?php echo $singleunit['LastName']; ?>" required/>
                    </div>
                    <div class="form-group">
                         <label for="email">Email Address:</label>
                         <input type="input" class="form-control email" name="email" value="<?php echo $singleunit['Email']; ?>" required/>
                    </div>
                    <div class="form-group">
                         <button class="btn btn-primary add-student">Submit</button>
                    </div>
                 </form>
            </div>
			<br />
        </div>        
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
<script>
    $('document').ready(function() {
        if($('input[name="regionopt"]').val() != undefined)
            $('.regionid').val($('input[name="regionopt"]').val());
    });

    $('.add-student').click(function(e) {
        e.preventDefault();
        var unitid = $('.unitid').val();
        var password = $('.password').val();
        var verify = $('.verify').val();
        var regionid = $('.regionid').val();
        var addpermission = $('.addpermission').val();
        var unitname = $('.unitname').val();
        var firstname = $('.firstname').val();
        var lastname = $('.lastname').val();
        var email = $('.email').val();
        var data = {
            unitid: unitid,
            password: password,
            verify: verify,
            regionid: regionid,
            addpermission: addpermission,
            unitname: unitname,
            firstname: firstname,
            lastname: lastname,
            email: email
        }
        console.log(data);
        $.ajax({
            type: 'POST',
            url: '/admin/tools/units/edit',
            data: data,
            success: function(response) {
                console.log(response);
                window.scrollTo(500, 0);
                $('.unit-ok').removeClass('hidden');
            }
        });
    });
</script>
</body>
</html>