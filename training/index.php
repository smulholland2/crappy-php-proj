<?php

    include_once $_SERVER['DOCUMENT_ROOT']."/training/TrainingController.php";
    
    if(!isset($_SESSION))
        session_start();

    $_SESSION["TrainingLogin"] = NULL;

    if(isset($_POST["username"]))
    {
        $training = new TrainingController();
        $training -> Login($_POST["username"]);
    }

?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
    <div id="wrapper" style="display: block;">
        <div class="container">
            <div class="page-header col-md-6 col-md-offset-3">
                <h1>Course Login</h1>
            </div>
            <div class="row col-md-6 col-md-offset-3 <?php echo isset($_SESSION["errors"]) ? 'hello': 'hidden' ?>">
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>ERROR:</strong> That username was not found. Please try again.
                </div>
            </div>
            <div class="row">
                <form class="col-md-6 col-md-offset-3 well" method="POST">
                    <div class="form-group form-header">
                        <span class="glyphicon glyphicon-user"></span>
                    </div>
                    <br />
                    <br />
                    <div class="form-group">
                        <label for="username">Type Username or License Key in the box and click Login.</span></label>
                        <input type="text" name="username" class="form-control"/>
                        <br />
                        <p>
                            <a href="/account/forgotpass" style="text-decoration:none;color:#008abf">Forgot Password?</a>
                        </p>
                    </div>
                    <br />
                    <div class="form-group">
                        <input type="button" class="btn btn-primary col-md-12 submit" value="Login"/>
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
            <br />
            <div class="row col-md-6 col-md-offset-3">
                <p>
                    We recommend customers use Google Chrome 
                    <img src="/wwwroot/images/Chromeee.png" class="browser-icon" alt="Google Chrome">
                    &nbsp;or Mozilla Firefox 
                    <img src="/wwwroot/images/firefff.png" class="browser-icon" alt="Mozilla Firefox">
                </p>
            </div>
        </div>
    </div>
    <!-- Multi Course Modal -->
    <div class="modal fade course-choose" id="lookupError" tabindex="-1" role="dialog" aria-labelledby="modalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalTitle">Your user name was found in more than one course.</h4>
                    <p>Please click the title of your course below.</p>
                </div>
                <div class="modal-body">
                    <?php

                        if(isset($_SESSION["courses"]))
                        {
                            echo "<input id='cl' name='cl' value='1' type='hidden'/>";
                            $courses = $_SESSION["courses"];
                            for ($i = 0; $i < count($courses); $i++) {
                                $courselink = "<a class ='btn btn-primary col-md-12' href='" . $training::COURSEHOST;
                                $courselink .= $courses[$i]['link'] . $training::SHELL . "'>" . $courses[$i]['title'] . "</a>";
                                echo $courselink;
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Use Lisc Key Modal -->
    <div class="modal fade" id="confirm-key" tabindex="-1" role="dialog" aria-labelledby="confirmKeyLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="confirmKeyLabel">Use this License Key?</h4>
                </div>
                <div class="modal-body">
                    <p>It looks like you have entered a license key and you don't have a user name. Click "Confirm" below to create your user name.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success confirm-key-ok">Confirm</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
<?php    

    // Clear out remaining session vars.
    if(isset($_SESSION["errors"]))
        unset($_SESSION["errors"]);

    if(isset($_SESSION["courses"]))
        unset($_SESSION["courses"]);
?>
<script>
    $(document).ready(function() {
        if($('#cl').val() == 1)
            $('.course-choose').modal('show');
    });

    $('.submit').click(function(e){
        e.preventDefault();
        var username = $('input[name="username"]').val();
        var prefix = username.substring(0,2);
        if(prefix.toUpperCase() == "LK")
        {
            $('#confirm-key').modal('show');
        }
        else
        {
            $('form').submit();
        }
    });

    $('.confirm-key-ok').click(function(){
        $('form').submit();
    });
    
</script>
</body>
</html>