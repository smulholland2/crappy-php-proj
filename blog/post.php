<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/blog/BlogController.php";

    $blog = new BlogController();
    if(isset($_GET['title']))
        $post = $blog -> PostByTitle($_GET['title']);
    else
        header('Location: /blog');

    $tags = $blog -> TagCloud();

?>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>

<div class="container">

      <div class="blog-header">
        <h1 class="blog-title">The TAP Series Blog</h1>
        <p class="lead blog-description">Stay up to date with the latest new in food safety.</p>
      </div>      
      <div class="row">        
        <div class="col-sm-8 blog-main">
            <div class="blog-post">
                <h2 class="blog-post-title"><?php echo $post['Title']; ?></h2>
                <p><?php echo $post['Content']; ?></p>
            </div><!-- /.blog-post -->          
        </div>
        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          <div class="sidebar-module">
            <h4><a href="/blog" class="btn btn-primary">Blog Home</a></h4>
          </div>
          <div class="sidebar-module sidebar-module-inset">
            <h4>Tags</h4>
            <p>
            <?php foreach ($tags as $key => $tag): ?>
              <?php echo '<a href="/blog/tags/' . $tag['Name'] .'">' . $tag['Name'] . '</a>,'; ?>
            <?php endforeach; ?>
            </p>
          </div>
          <div class="sidebar-module">
            <h4>Elsewhere</h4>
            <ol class="list-unstyled">              
              <li><a href="https://twitter.com/tapseries_" target="_new">Twitter</a></li>
              <li><a href="http://facebook.com/TAPSeries" target="_new">Facebook</a></li>
              <li><a href="#" target="_new">SnapChat</a></li>
              <li><a href="https://www.linkedin.com/company/tap-series" target="_new">LinkedIn</a></li>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>