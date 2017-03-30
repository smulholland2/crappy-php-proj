<?php
error_reporting(0);
session_start();
$VC_error = $_SESSION["VC_error"];
$company_name_session = $_SESSION["company_name_session"];
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Corporate Pricing Group</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="page-header">
        <h1>Add Corporate Pricing Group</h1>
    </div>

    <form class="form-horizontal" action='add_corp_pricing_group_db.php' method='get'>
    <div class="form-group">
        <p><strong>Please enter the information:</strong></p>
    </div>
    <div class="form-group">
    <div class="alert alert-info" <?php if($VC_error != ""){ echo "style='display:block'";} else{echo "style='display:none'";}?>>
        <?php echo $VC_error; ?>
    </div>
    </div>
    <div class="form-group">
        <label>Pricing Group/Company Full Name:</label>
        <input type="text" class="form-control" name="company_name" value="<?php if($company_name_session != ""){ echo $company_name_session;}?>" required>
    </div>
    <div class="form-group" style="width:300px">
        <label>Pricing Group Code/User Name:</label>
        <input type="text" class="form-control" name="company_code" required>
    </div>
    <div class="form-group">
    <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </form>

</div>

<?php
// remove all session variables
session_unset(); 
// destroy the session 
session_destroy(); 
?>
</body>
</html>