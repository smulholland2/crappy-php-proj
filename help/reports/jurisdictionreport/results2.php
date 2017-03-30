<?php
$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);

$startD=$_POST['startDate'];
$endD=$_POST['endDate'];

$ME=0;

$juris = array(
1 => "MOGEN", //jackson co
2 => "CASD",  //san diego
3 => "WVMV", //Mid-Ohio Valley
4 => "WVHR", //Hardy County
5 => "WVMN", //Monroe County
6 => "FLGEN", //florida
7 => "WVUP", //upshur
8 => "WVPE", //pendleton
9 => "WVPO", //pocahontas
10 => "WVBA", //barbour co
11 => "WVOH",  //Wheeling-Ohio County
12 => "UTBR", //bear river UT
13 => "UTCU", //central utah
14 => "UTDA", //davis utah
15 => "UTSL", //salt lake co utah
16 => "UTSE", //southeast utah
17 => "UTSW", //southwest utah
18 => "UTSU", //summit co utah
19 => "UTTO", //tooele co utah
20 => "UTTC", //tricounty utah
21 => "UTUT", //utah co
22 => "UTWA", //Wasatch County UT	 
23 => "UTWM" //Webber/Morgan County UT
);



foreach ($juris as $v) {

if ($v=="MOGEN"){
$ME=22;
}

if ($v=="CASD"){
$ME=3;
}

if ($v=="FLGEN"){
$ME=17;
}

if (substr($v, 0, 2) == 'UT') {
$ME=19;
}

if (substr($v, 0, 2) == 'WV') {
$ME=13;
}

//completions
if ($ME==19 || $ME==3 || $ME==17 || $ME==22 ) 
{ 
	
	$SQL0 = "SELECT * FROM [01D],[01C] WHERE [01D].UU=[01C].uu and [01D].DE >= '$startD'  AND [01D].DE <= '$endD' and ME=$ME and REGION='$v'"; 
} 

//enrollments
else 
{ 

	$SQL0 = "SELECT * FROM [01D],[01C] WHERE [01D].UU=[01C].uu and [01D].DA >= '$startD'  AND [01D].DA <= '$endD' and ME=$ME and REGION='$v'"; 
}



$resultset0=mssql_query($SQL0, $con);
$pri=0;
$commission=0;
$commissionWVPO=0;
$commissionWVPE=0;


while ($row = mssql_fetch_array($resultset0)) 
	{

	     $NF = $row['NF'];
	     $NL = $row['NL'];
	     $UU = $row['UU'];
	     $UA = $row['UA'];
	     $DA = $row['DA'];
	     $DE = $row['DE'];
	     $BD = $row['BD'];
	     $GEN = $row['GENDER'];
	
	
$AA1= "";	
$AA2="";
$ACI= "";
$AST= "";
$AZ= "";	
$EWP= "";	
$NCPY= "";


$DA = strtotime($DA);
$DA = date('m/d/y',$DA);

$DE = strtotime($DE);
$DE = date('m/d/y',$DE);

$BD = strtotime($BD);
$BD = date('m/d/y',$BD);



if ($v=="WVPO") 
{
	
	 $SQL2="Select * from [07O2],[07O4] where AN='$UA' and PN like 'Poca%' and [07o2].OID=[07O4].OID and pay='credit'";

	$resultset2=mssql_query($SQL2, $con);
	
	while ($row = mssql_fetch_array($resultset2)) 
	{
	    $pri = $row['PRI'];
	}    
	
}

if ($v=="WVPE") 
{
	
	 $SQL2="Select * from [07O2],[07O4] where AN='$UA' and PN like 'Pend%' and [07o2].OID=[07O4].OID and pay='credit'";
	$resultset2=mssql_query($SQL2, $con);
	
	while ($row = mssql_fetch_array($resultset2)) 
	{
	    $pri = $row['PRI'];
	} 
	
}


if($pri==14.95 && $v=='WVPO'){
		$commission=5;
		$commissionWVPO=5;
}
if($pri==19.95 && $v=='WVPO'){
		$commission=10;
		$commissionWVPO=10;
}
if($pri==29.95 && $v=='WVPO'){
		$commission=20;
		$commissionWVPO=20;
}

if($pri==14.95 && $v=='WVPE'){
		$commission=5;
		$commissionWVPE=5;
}
if($pri==24.95 && $v=='WVPE'){
		$commission=15;
		$commissionWVPE=15;
}

   $SQL3="Select * from [01D2] where UU='$UU'";

	$resultset3=mssql_query($SQL3, $con);
	
	while ($row = mssql_fetch_array($resultset3)) 
	{
	      $AA1 = $row['AA1'];
	      $AA2 = $row['AA2'];
	      $ACI = $row['ACI'];
	      $AST = $row['AST'];
	      $AZ = $row['AZ'];
	      $EWP = $row['EWP'];
	} 
	

	if ($AA1=="")
	{
		
	  $SQL4="Select * from [07O1] where AN='$UA'";

		$resultset4=mssql_query($SQL4, $con);
		
		while ($row = mssql_fetch_array($resultset4)) 
		{
		      $AA1 = $row['AA1'];
		      $AA2 = $row['AA2'];
		      $ACI = $row['ACI'];
		      $AST = $row['AST'];
		      $AZ = $row['AZ'];
		      $EWP = $row['AP'];
		      $NCPY = $row['NCPY'];
		} 
		

	}
	
	$posts[] = array('StartDate'=>$startD, 'EndDate'=>$endD, 'FirstName'=>$NF, 'LastName'=>$NL, 'Username'=>$UU, 'Address'=>trim($AA1.$AA2), 'City'=>trim($ACI), 'State'=>trim($AST),'ZipCode'=>trim($AZ),'Phone'=>trim($EWP),'Birthdate'=>$BD,'Gender'=>$GEN,'Company'=>$NCPY,'DateAdded'=>$DA, 'DateEnded'=>$DE, 'Price'=>$pri,'Region'=>$v, 'Commission'=>$commission, 'CommissionWVPO'=>$commissionWVPO, 'CommissionWVPE'=>$commissionWVPE, );
	}
	
	
 

$response['posts'] = $posts;

$fp = fopen('results2.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);


 header("Location: results.html");

}

?>
	
