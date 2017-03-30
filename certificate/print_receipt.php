<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
error_reporting(0);

$invoice = $_POST["id"];
$last4 = $_POST["last4"];

//get invoice info to create receipt
$SQL2 = "SELECT * FROM anchorage_invoices WHERE id='$invoice' ";
$resultset2=mssql_query($SQL2, $con);
while ($row = mssql_fetch_array($resultset2)) 
{
    $FN = $row['FN'];
    $LN = $row['LN'];
    $AA1 = $row['AA1'];
    $AA2 = $row['AA2'];
    $ACI = $row['ACI'];
    $AST = $row['AST'];
    $AZ = $row['AZ'];
    $ACO = $row['ACO'];
    $AP = $row['AP'];
    $AM = $row['AM'];
    $NCPY = $row['NCPY'];
    $TOTAL = $row['TOTAL'];
}

$date = date("m/d/Y");
$TOTAL = number_format($TOTAL,2);

?>


<p>Credit/Debit Card: XXXX XXXX XXXX <?php echo $last4;?></p>

<table style='border: 1px solid black; height: 119px; width: 311px;'>
<tbody>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Invoice number</td>
</tr>
<tr style='height: 12px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'><?php echo $invoice;?></td>
</tr>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Paid date</td>
</tr>
<tr style='height: 12px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'><?php echo $date;?></td>
</tr>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Billing information</td>
</tr>
<tr style='height: 62px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 62px;' colspan='3'>
<?php echo $FN;?>  <?php echo $LN;?> <br>
<?php echo $NCPY;?><br>
<?php echo $AA1;?> <br>				  
<?php echo $AA2;?> <br>				  
<?php echo $ACI;?> <?php echo $AST;?>, <?php echo $AZ;?><br>
<?php echo $ACO;?><br>				   
<?php echo $AM;?><br>
</td>
</tr>
<tr style='height: 34px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 34px; background-color: #0c7bab;' colspan='3'>
<p>Invoice details</p>
</td>
</tr>									
<tr style='height: 34px;'>												
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 34px;'>Anchorage, AK Food Handler Card</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 34px;'>1</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 34px;'><span>$</span><?php echo $TOTAL;?></td>
</tr>
<tr style='height: 12.3333px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 12.3333px;'>&nbsp;</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 12.3333px;'>Total:</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 12.3333px;'><span>$</span><?php echo $TOTAL;?></td>
</tr>
</tbody>
</table>
