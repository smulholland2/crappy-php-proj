<?php 

$url = $_SERVER['REQUEST_URI'];
$isLink = strstr($url,'discode');
if($isLink)
{
  $idx = stripos($url,'=');
  $idx2 = strpos($url,'&');

  $discode = '';
  for($i = $idx + 1;$i < $idx2; $i++)
  {
      $discode .= $url[$i];
  }

  header('Location: /4u/'. $discode);
}
include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php'; 

?>

<div id="wrapper">
  <div class="container">
    <div class="col-md-12">
      <div class="page-header error-code"><h1>Error: 404 - Page Not Found</h1></div>
        <p>The page you are looking for cannot be found.</p>
        <p>Try returning to the <a href="/">Home Page</a>.</p>
      </div>
  </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>
