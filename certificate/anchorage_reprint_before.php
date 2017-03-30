<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
error_reporting(0);

//get last Invoice #
$SQL2 = "SELECT MAX(id) AS last_id FROM anchorage_invoices";
$resultset2=mssql_query($SQL2, $con);
while ($row = mssql_fetch_array($resultset2)) 
{
    $last_id = $row['last_id'];
}

//create new Invoice #
$ONUM = $last_id + 1;

//get total
$total = 5.00;

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Print Anchorage Certificate</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div class="container" style="margin-top:90px;min-height:800px">
    <div class="page-header">
        <h1>Print Anchorage, AK Food Handler Certificate</h1>
    </div>
    <div class="alert alert-info">
        <strong>The course was completed more than 30 days ago.</strong>
        <br><br>
        <p>In order to print the certificate you will have to pay a $5 fee.</p>
        <p>Please fill up the form below and click submit.</p>
    </div>

    <br>
    <form action="anet_before.php" method="post" onsubmit='return validatecardForm()'>
    <h3>Student Information</h3>
    <div class="form-group">
        <label for="cert_fn">First name of the student:</label>
        <input type="text" class="form-control" id="cert_fn" name="cert_fn" maxlength="50" required>
    </div>
    <div class="form-group">
        <label for="cert_ln">Last name of the student:</label>
        <input type="text" class="form-control" id="cert_ln" name="cert_ln" maxlength="50" required>
    </div>

<span><label>Date of birth:</label><br> 
    <select style='font-size:18px;margin-left:5px' id='cert_month' name='cert_month' required>
    <option value='' select>Month</option>
<?php		  
for ($monthnum = 1; $monthnum <= 12; $monthnum++) {
    echo "<option value='$monthnum'>$monthnum</option>";
} 
?>
    </select>		
    <select style='font-size:18px' id='cert_day' name='cert_day' required>
    <option value='' select>Day</option>	  
<?php	               
for ($daynum = 1; $daynum <= 31; $daynum++) 
{   
    echo "<option value='$daynum'>$daynum</option>";
} 
?>
    </select>
    <select style='font-size:18px' id='cert_year' name='cert_year' required>
    <option value='' select>Year</option>
<?php	              
for ($yearnum = 1915; $yearnum <= 2010; $yearnum++) {
    echo "<option value='$yearnum'>$yearnum</option>";
} 
?>
    </select>
</span>

    <br><br>
    <div class="form-group">
        <label for="cert_email">Email where we will send the certificate:</label>
        <input type="text" class="form-control" id="cert_email" name="cert_email" required>
    </div>

<br><br><br>

    <h3>Billing Information</h3>
    <br>

    <!-- FORM -->

    <div class="form-group">
        <label for="fnc">First Name on credit/debit card:</label>
        <input type="text" class="form-control" id="fnc" name="x_first_name" maxlength="50" required>
    </div>
    <div class="form-group">
        <label for="lnc">Last Name on credit/debit card:</label>
        <input type="text" class="form-control" id="lnc" name="x_last_name" maxlength="50" required>
    </div>
    <div class="form-group">
        <label for="last4c">Last 4 digits of credit/debit card:</label>
        <input type="text" class="form-control" id="last4c" name="last4" maxlength='4' required>
    </div>
    <div class="form-group">
        <label for="a1c">Credit/debit card Address line 1:</label>
        <input type="text" class="form-control" id="a1c" name="x_address" maxlength="50" required>
    </div>
    <div class="form-group">
        <label for="a2c">Credit/debit card Address line 2 (optional):</label>
        <input type="text" class="form-control" name="a2" id="a2c" maxlength="50">
    </div>
    <div class="form-group">
        <label for="cityc">City:</label>
        <input type="text" class="form-control" id="cityc" name="x_city" maxlength="50" required>
    </div>
    <div class="form-group">
        <label for="statec">State:</label>
        <input type="text" class="form-control" id="statec" name="x_state" maxlength="50" required>
    </div>
    <div class="form-group">
        <label for="zipc">Zip Code:</label>
        <input type="text" class="form-control" id="zipc" name="x_zip" maxlength="50" required>
    </div>
    <div class="form-group">
        <label for="countryc">Country:</label>
        <input type="text" class="form-control" id="countryc" name="x_country" maxlength="50" required>
    </div>
    <div class="form-group">
        <label for="phonec">Phone Number:</label>
        <input type="text" class="form-control" id="phonec" name="x_phone" maxlength="50" required>
    </div>
    <div class="form-group">
        <label for="emailc">Email:</label>
        <input type="text" class="form-control" id="emailc" name="x_email" maxlength="50" required>
    </div>
    <div class="form-group">
        <label for="confirmemailc">Confirm Email:</label>
        <input type="text" class="form-control" id="confirmemailc"  maxlength="50" required>
    </div>
    <div class="form-group">
        <label for="companyc">School/Company Name:</label>
        <input type="text" class="form-control" id="companyc" name="x_company" maxlength="50" required>
    </div>

    <!-- anet and receipt info -->
    <INPUT TYPE="hidden" NAME="x_version" VALUE="3.1">
    <INPUT TYPE="hidden" NAME="x_login" VALUE="1658573">
    <INPUT TYPE="hidden" NAME="x_show_form" VALUE="PAYMENT_FORM">
    <INPUT TYPE="hidden" NAME="x_method" VALUE="CC">
    <INPUT TYPE="hidden" NAME="x_amount" VALUE="<?php echo $total;?>">
    <INPUT TYPE="hidden" NAME="x_recurring_billing" VALUE="F">
    <INPUT TYPE="hidden" NAME="x_invoice_num" VALUE="<?php echo $ONUM;?>">
    <INPUT TYPE="hidden" NAME="UU" VALUE="<?php echo $UU;?>">
    <INPUT TYPE="hidden" NAME="x_description" VALUE="Print Anchorage, AK Food Handler Certificate">
    <!-- END anet and receipt info -->

    <span style="font-weight:bold;color:red">YOU ACCEPT NO REFUNDS ARE ALLOWED <input type="checkbox" required></span><br><br><br>

    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <!-- FORM ENDS -->

</div>
<br><br><br><br><br>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
<style>
    #fnc, #lnc, #cityc, #statec, #countryc, #phonec, #emailc, #confirmemailc, #companyc, #cert_fn, #cert_ln, #cert_email {
        max-width:300px;
    }
    #a1c, #a2c {
        max-width:450px;
    }
    #zipc, #last4c{
        max-width:100px;
    }
    .btn{
        border-color:white;
    }
    .btn-success{
        background-color: #5cb85c;
    }
</style>
<script>
$(document).ready(function(){

$('#emailc, #confirmemailc').bind("cut copy paste",function(e) {
    e.preventDefault();
});




});

function validatecardForm() {

    var emailc_valid = $("#emailc").val();
    var confirmemailc_valid = $("#confirmemailc").val();
    if(emailc_valid != confirmemailc_valid){
        alert("Please make sure Email is exactly the same as Confirm Email");
        document.getElementById("confirmemailc").focus();
        return false;
    }

    

}
</script>
</body>
</html>