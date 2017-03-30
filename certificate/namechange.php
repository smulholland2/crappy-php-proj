<?php

    include $_SERVER['DOCUMENT_ROOT'].'/certificate/CertificateController.php';

    if(isset($_POST))
    {
        $certificate = new CertificateController();

        $request = $certificate -> NameChangeRequest();
    }

?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php'; ?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Certificate Name Change Request</small></h1>
            </div>
            <div class="form-errors row col-md-6 col-md-offset-3 <?php echo isset($_SESSION["error"]) ? 'error': 'hidden' ?>">
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>ERROR:</strong> Please fix the following erros and try agian.<ul class="error-list"></ul>
                </div>
            </div>
			<br />
            <div class="row">
                <form class="name-change-form">
                    <div class="col-sm-6">
                        <div class="form-group col-sm-12">
                            <label for="date">Certificate Date:</label>
                            <input type="text" name="date" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-12">
                            <label for="number">Certificate Number:</label>
                            <input type="text" name="number" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-12">
                            <label for="name">Current Name on Certificate:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>
                        <div>
                            <label for="dob" class="form-group col-sm-12">Date of Birth:</label>                        
                            <div class="date-picker dob-picker"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-12">
                            <label for="address">Address:</label>
                            <textarea name="address" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-12">
                            <label for="phone">Phone Number: (xxx-xxx-xxxx)</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-sm-6">                        
                        <div class="form-group col-sm-12">
                            <label for="email">Email Address: (name@company.com)</label>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-12">
                            <label for="newname">New Name to be on Certificate:</label>
                            <input type="text" name="newname" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-12">
                            <label for="reason">Reason for Name Change:</label>
                            <input type="text" name="reason" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-12">
                            <p><strong>Please fax a copy of your photo ID to 818-889-8798.</strong></p>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-sm-12 well">
                            <div class="checkbox">
                                <p>I certify that all of the information contained in this form is true and accurate to the best of my knowledge and that I am requesting this update of my Food Hander Certificate for myself.</p>
                                <hr />
                                <label><input type="checkbox" name="agree" value="1">I Agree</label>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>                    
                </form>
                <hr>
                <div class="form-group col-sm-12">
                    <button class="btn btn-primary submit">Submit</button>
                </div>
            </div>
			<br />
        </div>        
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="request-recieved" tabindex="-1" role="dialog" aria-labelledby="requestRecievedLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="requestRecievedLabel">Request Recieved</h4>
      </div>
      <div class="modal-body">
        <p>Thank you, your name change request has been sent to our technical support team. We will contact you shortly.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary request-ok" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
<script>

    $('.submit').click(function(e){
        e.preventDefault();
        var errs = [];

        if($('input[name="date"]').val() == '')
        {
            var err = {control: 'date', msg: 'Certificate date is required' };
            errs.push(err);
        }

        if($('input[name="number"]').val() == '')
        {
            var err = {control: 'number', msg: 'Certificate number is required' };
            errs.push(err);
        }

        if($('input[name="name"]').val() == '')
        {
            var err = {control: 'name', msg: 'Student name is required' };
            errs.push(err);
        }

        if($('input[name="phone"]').val() == '')
        {
            var err = {control: 'phone', msg: 'Phone number is required' };
            errs.push(err);
        }

        if($('input[name="email"]').val() == '')
        {
            var err = {control: 'email', msg: 'Email is required' };
            errs.push(err);
        }

        if($('input[name="reason"]').val() == '')
        {
            var err = {control: 'reason', msg: 'Name change reason is required' };
            errs.push(err);
        }

        if($('input[name="newname"]').val() == '')
        {
            var err = {control: 'newname', msg: 'New Name is required' };
            errs.push(err);
        }

        if($('input[name="agree"]').val() == '')
        {
            var err = {control: 'agree', msg: 'You must agress to the terms' };
            errs.push(err);
        }

        if($('textarea[name="address"]').val() == '')
        {
            var err = {control: 'address', msg: 'Address is required' };
            errs.push(err);
        }

        if($('select[name="month"]').val() == '')
        {
            var err = {control: 'month', msg: 'Birth month is required' };
            errs.push(err);
        }

        if($('select[name="day"]').val() == '')
        {
            var err = {control: 'day', msg: 'Birth day is required' };
            errs.push(err);
        }

        if($('select[name="year"]').val() == '')
        {
            var err = {control: 'year', msg: 'Birth year is required' };
            errs.push(err);
        }

        if(errs.length > 0)
        {
            for(var i = 0; i < errs.length; i++)
            {
                $('.error-list').append('<li>'+errs[i]+'</li>');
            }

            $('.form-errors').removeClass('hidden');
        }
        else
        {
            var data = {
                date: $('input[name="date"]').val(),
                number: $('input[name="number"]').val(),
                name: $('input[name="name"]').val(),
                phone: $('input[name="phone"]').val(),
                email: $('input[name="email"]').val(),
                reason: $('input[name="reason"]').val(),
                newname: $('input[name="newname"]').val(),
                address: $('textarea[name="address"]').val(),
                month: $('select[name="month"]').val(),
                day: $('select[name="day"]').val(),
                year: $('select[name="year"]').val(),
            };

            $.ajax({
                type: 'POST',
                url: '/certificate/namechange',
                data: data,
                success: function(){
                    $('#request-recieved').modal('show');
                }
            });
        }
    });

    $('.request-ok').click(function(){
        window.location.href="/certificate";
    });

</script>
</body>
</html>