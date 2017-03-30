<?php
error_reporting(0);

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);

$UA = $_GET['UA'];
$invoice = $_GET['invoice'];
$total = $_GET['total'];
$last4 = $_GET['last4'];
$LK = $_GET['LK'];
$corp = $_GET['corp'];
$oh2_id = $_GET['oh2_id'];

$date = date("m/d/Y");

// was conflicting
//$total = number_format($total,2);


				if($corp)
				{
					//get AN information ex. address etc from Billing Table
					$SQL33="SELECT * FROM [07L2] WHERE UU ='$UA' ";
						$resultset33=mssql_query($SQL33, $con); 

						while ($row = mssql_fetch_array($resultset33)) 
					{
					     $NF = $row['NF'];
					     $NL = $row['NL'];
					     $NCPY = $row['UA'];
					     $AA1 = $row['AA1'];
					     $AA2 = $row['AA2'];
					     $ACI = $row['ACI'];
					     $AST = $row['AST'];
					     $AZ = $row['AZ'];
					     $ACO = $row['ACO'];
					     $AP = $row['AP'];
					     $AM = $row['UM'];
					} 

					 $NCON = $NF. " " .$NL;

					//get vendor name
					$SQL45="SELECT VC FROM [07O2] WHERE OID ='$invoice' ";
					$resultset45=mssql_query($SQL45, $con); 
					while ($row = mssql_fetch_array($resultset45)) 
					{
						$VC_check = $row['VC'];
					}
					if($VC_check){
						$SQL46="SELECT NC FROM [07SL1C] WHERE VC ='$VC_check' ";
						$resultset46=mssql_query($SQL46, $con); 
						while ($row = mssql_fetch_array($resultset46)) 
						{
							$vendor_name = $row['NC'];
						}
					}
					else{
						$vendor_name = "TAP Series";
					}		

				}
				else
				{


                    //get AN information ex. address etc
                    $SQL="SELECT NCON, NCPY, AA1, AA2, ACI, AST, AZ, ACO, AP, AM FROM [07O1] WHERE AN ='$UA' ";
                    $resultset=mssql_query($SQL, $con); 

                        while ($row = mssql_fetch_array($resultset)) 
                        {
                            $NCON = $row['NCON'];
                            $NCPY = $row['NCPY'];
                            $AA1 = $row['AA1'];
                            $AA2 = $row['AA2'];
                            $ACI = $row['ACI'];
                            $AST = $row['AST'];
                            $AZ = $row['AZ'];
                            $ACO = $row['ACO'];
                            $AP = $row['AP'];
                            $AM = $row['AM'];
                        } 

					//get vendor name
					$SQL45="SELECT VC FROM [07O2] WHERE OID ='$invoice' ";
					$resultset45=mssql_query($SQL45, $con); 
					while ($row = mssql_fetch_array($resultset45)) 
					{
						$VC_check = $row['VC'];
					}
					if($VC_check){
						$SQL46="SELECT NC FROM [07SL1] WHERE VC ='$VC_check' ";
						$resultset46=mssql_query($SQL46, $con); 
						while ($row = mssql_fetch_array($resultset46)) 
						{
							$vendor_name = $row['NC'];
						}
					}
					else{
						$vendor_name = "TAP Series";
					}		
				}




        echo "<p>Paid in full</p>";
       
        echo "<p>Credit/Debit Card: XXXX XXXX XXXX $last4</p>";


					echo "

						<table style='border: 1px solid black; height: 119px; width: 311px;'>
				<tbody>
				<tr style='height: 12px;'>
				<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Order number</td>
				</tr>
				<tr style='height: 12px;'>
				<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$invoice</td>
				</tr>
				<tr style='height: 12px;'>
				<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Order date</td>
				</tr>
				<tr style='height: 12px;'>
				<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$date</td>
				</tr>
				<tr style='height: 12px;'>
				<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Vendor name</td>
				</tr>
				<tr style='height: 12px;'>
				<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$vendor_name</td>
				</tr>
				<tr style='height: 12px;'>
				<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Billing information</td>
				</tr>
				<tr style='height: 62px;'>
				<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 62px;' colspan='3'>$NCON <br>
								  $NCPY<br>
								   $AA1<br>				  
								   $AA2<br>				  
								   $ACI $AST, $AZ<br>
								   $ACO<br>				   
								   $AM<br>
								   $AP<br>
								   </td>
				</tr>

				";

				if($oh2_id != "")
				{
					$SQL5 = "SELECT * FROM ohioProctor WHERE id='$oh2_id' ";
					$resultset5=mssql_query($SQL5, $con);
					while ($row = mssql_fetch_array($resultset5)) 
					{
						$oh2_county = trim($row['county']);
						$oh2_educator = trim($row['educator']);
						$oh2_email = trim($row['email']);
						$oh2_phone = trim($row['phone']);
					}

						echo "
							<tr style='height: 34px;'>
							<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 34px; background-color: #0c7bab;' colspan='3'>
							Ohio Approved Proctor
							</td>
							</tr>
							<tr style='height: 12px;'>
							<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>
							<strong>County</strong>: $oh2_county<br>
							<strong>Educator</strong>: $oh2_educator<br>
							<strong>Email</strong>: $oh2_email<br>
							<strong>Phone</strong>: $oh2_phone					
							</td>
							</tr>
							";
					
				}

				echo "
				<tr style='height: 34px;'>
				<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 34px; background-color: #0c7bab;' colspan='3'>
				<p>Order details</p>
				</td>
				</tr>";

					$SQL1="SELECT * FROM [07O4] WHERE OID LIKE '%$invoice' ";
						$resultset1=mssql_query($SQL1, $con); 

					while ($row = mssql_fetch_array($resultset1)) 
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
				<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 34px;'>$NO</td>
				<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 34px;'><span>$</span>$PRI</td>
				</tr>

				";
					}												
				echo "
				<tr style='height: 12.3333px;'>
				<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 12.3333px;'>&nbsp;</td>
				<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 12.3333px;'>Total:</td>
				<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 12.3333px;'><span>$</span>$total</td>
				</tr>
				";

				if($LK)
				{
	
				  echo "<tr style='height: 12px;'>
						<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>
						Purchased license keys:<br>
						$LK		
						</td>
						</tr>
						";
				}	

				echo "
				</tbody>
				</table>
				";

				if($LK)
				{
					echo "<p>Each of your employees is to receive one license key. The employee will use their license key as their password when they enroll themselves in the course.</p>";
				}	



?>

<script>

window.print();

</script>