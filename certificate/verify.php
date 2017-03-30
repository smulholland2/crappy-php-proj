<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Certificate Verification</h1>
            </div>
			<br />
            <div class="row">
                <strong>To verify the validity of a TAP Series Food Handler certificate, please enter your information in the boxes below:</strong>
                <br />
                <span>If you do not have a certificate number, <a href="/certificate">click here to print your certificate.</a></span>
            </div>
            <br />
            <div class="row">                
                <form class="col-md-6">
                    <div class="form-group">
                        <label for="lname">Last name:</label>
                        <input type="text" class="form-control" name="lname"/>
                    </div>
                    <div class="form-group">
                        <label for="certnum">Certificate number (including first abbreviation):</label>
                        <input type="text" class="form-control" name="certnum"/>
                    </div>
                    <a href="corporate_admin_logout.asp" class="btn btn-primary">Submit</a>
                </form>
            </div>
            <br />
            <div class="row">
                <div class="alert alert-info alert-dismissible fade in" role="alert">                
                If you need further assistance, please call technical support at <a href="tel:8888265222" class="visible-xs">888-826-5222</a><span class="hidden-xs">888-826-5222</a></span>
                </div>
            </div>
        </div>        
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>