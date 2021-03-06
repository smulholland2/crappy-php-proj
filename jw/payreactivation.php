<!DOCTYPE HTML>
<HTML lang='en'>
<HEAD>
	<TITLE>Processing...</TITLE>
	
</HEAD>
<BODY>

<!-- This section generates the "Submit Payment" button using PHP           -->
<?PHP
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);

// This sample code requires the mhash library for PHP versions older than
// 5.1.2 - http://hmhash.sourceforge.net/
	
// the parameters for the payment can be configured here
// the API Login ID and Transaction Key must be replaced with valid values
//$loginID		= "84UCt7RLh59e"; new
$loginID		= "6F7gs9Gw";
//$transactionKey = "589Dd3T94vjnqgXp"; new
$transactionKey = "83Mz5pW5dF6824fR";
$amount 		= $_POST['x_amount'];
//$amount = number_format(trim($_POST["x_amount"],"$"),2);
$description 	= $_POST["x_description"];
//$label 			= "Continue"; // The is the label on the 'submit' button

// By default, this sample code is designed to post to our test server for
// developer accounts: https://test.authorize.net/gateway/transact.dll
// for real accounts (even in test mode), please make sure that you are
// posting to: https://secure.authorize.net/gateway/transact.dll
$url	= "https://secure.authorize.net/gateway/transact.dll";



// an invoice is generated using the date and time
$invoice	= $_POST["x_invoice_num"];
// a sequence number is randomly generated
$sequence	= rand(1, 1000);
// a timestamp is generated
$timeStamp	= time ();

// The following lines generate the SIM fingerprint.  PHP versions 5.1.2 and
// newer have the necessary hmac function built in.  For older versions, it
// will try to use the mhash library.
if( phpversion() >= '5.1.2' )
{	$fingerprint = hash_hmac("md5", $loginID . "^" . $sequence . "^" . $timeStamp . "^" . $amount . "^", $transactionKey); }
else 
{ $fingerprint = bin2hex(mhash(MHASH_MD5, $loginID . "^" . $sequence . "^" . $timeStamp . "^" . $amount . "^", $transactionKey)); }



$x_company = $_POST['x_description'];
$x_description = $_POST['x_description'];
$x_invoice_num = $_POST['x_invoice_num'];
$x_first_name = $_POST['x_first_name'];
$x_last_name = $_POST['x_last_name'];
$x_address = $_POST['x_address'];
$x_city = $_POST['x_city'];
$x_state = $_POST['x_state'];
$x_zip = $_POST['x_zip'];
$x_country = 'U.S.A.';
$x_email = $_POST['x_email'];
$x_duplicate_window = 300;
$x_relay_URL = 'https://www.tapseries.com/jw/reactivationreceipt.php';
$Description = $_POST['Description'];
$ID = $_POST['ID'];


$SQL = "UPDATE JWReactivation	
			SET CCfn = '$x_first_name', CCln = '$x_last_name', CCaddress = '$x_address', CCcity = '$x_city', CCstate = '$x_state', CCzip = '$x_zip', CCcountry = '$x_country', CCemail = '$x_email' , CCcn = '$x_description' 
			
			WHERE Id = '$invoice' ";				
	$resultset=mssql_query($SQL, $con);


// Create the HTML form containing necessary SIM post values
echo "<FORM method='post' id='form' action='$url'  >";
// Additional fields can be added here as outlined in the SIM integration guide
// at: http://developer.authorize.net
echo "	<INPUT type='hidden' name='x_login' value='$loginID' />";
echo "	<INPUT type='hidden' name='x_amount' value='$amount' />";
echo "	<INPUT type='hidden' name='x_invoice_num' value='$x_invoice_num' />";
echo "	<INPUT type='hidden' name='x_company' value='$x_company' />";
echo "	<INPUT type='hidden' name='x_fp_sequence' value='$sequence' />";
echo "	<INPUT type='hidden' name='x_fp_timestamp' value='$timeStamp' />";
echo "	<INPUT type='hidden' name='x_fp_hash' value='$fingerprint' />";
echo "	<INPUT type='hidden' name='x_test_request' value='false' />";
echo "	<INPUT type='hidden' name='x_first_name' value='$x_first_name' />";
echo "	<INPUT type='hidden' name='x_last_name' value='$x_last_name' />";
echo "	<INPUT type='hidden' name='x_address' value='$x_address' />";
echo "	<INPUT type='hidden' name='x_city' value='$x_city' />";
echo "	<INPUT type='hidden' name='x_state' value='$x_state' />";
echo "	<INPUT type='hidden' name='x_zip' value='$x_zip' />";
echo "	<INPUT type='hidden' name='x_country' value='$x_country' />";
echo "	<INPUT type='hidden' name='x_email' value='$x_email' />";
echo "	<INPUT type='hidden' name='x_duplicate_window' value='$x_duplicate_window' />";
echo "	<INPUT type='hidden' name='x_email_customer' value='N' />";
echo "	<INPUT type='hidden' name='x_relay_response' value='Y' />";
//echo "	<INPUT type='hidden' name='x_line_item' value='$x_line_item' />";
echo "	<INPUT type='hidden' name='x_relay_URL' value='$x_relay_URL' />";
echo "	<INPUT type='hidden' name='x_relay_always' value='TRUE' />";
echo "	<INPUT type='hidden' name='Description' value='$Description' />";
echo "	<INPUT type='hidden' name='x_recurring_billing' value='F' />";
echo "	<INPUT type='hidden' name='x_method' value='CC' />";
echo "	<INPUT type='hidden' name='ID' value='$ID' />";
echo "	<INPUT TYPE=HIDDEN NAME='x_show_form' VALUE='PAYMENT_FORM'>";
echo "</FORM>";
echo "<script type='text/javascript'>document.getElementById('form').submit();</script>";
?>
<!-- This is the end of the code generating the "submit payment" button.    -->

</BODY>
</HTML>
