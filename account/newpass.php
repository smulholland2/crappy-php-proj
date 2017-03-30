<?
    // If there is no id, do not allow the user to access this page.
    // Redirect to the home page.    
    if(!isset($_GET["id"]))
    {
        header("Location:/");
        exit();
    }
    else
    {
        include_once $_SERVER['DOCUMENT_ROOT'].'/account/LoginController.php';

        $login = new LoginController();
        $validlink = $login -> ValidateLink();

        // Check the to see if the link exists and is active.
        if(!$validlink)
        {
            header("Location:/");
            exit();
        }

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
                <strong>To reset your password, please enter and confirm your new password in the boxes below:</strong>
            </div>
            <br />
            <div class="row">                
                <form class="col-md-6" method="POST" action="/account/passreset">
                    <input type="hidden" name="userid" value="<?php echo $_GET['id']; ?>"/>
                    <input type="hidden" name="course" value="<?php echo $_GET['course']; ?>"/>
                    <div class="form-group">
                        <label for="lname">New Password:</label>
                        <input type="password" class="form-control passwords" name="newpass" required />
                    </div>
                    <div class="form-group">
                        <label for="certnum">Confirm Password:</label>
                        <input type="password" class="form-control passwords" name="confirm" required />
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="" class="showpass">Click here to show the password</label>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit"/>
                    </div>
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