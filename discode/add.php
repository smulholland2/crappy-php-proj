<?php
  include_once $_SERVER['DOCUMENT_ROOT']."/discode/DiscodeController.php";

  error_reporting(0);

  if(isset($_POST["discode"])) {
    $discode = new DiscodeController("add", $_POST, $_FILES);
    $discode -> AddDiscode();
  } else {
    session_start();    
    $discode_error = isset($_SESSION["discode_error"]) ? $_SESSION["discode_error"] : null;
    $logo_session = isset($_SESSION["logo"]) ? $_SESSION["logo"] : null;
    $htmlcodes_session = isset($_SESSION["htmlcodes"]) ? $_SESSION["htmlcodes"] : null;
  }  
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Add New Discode</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <div class="page-header">
        <h1>Add New Discode</h1>
      </div>
      <?php echo isset($discode_error) ? $discode_error: null; ?>
      <form class="form-horizontal" method='POST' enctype="multipart/form-data">
        <!-- discode-->
        <div class="form-group col-md-4">
          <label for="discode">Discode:</label>
          <input type="text" class="form-control" name="discode" id="discode" required>
        </div>
        <!-- logo -->
        <div class="clearfix"></div>
        <div class="form-group col-md-4">
            <label for="fileToUpload">Upload logo:</label>
            <input type="file" class="form-control" name="logo" id="logo" value="<?php if($logo_session){echo $logo_session;}?>" required >                        
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-md-4">
          <button class="btn btn-primary templater">Use Template</button>
        </div>        
        <div class="clearfix"></div>
        <!-- html coding -->
        <div class="form-group">
          <label>Place your html content here:</label>
          <textarea name="htmlcodes" id="htmlcodes" class="htmlcodes" value="<?php if($htmlcodes_session){echo $htmlcodes_session;}?>"></textarea>
        </div>
        <!-- custom javascript -->
        <div class="form-group">
          <label>Place your custom Javascript here:</label>
          <textarea name="customjs" id="customjs" class="form-control" rows="10" value="<?php if($customjs_session){echo $customjs_session;}?>"></textarea>
        </div>
        <!-- custom css -->
        <div class="form-group">
          <label>Place your custom CSS here:</label>
          <textarea name="customcss" id="customcss" class="form-control" rows="10" value="<?php if($customcss_session){echo $customcss_session;}?>"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
      tinymce.init({
        selector: '#htmlcodes',
        height: 500,
        theme: 'modern',
        image_advtab: true,
        verify_html : false,
        cleanup : false,
        plugins: [
          'advlist autolink lists link image charmap print preview hr anchor pagebreak',
          'searchreplace wordcount visualblocks visualchars code fullscreen',
          'insertdatetime media nonbreaking save table contextmenu directionality',
          'emoticons template paste textcolor colorpicker textpattern imagetools codesample'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
        image_advtab: true,
        content_css: [
          '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
          '//www.tinymce.com/css/codepen.min.css'
        ]
      });
      // Sets the HTML contents of the activeEditor editor
      $('.templater').click(function(e){
          e.preventDefault();
          var discode = $('#discode').val();
          var template = '<h4>New customers, click "Buy Course" to purchase the course.<br>Click "Go to Course" to start/resume your training.</h4>';
          template += '<br>';
          template += '<a href="../shopping_cart/sc_purchase_a.php?discode='+ discode +'" class="btn btn-primary" role="button">Buy Course</a>';
          template += '<a href="http://www.tapseries.com/onlinetraining.htm" class="btn btn-primary" role="button">Go to Course</a>';
          template += '<a href="http://www.tapseries.com/certificate/certificate_login.asp" class="btn btn-primary" role="button">Print Certificate</a>';
          template +=' <br><br>';
          template +=' <h4>Existing accounts, click below to access your account and purchase more courses.</h4>';
          template += '<br>';
          template += '<a href="http://www.tapseries.com/login_il.asp" class="btn btn-primary" role="button">Account Logon</a>';
          template += '<br><br>';
          template += '<h4>Click on the link below for tutorials.</h4>';
          template += '<br>';
          template += '<a href="http://www.tapseries.com/tutorials/index.asp" class="btn btn-primary" role="button">Tutorials</a>';
          template += '<br><br>';
          template += '<h4>For technical support, please call<br>888-826-5222</h4>';
          template += '<br>';
          template += '<h4><strong>&#169; Copyright 2016 TAP Series, LLC <br><a style="text-decoration:none" href="http://www.tapseries.com/privacy.asp">Privacy Policy</a></strong></h4>';
          tinymce.activeEditor.setContent(template, {format: 'raw'});
      });
    </script>
    <?php unset($_SESSION["discode_error"]); ?>
  </body>
</html>
