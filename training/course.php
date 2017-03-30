<?php
    $link = $_GET['link'];
    $user = $_GET['user'];

    const COURSEHOST = "http://tapseries-assets.s3-website-us-east-1.amazonaws.com/";
    const SHELL      = "/shell.html";

    $linkToCourse =  COURSEHOST . $link . SHELL . '?u=' . $user;
?>

<frameset >

  <frame src="<?php echo $linkToCourse; ?>">

</frameset>