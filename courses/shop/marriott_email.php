<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/Mailer.php';
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

$AM = $_POST["email"];
if($AM){
session_start();
$NCPY = $_SESSION["checkcn"];
$invoice = $_SESSION["TAPONUM"];

//get product id
$SQL="SELECT PC FROM [07O4] WHERE OID = '$invoice' ";
$resultset=mssql_query($SQL, $con); 
while ($row = mssql_fetch_array($resultset)) 
{
    $PC = $row['PC'];
}

//get vendor code
$SQL45="SELECT VC FROM [07O2] WHERE OID ='$invoice' ";
$resultset45=mssql_query($SQL45, $con); 
while ($row = mssql_fetch_array($resultset45)) 
{
    $VC_check = $row['VC'];
}

//check if the customer works for one of the hotels that are part of Marriott
//check if one of the values from the array can be found on the company name
if($PC == "fs" && $NCPY)
{
    $company_name = $NCPY;
    $SQL200 = "SELECT hotel_name FROM [marriott_hotels] ";		
    $resultset200=mssql_query($SQL200, $con); 
    while ($row = mssql_fetch_array($resultset200)) 
    {
        $array_marriott_hotels[] = $row['hotel_name'];
    }   

    function check_cn_array($company_name){
        
        global $array_marriott_hotels;
        
        foreach ($array_marriott_hotels as $marriott_hotel){
            if (stripos($company_name,$marriott_hotel) !== false) {
                    return true;
            }
        }
        
    }

    $company_name_match = check_cn_array($company_name);
    // ENDS HERE
}


//email only for Marriott companies
if($VC_check == "marriott" && $PC == "fs" || $company_name_match === true && $PC == "fs")
{
    //email starts
    $from = "info@tapseries.com";
    $subject = "TAP Series Food Safety Manager Training Course";
    $cc_address = "dp@tapseries.com";

    $body = "<span>Greetings,</span><br><br>";

    $body .= "<span>Thank you for your order for the Foodservice Safety Manager Training Course.  The course will fulfill the Brand Standard requirement for Marriott's for food safety training. The course provides the necessary training to prepare your employees for the online ANSI proctored exam. The course can be taken on smartphones, tablets, or PC devices without needing to download any apps and users can switch between any of their devices while taking the course. There are 14 lessons and a TAP Series' online practice exam. Any lesson may be retaken.  We recommend that the employee earns a 90% or better on each lesson before sitting for the online ANSI proctored exam. There is a study guide available at the main menu of the course. The main menu is accessible after each lesson. Information on becoming a proctor can be found at <a href='http://www.tapseries.com/4u/marriott'>www.tapseries.com/4u/Marriott<a>.</span><br><br>";


    $body .= "For a wire transfer, there is an additional $15 fee. Please send an email requesting wire transfer instructions with your order number to sk@tapseries.com and the wire transfer instructions will be emailed to you. Once the wire transfer is received, your licenses will be added and an email will be sent to you to add your employees.<br><br>";

    $body .= "If you have any questions, please submit a ticket at <a href='https://www.tapseries.com/'>www.tapseries.com</a> by clicking on 'Need Help' or email us at sk@tapseries.com.<br><br>";

    $body .= "Stay calm and TAP on,<br>The TAP Series Team<br><br>";
    
    $body .= "Other TAP Series Courses at <a href='https://www.tapseries.com/'>www.tapseries.com</a>:<br>
            Alcohol Training<br>
            Allergen Friendly Series&reg; - Allergen Awareness&reg;, Allergen Plan Development, Allergen Plan Specialist<br>
            HACCP - ACF 15 Continuing Education hours.<br> 
            Cooking Basics - ACF 15 Continuing Education hours.<br> 
            Earn More With Service - ACF 15 Continuing Education hours.<br>  
            Strategies for Increasing Sales - ACF 15 Continuing Education hours.
            ";

    $smtp = new smtp_class;
    $smtp->host_name = 'smtp.gmail.com'; // Google mail host.
    $smtp->host_port = 465; // Secure port.
    $smtp->ssl = 1;
    $smtp->start_tls = 0;
    $smtp->localhost = 'tapseries.com';
    $smtp->direct_delivery = 0;
    $smtp->timeout = 10;
    $smtp->data_timeout = 0;
    $smtp->debug = 0;
    $smtp->html_debug = 0;
    $smtp->user = 'info@tapseries.com'; // Or orders@tapseries.com
    $smtp->password = 'Training0nline!'; // refer to salesforce or sticky note

    // Create a new array.
    $recipients = [];
    // Push your $email address to the array.
    array_push($recipients,$AM);

    $headers = [];
    array_push($headers,"Subject: ". $subject);
    array_push($headers,"To: " . $AM);
    array_push($headers,"Cc: " . $cc_address);
    array_push($headers,"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z"));
    array_push($headers, "Content-Type: text/html; charset=ISO-8859-1");
    // If you are going to send the email to more than one person, 
    // $to will need to be an array of the email addresses you want to send.
    $sent = $smtp->SendMessage($from, $recipients, $headers, $body); // This sends the email.
    /*
    if(!$sent)
        die($smtp -> error);
    */
    //email ends
}
}


?>