<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Certificate Name Change Form</h1>
            </div>
			<br />
            <div class="row">
                <p>Please fill out the form below and we will contact you when the change is completed:</p>    
            </div>
			<br />
            <div class="row">
                <form>
                    <div class="form-group col-md-4">
                        <label for="">Certificate Date:</label>
                        <input type="text" class="form-control"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Certificate Number:</label>
                        <input type="text" class="form-control"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Current Name on Certificate:</label>
                        <input type="text" class="form-control"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Birthdate of Current Person on Certificate:</label>
                        <input type="text" class="form-control"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Address:</label>
                        <textarea type="text" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Phone Number:</label>
                        <input type="text" class="form-control"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Email Address:</label>
                        <input type="text" class="form-control"/>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">New Name to be on Certificate</label>
                        <input type="text" class="form-control"/>
                    </div>
                    <p class="text-info bg-info">Please fax a copy of your photo ID to 818-889-8798.</p>
                    <div class="form-group col-md-4">
                        <label for="">I certify that all of the information contained in this form is true and accurate to the best of my knowledge and that I am requesting this update of my Food Hander Certificate for myself.</label>
                        <input type="checkbox" class="form-control"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>