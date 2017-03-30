<?php
error_reporting(0);

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

$cyear = date("Y");	
session_start();

$wrongextun = $_GET["wrongextun"];
$realTotal=$_SESSION["realTotal"];

$discode=$_SESSION["discode"];
$price_discode=$_SESSION["price_discode"];

if($wrongextun){
	echo "<input type='hidden' id='wrongextun' value='yes'>";
}

?>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans' />
<meta name='viewport' content='width=device-width, initial-scale=1.0'>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>

<div id='wrapper'>
<h3 style='text-align:center'>Sign in</h3>


<?php 
	/*
	if(isset($_SESSION["error"])) {
		$return_errs = '<div class="alert alert-danger" role="alert">There were errors with your input:<ul>';
		for($i = 0; $i < count($_SESSION['error']); $i++) {
			$return_errs .= '<li>'.$_SESSION['error'][$i].'</li>';
		}
		$return_errs .= '</ul></div>';
		echo $return_errs;
	}
	*/
?>



<div id='signin'>
<div id='topsignin'>
<div id='newcustomer'>
<p style='text-align:center;font-weight:bold;margin-top:18px'>New Customer</p>
</div>
<div id='existingcustomer'>
<p style='text-align:center;font-weight:bold;margin-top:18px' id='excumobile'>Existing Customer</p>
</div>
</div>
<div id='newbody'>
<div id='new_form_part'>
<span style='font-size:15px'>Type in a new username and password below.<br>-Enter alphabet characters and/or numbers only.<br>-No spaces or special characters.
</span>

<form style='margin-top:15px' name='newform' action='sc_infovar.php' onsubmit='return validatenewForm()' method='post'>

<div class='form-group'>
<?php if ($discode=="cps" || $discode=="cpsfsm") { ?>
<label>CPS Employee ID number</label>
<?php } else { ?>
<label>Username</label>

<?php } ?>
<input class='form-control' id='newusername' name='newusername' type='text' style='font-size:20px'  maxlength="12"
value=<?php echo isset($_SESSION["newusername"]) ? $_SESSION["newusername"]: false; ?> >
</div>
<div id='errormsg' style='width:100%;background-color:#d9edf7;height:auto;margin-top:-15px'>
</div>

<br>
<div class='form-group'>
<label>Password</label>
<input class='form-control' type='text' style='font-size:20px' maxlength='12' id='newpassword' name='newpassword' value="<?php echo $_SESSION['newpasswordused']; ?>">
</div>

<div class='form-group' style='margin-bottom:25px'>
<label>Confirm Password</label>
<input class='form-control' type='text' style='font-size:20px' maxlength='12' id='newcpassword' name='newcpassword' value='<?php echo $_SESSION['newpasswordused']; ?>'>
</div>

<?php 
if($discode && $price_discode){
	$SQL0 = "SELECT id, INF, INL FROM [07SL4] WHERE VC='$price_discode' ";
}
if($discode && !$price_discode){
	$SQL0 = "SELECT id, INF, INL FROM [07SL4] WHERE VC='$discode' ";
}
	$resultset0=mssql_query($SQL0, $con);
	while ($row = mssql_fetch_array($resultset0)) 
	{
		$valid_id = $row['id'];
	}
?>

<!-- only show if 4u page has multiple instructors -->
<div class='form-group' <?php if($valid_id){echo "style='margin-bottom:25px;display:block'";}else{echo "style='display:none'";}?>>
<label>Instructor/Course</label>
	<br>
	<?php 
	echo "<select style='width:100%' name='PRO_4u'>";
	if($discode && $price_discode){
		$SQL = "SELECT id, INF, INL FROM [07SL4] WHERE VC='$price_discode' ";
	}
	if($discode && !$price_discode){
		$SQL = "SELECT id, INF, INL FROM [07SL4] WHERE VC='$discode' ";
	}
	$resultset=mssql_query($SQL, $con);
	
	while ($row = mssql_fetch_array($resultset)) 
	{
	$id = $row['id'];
	$INF = $row['INF'];
	$INL = $row['INL'];	
	echo "<option value='$id'>$INL, $INF</option>";
	}
	echo "</select>";
	?>	
	
</div>


<span style='font-weight:bold'>Click who this training is for:</span>
<br>
<input type='radio' style='margin-top:20px' name='whosbuying' value='single' checked> Is this training for you?
<br>
<input type='radio' name='whosbuying' value='multiple'> Are you buying this training for someone else?

<button id='newbtn' type='submit' style='margin-top:20px'>Sign in</button>
</form>
</div>
</div>
<div id='existingbody'>
<div id='existing_form_part'>

<?php
if($wrongextun){
	echo "<div id='extunnotmsg' style='width:100%;/* height: 30px; */color: #31708f;border: 1px solid transparent;background-color: #d9edf7;'><span style='color:#31708f;font-size:16px'>$wrongextun</span></div>";
	echo "<br>";
}


echo "
<span style='font-size:15px'>Type in your existing username and password below.</span>
<br>
<form name='existingform' action='sc_infovar.php' onsubmit='return validateexistingForm()' method='post'>
<br>

<div class='form-group'>
<label>Username</label>
<input class='form-control' type='text' style='font-size:20px' id='existingusername' name='existingusername' maxlength='25'>
</div>

<div class='form-group'>
<label>Password</label>
<input class='form-control' type='text' style='font-size:20px' id='existingpassword' name='existingpassword' maxlength='24'>
</div>

<button id='existingbtn' type='submit' style='margin-top:30px'>Sign in</button>
</form>

<p style='font-weight:bold;font-size:15px;text-align:right'><a href='#' data-toggle='modal' data-target='#forgot-password' class='forgotpass' style='text-decoration:none;color:#008abf'>Forgot your username and/or password?</a></p>
</div>
</div>
</div>
<p style='text-align:center'><strong>&#169; Copyright $cyear TAP Series, LLC <br><a style='text-decoration:none' href='/home/privacy'>Privacy Policy</a></strong></p>
</div>
";

?>

<!-- Modal -->
  <div class="modal fade" id="myModal_unmessage" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Error Message</h4>
        </div>
        <div class="modal-body">
          <p><?php echo $_SESSION["unmessage"]; ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal END-->

<!-- Modal -->
<div class="modal fade" id="forgot-password" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="forgotPasswordLabel">Forgot Password</h4>
      </div>
      <div class="modal-body">
        <div class="forgotform">
            <p>
                Enter your e-mail address that you used when purchasing the course.Your account administrator user name and a password reset link will be e-mailed to you.
            </p>
            <br />
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control email" name="email" required />
                </div>
            </form>
        </div>
        <div class="thankyou hidden">
            <h2>Success!</h2>
            <p>Thank you, your password reset link has been emailed to <span class="sentto"></span>.</p>
            <p>Please check your email and follow the instructions to reset your password.</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger submit-close" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success submitpass">Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal ENDS-->

<script>
$(document).ready(function(){
   
        $("#existingbody").hide();
		$("#existingcustomer").css({"background-color": "#1E2B41", "color": "white"});
		$("#existingusername, #existingpassword").val("");
	
		var wrongextun = $('#wrongextun').val();
			if(wrongextun=='yes')
			{
				$("#newcustomer").css({"background-color": "#1E2B41", "color": "white"});
				$("#existingcustomer").css({"background-color": "white", "color": "black"});
				$("#existingbody").show();
				$("#newbody").hide();
				$("#newusername, #newpassword, #newcpassword").val("");
			}
	
		
		$("#newcustomer").click(function(){
			$("#existingcustomer").css({"background-color": "#1E2B41", "color": "white"});
			$("#newcustomer").css({"background-color": "white", "color": "black"});
			$("#newbody").show();
			$("#existingbody").hide();
			$("#existingusername, #existingpassword").val("");
		});
		
		$("#existingcustomer").click(function(){
			$("#newcustomer").css({"background-color": "#1E2B41", "color": "white"});
			$("#existingcustomer").css({"background-color": "white", "color": "black"});
			$("#existingbody").show();
			$("#newbody").hide();
			$("#newusername, #newpassword, #newcpassword").val("");
		});

<?php
if(isset($_SESSION["unmessage"])){
echo "$('#myModal_unmessage').modal('show');";

}
?>
		
		
    
});
</script>



<script>


function validatenewForm() {
	
	var alphaExp = /^[0-9a-zA-Z]+$/;
	
	//won't go to the next page if username is empty or has special characters
    var x = document.forms["newform"]["newusername"].value;
    if (x == null || x == "") {
        alert("Username must be filled out");
		document.getElementById("newusername").focus();
        return false;
    }
	if(!x.match(alphaExp)){
		alert("Username contains special characters or spaces");
		document.getElementById("newusername").focus();
	return false;
	}
	//won't go to the next page if password is empty or has special characters
	var y = document.forms["newform"]["newpassword"].value;
    if (y == null || y == "") {
        alert("Password must be filled out");
		document.getElementById("newpassword").focus();
        return false;
    }
	if(!y.match(alphaExp)){
		alert("Password contains special characters or spaces");
		document.getElementById("newpassword").focus();
	return false;
	}
	
	//won't go to the next page if confimr password is empty or has special characters
	var z = document.forms["newform"]["newcpassword"].value;
    if (z == null || z == "") {
        alert("Confirm Password must be filled out");
		document.getElementById("newcpassword").focus();
        return false;
    }
	if(!z.match(alphaExp)){
		alert("Confirm Password contains special characters or spaces");
		document.getElementById("newcpassword").focus();
	return false;
	}
	
	
	//won't go to the next page if password and confirm password are not the same
	if(y!=z){
		alert("Please make sure Password is exactly the same as Confirm Password");
		document.getElementById("newcpassword").focus();
        return false;
	}
	
}
function validateexistingForm() {
	
	//won't go to the next page if username is empty or has special characters
    var m = document.forms["existingform"]["existingusername"].value;
    if (m == null || m == "") {
        alert("Username must be filled out");
		document.getElementById("existingusername").focus();
        return false;
    }
	
	//won't go to the next page if password is empty or has special characters
	var l = document.forms["existingform"]["existingpassword"].value;
    if (l == null || l == "") {
        alert("Password must be filled out");
		document.getElementById("existingpassword").focus();
        return false;
    }
	
}


    $('.forgotpass').click(function(){
        $('.submitpass').removeClass('hidden');
        $('.forgotform').removeClass('hidden');
        $('.thankyou').addClass('hidden');
        $('.submit-close').html('Cancel');
        $('.sentto').html();
    });

    $('.submitpass').click(function(e){
        e.preventDefault();

        var admininfo = [];
        admininfo["email"] = $('.email').val();
        $.ajax({
            url:'/account/resetrequest',
            type: "POST",
            data: { 
                email: admininfo["email"],
                type: "07O6"
            },
            success: function(data){
                $('.forgotform').addClass('hidden');
                $('.thankyou').removeClass('hidden');
                $('.submit-close').html('Close');
                $('.submitpass').addClass('hidden');
                $('.sentto').html(admininfo["email"]);
				console.log(data);
            },
            failure: function(data) {
                consol.log("fail:" + data);
            }
        });
    });



<?php
if($_SESSION["discode"]=="ol2"){
    echo "  
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-90592116-1', 'auto');
            ga('send', 'pageview');
        ";    
}
?>




</script>



<style>
#shc{
	border:1px solid transparent;
	background-color:#333;
	height:50px;
	color:white;
	width:150px;
	margin-left:-1px;
	border-top-right-radius:10px;
	border-bottom-right-radius:10px;
	-webkit-transition: width 2s; /* For Safari 3.1 to 6.0 */
    transition: width 2s;
}
#shc:hover{
	background-color:#404040;
	width: 180px;
}
#existingbtn{
	width:100%;
	height:50px;
	background-color: #1E2B41;
	border:none;
	color:white;
	font-size:20px;
	border-radius:3px;
	cursor:pointer;
}
#existingbtn:hover{
	background-color:#182234;
}
#existing_form_part{
	width:80%;
	height:auto;
	border:1px solid transparent;
	margin:40px auto;
}
#newbtn{
	width:100%;
	height:50px;
	background-color: #1E2B41;
	border:none;
	color:white;
	font-size:20px;
	border-radius:3px;
	cursor:pointer;
}
#newbtn:hover{
	background-color:#182234;
}
#new_form_part{
	width:80%;
	height:auto;
	border:1px solid transparent;
	margin:20px auto;
}
#newbody{
	width:99%;
	height:auto;
	border:1px solid transparent;
	background-color:white;
}
#existingbody{
	width:99%;
	height:auto;
	border:1px solid transparent;
	background-color:white;
}
#existingcustomer{
	width:50%;
	height:70px;
	float:left;
	border:1px solid transparent;
	margin-top:-1px;
	margin-right:-3px;
}
#newcustomer{
	width:49%;
	height:70px;
	border:1px solid transparent;
	float:left;
	margin-top:-1px;
	margin-left:-1px;
}
#topsignin{
	width:102%;
	height:70px;
	border:1px solid transparent;
	cursor:pointer;
	
}
#signin{
	max-width:500px;
	height:auto;
	border:1px solid #1E2B41;
	margin:20px auto;
	border-radius:5px;
	overflow:hidden;
	
}
#wrapper{
	max-width:1000px;
	height:auto;
	border:1px solid white;
	background-color:white;
	margin:30px auto;
	border-radius:5px;
}
body{
	background-color:white;
	font-family: 'Open Sans', sans-serif;  
	font-size:20px;
}
@media only screen and (max-width: 355px) {
	#excumobile{
		margin-top:5px !important;
		}
}
</style>

<?php
unset ($_SESSION['unmessage']);
unset ($_SESSION['newpasswordused']);
//print_r($_SESSION);
?>
