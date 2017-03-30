<?
    // If there is no id, do not allow the user to access this page.
    // Redirect to the home page.
    if(!isset($_POST["userid"]))
        header("Location:/");
    if(!isset($_POST["newpass"]) || !isset($_POST["confirm"]))
        header("Location:" . $_SERVER['HTTP_REFERER']);
    else
    {
        include_once $_SERVER['DOCUMENT_ROOT'].'/account/LoginController.php';
        $login = new LoginController();
        $login -> ResetPassword();
    }
?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Password Reset Form</h1>
            </div>
			<br />
            <div class="row">
                <strong>SUCESS!</strong>
            </div>
            <br />
            <div class="row">                
                <p>Congratulations, your password has been reset.</p>
                <p><a href="/training">Click here</a> to login to your course, or if you are an administrator, click the button below.</p>
                <p>Thank you.</p>
                <div class="form-group">
                    <a href="/account/login" class="btn btn-primary">Administator Login</a>
                </div>
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
<script>    
    $('.showpass').change(function() {
        console.log("checked");
        // this will contain a reference to the checkbox   
        if (this.checked) {
            $('.passwords').attr('type','text');
        } else {
            $('.passwords').attr('type','password');
        }
    });
</script>
</body>
</html>