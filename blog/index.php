<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/blog/BlogController.php";

    $blog = new BlogController();

    if(isset($_GET['tag']))
      $posts = $blog -> PostsByTag($_GET['tag']);
    else if(isset($_GET['month']) && isset($_GET['year']))
      $posts = $blog -> PostsByDate($_GET['month'], $_GET['year']);
    else
      $posts = $blog -> AllPosts();

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
            <?php foreach ($posts as $key => $post): ?>
                <div class="blog-post">
                  <h2 class="blog-post-title"><?php echo '<a href="/blog/post/' . $post['UrlTitle'] .'">' . $post['Title'] . '</a>'; ?></h2>
                  <p>
                    <?php
                      $string = $post['Content'];
                      $maxLength = 400;

                      if (strlen($string) > $maxLength) {
                          $stringCut = substr($string, 0, $maxLength);
                          $string = substr($stringCut, 0, strrpos($stringCut, ' ')); 
                      }

                      echo $string  . "...";
                    ?>
                  </p>
                </div><!-- /.blog-post -->
                <div class="clearfix"></div>
                <?php echo '<a href="/blog/post/' . $post['UrlTitle'] .'" class="btn btn-default btn-xs">Read More</a>'; ?>
                <hr>
            <?php endforeach; ?>
          
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