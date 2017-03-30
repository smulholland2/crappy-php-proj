<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<!DOCTYPE html>
<html>
<head>
	<title>4u page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



</head>
<body>
<div class="container">
  <form class="form-horizontal" action='/courses/shop/add4u.php' method='get'>

<?php
error_reporting(0); 

session_start();
$discode_error = $_SESSION["discode_error"];
$logo_session = $_SESSION["logo"];
$htmlcodes_session = $_SESSION["htmlcodes"];

  if($discode_error)
  {
    echo $discode_error;
  }
?>

    <div class="page-header">
    <h1>Add New Vendor <br><small>This page is to create 4u and vendor pages.</small></h1>
    </div>

     <!-- add pricing group btn -->
    <div class="form-group" style="margin-left:0px" id="add_pricing_btn_container">
    <a href="/courses/shop/add_pricing_group.php" class="btn btn-primary" role="button">Add Pricing Group</a>
    </div>

    <!-- update pricing group btn -->
    <div class="form-group" style="margin-left:0px" id="update_pricing_btn_container">
    <a href="/courses/shop/update_pricing_group.php" class="btn btn-primary" role="button">Update Pricing Group</a>
    </div>


    <div class="form-group" style="margin-left:0px">
    <labeL>Page Content:</label>
    <input type="radio" name="pagecontent" id="singlecourse" value="/courses/shop/sc_product_list.php"> Buy One Course
    <input type="radio" name="pagecontent" id="multiplecourses" value="/courses/shop/sc_product_options_aa.php"> Buy Multiple Courses
    <input type="radio" name="pagecontent" id="enrollnow" value="/admin/tools/students"> Enroll Students
    <br><br>
    <div class="well well-sm">

    <div id="single_course_options">
      <input type="radio" name="single_course_ProID" id="aa_option" value="?ProID=aa"> Allergen Awareness <br>
      <input type="radio" name="single_course_ProID" id="ad_option" value="?ProID=ad"> Allergen Plan Development <br>
      <input type="radio" name="single_course_ProID" id="as_option" value="?ProID=as"> Allergen Plan Specialist <br>
      <input type="radio" name="single_course_ProID" id="azfsh_option" value="?ProID=azfsh"> Arizona Food Handler Training <br>
      <input type="radio" name="single_course_ProID" id="wvba_option" value="?ProID=WVBA"> Barbour County, WV Food Handler<br>
      <input type="radio" name="single_course_ProID" id="califsh_option" value="?ProID=califsh"> California Food Handler Training (Not San Diego)<br>
      <input type="radio" name="single_course_ProID" id="wvch_option" value="?ProID=WVCH"> Cabell-Huntington County, WV Food Handler<br>
      <input type="radio" name="single_course_ProID" id="cf_option" value="?ProID=cf"> Chef Fundamentals <br>
      <input type="radio" name="single_course_ProID" id="cb_option" value="?ProID=cb"> Cooking Basics <br>
      <input type="radio" name="single_course_ProID" id="emws_option" value="?ProID=emws"> Earn More With Service <br>
      <input type="radio" name="single_course_ProID" id="flfsh_option" value="?ProID=flfsh"> Florida Food Worker Training Program <br>
      <input type="radio" name="single_course_ProID" id="nfon_option" value="?ProID=nfon"> Food Handler (all other states) <br>
      <input type="radio" name="single_course_ProID" id="refs_option" value="?ProID=refs"> Food Safety Re-Certification Training <br>
      <input type="radio" name="single_course_ProID" id="fs_option" value="?ProID=fs"> Food Service Food Safety Manager Certification Training <br>
      <input type="radio" name="single_course_ProID" id="nhaccp_option" value="?ProID=nhaccp"> HACCP Managers Certificate Course <br>
      <input type="radio" name="single_course_ProID" id="idfsh_option" value="?ProID=idfsh"> Idaho Food Handler Training <br>
      <input type="radio" name="single_course_ProID" id="ilfsh_option" value="?ProID=ilfsh"> Illinois Food Handler <br>
      <input type="radio" name="single_course_ProID" id="imofsh_option" value="?ProID=mofsh"> Jackson County Food Handler Training <br>
      <input type="radio" name="single_course_ProID" id="wvfsh_option" value="?ProID=wvfsh"> Mid-Ohio Valley Health Department West Virginia Food Worker's Permit (Calhoun County, Pleasants County, Ritchie County, Roane County, Wirt County, and Wood County)<br>
      <input type="radio" name="single_course_ProID" id="remn_option" value="?ProID=remn"> Minnesota Food Safety Renewal Training <br>
      <input type="radio" name="single_course_ProID" id="wvmn_option" value="?ProID=WVMN"> Monroe County, WV Food Handler <br>
      <input type="radio" name="single_course_ProID" id="nmfsh_option" value="?ProID=nmfsh"> New Mexico Food Handler Training <br>
      <input type="radio" name="single_course_ProID" id="vaccfsh_option" value="?ProID=vaccfsh"> Norfolk VA Food Handler Training <br>
      <input type="radio" name="single_course_ProID" id="oh2_option" value="?ProID=oh2"> Ohio Level 2 Food Service Food Safety Manager Certification Training <br>
      <input type="radio" name="single_course_ProID" id="oh2rt_option" value="?ProID=oh2rt"> Ohio Level 2 Retail Food Safety Manager Certification Training <br>
      <input type="radio" name="single_course_ProID" id="ohfsh_option" value="?ProID=ohfsh"> Ohio Level One Certification <br>
      <input type="radio" name="single_course_ProID" id="wvpe_option" value="?ProID=WVPE"> Pendleton County, WV Food Handler <br>
      <input type="radio" name="single_course_ProID" id="wvpo_option" value="?ProID=WVPO"> Pocahontas County, WV Food Handler <br>
      <input type="radio" name="single_course_ProID" id="fsrt_option" value="?ProID=fsrt"> Retail Food Safety Manager Certification Training <br>
      <input type="radio" name="single_course_ProID" id="sd_option" value="?ProID=casd"> San Diego Food Handler Training  <br>
      <input type="radio" name="single_course_ProID" id="sfis_option" value="?ProID=sfis"> Strategies for Increasing Sales  <br>
      <input type="radio" name="single_course_ProID" id="txfsh_option" value="?ProID=txfsh"> Texas Food Handler Training  <br>
      <input type="radio" name="single_course_ProID" id="wvup_option" value="?ProID=WVUP"> Upshur County, WV Food Handler  <br>
      <input type="radio" name="single_course_ProID" id="utfsh_option" value="?ProID=utfsh"> Utah Food Handler  <br>
      <input type="radio" name="single_course_ProID" id="wvwa_option" value="?ProID=WVWA"> Wayne County, WV Food Handler  <br>
      <input type="radio" name="single_course_ProID" id="wvoh_option" value="?ProID=WVOH"> Wheeling-Ohio County, WV Food Handler  <br>
      <input type="radio" name="single_course_ProID" id="ksfsh_option" value="?ProID=ksfsh"> Wichita Food Handler Training  <br>
      <input type="radio" name="single_course_ProID" id="rewi_option" value="?ProID=rewi"> Wisconsin Re-Certification Training <br>
    </div>

    <div id="multiple_courses_options">
      <input type="checkbox" id="checkAll">Check/Uncheck All<br><br>
      <input type="checkbox" name="coursesarray[]" value="alcohol"> Alcohol Training <br>
      <input type="checkbox" name="coursesarray[]" value="aa"> Allergen Awareness <br>
      <input type="checkbox" name="coursesarray[]" value="ad"> Allergen Plan Development <br>
      <input type="checkbox" name="coursesarray[]"  value="as"> Allergen Plan Specialist <br>
      <input type="checkbox" name="coursesarray[]"  value="azfsh"> Arizona Food Handler Training <br>
      <input type="checkbox" name="coursesarray[]"  value="wvba"> Barbour County, WV Food Handler <br>
      <input type="checkbox" name="coursesarray[]"  value="wvch"> Cabell-Huntington County, WV Food Handler <br>
      <input type="checkbox" name="coursesarray[]"  value="califsh"> California Food Handler Training (Not San Diego) <br>
      <input type="checkbox" name="coursesarray[]" value="cf"> Chef Fundamentals <br>
      <input type="checkbox" name="coursesarray[]"  value="cb"> Cooking Basics <br>
      <input type="checkbox" name="coursesarray[]"  value="emws"> Earn More With Service <br>
      <input type="checkbox" name="coursesarray[]"  value="flfsh"> Florida Food Worker Training Program <br>
      <input type="checkbox" name="coursesarray[]"  value="fh"> Food Handler Training (MAP) <br>
      <input type="checkbox" name="coursesarray[]"  value="nfon"> Food Handler (all other states) <br>
      <input type="checkbox" name="coursesarray[]"  value="fs"> Food Service Food Safety Manager Certification Training <br>
      <input type="checkbox" name="coursesarray[]" value="nhaccp"> HACCP Managers Certificate Course <br>
      <input type="checkbox" name="coursesarray[]" value="idfsh"> Idaho Food Handler Training <br>
      <input type="checkbox" name="coursesarray[]" value="ilfsh"> Illinois Food Handler <br>
      <input type="checkbox" name="coursesarray[]" value="mofsh"> Jackson County Food Handler Training <br>
      <input type="checkbox" name="coursesarray[]"  value="wvfsh"> Mid-Ohio Valley Health Department West Virginia Food Worker's Permit (Calhoun County, Pleasants County, Ritchie County, Roane County, Wirt County, and Wood County) <br>
      <input type="checkbox" name="coursesarray[]"  value="remn"> Minnesota Food Safety Renewal Training <br>
      <input type="checkbox" name="coursesarray[]" value="wvmn"> Monroe County, WV Food Handler <br>
      <input type="checkbox" name="coursesarray[]" value="nmfsh"> New Mexico Food Handler Training <br>
      <input type="checkbox" name="coursesarray[]" value="vaccfsh"> Norfolk VA Food Handler Training <br>
      <input type="checkbox" name="coursesarray[]"  value="oh2"> Ohio Level 2 Food Service Food Safety Manager Certification Training <br>
      <input type="checkbox" name="coursesarray[]"  value="oh2rt"> Ohio Level 2 Retail Food Safety Manager Certification Training <br>
      <input type="checkbox" name="coursesarray[]"  value="ohfsh">  Ohio Level One Certification <br>
      <input type="checkbox" name="coursesarray[]"  value="wvpe"> Pendleton County, WV Food Handler <br>
      <input type="checkbox" name="coursesarray[]"  value="wvpo"> Pocahontas County, WV Food Handler <br>
      <input type="checkbox" name="coursesarray[]"  value="fsrt"> Retail Food Safety Manager Certification Training <br>
      <input type="checkbox" name="coursesarray[]"  value="reri"> Rhode Island Food Safety Re-Certification Training  <br>
      <input type="checkbox" name="coursesarray[]"  value="casd"> San Diego Food Handler Training  <br>
      <input type="checkbox" name="coursesarray[]"  value="sfis"> Strategies for Increasing Sales  <br>
      <input type="checkbox" name="coursesarray[]"  value="txfsh"> Texas Food Handler Training  <br>
      <input type="checkbox" name="coursesarray[]"  value="wvup"> Upshur County, WV Food Handler  <br>
      <input type="checkbox" name="coursesarray[]"  value="utfsh"> Utah Food Handler  <br>
      <input type="checkbox" name="coursesarray[]" value="wvwa"> Wayne County, WV Food Handler <br>
      <input type="checkbox" name="coursesarray[]" value="wvoh"> Wheeling-Ohio County, WV Food Handler <br>
      <input type="checkbox" name="coursesarray[]" value="ksfsh"> Wichita Food Handler Training <br>
      <input type="checkbox" name="coursesarray[]" value="rewi"> Wisconsin Re-Certification Training <br>
    </div>

    <div id="enrollnow_options">
      <label>Enrollment:</label>
      <select id="enrollnow_link">
        <option id="add_single" value="/admin/tools/students">Single (students can see all the courses)</option>
        <option id="add_multiple" value="/admin/tools/students">Multiple (students can see all the courses)</option>
        <option id="add_specific_course" value="/admin/tools/students/single">Specific Course (students will go straight to the form)</option>
      </select>
      <br><br>
      <label>Account Username: (students will be added to this Username)</label>
      <input type="text" class="form-control" name="UA_add" id="UA_add" style="width:200px">

      <div id="add_student_specific_course">
      <br>
      <input type="radio" name="add_stud_id" value="166"> Allergen Awareness <br>
      <input type="radio" name="add_stud_id" value="167"> Allergen Plan Development <br>
      <input type="radio" name="add_stud_id" value="168"> Allergen Plan Specialist <br>
      <input type="radio" name="add_stud_id" value="163"> Arizona Food Handler Training <br>
      <input type="radio" name="add_stud_id" value="77"> Barbour County, WV Food Handler<br>
      <input type="radio" name="add_stud_id" value="16"> California Food Handler Training (Not San Diego)<br>
      <input type="radio" name="add_stud_id" value="83"> Cabell-Huntington County, WV Food Handler<br>
      <input type="radio" name="add_stud_id" value="170"> Chef Fundamentals <br>
      <input type="radio" name="add_stud_id" value="4"> Cooking Basics <br>
      <input type="radio" name="add_stud_id" value="1"> Earn More With Service <br>
      <input type="radio" name="add_stud_id" value="75"> Florida Food Worker Training Program <br>
      <input type="radio" name="add_stud_id" value="3"> Food Handler (all other states) <br>
      <input type="radio" name="add_stud_id" value="14"> Food Safety Re-Certification Training <br>
      <input type="radio" name="add_stud_id" value="2"> Food Service Food Safety Manager Certification Training <br>
      <input type="radio" name="add_stud_id" value="6"> HACCP Managers Certificate Course <br>
      <input type="radio" name="add_stud_id" value="19"> Idaho Food Handler Training <br>
      <input type="radio" name="add_stud_id" value="162"> Illinois Food Handler <br>
      <input type="radio" name="add_stud_id" value="164"> Jackson County Food Handler Training <br>
      <input type="radio" name="add_stud_id" value="157"> Mid-Ohio Valley Health Department West Virginia Food Worker's Permit (Calhoun County, Pleasants County, Ritchie County, Roane County, Wirt County, and Wood County)<br>
      <input type="radio" name="add_stud_id" value="174"> Minnesota Food Safety Renewal Training <br>
      <input type="radio" name="add_stud_id" value="110"> Monroe County, WV Food Handler <br>
      <input type="radio" name="add_stud_id" value="18"> New Mexico Food Handler Training <br>
      <input type="radio" name="add_stud_id" value="74"> Norfolk VA Food Handler Training <br>
      <input type="radio" name="add_stud_id" value="172"> Ohio Level 2 Food Service Food Safety Manager Certification Training <br>
      <input type="radio" name="add_stud_id" value="175"> Ohio Level 2 Retail Food Safety Manager Certification Training <br>
      <input type="radio" name="add_stud_id" value="24"> Ohio Level One Certification <br>
      <input type="radio" name="add_stud_id" value="114"> Pendleton County, WV Food Handler <br>
      <input type="radio" name="add_stud_id" value="115"> Pocahontas County, WV Food Handler <br>
      <input type="radio" name="add_stud_id" value="169"> Retail Food Safety Manager Certification Training <br>
      <input type="radio" name="add_stud_id" value="184"> San Diego Food Handler Training  <br>
      <input type="radio" name="add_stud_id" value="5"> Strategies for Increasing Sales  <br>
      <input type="radio" name="add_stud_id" value="21"> Texas Food Handler Training  <br>
      <input type="radio" name="add_stud_id" value="123"> Upshur County, WV Food Handler  <br>
      <input type="radio" name="add_stud_id" value="80"> Utah Food Handler  <br>
      <input type="radio" name="add_stud_id" value="124"> Wayne County, WV Food Handler  <br>
      <input type="radio" name="add_stud_id" value="113"> Wheeling-Ohio County, WV Food Handler  <br>
      <input type="radio" name="add_stud_id" value="76"> Wichita Food Handler Training  <br>
      <input type="radio" name="add_stud_id" value="171"> Wisconsin Re-Certification Training <br>
      </div>
 
    </div>

    </div>
    </div>

   
    

    <!-- discode-->
    <div class="form-group" style="width:180px;margin-left:0px" id="discode_container">
    <label for="discode">Vendor Code (discode):</label>
    <input type="text" class="form-control" name="discode" id="discode" required>
    </div>

    <!-- price_discode -->
    <div class="form-group" style="width:180px;margin-left:0px" id="price_discode_container">
    <label for="price_discode">Price Discode (optional):</label>
    <input type="text" class="form-control" name="price_discode" id="price_discode" >
    </div>

    <!-- logo -->
    <div class="form-group" style="width:300px;margin-left:0px">
    <label for="logo">Logo:</label>
    <input type="text" class="form-control" name="logo" id="logo"  value="<?php if($logo_session){echo $logo_session;}?>">
    </div> 

    <input type="hidden" id="ProIDbox" style="width:250px">
    <input type="hidden" id="link" style="width:250px">
    

    <!-- corporate username -->
    <div class="form-group" style="margin-left:0px" id="corp_username_container">
    <label>Corporate Username?
    <input type="radio" name="corpcheckbox" id="dontshow" value="no"> No
    <input type="radio" name="corpcheckbox" id="showopt" value="yes"> Yes
    </label>
    </div>

    <div class="form-group" style="width:300px;margin-left:0px" id="corpdiv">
    <label for="logo">Corporate Username:</label>
    <input type="text" class="form-control" name="corporate_username" id="corporate_username">
    </div>


    <!-- region username -->
    <div class="form-group" style="margin-left:0px" id="region_username_container">
    <label>Region Username?
    <input type="radio" name="regioncheckbox" id="dontshowregion" value="no"> No
    <input type="radio" name="regioncheckbox" id="showoptregion" value="yes"> Yes
    </label>
    </div>

    <div class="form-group" style="width:300px;margin-left:0px" id="regiondiv">
    <label for="logo">Region Username:</label>
    <input type="text" class="form-control" name="region_username" id="region_username">
    </div>

    <br>
    <div class="form-group" style="margin-left:0px">
    <button class="btn btn-primary" id="copyHTMLbtn">Generate HTML code</button>
    </div>

    <br>
    <!-- html codgin -->
    <div class="form-group" style="margin-left:0px">
    <textarea name="htmlcodes" id="htmlcodes">
    </textarea>
    </div>

    <div class="form-group" style="margin-left:0px">
    <button type="submit" class="btn btn-primary">Submit</button>
    </div>

    </form>

</div>


<?php
// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 
?>

<script>
tinymce.init({
  selector: 'textarea',
  height: 500,
  theme: 'modern',
  verify_html: false,
  cleanup: false,
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample'
  ],
  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
  image_advtab: true,
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
});

$('document').ready(function(){


        //do this when page is loaded
        $("#add_student_specific_course").hide();
        $("#multiple_courses_options").hide();
        $("#enrollnow_options").hide();
        $("#corpdiv").hide();
        $("#dontshow").prop("checked", true)
        $("#regiondiv").hide();
        $("#dontshowregion").prop("checked", true)
        $("#singlecourse").prop("checked", true)
        $("#link").val("/courses/shop/sc_product_options_aa.php");
        $("#aa_option").prop("checked", true)
        $("#ProIDbox").val("?ProID=aa");




        //check/uncheck all
        $("#checkAll").change(function () {
          $("input:checkbox").prop('checked', $(this).prop("checked"));
        });


        // corporate username yes
         $('input[name=corpcheckbox]').click(function () {
          if (this.id == "showopt") {
              $("#corpdiv").show();
          } else {
              $("#corpdiv").hide();
          }
         });

          // region username yes
          $('input[name=regioncheckbox]').click(function () {
            if (this.id == "showoptregion") {
                $("#regiondiv").show();
            } else {
                $("#regiondiv").hide();
            }
          });

          // delete value 
          $("#dontshow").click(function(){
            $("#corporate_username").val("");  
          });

          // delete value 
          $("#dontshowregion").click(function(){
            $("#region_username").val("");  
          });  

          
          // single course radio btn
          $("#singlecourse").click(function(){
            $("#link").val("/courses/shop/sc_product_options_aa.php");
            $("#single_course_options").show();
            $("#multiple_courses_options").hide();
            $("#enrollnow_options").hide();
            $("input:checkbox").prop('checked', false);
            $("#aa_option").prop('checked', true);
            $("#ProIDbox").val("?ProID=aa");
            $("input[name=add_stud_id]").prop("checked", false);
            $("#add_pricing_btn_container").show();
            $("#update_pricing_btn_container").show();
            $("#price_discode_container").show();
            $("#corp_username_container").show();
            $("#region_username_container").show();
          });

          // multiple courses radio btn
          $("#multiplecourses").click(function(){
            $("#link").val("/courses/shop/sc_product_list.php");
            $("#multiple_courses_options").show();
            $("#single_course_options").hide();
            $("#enrollnow_options").hide();
            $("#ProIDbox").val("");
            $("input[name=add_stud_id]").prop("checked", false);
            $("#add_pricing_btn_container").show();
            $("#update_pricing_btn_container").show();
            $("#price_discode_container").show();
            $("#corp_username_container").show();
            $("#region_username_container").show();
          });

          // enrroll now radio btn
          $("#enrollnow").click(function(){
            $("#enrollnow_options").show();
            $("#link").val("/admin/tools/students"); 
            $("#single_course_options").hide();
            $("#multiple_courses_options").hide();
            $("#ProIDbox").val("");
            $("input[name=add_stud_id]").prop("checked", false);
            $('#add_single').prop('selected', true);
            $("#add_student_specific_course").hide();
            $("#add_pricing_btn_container").hide();
            $("#update_pricing_btn_container").hide();
            $("#price_discode_container").hide();
            $("#corp_username_container").hide();
            $("#region_username_container").hide();
          });


          // Enroll Student URL
          $("#enrollnow_link").change(function(){
             var enrollnow_changed_link = $(this).val();
             $("#link").val(enrollnow_changed_link);

             if(enrollnow_changed_link == "/admin/tools/students/single"){
               $("#add_student_specific_course").show();
               $("input[name=add_stud_id]").prop("checked", false);
             }
             else{
               $("#add_student_specific_course").hide();
             }

          });


          //Changes the ProID that will be sent in the link
          $("input[name=single_course_ProID]").click(function(){
          var ProID_value = $('input[name=single_course_ProID]:checked').val();
          $("#ProIDbox").val(ProID_value);
          });


         $("#copyHTMLbtn").click(function(e){
           e.preventDefault();
 
          var page = $("#link").val();
          var ProID = $("#ProIDbox").val();

          if(page == "/courses/shop/sc_product_list.php"){
            ProID = "";
          }

          if(page == "/courses/shop/sc_product_list.php" || page == "/courses/shop/sc_product_options_aa.php"){
            var btn_txt = "Buy Course";
            var buy_or_add_text = 'New customers, click "Buy Course" to purchase the course';
          }
          if(page == "/admin/tools/students" || page == "/admin/tools/students" || page == "/admin/tools/students/single"){
            var btn_txt = "Enroll Now";
            var buy_or_add_text = 'Click "Enroll Now" to register to the course';
          }



          conole.log(page);


          var template = '<h4>' + buy_or_add_text + '.<br>Click "Go to Course" to start/resume your training.</h4>';
          template += '<br>';
          template += '<a href="' + page + '' + ProID + '" class="btn btn-primary" role="button">' + btn_txt + '</a>';
          template += '<a href="/training/" class="btn btn-primary" role="button">Go to Course</a>';
          template += '<a href="/certificate/" class="btn btn-primary" role="button">Print Certificate</a>';
          template +='<br><br>';
          template +='<h4>Existing accounts, click below to access your account and purchase more courses.</h4>';
          template += '<br>';
          template += '<a href="/account/login/" class="btn btn-primary" role="button">Account Logon</a>';
          template += '<br><br>';
          template += '<h4>Click on the link below for tutorials.</h4>';
          template += '<br>';
          template += '<a href="/home/tutorials" class="btn btn-primary" role="button">Tutorials</a>';
          template += '<br><br>';
          template += '<h4>For technical support, please call<br>888-826-5222</h4>';
          template += '<br>';
          template += '<h4><strong>&#169; Copyright 2016 TAP Series, LLC <br><a style="text-decoration:none" href="/home/privacy">Privacy Policy</a></strong></h4>';
          tinymce.activeEditor.setContent(template, {format: 'raw'});
          console.log(template);
           });

});

</script>

</body>
</html>  

