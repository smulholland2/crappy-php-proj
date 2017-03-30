<?php
$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>4u Editor</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <style>
  th{
      text-align:center;
  }
  </style>
</head>
<body>

<div class="container">


    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Are you sure you want to delete this 4u page?</h4>
          </div>
          <div class="modal-body text-center">
            <a href="#" id="delete_link" class="btn btn-danger" role="button">Yes</a> <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    <!-- END MODAL-->


    <div class="page-header">
    <h1>4u Editor</h1>
    </div>

  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>go to page</th>
        <th>discode</th>
        <th>price discode</th>
        <th>logo</th>
        <th>html</th>
        <!--<th>js</th>-->
        <!--<th>css</th>-->
        <th>active</th>
        <th>corporate username</th>
        <th>region username</th>
        <th>account username</th>
        <th>course id</th>
        <th>action</th>
      </tr>
    </thead>
    <tbody>

      <?php
        $SQL = " SELECT * FROM discodes ORDER BY discode";
        $resultset=mssql_query($SQL, $con); 
        while ($row = mssql_fetch_array($resultset)) 
        {
            $discode = $row['discode'];
            $price_discode = $row['price_discode'];
            $logo = $row['logo'];
            $html = $row['html'];
            $js = $row['js'];
            $css = $row['css'];
            $active = $row['active'];
            $corporate_username = $row['corporate_username'];
            $region_username = $row['region_username'];
            $account_username = $row['account_username'];
            $add_id = $row['add_id'];

            echo "<tr>";
            echo "<td><a href='/4u/$discode'>see page</a></td>";
            echo "<td>$discode</td>";
            echo "<td>$price_discode</td>";
            echo "<td>$logo</td>";
            echo "<td><xmp>$html</xmp></td>";
          //echo "<td>$js</td>";
          //echo "<td>$css</td>";
            echo "<td>$active</td>";
            echo "<td>$corporate_username</td>";
            echo "<td>$region_username</td>";
            echo "<td>$account_username</td>";
            echo "<td>$add_id</td>";
            echo "<td><a href='edit_4u_changes.php?discode=$discode' class='btn btn-primary' role='button'><span class='glyphicon glyphicon-pencil'></span></a> <button type='button' value='$discode' class='btn btn-danger delete_btn' data-toggle='modal'' data-target='#myModal'><span class='glyphicon glyphicon-remove'></span></button></td>";
            echo "</tr>";
        }
      ?>  

    </tbody>
  </table>
</div>

<script>
$(document).ready(function(){

  $(".delete_btn").click(function(){
    var x = $(this).val();
    $("#delete_link").attr("href", 'delete_4u.php?discode='+ x +'');
  });    

});

</script>

</body>
</html>