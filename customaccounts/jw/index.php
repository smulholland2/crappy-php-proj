<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
error_reporting(0); 
session_start();

$discode = $_SESSION["discode"];

if($discode == "jwpc"){
    $schoolname = "Johnson & Wales Providence Culinary";
    $like = "fsmcp";
}
if($discode == "jwhp"){
    $schoolname = "Johnson & Wales Providence Hospitality";
    $like = "fsmhp";
}
if($discode == "jwcc"){
    $schoolname = "Johnson & Wales Charlotte";
    $like = "fsmcc";
}
if($discode == "jwmiami"){
    $schoolname = "Johnson & Wales North Miami";
    $like = "fsmhm";
}
if($discode == "jwhd"){
    $schoolname = "Johnson & Wales Denver";
    $like = "fsmhd";
}
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
                <div class="alert alert-danger alert-dismissable fade in" <?php if(!$_SESSION["error_usernametaken"]){echo "style='display:none'";}?>>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><?php echo $_SESSION["error_usernametaken"]; ?></strong>
                </div>
                <div class="alert alert-danger alert-dismissable fade in" <?php if(!$_SESSION["error_storecode"]){echo "style='display:none'";}?>>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><?php echo $_SESSION["error_storecode"]; ?></strong>
                </div>
                <div class="alert alert-danger alert-dismissable fade in" <?php if(!$_SESSION["error_voucheractivated"]){echo "style='display:none'";}?>>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><?php echo $_SESSION["error_voucheractivated"]; ?></strong>
                </div>
            <div class="row">
                <p>Please enter the student's information.</p>
            </div>
			<br />
            <div class="row">
                 <form action='enroll.php' name='studentform' onsubmit='return validateForm()' method='POST'>
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger"></span> School Name:</label>
                            <input type="text" class="form-control" value="<?php echo $schoolname; ?>" disabled/>
                        </div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> Class Code:</label>
                            <select class="form-control" name="classcode" id="classcode" required>
                                    <option value=''>Select Class</option>
                            <?php
                                //get all the class codes that are part of this campus
                                $SQL = "SELECT DISTINCT AN FROM [07L3] WHERE AN LIKE '$like%' ";
                                $resultset=mssql_query($SQL, $con);
                                while ($row = mssql_fetch_array($resultset)) 
                                {
                                    $UA[] = $row['AN'];
                                }
                                natcasesort($UA);
                                foreach ($UA as $item) 
                                {
                                    $item = strtolower($item);
                                    echo "<option value='$item'>$item</option>";
                                }
                            ?>

                            </select>
                        </div>
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
                            <label for=""><span class="text-danger">*</span>Student Email:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION["email"]; ?>" name="email" id="email" maxlength="69" required/>
                        </div>  
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span>Confirm Student Email:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION["email"]; ?>" name="email2" id="email2" maxlength="69" required/>
                        </div>                    
                        
                    </div>
                    <div class="col-md-6">
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> Student Username:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION["username"]; ?>" name="username" id="username" maxlength="25" required />
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> Voucher Number:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION["password"]; ?>" name="password"  id="password" maxlength="24" required/>
                        </div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> Verify Voucher Number:</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION["password"]; ?>" name="password2"  id="password2" maxlength="24" required/>
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
    if($_SESSION["error_usernametaken"]){
       echo "document.getElementById('username').focus();";
       echo "document.getElementById('username').value = '';";
    }
    if($_SESSION["error_storecode"]){
       echo "document.getElementById('password2').value = '';";
       echo "document.getElementById('password').focus();";
    }
    if($_SESSION["error_voucheractivated"]){
       echo "document.getElementById('password2').value = '';";
       echo "document.getElementById('password').focus();";
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

    //make sure that Voucher Number and Verify Voucher Number are the same
    var d2 = document.forms["studentform"]["password2"].value;
    if(d != d2){
    alert("Please make sure Voucher Number is exactly the same as Verify Voucher Number");
    document.getElementById("password2").focus();
    return false;
    }

    //make sure Email and Confirm Email are the same
    var e = document.forms["studentform"]["email"].value;
    var e2 = document.forms["studentform"]["email2"].value;
    if(e != e2){
    alert("Please make sure Student Email is exactly the same as Confirm Student Email");
    document.getElementById("email2").focus();
    return false;
    }
	
}



$(document).ready(function(){
$("#email, #email2, #password, #password2").bind("cut copy paste",function(e) {
    e.preventDefault();
});
});


</script>
<?php 
    unset($_SESSION["firstname"]); 
    unset($_SESSION["lastname"]); 
    unset($_SESSION["email"]); 
    unset($_SESSION["username"]); 
    unset($_SESSION["password"]); 
    unset($_SESSION["lang"]); 

    unset($_SESSION["error_usernametaken"]); 
    unset($_SESSION["error_storecode"]); 
    unset($_SESSION["error_voucheractivated"]); 
?>

</body>
</html>