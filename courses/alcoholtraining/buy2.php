<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/courses/CoursesController.php";

    session_start();

    $courses = new CoursesController();

    if(isset($_POST['state']) && strlen($_POST['state']) === 2)
    {
        $state = $courses -> PurchaseState();
        exit;
    }
    else
    {
        $course = $courses -> AlcoholCourse();
    }
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-nomenu.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-sm-8 col-md-offset-2">
            <div class="product">
                <h1 class="center-block"><?php echo $_SESSION['alcoholtraining']['purchasestate']; ?>&nbsp;State Alcohol Training</h1>
                <div class="row">
                    <div class="row">
                        <div class="col-sm-6"><img class="img-responsive" src="../images/alc.png"></div>
                        <div class="col-sm-6">
                            <form class='product-form' method="get" action="/courses/shop/sc_shopping_cart.php">
                            <input type="hidden" name="Qty" value="1">
                            <input type="hidden" name="ProName" value="<?php echo $course['ProductName'] ?>">
                            <input type="hidden" name="ProID" value="<?php echo $course['ProID'] ?>">
                            <input type="hidden" name="ProPrice" value="<?php echo $course['Price'] ?>">
                            <div class="form-group"><strong>Price: </strong><?php echo $course['Price'] ?> </div>
                            <div class="form-group"><strong>Certificate Valid for: </strong><?php echo $course['CertificateExpiration'] ?></div>
                            <div class="form-group"><strong>Approximate Time: </strong><?php echo $course['CourseTime'] ?></div>
                            <div class="form-group"><strong>Compatible: </strong>Computers, tablets and smartphones</div>
                            <div class="form-group"><button tyle="submit" class="col-xs-12 btn btn-primary">Buy Now</button></div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="dropdown">
                            <button id="desc-btn" class="col-xs-12 btn btn-primary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Description
                                <span class="caret"></span>
                            </button>
                            <br /><br />
                            <div class="dropdown-menu well col-xs-12" aria-labelledby="desc-btn">
                                <?php echo $course['ProductDescription'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-nomenu.php';?>
</body>
</html>