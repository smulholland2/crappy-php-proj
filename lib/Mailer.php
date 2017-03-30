<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/lib/Mail/smtp.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/lib/Mail/sasl.php";

    class Mailer
    {
        const SMTPHOST           = "smtp.gmail.com";
        const SMTPPORT           = 465;
        const SMTPSSL            = 1;
        const LOCALHOST          = "tapseries.com";

        const ADDUSERBOT         = "info@tapseries.com";
        const ADDUSERPASS        = "Training0nline!";
        const ADDUSERSUB         = "TAP Series Online Course Codes and Access Information";

        const REORDERBOT         = "orders@tapseries.com";
        const REORDERPASS        = "Order0nline!";
        const REORDERSUB         = "TAP Series Add License(s)";

        public function Contact()
        {
            $this -> Send($data);
        }

        public function ForgotPassword($data)
        {
            $body = 'Hi,<br />' . $data["greeting"] . '<br />';
            $body .= '<p>We have received a request to reset your password.</p>';
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
            $body .= '<p>We have received a request to reset your password.</p>';
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
            if(isset($data['email']))
            {
                $student = Array(
                    "smtpuser" => self::ADDUSERBOT,
                    "smtppass" => self::ADDUSERPASS,
                    "from"     => self::ADDUSERBOT,
                    "to"       => $data['email'],
                    "cc"       => $adminEmail,
                    "subject"  => self::ADDUSERSUB,
                    "body"     => $body,
                );
            }
            else
            {
                $student = Array(
                    "smtpuser" => self::ADDUSERBOT,
                    "smtppass" => self::ADDUSERPASS,
                    "from"     => self::ADDUSERBOT,
                    "to"       => $adminEmail,
                    "cc"       => null,
                    "subject"  => self::ADDUSERSUB,
                    "body"     => $body,
                );
            }

            $this -> Send($student);
        }

        public function ResendCredentials($data)
        {
            
            if(isset($data['adminemail']))
                $adminEmail = $data['adminemail'];
            else
                $adminEmail = '';

            $body = "Dear Student,";
            $body .= "You have been enrolled in the " . $data["coursename"] ." course<br /><br />";
            $body .= "Student full name: " . $data["firstname"] . " " . $data["lastname"] . "<br />";
            $body .= "Your user name is: " . $data["username"] . "<br />";
            $body .= "Your password is: " . $data["password"] . "<br /><br />";
            $body .= "<a href='http://tapseries.com/training'>Click here to start your training</a><br /><br />";
            $body .= "OR LATER<br /><br />";
            $body .= "Go to <a href='http://tapseries.com'>http://tapseries.com</a> and click <a href='http://tapseries.com/training'>LOGIN TO COURSE</a><br /><br />";            
            $body .= "For technical support, please call 888-826-5222 or go to <a href='http://tapseries.com'>http://tapseries.com</a><br />";
            $body .= "After hours technical support (8am-8pm Pacific time): 818-809-3762<br /><br />";
            $body .= "<p style='font-size:9px;'>100% money back of the purchase price, or credit to your corporate account, if returned within 30 days of enrollment, and if no more than lesson 1 has been studied. Courses are purchased as single use enrollments. Each lesson allows up to 5 reviews. After 5 reviews the lesson is closed. Courses are active for 180 days from date of enrollment and will stop functioning 180 days after the enrollment. Within the 180 day active period, the name of the student can be changed for a $20 fee for all courses except Food Handler, if a TAP Certificate of Achievement has NOT been awarded. Changing of the name will not re-activate any inactive, closed or ended functions. We reserve the right to charge a $5 fee for Food Handler name changes.</p>";
            $body .= "<a href='https://www.facebook.com/TAPSeries'>Become a fan of the TAP Series on Facebook!</a>";

            if(isset($data['email']))
            {
                $student = Array(
                    "smtpuser" => self::ADDUSERBOT,
                    "smtppass" => self::ADDUSERPASS,
                    "from"     => self::ADDUSERBOT,
                    "to"       => $data['email'],
                    "cc"       => $adminEmail,
                    "subject"  => self::ADDUSERSUB,
                    "body"     => $body,
                );
            }
            else
            {
                $student = Array(
                    "smtpuser" => self::ADDUSERBOT,
                    "smtppass" => self::ADDUSERPASS,
                    "from"     => self::ADDUSERBOT,
                    "to"       => $adminEmail,
                    "cc"       => null,
                    "subject"  => self::ADDUSERSUB,
                    "body"     => $body,
                );
            }

            $this -> Send($student);
        }

        public function MessageStudent($data)
        {
            $this -> Send($data);
        }

        public function SendInvoice($data)
        {
            $this -> Send($data);
        }

        public function SendLimitNote($data)
        {
            $body = '<table class="m_-2993456699692198185MsoNormalTable" border="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td colspan="2" style="background:#ffb400;padding:.75pt .75pt .75pt .75pt">
                                    <p class="MsoNormal">Account Information<u></u><u></u></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:.75pt .75pt .75pt .75pt">
                                    <p class="MsoNormal"><b>Login type</b> <i>(account/corp)</i>:<u></u><u></u></p>
                                </td>
                                <td style="padding:.75pt .75pt .75pt .75pt">
                                    <p class="MsoNormal">'.$data["type"].'<u></u><u></u></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:.75pt .75pt .75pt .75pt">
                                    <p class="MsoNormal"><b>Login username:</b><u></u><u></u></p>
                                </td>
                                <td style="padding:.75pt .75pt .75pt .75pt">
                                    <p class="MsoNormal">'.$data["user"].'<u></u><u></u></p>
                                </td>
                            </tr>                            
                            <tr>
                                <td colspan="2" style="padding:.75pt .75pt .75pt .75pt">
                                    <p class="MsoNormal">&nbsp;<u></u><u></u></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="background:#ffb400;padding:.75pt .75pt .75pt .75pt">
                                    <p class="MsoNormal">Order information:<u></u><u></u></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:.75pt .75pt .75pt .75pt">
                                    <p class="MsoNormal">Add '.$data["add"].' license(s) of '.$data["course"].'<u></u><u></u></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:.75pt .75pt .75pt .75pt">
                                    <p class="MsoNormal">Minimum license requirement: <u></u><u></u></p>
                                </td>
                                <td style="padding:.75pt .75pt .75pt .75pt">
                                    <p class="MsoNormal">'.$data["min"].'<u></u><u></u></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:.75pt .75pt .75pt .75pt">
                                    <p class="MsoNormal">Current number of license: <u></u><u></u></p>
                                </td>
                                <td style="padding:.75pt .75pt .75pt .75pt">
                                    <p class="MsoNormal">'.$data["remaining"].'<u></u><u></u></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding:.75pt .75pt .75pt .75pt">
                                    <p class="MsoNormal">&nbsp;<u></u><u></u></p>
                                </td>
                            </tr>                            
                        </tbody>
                    </table>';

                $reorder = Array(
                    "smtpuser" => self::REORDERBOT,
                    "smtppass" => self::REORDERPASS,
                    "from"     => self::REORDERBOT,
                    "to"       => self::REORDERBOT,
                    "cc"       => 'admin@tapseries.com',
                    "subject"  => self::REORDERSUB,
                    "body"     => $body,
                );

                $this -> Send($reorder);
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
            $recipients = [];

            
            // Make the email strings into arrays so we can validate each one individually.
            $fromlist = explode(",", $args['from']);
            $from = $fromlist[0];
            array_push($headers,"From: TAP Series<" . $from.">");
            /*echo "TO: <br />";
            echo print(gettype($args['to'])) ."<br />";
            echo var_dump($args['to']) ."<br />";
            echo "CC: <br />";
            echo print(gettype($args['cc'])) ."<br />";
            echo var_dump($args['cc']) ."<br />";*/

            $tolist = explode(",", $args['to']);

            for($i = 0; $i < count($tolist); $i++)
            {
                    array_push($recipients,$tolist[$i]);
                    array_push($headers,"To: " . $tolist[$i]);
            }
            /*if(gettype($args['to']) == 'Array')
            {
                for($i = 0; $i < count($tolist); $i++)
                {
                     array_push($recipients,$tolist[$i]);
                }    
            }
            else
                array_push($recipients,$args['to']);*/

            if(isset($args['cc']) && strlen($args['cc']) > 0)
            {
                if(gettype($args['cc']) == 'Array')
                {
                    $cclist = explode(",", $args['cc']);

                    for($i = 0; $i < count($cclist); $i++)
                    {
                        array_push($recipients,$cclist[$i]);
                        array_push($headers,"To: " . $cclist[$i]);
                    }
                }
                else
                {
                    array_push($recipients,$args['cc']);
                    array_push($headers,"To: " . $args['cc']);
                }
            }

            array_push($headers,"Subject: ". $args['subject']);
            array_push($headers,"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z"));
            array_push($headers, "Content-Type: text/html; charset=ISO-8859-1");

            $body = $args["body"];
            $sent = $smtp->SendMessage($from, $recipients, $headers, $body);

            /*if(!$sent)
                die($smtp -> error);//print("Could not send the message to $to.\nError: " . $smtp -> error . "\n");*/
            
        }
    }
?>