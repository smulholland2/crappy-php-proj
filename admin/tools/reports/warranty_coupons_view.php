<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<?php
error_reporting(0);
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

session_start();
$AN = trim($_SESSION['user']);

$start = $_GET['startDate']; 
$end = $_GET['endDate']; 
$productid = 1; 

$scores_table = "01P";

$SQL1 = "SELECT NCON, NCPY FROM [07O6] WHERE AN='$AN' ";
$resultset1=mssql_query($SQL1, $con); 
while ($row = mssql_fetch_array($resultset1)) 
{
    $NCON = $row['NCON'];
    $NCPY = $row['NCPY'];
}
?>

<div class="container" style="margin-top:90px;margin-bottom:90px">
    <div class="page-header">
        <h1>Student List</h1>
    </div>
    <input type="button" value="Go Back" onclick="goBack()" class="btn btn-primary">
    <p><strong>Organization:</strong> <?php echo $NCPY;?></p>
    <p><strong>Instructor/Administrator:</strong> <?php echo $NCON;?></p>
    <p><strong>Date range of report:</strong> <?php echo $start;?> - <?php echo $end;?></p>
    <p><strong>Course Name:</strong> Food Service Food Safety Manager Certification Training</p>    
    <br><br>

      

<?php

        $count=1;

            
            echo "<table class='table table-striped table-hover'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>Last Name</th>";
            echo "<th>First Name</th>";
            echo "<th>Username</th>";
            //echo "<th>Password</th>";
            echo "<th>Email</th>";
            echo "<th>Date Added</th>";
            echo "<th>Completed</th>";
            //echo "<th>L1</th>";
            //echo "<th>L2</th>";
            //echo "<th>L3</th>";
            //echo "<th>L4</th>";
            //echo "<th>L5</th>";
            //echo "<th>L6</th>";
            //echo "<th>L7</th>";
            //echo "<th>L8</th>";
            //echo "<th>L9</th>";
            //echo "<th>L10</th>";
            //echo "<th>L11</th>";
            //echo "<th>L12</th>";
            //echo "<th>L13</th>";
            //echo "<th>L14</th>";
            echo "<th>Progress</th>";
            echo "<th>90%</th>";
            echo "<th>Click Below</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            


        $SQL3 = "SELECT NF, NL, UU, UC, UM, DA FROM [01D] WHERE UA='$AN' AND ME='$productid' AND DA >= '$start' AND  DA <= '$end' ORDER BY NL";		
        $resultset3=mssql_query($SQL3, $con); 
        while ($row = mssql_fetch_array($resultset3)) 
        {
            

            $NF = $row['NF'];
            $NL = $row['NL'];
            $UU = $row['UU'];
            $UC = $row['UC'];
            if($UC == "expired"){
                $UC = "**expired**";
            }
            $UM = $row['UM'];

            $DA = $row['DA'];
            $DA = strtotime($DA);
            $DA=date('m/d/Y', $DA);

            

                $PER01 = "-";
                $PER02 = "-";
                $PER03 = "-";
                $PER04 = "-";
                $PER05 = "-";
                $PER06 = "-";
                $PER07 = "-";
                $PER08 = "-";
                $PER09 = "-";
                $PER10 = "-";
                $PER11 = "-";
                $PER12 = "-";
                $PER13 = "-";
                $PER14 = "-";
                $PER15 = "-";

                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=01";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER01 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=02";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER02 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=03";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER03 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=04";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER04 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=05";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER05 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=06";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER06 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=07";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER07 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=08";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER08 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=09";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER09 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=10";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER10 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=11";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER11 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=12";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER12 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=13";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER13 = $row['PER'];
                }
                $SQL4 = "SELECT PER FROM [$scores_table] WHERE UU='$UU' AND NUM=14";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER14 = $row['PER'];
                }
                $SQL4 = "SELECT PER, DE FROM [$scores_table] WHERE UU='$UU' AND NUM=15";		
                $resultset4=mssql_query($SQL4, $con); 
                while ($row = mssql_fetch_array($resultset4)) 
                {
                    $PER15 = $row['PER'];

                    $PER15_DE = $row['DE'];
                    $PER15_DE = strtotime($PER15_DE);
                    $PER15_DE=date('m/d/Y', $PER15_DE);
                }

            if($PER01 >= 90 && $PER02 >= 90 && $PER03 >= 90 && $PER04 >= 90 && $PER05 >= 90 && $PER06 >= 90 && $PER07 >= 90 && $PER08 >= 90 && $PER09 >= 90 && $PER10 >= 90 && $PER11 >= 90 && $PER12 >= 90 && $PER13 >= 90 && $PER14 >= 90 && $PER15 >= 90)
            {
                echo "<tr style='display:$show_hide_student'>";
                echo "<td>$count</td>";
                echo "<td>$NL</td>";
                echo "<td>$NF</td>";
                echo "<td>$UU</td>";
                //echo "<td>$UC</td>";
                echo "<td>$UM</td>";
                echo "<td>$DA</td>";
                echo "<td>$PER15_DE</td>";
                //echo "<td>$PER01</td>";
                //echo "<td>$PER02</td>";
                //echo "<td>$PER03</td>";
                //echo "<td>$PER04</td>";
                //echo "<td>$PER05</td>";
                //echo "<td>$PER06</td>";
                //echo "<td>$PER07</td>";
                //echo "<td>$PER08</td>";
                //echo "<td>$PER09</td>";
                //echo "<td>$PER10</td>";
                //echo "<td>$PER11</td>";
                //echo "<td>$PER12</td>";
                //echo "<td>$PER13</td>";
                //echo "<td>$PER14</td>";
                echo "<td>$PER15%</td>";
                echo "<td>Y</td>";
                echo "<td><a href='http://asp.tapseries.com/war_coupon_options.asp?source=prof&Name=$NF $NL&Account=$AN&UserName=$UU&email=$UM'>Coupon</a></td>";
                echo "</tr>";
                
                $count=$count+1;
            }


        }
            
            echo "</tbody>";
            echo "</table>";
    

?>

      

</div>

<script>
function goBack() {
    window.history.back()
}
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>