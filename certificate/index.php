<?php 

    include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';

    if(isset($_GET['invalid']))
        $invalidlogin = true;

?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Certificate Of Achievement</h1>
            </div>
            <div class="row col-md-6 col-md-offset-3 <?php echo isset($invalidlogin) ? 'hello': 'hidden' ?>">
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>ERROR:</strong> That username was not found. Please try again.
                </div>
            </div>
			<br />
            <div class="clearfix"></div>
            <div class="row well"> <!-- Choose Your Course Section -->
                <div id="our_courses" class="col-md-12">
                    <h3 class="english" title="food safety courses">Please Select A Course</h3>
                    <h3 class="spanish" title="cursos de salubridad de alimentos" style="display: none;">Nuestros Cursos</h3>
                    <div class="coursesbox col-md-12">
                        <a href="/certificate/foodhandler" style="color: white;">
                            <div class="course col-md-6">
                                <p class="english" title="online food handlers course">Food Handler</p>
                                <p class="spanish" style="font-size: 22px; display: none;" title="curso online para manejadores de alimentos">Manejador de Alimentos</p>
                            </div>
                        </a>
                        <a href="/certificate/foodsafteymanager" style="color: white;">
                            <div class="course col-md-6">
                                <p class="english" title="online food safety manager course">Food Safety Manager</p>
                                <p class="spanish" style="font-size: 22px; display: none;" title="curso para gerentes de salubridad de alimentos">Gerente de Salubridad de Alimentos</p>
                            </div>
                        </a>
                    </div>
                    <div class="coursesbox col-md-12">
                        <a href="/certificate/haccp" style="color: white;">
                            <div class="course col-md-6">
                                <p title="online haccp course">HACCP</p>
                            </div>
                        </a>
                        <a href="/certificate/allergentraining" style="color: white;">
                            <div class="course col-md-6">
                                <p class="english" title="online food allergy courses">Allergen Friendly</p>
                                <p class="spanish" title="cursos de alergenos en alimentos" style="display: none;">Alergenos en Alimentos</p>
                            </div>
                        </a>
                    </div>
                    <div class="coursesbox col-md-12">
                        <a href="/certificate/foodsafetyrecert" style="color: white;">
                            <div class="course col-md-6">
                                <p class="english" title="other online food safety courses"><small>Food Safety Recertification</small></p>
                                <p class="spanish" style="font-size: 22px; display: none;" title="otros cursos para salubridad de alimentos">Operaciones de Servicios de Alimentos</p>
                            </div>
                        </a>
                        <a href="/certificate/alcoholtraining" style="color: white;">
                            <div class="course col-md-6">
                                <p class="english" title="online alcohol training">Alcohol Training</p>
                                <p class="spanish" title="curso de entrenamiento de alcohol" style="display: none;">Entrenamiento de Alcohol</p>
                            </div>
                        </a>
                    </div>
                    <div class="coursesbox col-md-12">
                        <a href="/certificate/cookingbasics" style="color: white;">
                            <div class="course col-md-6">
                                <p class="english" title="other online food safety courses">Cooking Basics</p>
                                <p class="spanish" style="font-size: 22px; display: none;" title="otros cursos para salubridad de alimentos">Operaciones de Servicios de Alimentos</p>
                            </div>
                        </a>
                        <a href="/certificate/emws" style="color: white;">
                            <div class="course col-md-6">
                                <p class="english" title="online alcohol training">Earn More with Service</p>
                                <p class="spanish" title="curso de entrenamiento de alcohol" style="display: none;">Entrenamiento de Alcohol</p>
                            </div>
                        </a>
                    </div>
                    <div class="coursesbox col-md-12">
                        <a href="/certificate/sfis" style="color: white;">
                            <div class="course col-md-6">
                                <p class="english" title="other online food safety courses">Strategies for Increasing Sales</p>
                                <p class="spanish" style="font-size: 22px; display: none;" title="otros cursos para salubridad de alimentos">Operaciones de Servicios de Alimentos</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div><!-- /Choose Your Course Section -->
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>