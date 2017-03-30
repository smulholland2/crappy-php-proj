<?php
error_reporting(0); 
session_start();
//echo $_SESSION["account_username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Food Safety Training | TAP Series</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Add New Student</h1>
            </div>
                <div class="alert alert-danger alert-dismissable fade in" <?php if(!$_SESSION["usernametaken"]){echo "style='display:none'";}?>>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Please try another Student Username. Unfortunately the one you chose is already in use.</strong>
                </div>
            <div class="row">
                <p>Please enter the student's information.</p>
            </div>
			<br />
            <div class="row">
                 <form action='enroll.php' name='studentform' onsubmit='return validateForm()' method='POST'>
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> First Name:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION["firstname"]; ?>" name="firstname" id="firstname" maxlength="69" required/>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> Last Name:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION["lastname"]; ?>" name="lastname" id="lastname" maxlength="69" required/>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for="">Student Email:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION["email"]; ?>" name="email" maxlength="69" />
                        </div>                    
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> Student Username:</label>
                            <input type="text" class="form-control"  name="username" id="username" maxlength="25" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> Training Password:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION["password"]; ?>" name="password"  id="password" maxlength="24" required/>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> Training Program:</label>
                            <input type="text" class="form-control" name="coursename" value="Food Safety Manager Certification Training" disabled/>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for="lang"><span class="text-danger">*</span> Training Language:</label>
                            <select class="form-control" name="lang">
                                    <option value='ENGLISH' <?php if($_SESSION["lang"] == "ENGLISH"){echo "selected";}?>>English</option>
                                    <option value='SPANISH' <?php if($_SESSION["lang"] == "SPANISH"){echo "selected";}?>>Spanish</option>
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-group">
                        <p><span class="text-danger">*</span> - Required Field</p>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit"/>
                    </div>
                </form>
            </div>
			<br />
        </div>
    </div>
</div>
<script>

<?php 
    if($_SESSION["usernametaken"]){
       echo "document.getElementById('username').focus();";
    }
?>

function validateForm() {

	var hasNumber = /\d/;
    var alphaExp = /^[0-9a-zA-Z]+$/;

    var a = document.forms["studentform"]["firstname"].value;
	if(hasNumber.test(a)){  
	  document.getElementById("firstname").focus();
      alert('Numbers are not allowed on First Name'); 
      return false;  
    } 

	var b = document.forms["studentform"]["lastname"].value;
	if(hasNumber.test(b)){  
	document.getElementById("lastname").focus();
    alert('Numbers are not allowed on Last Name'); 
    return false;  
    } 

    var c = document.forms["studentform"]["username"].value;
    if(!c.match(alphaExp)){
    alert("Special characters or spaces are not allowed on Student Username");
    document.getElementById("username").focus();
	return false;
	}

    var d = document.forms["studentform"]["password"].value;
    if(!d.match(alphaExp)){
    alert("Special characters or spaces are not allowed on Training Password");
    document.getElementById("password").focus();
	return false;
	}
	
}
</script>
<?php 
    unset($_SESSION["firstname"]); 
    unset($_SESSION["lastname"]); 
    unset($_SESSION["email"]); 
    unset($_SESSION["username"]); 
    unset($_SESSION["password"]); 
    unset($_SESSION["lang"]); 
    unset($_SESSION["usernametaken"]); 
?>

</body>
</html>