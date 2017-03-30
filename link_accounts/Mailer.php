<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/lib/Mail/smtp.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/lib/Mail/sasl.php";

    class Mailer
    {
        const SMTPHOST           = "smtp.emailsrvr.com";
        const SMTPPORT           = 25;
        const SMTPSSL            = 0;
        const LOCALHOST          = "tapseries.com";

        const ADDUSERBOT         = "info@tapseries.com";
        const ADDUSERPASS        = "needhelp";
        const ADDUSERSUB         = "TAP Series Online Course Codes and Access Information";

        public function Contact()
        {
            $this -> Send($data);
        }

        public function ForgotPassword($data)
        {
            $body = 'Hi,<br />' . $data["greeting"] . '<br />';
            $body .= '<p>We have recieved a request to reset your password.</p>';
            $body .= '<p><a href="';
            $body .= $data["body"]["host"];
            $body .= '&id=' . $data["body"]["id"];
            $body .= '&course=' . $data["body"]["course"];
            $body .= '&encrypt=' . $data["body"]["encrypt"]; 
            $body .= '">Click here to reset your password</a></p><br/><br/>';
            $body .= '<p>If you did not initiate this request, please ignore this message and contact TAP Series.<br />Thank you.</p>';
            
            unset($data["body"]);
            $data["body"] = $body;

            $this -> Send($data);
        }

        public function ForgotAdminPassword($data)
        {
            $body = 'Hi,<br />' . $data["greeting"] . '<br />';
            $body .= '<p>We have recieved a request to reset your password.</p>';
            $body .= '<p><a href="';
            $body .= $data["body"]["host"];
            $body .= '&id=' . $data["body"]["id"];
            $body .= '&type=' . $data["body"]["type"];
            $body .= '&encrypt=' . $data["body"]["encrypt"]; 
            $body .= '">Click here to reset your password</a></p><br/><br/>';
            $body .= '<p>If you did not initiate this request, please ignore this message and contact TAP Series.<br />Thank you.</p>';
            
            unset($data["body"]);
            $data["body"] = $body;

            $this -> Send($data);
        }

        public function CoursePassReport($data)
        {
            $this -> Send($data);
        }

        public function SchoolProgressReport($data)
        {
            $this -> Send($data);
        }

        public function BusinessProgressReport($data)
        {
            $this -> Send($data);
        }

        public function CartReciept($data)
        {
            $this -> Send($data);
        }

        public function AddedToCouse($data)
        {
            if(isset($_POST['adminemail']))
                $adminEmail = $_POST['adminemail'];
            else
                $adminEmail = '';

            $body = "Dear Student,";
            $body .= "You have been enrolled in the " . $_POST["coursename"] ." course<br /><br />";
            $body .= "Student full name: " . $_POST["firstname"] . " " . $_POST["lastname"] . "<br />";
            $body .= "Your user name is: " . $_POST["username"] . "<br />";
            $body .= "Your password is: " . $_POST["password"] . "<br /><br />";
            $body .= "<a href='http://tapseries.com/training'>Click here to start your training</a><br /><br />";
            $body .= "OR LATER<br /><br />";
            $body .= "Go to <a href='http://tapseries.com'>http://tapseries.com</a> and click <a href='http://tapseries.com/training'>LOGIN TO COURSE</a><br /><br />";            
            $body .= "For technical support, please call 888-826-5222 or go to <a href='http://tapseries.com'>http://tapseries.com</a><br />";
            $body .= "After hours technical support (8am-8pm Pacific time): 818-809-3762<br /><br />";
            $body .= "<p style='font-size:9px;'>100% money back of the purchase price, or credit to your corporate account, if returned within 30 days of enrollment, and if no more than lesson 1 has been studied. Courses are purchased as single use enrollments. Each lesson allows up to 5 reviews. After 5 reviews the lesson is closed. Courses are active for 180 days from date of enrollment and will stop functioning 180 days after the enrollment. Within the 180 day active period, the name of the student can be changed for a $20 fee for all courses except Food Handler, if a TAP Certificate of Achievement has NOT been awarded. Changing of the name will not re-activate any inactive, closed or ended functions. We reserve the right to charge a $5 fee for Food Handler name changes.</p>";
            $body .= "<a href='https://www.facebook.com/TAPSeries'>Become a fan of the TAP Series on Facebook!</a>";
            $student = Array(
                "smtpuser" => self::ADDUSERBOT,
                "smtppass" => self::ADDUSERPASS,
                "from"     => self::ADDUSERBOT,
                "to"       => $_POST['email'],
                "cc"       => $adminEmail,
                "subject"  => self::ADDUSERSUB,
                "body"     => $body,
            );

            $this -> Send($student);
        }

        public function MessageStudent($data)
        {
            $this -> Send($data);
        }

        private function Send($args)
        {
            $smtp = new smtp_class;

            $smtp->host_name = self::SMTPHOST;
            $smtp->host_port = self::SMTPPORT;
            $smtp->ssl = self::SMTPSSL;

            $smtp->start_tls = 0;
            $smtp->localhost = self::LOCALHOST;
            $smtp->direct_delivery = 0;
            $smtp->timeout = 10;
            $smtp->data_timeout = 0;

            $smtp->debug = 0;
            $smtp->html_debug = 0;
            $smtp->user = $args["smtpuser"];
            $smtp->password = $args["smtppass"];

            $headers = [];

            
            // Make the email strings into arrays so we can validate each one individually.
            $fromlist = explode(",", $args['from']);
            $from = $fromlist[0];
            array_push($headers,"From: " . $from);
            /*echo "TO: <br />";
            echo print(gettype($args['to'])) ."<br />";
            echo var_dump($args['to']) ."<br />";
            echo "CC: <br />";
            echo print(gettype($args['cc'])) ."<br />";
            echo var_dump($args['cc']) ."<br />";*/
            
            if(gettype($args['to']) == 'Array')
            {
                $tolist = explode(",", $args['to']);
                $to = '';
                for($i = 0; $i < count($tolist); $i++)
                {
                    $to .= "<".$tolist[$i].">,";
                }
                array_push($headers,"To: ".$to);
            }
            else
                array_push($headers,"To: ". $args['to']);

            /*if(gettype($args['cc']) == 'Array')
            {
                $cclist = explode(",", $args['cc']);
                $cc = '';
                for($i = 0; $i < count($cclist); $i++)
                {
                    $cc .= "<".$cclist[$i].">,";
                }
            }
            else
                array_push($headers,"Cc: ". $args['cc']);*/

            die(var_dump($headers));

            array_push($headers,"Subject: ". $args['subject']);
            array_push($headers,"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z"));
            array_push($headers, "Content-Type: text/html; charset=ISO-8859-1");
            die(var_dump($headers));
            $body = $args["body"];
            $sent = $smtp->SendMessage($from, $tolist, $headers, $body);

            if(!$sent)
                print("Could not send the message to $to.\nError: " . $smtp -> error . "\n");
        }
    }
?>