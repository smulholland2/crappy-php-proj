<?php	
	// start the css directory file path.
	$jsFile = "/wwwroot/js/";

	// check for path
	if(dirname($_SERVER["PHP_SELF"]) != '\\')
		$jsFile .= ltrim(dirname($_SERVER["PHP_SELF"]),'/') . "/";
	
	// remove the .php file extension from the PHP_SELF variable by passing '' as the replacement argument.	
	$jsFile .= str_replace(".php", "", basename($_SERVER['PHP_SELF']));

	// append the .js file extension so we can echo the $jsFile variable cleanly in the script call in the footer.
	$jsFile .= ".js";
?>
<footer>
	<div id="footeropt">
		<div id="footeropt">
		<div class="footercol">
			<p style="font-weight:bold" class="english">Information</p><p style="font-weight:bold" class="spanish">Informaci&oacute;n</p><br>			
			<a href="/students/studentProgress.php"><p class="english">Student Track Progress</p><p class="spanish">Calificaciones del Estudiante</p></a>
			<a href="http://asp.tapseries.com/califsh_verify.asp"><p class="english">Food Handler Certificate Verification</p><p class="spanish">Verificaci&oacute;n de Certificados</p></a>
			<p style="font-weight:bold" class="english">Information</p><p style="font-weight:bold" class="spanish">Informaci&oacute;n</p><br>
			<a href="/certificate/verify"><p class="english">Food Handler Certificate Verification</p><p class="spanish">Verificaci&oacute;n de Certificados</p></a>
			<a href="/home/quotes"><p class="english">Quotes from Customers</p><p class="spanish">Comentarios de Clientes</p></a>
			<a href="/blog"><p>TAP Series Blog</p></a>			
			<a href="http://tapseries-assets.s3-website-us-east-1.amazonaws.com/fs9demo/shell.html"><p class="english">View Course Demo</p><p class="spanish">Veer Demostraci&oacute;n de Curso</p></a>
			<a href="/home/contactus"><p class="english">Contact Us</p><p class="spanish">Contactenos</p></a>
		</div>
		<div class="footercol">
			<p style="font-weight:bold" class="english">FAQ's</p><p style="font-weight:bold" class="spanish">Preguntas Frequentes</p><br>
			<a href="/home/tutorials"><p class="english">Tutorials</p><p class="spanish">Tutorias</p></a>
			<a href="/home/taptrac"><p>TAP-TRAC LMS</p></a>						
			<a href="/home/systemrequirements"><p class="english">System Requirements</p><p class="spanish">Requisitos del Sistema</p></a>
			<a href="/wwwroot/pdf/PAS_Flierv4.pdf"><p class="english">Food Safety Certification <br>Training Warranty</p><p class="spanish">Garantia del Entrenamiento de <br>Salubridad Alimenticia</p></a>
		</div>
		<div class="footercol">		
			<p style="font-weight:bold" class="english">Policy</p><p style="font-weight:bold" class="spanish">Pol&iacute;ticas</p><br>
			<a href="/home/regulatory_requirements"><p class="english">Regulatory Requirements</p><p class="spanish">Requisitos Regulatorios</p></a>
			<a href="/home/privacy"><p class="english">Privacy policy</p><p class="spanish">Pol&iacute;tica de Privacidad</p></a>
			<a href="/home/privacyh"><p class="english">Food Handler Privacy Policy (English)</p><p class="spanish">Pol&iacute;tica de Privacidad de Manejadores de Alimentos (Ingles)</p></a>
			<a href="/home/privacyhs"><p class="english">Food Handler Privacy Policy (Spanish)</p><p class="spanish">Pol&iacute;tica de Privacidad de Manejadores de Alimentos (Espa&ntilde;ol)</p></a>
			<!--<p class="english">Client/Regulator Comments</p><p class="spanish">Comentarios de Clientes/Reguladores</p>-->
			<a href="/home/return"><p class="english">Return Policy / Terms of Purchase</p><p class="spanish">Pol&iacute;tica de Devoluciones / Terminos de Compra</p></a>
		</div>
	</div>
	</div>
	<p style="text-align:center;margin-top:0px">
		<a href="http://facebook.com/TAPSeries" target="_blank"><img src="/wwwroot/images/facebook1.png" style="width:60px"></a>
		<a href="https://twitter.com/tapseries_" target="_blank"><img src="/wwwroot/images/twitter.png" style="width:60px"></a>
		<a href="https://www.linkedin.com/company/tap-series" target="_blank"><img src="/wwwroot/images/linkedin1.png" style="width:60px"></a>
	</p>
	<p style="text-align:center;margin-top:50px;font-size:15px">&copy;  Copyright 2016&nbsp;<b>TAPSeries.com</b>. All rights reserved.</p>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="/wwwroot/lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/wwwroot/lib/js/date-picker.min.js"></script>
<script src="/wwwroot/js/site.js" type="text/javascript"></script>
<?php echo file_exists($_SERVER["DOCUMENT_ROOT"] . $jsFile) ? '<script src="'. $jsFile .'" type="text/javascript"></script>': ''; ?>

