<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
error_reporting(0);

$UU = $_GET["UU"];

// get Billing Information
$SQL = "SELECT * FROM [07O1] WHERE AN='$UU' ";
$resultset=mssql_query($SQL, $con);
while ($row = mssql_fetch_array($resultset)) 
{
    $NCPY = $row['NCPY'];
    $AA1 = $row['AA1'];
    $AA2 = $row['AA2'];
    $ACI = $row['ACI'];
    $AST = $row['AST'];
    $AZ = $row['AZ'];
    $ACO = $row['ACO'];
    $AP = $row['AP'];
    $AM = $row['AM'];
    $DIV_NAME = $row['DIV_NAME'];
}

//get last Invoice #
$SQL2 = "SELECT MAX(id) AS last_id FROM anchorage_invoices";
$resultset2=mssql_query($SQL2, $con);
while ($row = mssql_fetch_array($resultset2)) 
{
    $last_id = $row['last_id'];
}

//get total
echo $total = 5.00;

//create new Invoice #
$ONUM = $last_id + 1;

//get first and last name
$DIV_NAMEparts = explode("_", $DIV_NAME);
$fnc = $DIV_NAMEparts[0];
$lnc = $DIV_NAMEparts[1];
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
    <h3>Billing Information</h3>
    <br>
        <button type="button" class="btn btn-success" id="clear">Clear Form</button>
    <br><br>

    <!-- FORM -->
    <form action="anet.php" method="post" onsubmit='return validatecardForm()'>
    <div class="form-group">
        <label for="fnc">First Name on credit/debit card:</label>
        <input type="text" class="form-control" id="fnc" name="x_first_name" value="<?php echo $fnc;?>" required>
    </div>
    <div class="form-group">
        <label for="lnc">Last Name on credit/debit card:</label>
        <input type="text" class="form-control" id="lnc" name="x_last_name" value="<?php echo $lnc;?>" required>
    </div>
    <div class="form-group">
        <label for="last4c">Last 4 digits of credit/debit card:</label>
        <input type="text" class="form-control" id="last4c" name="last4" maxlength='4' required>
    </div>
    <div class="form-group">
        <label for="a1c">Credit/debit card Address line 1:</label>
        <input type="text" class="form-control" id="a1c" name="x_address" value="<?php echo $AA1;?>" required>
    </div>
    <div class="form-group">
        <label for="a2c">Credit/debit card Address line 2 (optional):</label>
        <input type="text" class="form-control" name="a2" value="<?php echo $AA2;?>" id="a2c">
    </div>
    <div class="form-group">
        <label for="cityc">City:</label>
        <input type="text" class="form-control" id="cityc" name="x_city" value="<?php echo $ACI;?>" required>
    </div>
    <div class="form-group">
        <label for="statec">State:</label>
        <input type="text" class="form-control" id="statec" name="x_state" value="<?php echo $AST;?>" required>
    </div>
    <div class="form-group">
        <label for="zipc">Zip Code:</label>
        <input type="text" class="form-control" id="zipc" name="x_zip" value="<?php echo $AZ;?>" required>
    </div>
    <div class="form-group">
        <label for="countryc">Country:</label>
        <input type="text" class="form-control" id="countryc" name="x_country" value="<?php echo $ACO;?>" required>
    </div>
    <div class="form-group">
        <label for="phonec">Phone Number:</label>
        <input type="text" class="form-control" id="phonec" name="x_phone" value="<?php echo $AP;?>" required>
    </div>
    <div class="form-group">
        <label for="emailc">Email:</label>
        <input type="text" class="form-control" id="emailc" name="x_email" value="<?php echo $AM;?>" required>
    </div>
    <div class="form-group">
        <label for="confirmemailc">Confirm Email:</label>
        <input type="text" class="form-control" id="confirmemailc" value="<?php echo $AM;?>" required>
    </div>
    <div class="form-group">
        <label for="companyc">School/Company Name:</label>
        <input type="text" class="form-control" id="companyc" name="x_company" value="<?php echo $NCPY;?>" required>
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

    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <!-- FORM ENDS -->

</div>
<br><br><br><br><br>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
<style>
    #fnc, #lnc, #cityc, #statec, #countryc, #phonec, #emailc, #confirmemailc, #companyc {
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

$("#clear").click(function(){
    $(".form-control").val("");
});

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