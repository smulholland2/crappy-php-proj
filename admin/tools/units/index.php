<?php

    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/tools/units/UnitsController.php';

    if(isset($_POST["action"]))
    {
        $units = new UnitsController($_POST);
    }
    
    $units = new UnitsController();
    $unitslist = $units -> UnitsList();    

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Unit List</h1>
            </div>
            <a href="/account/login" class="btn btn-primary">Main Menu</a>
			<br />
            <div class="row alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p><strong>How to use this section:</strong></p>
                <ol>
                    <li>Select a unit by clicking the circle (<input type="radio" />) next to the Unit ID.</li>
                    <li>Choose the action you want to take on that unit by clicking the arrow (<span class="caret"></span>) next to Action, then clicking on the action to perform.</li>
                    <li>Once you have chosen an action, click the "Submit" button to continue.</li>
                </ol>
                <ul>
                    <li>To add a new Unit Administrator, click the "Add New Unit" button.</li>
                  <!--  <li>To sort the table of Unit Administrators, use the "Order By" list by clicking its&nbsp;<span class="caret"></span>.</li></li>-->
                </ul>
            </div>
            <br />
            <div class="row">
                <form class="form-inline well action-form" method="POST">
                    <input type="hidden" class="unitid" name= "unitid" value="0" />
                    <div class="form-group">
                        <label>Action:&nbsp;&nbsp;</label>
                        <select class="form-control actions">
                            <option value="0"></option>
                            <option value="/admin/tools/units/edit">Edit / Reassign</option>
                            <option value="/admin/tools/trackprogress/index">View Students</option>
                            <!--<option value="/admin/tools/units/delete">Delete Unit</option>-->
                            <option value="/admin/tools/students/index">Add Students</option>
                        </select>
                        &nbsp;
                        <a role="button" data-trigger="focus" title="No Unit Selected" 
                        data-content="Please chose a unit from the table below and press Submit again to continue." 
                        class="btn btn-success action-ok" tabindex="1" disabled data-placement="top">Submit</a>
                    </div>
                    <div class="form-group">
                        <a href="/admin/tools/units/add" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add New Unit</a>
                    </div>
                </form>
            </div>
            <div class="row">
                <table class="table table-bordered table-condensed table-striped unit-table">
                    <thead>
                        <tr>
                            <td></td>
                            <td>Unit ID</td>
                            <td>Last Name</td>
                            <td>First Name</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($unitslist[0]["AN"]))
                            {
                                for($i = 0; $i < count($unitslist); $i++)
                                {
                                    if($unitslist[$i]["AN"] != "")
                                    {
                                        $unit = "<tr>";
                                        $unit .= "<td><input type='radio' name='unit' class='unit' value=" . $unitslist[$i]['AN'] . " /></td>";
                                        $unit .= "<td class='uid'>" . $unitslist[$i]['AN'] ."</td>";
                                        $unit .= "<td>" . $unitslist[$i]["NF"] ."</td>";
                                        $unit .= "<td>" . $unitslist[$i]["NL"] ."</td>";
                                        $unit .= "</tr>";
                                        echo $unit;
                                    }
                                }
                            }
                            else if(count($unitslist) == 0)
                            {
                                
                            }
                            else
                            {
                                $unit = "<tr>";
                                $unit .= "<td><input type='radio' name='unit' class='unit' value=" . $unitslist['AN'] . " /></td>";
                                $unit .= "<td class='uid'>" . $unitslist['AN'] ."</td>";
                                $unit .= "<td>" . $unitslist["NF"] ."</td>";
                                $unit .= "<td>" . $unitslist["NL"] ."</td>";
                                $unit .= "</tr>";
                                echo $unit;
                            }
                        ?>
                    </tbody>
                 </table>
                 <?php if(count($unitslist) == 0){ echo "There are no units associated with the account."; } ?>
            </div>
			<br /><br><a href="/admin/multi_unit" class="btn btn-primary">Return To Menu</a>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
<script>

$('.unit').click(function(){

    // Assign the table value of unitid to the hidden form field.
    if($(this).val() != 0)
        $('.unitid').val($(this).val());

    /* 
    * The submit button starts off as disabled.
    * We want to keep it that way until there are
    * valid selections in the dropdown and the table.
    * Both are set to 0 values by default.
    */

    // Hidden input and dropdown are not 0 so we enable the button.
    if($('.actions').val() != 0 && $('.unitid').val() != 0)
        $('.action-ok').attr('disabled', false);

    // Hidden input is not zero, but the table is so we make sure to disable the button
    // and change the error message.
    else if($('.unitid').val() != 0 && $('.unitid').val() == 0)
    {
        $('.action-ok').attr('title', 'No Action Selected');
        $('.action-ok').attr('data-content', 'Please select an Action from the drop down list to the left and press Ok to continue');
        $('.action-ok').attr('disabled', true);
    }

    // If somehow both values end up at 0 after the event, 
    // we will just leave the button disabled.
    else
        $('.action-ok').attr('disabled', true);
});

$('.actions').change(function(){

    /* 
    * Once the table has been selected, its difficult
    * to deselect it. The dropdown can easily be set back to 0
    * so we will base the disabled state of the Ok button mostly
    * based on the value of the dropdown.
    */

    // The form action is set in the value of the options.
    // Once an option has been selected, we set the form action.
    if($(this).val() != 0)
        $('.action-form').attr('action', $(this).val());
    // If no action is selected, remove the form action.
    if($(this).val() == 0)
        $('.action-form').attr('action', '');
    
    // Once the dropdown and the hidden input have non 0 values,
    // enable the Ok button.
    if($(this).val() != 0 && $('.unitid').val() != 0){
        $('.action-ok').attr('disabled', false);
        console.log($(this).val());
        console.log($('.unitid').val());
    }        
    // If the dropdown is set back to 0, disabled the button.
    else
        $('.action-ok').attr('disabled', true);
});

$('.action-ok').click(function(){    
    if($('.actions').val() == 0 || $('.unitid').val() == 0)
        $(this).popover('show');
    else {
        $(this).on('hidden.bs.popover', function () {
            $('.action-ok').popover('hide');
        });
        $('.action-form').submit();
    }
});

</script>
</body>
</html>