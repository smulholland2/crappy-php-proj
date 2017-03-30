<?php

    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/tools/units/UnitsController.php';

    /*if(!isset($_SESSION['region']))
        $hiddenregion = true;*/

    $unit = new UnitsController();

    if(isset($_POST['password']))
    {        
        $addedunit = $unit -> AddUnit();
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
    }

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Region Administration Menu&nbsp;<small>Add Unit</small></h1>
            </div>
            <a href="/admin/tools/units" class="btn btn-primary">Unit List</a>
			<br />
            <div class="row">
                <div class="alert alert-success alert-dismissible unit-ok fade in hidden" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p><strong>SUCCESS</strong> You have successfully added a new unit. Add another unit below, or&nbsp;
                    <a href="/admin/tools/units" class="btn btn-success">go back to the unit list.</a></p>
                </div>
            </div>
            <div class="row">
                 <form id="addform">
                     <div class="form-group">
                         <label for="unitid">Unit / Class Id:</label>
                         <input type="input" class="form-control unitid" name="unitid" required/>
                    </div>
                    <div class="form-group">
                         <label for="password">Password:</label>
                         <input type="input" class="form-control password" name="password" required/>
                    </div>
                    <div class="form-group">
                         <label for="verify">Verify Password:</label>
                         <input type="input" class="form-control verify" name="verify" required/>
                    </div>
                    <?php
                        // Display region list or assign super admin as the region id if nothing in the list.
                        if(strlen($options) > 1)
                        {
                            $input = '<div class="form-group">';
                            $input .= '<label for="regionid">Select Region Id:</label>';
                            $input .= '<select type="input" class="form-control regionid" name="regionid" required>';
                            $input .= $options;
                            $input .= '</select>';
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
                         <input type="input" class="form-control unitname" name="unitname" required/>
                    </div>
                    <div class="form-group">
                         <label for="firstname">First Name:</label>
                         <input type="input" class="form-control firstname" name="firstname" required/>
                    </div>
                    <div class="form-group">
                         <label for="lastname">Last Name:</label>
                         <input type="input" class="form-control lastname" name="lastname" required/>
                    </div>
                    <div class="form-group">
                         <label for="email">Email Address:</label>
                         <input type="input" class="form-control email" name="email" required/>
                    </div>
                    <div class="form-group">
                         <button class="btn btn-primary add-student">Add</button>
                    </div>
                 </form>
            </div>
			<br />
        </div>        
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
<script>
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
        $.ajax({
            type: 'POST',
            url: '/admin/tools/units/add',
            data: data,
            success: function(response) {
                document.getElementById('addform').reset();
                window.scrollTo(500, 0);
                $('.unit-ok').removeClass('hidden');
            }
        });
    });
</script>
</body>
</html>