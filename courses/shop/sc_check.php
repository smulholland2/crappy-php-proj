<?php
error_reporting(0);

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 


session_start();
$corporate_username=$_SESSION["corporate_username"];
$corpVC=$_SESSION["corpVC"];

$newusername = $_SESSION["newusername"] ;
$newpassword = $_SESSION["newpassword"] ;
$existingusername = $_SESSION["existingusername"] ;
$existingpassword = $_SESSION["existingpassword"] ;

if($corporate_username && $corpVC)
{
	$SQL2 = "SELECT UC FROM [07L2] WHERE UU='$corporate_username' ";
	$resultset=mssql_query($SQL2, $con); 
	while ($row = mssql_fetch_array($resultset)) 
	{
		$checkPassword = $row['UC'];
	}

	$checkUsername = $corporate_username;
}
else
{
	if($newusername)
	{
		$checkUsername = $newusername;
		$checkPassword = $newpassword;
	}
	else
	{
		$checkUsername = $existingusername;
		$checkPassword = $existingpassword;
	}
}


	 $realTotal = $_SESSION["realTotal"];
	 $realTotalQTY = $_SESSION["realTotalQTY"];
	 $ONUMsess = $_SESSION["ONUM"];
	 $TAPONUMsess = $_SESSION["TAPONUM"];

$checkfn = $_SESSION["checkfn"];
$checkln = $_SESSION["checkln"];
$checkcn = $_SESSION["checkcn"];
$checkadd1 = $_SESSION["checkadd1"];
$checkadd2 = $_SESSION["checkadd2"];
$checkci = $_SESSION["checkci"];
$checkst = $_SESSION["checkst"];
$checkzip = $_SESSION["checkzip"];
$checkcou = $_SESSION["checkcou"];
$checkphone = $_SESSION["checkphone"];
$checkem = $_SESSION["checkem"];
	 
	 $date = date("m/d/Y");


echo "
<html>
<head>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans' />
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<link rel='stylesheet' type='text/css' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
</head>
<div id='wrapper'>

<h3 style='text-align:center'>TAP Series Order</h3>

<p style='text-align:center;'><button style='font-size:20px' onclick=printFunction()>Print Page</button></p>
<p style='text-align:center;'><button style='font-size:20px' class='sendinvoice' data-toggle='modal' data-target='#email-invoice'>Email Invoice</button></p>
<p style='text-align:center;'><button style='font-size:20px' onclick=gotoTAP()>Back to TAP Series</button></p>

<table id='invoice-table' style='border: 1px solid black; height: 119px;margin:auto;border-radius:3px'>

<tbody>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Order number</td>
</tr>
<tr style='height: 12px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$TAPONUMsess</td>
</tr>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Order date</td>
</tr>
<tr style='height: 12px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$date</td>
</tr>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Billing information</td>
</tr>
<tr style='height: 62px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 62px;' colspan='3'>
				   $checkfn $checkln<br>
				   $checkcn<br>
				   $checkadd1<br>				  
				   $checkadd2<br>				  
				   $checkci $checkst, $checkzip<br>
				   $checkcou<br>				   
				   $checkem<br>
				   $checkphone<br>
				   </td>
</tr>
<tr style='height: 34px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 34px; background-color: #0c7bab;' colspan='3'>
<p>Order details</p>
</td>
</tr>";
													
	$SQL="SELECT * FROM [07O4] WHERE OID = '$TAPONUMsess' ";
		$resultset=mssql_query($SQL, $con); 

		while ($row = mssql_fetch_array($resultset)) 
			{
				$OID = $row['OID'];
				$PC = $row['PC'];
				$PN = $row['PN'];
				$PRI = $row['PRI'];
				$NO = $row['NO'];

				$PRI = number_format($PRI,2);
	
echo "													
<tr style='height: 34px;'>												
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 34px;'>$PN</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 34px;text-align:center'>$NO</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 34px;'><span>$</span>$PRI</td>
</tr>

	
";
	}												

echo  "
<tr style='height: 12.3333px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 12.3333px;'>&nbsp;</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 12.3333px;'>Total:</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 12.3333px;'><span>$</span>$realTotal</td>
</tr>
</tbody>

</table>



<div id='un' style='width:90%;margin:auto'>
<span><span style='font-weight:bold'>Account Username:</span> $checkUsername</span>
<br>
<span><span style='font-weight:bold'>Account Password:</span> $checkPassword</span>
</div>

<br>


<div id='inst' style='width:90%;margin:auto'>

<span style='font-weight:bold'>Instructions to send check</span>
<br>
<span> <span style='font-weight:bold'>1.</span> Make check payable to: <span style='font-weight:bold'>TAP Series</span>.</span>
<br>
<span> <span style='font-weight:bold'>2.</span> Mail to: <span style='font-weight:bold'>5655 Lindero Canyon Road, Suite 501, Westlake Village, CA 91362</span>.</span>
<br>
<span> <span style='font-weight:bold'>3.</span> Please be sure to enclose a copy of this page with your check.  Keep one copy for yourself.</span>

<br><br>


<span style='font-weight:bold'>When your payment is received, your account will be activated and you will be notified by email.</span>
<br><br>
<span style='font-weight:bold'>Instructions after your account is activated</span>
<br>
<span> <span style='font-weight:bold'>1.</span> Go to <a href='https://www.tapseries.com/'>www.tapseries.com</a> and click on '<span style='font-weight:bold'>Administration</span>'.</span>
<br>
<span> <span style='font-weight:bold'>2.</span> Enter your account <span style='font-weight:bold'>username: $checkUsername</span> and <span style='font-weight:bold'>password: $checkPassword</span> and click '<span style='font-weight:bold'>Submit</span>'.</span>
<br>
<span> <span style='font-weight:bold'>3.</span> Select '<span style='font-weight:bold'>Add Students</span>' and on the next page, select the course, enter the number of students you want to add, and click Continue.</span>
<br>
<span> <span style='font-weight:bold'>4.</span> On the next page, enter the student's information.  After you fill up the form, click '<span style='font-weight:bold'>Submit</span>'.</span>
<br>

</div>

<p style='text-align:center;font-weight:bold'>Please email techsupport@tapseries.com, or call (818)-889-8799 for assistance. </p>

</div>
";

?>
<div class="modal fade" id="email-invoice" tabindex="-1" role="dialog" aria-labelledby="emailInvoiceLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="emailInvoiceLabel">Email this Invoice</h4>
      </div>
      <div class="modal-body">
        <div class="emailinvoiceForm">
            <p>
                Enter the e-mail address that you want to send a copy of this invoice to. You can resend the invoice to as many emails as you like.
            </p>
            <br />
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control email" name="email" required />
                    <input type="hidden" class="type" name="type" value="" required />
                </div>
            </form>
        </div>
        <div class="thankyou hidden">
            <h2>Success!</h2>
            <p>You have sent the invoice to <span class="sentto"></span>.</p>
            <p>Please check the email and follow the instructions to complete the transfer.</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger send-close" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success send">Submit</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<style>
button{
	border:none;
	background-color:#38507a;
	color:white;
	border-radius:3px;
	padding:5px 10px 5px 10px;
	cursor:pointer;
}
button:hover{
	background-color:#1E2B41
}
span{
	font-size:14px;
}

table{
	max-width:311px;
}
#wrapper{
	max-width:1000px;
	height:auto;
	border:1px solid #333;
	background-color:white;
	margin: auto;
	border-radius:5px;
	
}
body{
	background-color:#1E2B41;
	font-family: 'Open Sans', sans-serif;  
	font-size:15px;
}

</style>


<script>
function printFunction() {
    window.print();
}
function gotoTAP() {
    $.ajax({
        url:'/courses/shop/delete_all_svariables.php',
        type: "POST",
        data: {
        delete: 1,
        },
        success: function(data){
            console.log("Session variables where deleted.");
        },
        failure: function(data) {
            console.log("There was an error while deleting session variables.");
        }
    });

    window.location.href = '/';
}
//marriott message
$.ajax({
    url:'/courses/shop/marriott_email.php',
    type: "POST",
    data: {
    email: "<?php echo $checkem;?>",
    },
    success: function(data){
        console.log("Marriott email was sent.");
    },
    failure: function(data) {
        console.log("There was an error sending Marriott email.");
    }
});

//send invoice to Sandra when customers visit this page
$.ajax({
    url:'/courses/shop/sendinvoice.php',
    type: "POST",
    data: {
    email: "sk@tapseries.com",
    },
    success: function(data){
        console.log("Email with receipt was sent.");
    },
    failure: function(data) {
        console.log("There was an error sending the email.");
    }
});

	$('.sendinvoice').click(function(){
        $('.send').removeClass('hidden');
        $('.emailinvoiceForm').removeClass('hidden');
        $('.thankyou').addClass('hidden');
        $('.send-close').html('Cancel');
        $('.sentto').html();
    });

    $('.send').click(function(e){
        e.preventDefault();

        var emailinfo = [];
        emailinfo["email"] = $('.email').val();
        emailinfo["message"] = $('#invoice-table').html();
		var data = { 
			email: emailinfo["email"],
			message: emailinfo["message"]
		};
        $.ajax({
            url:'/courses/shop/sendinvoice',
            type: "POST",
            data: data,
            success: function(data){
                $('.emailinvoiceForm').addClass('hidden');
                $('.thankyou').removeClass('hidden');
                $('.send-close').html('Close');
                $('.send').addClass('hidden');
                $('.sentto').html(emailinfo["email"]);
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