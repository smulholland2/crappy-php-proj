<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
tinymce.init({
  selector: '#htmlcodes',
  height: 500,
  theme: 'modern',
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
</script>

<!DOCTYPE html>
<html>
<head>
	<title>4u page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</head>
<body>
<div class="container">

<?php
error_reporting(0); 

session_start();
$discode_error = $_SESSION["discode_error"];
$logo_session = $_SESSION["logo"];
$htmlcodes_session = $_SESSION["htmlcodes"];

  if($discode_error)
  {
    echo $discode_error;
  }
?>

    <div class="page-header">
    <h1>4u maker</h1>
    </div>

    <form class="form-horizontal" action='add4u.php' method='get'>

    <!-- discode-->
    <div class="form-group" style="width:150px">
      <label for="discode">Discode:</label>
      <input type="text" class="form-control" name="discode" id="discode" required>
    </div>

    <!-- logo -->
    <div class="form-group" style="width:300px">
      <label for="logo">Logo:</label>
      <input type="text" class="form-control" name="logo" id="logo"  value="<?php if($logo_session){echo $logo_session;}?>" required>
    </div>

    <!-- html coding -->
    <div class="form-group">
      <label>Place your html content here:</label>
      <textarea name="htmlcodes" id="htmlcodes" class="htmlcodes" value="<?php if($htmlcodes_session){echo $htmlcodes_session;}?>"></textarea>
    </div>

    <!-- custom javascript -->
    <div class="form-group">
      <label>Place your custom Javascript here:</label>
      <textarea name="customjs" id="customjs" class="form-control" value="<?php if($customjs_session){echo $customjs_session;}?>"></textarea>
    </div>

    <!-- custom css -->
    <div class="form-group">
      <label>Place your custom CSS here:</label>
      <textarea name="customcss" id="customcss" class="form-control" value="<?php if($customcss_session){echo $customcss_session;}?>"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

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

