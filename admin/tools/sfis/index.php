<?php    
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/tools/sfis/SFISController.php";

    $sfis = new SFISController();
    $students = $sfis -> GetStudentList();
    if(!$students)
    {
        if(!isset($_SESSION))
            session_start();
        $_SESSION["sfiserror"] = 1;
        header("Location:/admin/company/sfis/");
    }

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Strategies For Increasing Sales Data Center</h1>
            </div>
			<br />
            <div class="row">
                <div class="row col-md-12">
                    <!--<div class="alert alert-info alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>IMPORTANT:</strong> Enter the student's user name and password.
                        <p><em>Please note that password is case-sensitive.</em></p>
                    </div> -->
                </div>                
            </div>
            <br />
            <div class="row">
                <form class="col-md-6" method="POST" action="datacenter">
                    <div class="form-group">
                        <label for="studentname">Select a Student:</label>
                        <select class="form-control" name="studentid" size="10">
                            <?php 
                                for($i = 0; $i < count($students); $i++)
                                {
                                    $option = "<option value='" . $students[$i]["id"] . "'>";
                                    $option .= $students[$i]["NL"] . " , ";
                                    $option .= $students[$i]["NF"];
                                    $option .= "</option>";
                                    echo $option;
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" />
                    </div>
                </form>
            </div>
            <br />
        </div>        
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
</body>
</html>