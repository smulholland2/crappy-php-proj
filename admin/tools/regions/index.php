<?php

    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/tools/regions/RegionsController.php';

    $regions = new RegionsController();

    if(isset($_POST["action"]))
    {
        $units = new RegionsController($_POST);
    }

    if(isset($_POST["deleteregion"]))
    {
        ob_start();
        $region = $regions -> ValidateRegion(2);
        ob_end_clean();
        echo json_encode($region);
        exit;
    }
    
    $regionslist = $regions -> RegionsList();
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Multi Unit Administration Menu&nbsp;<small>Region List</small></h1>
            </div>
			<br />
            <div class="row alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p><strong>How to use this section:</strong></p>
                <ol>
                    <li>Select a region by clicking the <input type="radio" /> in the region's corresponding row.</li>
                    <li>Choose the action you want to take on that region from the list marked "Action" by clicking its&nbsp;<span class="caret"></span>.</li>
                    <li>Once you have choosen an action, click the "Submit" button to continue.</li>
                </ol>
                <ul>
                    <li>To add a new Region administrator, click the "Add New Region" button.</li>
                    <li>To sort the table of unit administratos, use the "Order By" list by clicking its&nbsp;<span class="caret"></span>.</li></li>
                </ul>
            </div>
            <br />
            <div class="row">
                <form class="form-inline well action-form" method="POST">
                    <input type="hidden" class="regionid" name= "regionid" value="0" />
                    <div class="form-group">
                        <label>Action:&nbsp;&nbsp;</label>
                        <select class="form-control actions">
                            <option value="0"></option>
                            <option value="/admin/tools/regions/edit">Edit Region</option>
                            <option value="/admin/tools/units/index">Unit / Class List</option>
                            <option value="delete">Delete Region</option>
                        </select>
                        &nbsp;
                        <a role="button" data-trigger="focus" title="No Unit Selected" 
                        data-content="Please chose a unit from the table below and press Submit again to continue." 
                        class="btn btn-success action-ok" tabindex="1" disabled data-placement="top">Submit</a>
                    </div>
                    <div class="form-group">
                        <a href="/admin/tools/regions/add" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add New Region</a>
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
                            if(isset($regionslist[0]["UU"]))
                            {
                                for($i = 0; $i < count($regionslist); $i++)
                                {
                                    if($regionslist[$i]["UU"] != "")
                                    {
                                        $region = "<tr id=".$regionslist[$i]['UU'].">";
                                        $region .= "<td><input type='radio' name='unit' class='unit' value=" . $regionslist[$i]['UU'] . " /></td>";
                                        $region .= "<td class='uid'>" . $regionslist[$i]['UU'] ."</td>";
                                        $region .= "<td>" . $regionslist[$i]["NF"] ."</td>";
                                        $region .= "<td>" . $regionslist[$i]["NL"] ."</td>";
                                        $region .= "</tr>";
                                        echo $region;
                                    }
                                }
                            }
                            else
                            {
                                $region = "<tr id=".$regionslist['UU'].">";
                                $region .= "<td><input type='radio' name='unit' class='unit' value=" . $regionslist['UU'] . " /></td>";
                                $region .= "<td class='uid'>" . $regionslist['UU'] ."</td>";
                                $region .= "<td>" . $regionslist["NF"] ."</td>";
                                $region .= "<td>" . $regionslist["NL"] ."</td>";
                                $region .= "</tr>";
                                echo $region;
                            }                            
                        ?>
                    </tbody>
                 </table>
            </div>
			<br />
        </div>
    </div>
</div>
<div class="modal fade delete-confirm" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalLabel">Please confirm deletion</h4>
				</div>
				<div class="modal-body">
                    <div class="confirm-box">
                        <p class="modal-msg">Are you sure you want to delete the Region:</p>
                        <p class="confirm-region"></p>
                        <input class="deleteregion" type="hidden" name="deleteregion" />
                    </div>
                    <div class="success-box hidden">
                        <p class="modal-msg">You have successfully removed the region:</p>
                        <p class="confirm-region"></p>
                        <input class="deleteregion" type="hidden" name="deleteregion" />
                    </div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-success delete-yes">Yes</button>
					<button class="btn btn-danger delete-no" data-dismiss="modal">No</button>
                    <button class="btn btn-success delete-ok hidden" data-dismiss="modal">Ok</button>
				</div>
    		</div>
  		</div>
	</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
<script>

$('.unit').click(function(){

    // Assign the table value of regionid to the hidden form field.
    if($(this).val() != 0)
        $('.regionid').val($(this).val());

    /* 
    * The submit button starts off as disabled.
    * We want to keep it that way until there are
    * valid selections in the dropdown and the table.
    * Both are set to 0 values by default.
    */

    // Hidden input and dropdown are not 0 so we enable the button.
    if($('.actions').val() != 0 && $('.regionid').val() != 0)
        $('.action-ok').attr('disabled', false);

    // Hidden input is not zero, but the table is so we make sure to disable the button
    // and change the error message.
    else if($('.regionid').val() != 0 && $('.regionid').val() == 0)
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
    if($(this).val() != 0 && $('.regionid').val() != 0){
        $('.action-ok').attr('disabled', false);
    }        
    // If the dropdown is set back to 0, disabled the button.
    else
        $('.action-ok').attr('disabled', true);
});

$('.action-ok').click(function(){    
    if($('.actions').val() == 0 || $('.regionid').val() == 0)
        $(this).popover('show');
    else if($('.actions').val() == 'delete' && $('.regionid').val() != 0) {
        $('.confirm-region').html($('.regionid').val());
        $('.deleteregion').val($('.regionid').val());
        $('.delete-confirm').modal('show');
    }
    else {
        $(this).on('hidden.bs.popover', function () {
            $('.action-ok').popover('hide');
        });
        $('.action-form').submit();
    }
});
$('.delete-confirm').on('shown.bs.modal', function () {
    $('.delete-confirm').focus();
    $('#modalLabel').html("Please confirm deletion");
    $('.delete-ok').addClass('hidden');
    $('.success-box').addClass('hidden');
    $('.delete-yes').removeClass('hidden');
    $('.delete-no').removeClass('hidden');
    $('.confirm-box').removeClass('hidden');
});
$('.delete-yes').click(function(){
    if($('.deleteregion').val() != undefined){
        var deleteregion = $('.deleteregion').val();
        var data = {deleteregion: deleteregion};

        $.ajax({
            type: 'POST',
            url: '/admin/tools/regions/index',
            data: data,
            dataType: 'json',
            success: function(response) {
                $('#modalLabel').html("Success");
                $('.delete-yes').addClass('hidden');
                $('.delete-no').addClass('hidden');
                $('.confirm-box').addClass('hidden');
                $('.delete-ok').removeClass('hidden');
                $('.success-box').removeClass('hidden');
                $("#"+deleteregion).remove();
            }
        });
    }
})

</script>
</body>
</html>