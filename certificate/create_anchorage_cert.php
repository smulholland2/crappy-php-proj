<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
error_reporting(0);

$invoice = $_GET["invoice"];

if($invoice){
    $SQL = "SELECT * FROM anchorage_invoices WHERE id='$invoice' ";
    $resultset=mssql_query($SQL, $con);
    while ($row = mssql_fetch_array($resultset)) 
    {
        $CERT_FN = $row['CERT_FN'];
        $CERT_LN = $row['CERT_LN'];
        $CERT_EMAIL = $row['CERT_EMAIL'];
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Anchorage Re-print Certificate</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  
<div class="container">

<form action="create_anchorage_cert_view.php" method="post" target="_blank">
        <div class="page-header">
            <h1>Re-print Anchorage Certificate</h1>
        </div>
        <div class="alert alert-info">
            <strong>Instructions</strong><br>
            <p>1. Go to the Excel file and find the student information (Z drive/Alaska Student List/ PremierAlaskaStudentList.xlsx).</p>
            <p>2. From the Excel file get the  <strong>Completion Date</strong> and <strong>Verification Code</strong>.</p>
            <p>3. After you create the certificate, send the certificate to the email that the student provided.</p>
            <p>4. After you send the certificate to the student, click <strong>"Email Sent"</strong>.</p>
        </div>
    <br>
    <label>Student email:</label>
    <span><?php echo $CERT_EMAIL;?></span>
    <br><br>
    <div class="form-group">
        <label for="cert_fn">First name of the student:</label>
        <input type="text" class="form-control" id="cert_fn" name="cert_fn" value="<?php echo $CERT_FN;?>" required>
    </div>
    <div class="form-group">
        <label for="cert_ln">Last name of the student:</label>
        <input type="text" class="form-control" id="cert_ln" name="cert_ln" value="<?php echo $CERT_LN;?>" required>
    </div>
    <div class="form-group">
        <label for="cert_number">Verification code (From Excel):</label>
        <input type="text" class="form-control" id="cert_number" name="cert_number" required>
    </div>
    
        <span><label>Completion date (From Excel):</label><br> 
        <select style='font-size:18px;margin-left:5px' id='completion_month' name='completion_month' required>
        <option value='' select>Month</option>
    <?php		  
    for ($monthnum = 1; $monthnum <= 12; $monthnum++) {
        echo "<option value='$monthnum'>$monthnum</option>";
    } 
    ?>
        </select>		
        <select style='font-size:18px' id='completion_day' name='completion_day' required>
        <option value='' select>Day</option>	  
    <?php	               
    for ($daynum = 1; $daynum <= 31; $daynum++) 
    {   
        echo "<option value='$daynum'>$daynum</option>";
    } 
    ?>
        </select>
        <select style='font-size:18px' id='completion_year' name='completion_year' required>
        <option value='' select>Year</option>
    <?php	              
    for ($yearnum = 1915; $yearnum <= 2019; $yearnum++) {
        echo "<option value='$yearnum'>$yearnum</option>";
    } 
    ?>
        </select>
    </span>
    <br><br>
    <input type="submit" class="btn btn-primary" value="Create Certificate">
<form>

<br><br><br>

<input type="hidden" id="invoicenumber" value="<?php echo $invoice;?>">
<butto class="btn btn-primary" id="emailsent">Email Sent</button>


</div>

<style>
    #cert_fn, #cert_ln, #cert_number {
        max-width:300px;
    }
</style>
<script>
$(document).ready(function(){
    $("#emailsent").click(function(){
        var invoice = $("#invoicenumber").val();
        $.ajax({
                url:'anchorage_email_sent.php',
                type: 'POST',
                data: {
                    invoice: invoice,
                },
                success: function(data){
                    alert(data);
                }
        })    
    });
});
</script>

</body>
</html>

