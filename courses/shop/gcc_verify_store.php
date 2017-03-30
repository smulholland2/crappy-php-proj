<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
error_reporting(0); 
session_start();

$UN = $_GET["UN"];

if (substr( $UN, 0, 2 ) === "gc" && (strlen($UN) === 5) || substr( $UN, 0, 2 ) === "GC" && (strlen($UN) === 5))
{
  if(strlen($UN) === 5){
    $last3chars = substr($UN, -3);
    if(!is_numeric($last3chars)){
      bad_username();
    }
  }
  else{
    bad_username();
  }
}
else{
  bad_username();
}

function bad_username() {
    if($_GET["click"]){
      $_SESSION["bad_username"] = 1;
      header("location: gcc.php");
      die;
    }
    else{
      $_SESSION["bad_username"] = 1;
      header("location: gcc.php");
      die;
    }
}

$SQL = "SELECT * FROM [07O6] WHERE AN='$UN' ";
$resultset=mssql_query($SQL, $con);
while ($row = mssql_fetch_array($resultset)) 
{
    $AN_check = trim($row['AN']);
    $NF = trim($row['NF']);
    $NL = trim($row['NL']);
    $AA1 = trim($row['AA1']);
    $AA2 = trim($row['AA2']);
    $ACI = trim($row['ACI']);
    $AST = trim($row['AST']);
    $AZ = trim($row['AZ']);
    $AP = trim($row['AP']);
    $AM = trim($row['AM']);
}

//checks if password is equals to pending
$SQL1 = "SELECT AC FROM [07L3] WHERE AN='$UN' ";
$resultset1=mssql_query($SQL1, $con);
while ($row = mssql_fetch_array($resultset1)) 
{
  $AC_check_pending = trim($row['AC']);
}
if($AC_check_pending == "pending"){
    $_SESSION["username_pending"] = 1;
    header("Location: gcc.php");
    die;
}


if(!$AN_check){
    header("Location: gcc_create.php?UN=$UN");
}

session_start();
$_SESSION["displayname"] = "Ghirardelli";
$_SESSION["admintable"] = "07L3";
$_SESSION["menu"] = "/admin/gcc";
$_SESSION["user"] = $_GET["UN"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>



<div class="container text-center" style="margin-top:50px">

  <div class="alert alert-info alert-dismissable text-left" <?php if($_SESSION["info_updated"]=="yes"){echo "style='display:block'";}else{echo "style='display:none'";}?>>
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    <strong>Congratulations the information was successfully updated.</strong>
  </div>

  <div class="alert alert-danger alert-dismissable text-left" <?php if($_SESSION["info_updated"]=="no"){echo "style='display:block'";}else{echo "style='display:none'";}?>>
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    <strong>There was a problem updating the information.</strong>
  </div>

<div class="well">
<h3><?php echo $NF." ".$NL;?></h3>
<h3>Is this person your store administrator?</h3>
<p><a href="/admin/gcc" class="btn btn-primary" role="button">Yes</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">No</button></p>
<br>
<p><button type="button" class="btn btn-primary" onclick="goBack()">Go Back</button></p>

<h3>For technical support, please call<br>888-826-5222</h3>
</div>


  <!-- Modal -->
  <div class="modal fade text-left" id="myModal" role="dialog" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Store Information</h4>
        </div>
        <div class="modal-body">
          <p>Please correct your store's information below and click <strong>Save Changes</strong>.</p>
          <br>
          
          <form action="gcc_update.php" method="get">

          <input type="hidden" value="<?php echo $UN;?>" name="UN" required>

          <div class="form-group">
          <label>Store Username:</label>
          <input type="text" class="form-control" style="max-width:300px" value="<?php echo $UN;?>" disabled>
          </div>

          <div class="form-group">
          <label>Store Administrator First Name:</label><br>
          <input type="text" class="form-control" style="max-width:300px" value="<?php echo $NF;?>" name="NF" required>
          </div>

          <div class="form-group">
          <label>Store Administrator Last Name:</label><br>
          <input type="text" class="form-control" style="max-width:300px" value="<?php echo $NL;?>" name="NL" required>
          </div>

          <div class="form-group">
          <label>Store Address Line 1:</label><br>
          <input type="text" class="form-control" style="max-width:300px" value="<?php echo $AA1;?>" name="AA1" required>
          </div>

          <div class="form-group">
          <label>Store Address Line 2:</label><br>
          <input type="text" class="form-control" style="max-width:300px" value="<?php echo $AA2;?>" name="AA2">(Optional)
          </div>

          <div class="form-group">
          <label>Store City:</label><br>
          <input type="text" class="form-control" style="max-width:300px" value="<?php echo $ACI;?>" name="ACI" required>
          </div>

          <div class="form-group">
          <label>Store State:</label><br>
          <input type="text" class="form-control" style="max-width:300px" value="<?php echo $AST;?>" name="AST" required>
          </div>

          <div class="form-group">
          <label>Store Zip Code:</label><br>
          <input type="text" class="form-control" style="max-width:300px" value="<?php echo $AZ;?>" name="AZ" required>
          </div>

          <div class="form-group">
          <label>Store Phone Number:</label><br>
          <input type="text" class="form-control" style="max-width:300px" value="<?php echo $AP;?>" name="AP">(Optional)
          </div>

          <div class="form-group">
          <label>Store E-mail Address:</label><br>
          <input type="text" class="form-control" style="max-width:300px" value="<?php echo $AM;?>" name="AM" required>
          </div>

          <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Save Changes">
          </div>
          
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Modal ENDS-->


</div>


<style>
button, a{
    width:100px;
}
</style>

<script>
function goBack() {
    window.history.back();
}
</script>

<?php unset($_SESSION['info_updated']);?>
<?php //print_r($_SESSION);?>

</body>
</html>

