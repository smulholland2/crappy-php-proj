<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';?>
<?php 

    $hidden_productid = "<input type='hidden' value='" . $_POST["productid"] . "'" . "name='productid' />";
    $hidden_newstudentval = "<input type='hidden' value='" . $_POST["newstudentval"] . "'" . "name='newstudentval' />";

?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Upload Multiple Students</h1>
            </div>
			<br />
            <div class="row">
                <form action="/admin/tools/students/excel/review" method="post" enctype="multipart/form-data">
                    <?php echo $hidden_productid; ?>
                    <?php echo $hidden_newstudentval; ?>
                    <div class="form-group">
                        <label for="fileToUpload">Select Excel file to upload:</label>
                        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control uploader">                        
                    </div>
                    <br />
                    <div class="form-group">
                        <input type="submit" value="Upload Excel File" name="submit" class="btn btn-primary">
                    </div<
                </form>
            </div>
			<br />
        </div>        
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
</body>
</html>
