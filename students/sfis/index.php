<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/tools/sfis/SFISController.php";
    /*if(count($_GET) == 0)
        die(var_dump($_GET));*/
    /*$sfis = new SFISController();
    $student = $sfis -> GetStudent($_POST);
    if(!$student)
    {
        if(!isset($_SESSION))
            session_start();
        $_SESSION["sfiserror"] = 1;
        header("Location:/admin/company/sfis/");
    }*/

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Strategies For Increasing Sales Data Center</h1>
            </div>
            <br />
            <div class="row col-md-12">
                <div class="alert alert-info" role="alert">STUDENT RESPONSES</div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"><a href="#card" aria-controls="card" role="tab" data-toggle="tab" class="tab">Guest Comment Card</a></li>
                    <li role="presentation"><a href="#plan" aria-controls="plan" role="tab" data-toggle="tab" class="tab">Marketing Plan</a></li>
                    <li role="presentation"><a href="#notepad" aria-controls="notepad" role="tab" data-toggle="tab" class="tab">Notepad</a></li>
                    <li role="presentation"><a href="#survey" aria-controls="survey" role="tab" data-toggle="tab"class="tab">Waitstaff Survey</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Guest Comment Card -->
                    <div role="tabpanel" class="tab-pane" id="card"></div>
                    <!-- Marketing Plan -->
                    <div role="tabpanel" class="tab-pane" id="plan"></div>
                    <!-- Notepad -->
                    <div role="tabpanel" class="tab-pane" id="notepad"></div>
                    <!-- Waitstaff Survey -->
                    <div role="tabpanel" class="tab-pane" id="survey"></div>
                </div>
            </div>
        </div>        
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
<script>
$('.tab').click(function(e){
    var tab = $(this).attr('href');
    page = tab.replace('#', '') + ".html";

    $.ajax({
        type: 'GET',
        url: page,
        dataType:'html',
        beforeSend:function(){
            // this is where we append a loading image
            //$('#ajax-panel').html('<div class="loading"><img src="/images/loading.gif" alt="Loading..." /></div>');
        },
        success:function(response){
            // successful request; do something with the data
            //$('#ajax-panel').empty();
            $(tab).html(response);
            initSelector(tab);
        },
        error:function(){
            // failed request; give feedback to user
            //$('#ajax-panel').html('<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
        }
    });
});
function initSelector(_tab)
{
    $('.module-select').change(function(e){
        var tab = _tab.replace('#', '');
        var form = tab + "-scroll";
        var module = "m" + $(this).val();
        //window.location.href = module;
        console.log(module);
        console.log(form);
        console.log(document.getElementById(module));
        //document.getElementById(tab).location.href = module;
        //window.scrollTo(0, 200);
        var topPos = document.getElementById(module).offsetTop;
        document.getElementById(form).scrollTop = topPos - 140;
    });
}
</script>
</body>
</html>