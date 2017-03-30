<div class="navbar navbar-inverse navbar-fixed-top tap-nav">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">TAP SERIES</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav main-menu">
        <li id="courses_scroll">
						<a id="courses" href="/#course-list" class="english hidden-xs">Purchase Courses</a>
						<a id="courses" href="/#course-list" class="spanish hidden-xs" style="display: none;">Cursos</a>
						<a id="courses" href="/#course-list" class="english epurchase visible-xs">Purchase Course</a>
						<a id="courses" href="/#course-list" class="spanish spurchase" style="display: none;">Comprar Curso</a>
				</li>
				<li>
						<a href="/training" class="english">Login to Course</a>
						<a href="/training" class="spanish" style="display: none;">Entrar al Curso</a>
				</li>
				<li>
						<a href="/certificate" class="english">Print Certificate</a>
						<a href="/certificate" class="spanish" style="display: none;">Imprimir Certificado</a>
				</li>
				<li>
						<a href="/account/login" class="english">Administration</a>
						<a href="/account/login" class="spanish" style="display: none;">Administrador</a>
				</li>
				<li>
						<a href="/testcenters" class="english">Test Centers</a>
						<a href="/testcenters" class="spanish" style="display: none;">Centros de Examen</a>
				</li>				
				<li>
						<a href="/home/troubleshooting" class="english">Support</a>
						<a href="/home/troubleshooting" class="spanish" style="display: none;">Ayuda Técnica</a>
				</li>
      </ul>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<div id="google_translate_element"></div>
<script type="text/javascript">
function googleTranslateElementInit() {
new google.translate.TranslateElement({pageLanguage: 'en', gaTrack: true, gaId: 'UA-90442747-1'}, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<style>
.tap-nav{
	font-size:16px;
}
.navbar-fixed-top .navbar-collapse{
	max-height:600px;
}
#google_translate_element {
	position:fixed;
	top: 80px;
  right: 5px;
}
@media only screen and (max-width: 1200px) {
.tap-nav {
    font-size: 10px;
}
.navbar-brand {
	font-size:18px;
}
ul li a{
	font-size:14px;
}
.main-menu {
	float: right;
}
}
@media only screen and (max-width: 900px) {
ul li a{
	font-size:10px;
}
.nav>li{
	margin-left:-12px;
}
}
@media only screen and (max-width: 767px) {
.main-menu {
	float: left;
}
ul li a{
	font-size:25px;
}
}


</style>