<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Certificate Of Achievement - <small>Earn More with Service</small></h1>
            </div>
            <br />
            <div class="row well cert-login-forms"> <!-- UN/PW Login Form -->
                <a href="/certificate" class="btn btn-primary">Back to Courses</a>
                <form method="POST" action="http://asp.tapseries.com/certificate/ShowCertificate_.asp" class="dobform">
                    <input type="hidden" name="lname200" />
                    <input type="hidden" name="month" value="Month" />
                    <input type="hidden" name="day" value="Day" />
                    <input type="hidden" name="year" value="Year" />
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="lastname">Last Name (Apellido):</label>
                        <input type="text" name="lname100" class="form-control"/>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="username">User Name (Nombre de Usuario):</label>
                        <input type="text" class="form-control" name="ctname933"/>
                    </div>
                    <div class="clearfix"></div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>               
            </div><!-- /UN/PW Login Form -->
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>