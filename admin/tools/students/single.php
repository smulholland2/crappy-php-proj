<?php

    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/tools/students/StudentsController.php';

    $student = new StudentsController();
    
    $usernameLabel = "Username";

    $productId = null;
    if(isset($_POST["numstudents"]))
        if($_POST["numstudents"] == '')
            header('Location:/admin/tools/students');

    if(isset($_POST["firstname"]))
        $student -> AddSingle();
    else if(isset($_POST["productid"]) || isset($_SESSION['Serial']) || isset($_SESSION["student"]) || isset($_SESSION['postpurchase']))
    {
        if(isset($_POST["productid"]))
            if($_POST["productid"] == '')
                header('Location:/admin/tools/students');

        $student -> GetCourseData();

        // Set up the optional fields
        $isStoreNum = $student -> CheckStoreNum();        
        if(isset($_SESSION["student"]['productid']) || isset($_SESSION['Serial']['ProductId']))
        {
            if(isset($_SESSION["student"]['productid']))
                $productId = $_SESSION["student"]['productid'];
            else if(isset($_SESSION['Serial']['ProductId']))
                $productId = $_SESSION["Serial"]['ProductId'];
            
            $isSpanish = $student -> SpanishAvailable($productId);
            $isDobRequired = $student -> CheckDobRequired($productId);
            $isAlaska = $productId == 185 ? true : false;
        }
        else if(isset($_SESSION['postpurchase']))
        {
            $productId = $student -> GetProductId($_SESSION['ProID']);
            $isSpanish = $student -> SpanishAvailable($productId['id']);
            $isDobRequired = $student -> CheckDobRequired($productId['id']);
            $isAlaska = $productId['id'] == 185 ? true : false;
        }
        else
        {
            $isSpanish = $student -> SpanishAvailable();
            $isDobRequired = $student -> CheckDobRequired();
            $isAlaska = $_POST['productid'] == 185 ? true : false;
        }        
        $storeNumField = '';
        $dobField = '';

        // Check for Travel Centers of America discode and change the labels of some of the fields.
        $isTCOA = false;
        if(isset($_SESSION['discode']))
            $isTCOA =  substr($_SESSION['discode'],0,4) == 'tcoa' ? true : false;            

        if($isStoreNum)
        {
            $storeNumField  = '<div class="form-group col-md-12">';
            if($isTCOA){
                $usernameLabel =  '9 Digit Employee Number (Username)';
                $storeNumField .= '<label for=""><span class="text-danger">*</span> Store Number: </label>';
                $storeNumField .= '<br><small>Must be 6 numbers. Example: 015700 (restaurant), 015800 (QSR), 015300 (store)</small>';
                $storeNumField .= '<input type="text" class="form-control" name="storenum" maxlength="6" />';
            }
            else {
                $storeNumField .= '<label for=""><span class="text-danger">*</span> Store Number:</label>';
                $storeNumField .= '<input type="text" class="form-control" name="storenum"/>';
            }
            $storeNumField .= '</div>';
        }
        if($isDobRequired)
        {
            $dobField  = '<label for="" class="col-sm-12">';
            $dobField .= '<span class="text-danger">*</span> Student Birthdate:</label>';
            $dobField .= '<div class="date-picker dob-picker"></div>';
        }
    }
    else
        header("Location:/admin/tools/students");

    if(isset($_SESSION["studentErrors"]))
    {
        $errmsg = '<div class="alert alert-danger alert-dismissible" role="alert">';
        $errmsg .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        $errmsg .= '<strong>Error!</strong> Please fix the following errors and try again.<ul>';
        foreach ($_SESSION["studentErrors"][0] as $key => $error) {
            foreach ($error as $key => $value) {
                $errmsg .= '<li>'.$value.'</li>';
            }
        }
        $errmsg .= '</ul></div>';

        $productId = $_SESSION["student"]['productid'];
        $lang = $_SESSION["student"]['language'];

        unset($_SESSION["studentErrors"]);
        unset($_SESSION["student"]['add_student_error']);
        unset($_SESSION["student"]['add_student_error_msg']);
    }

    $isUtah = false;
    if(isset($_SESSION["student"]))
        $isUtah = $_SESSION["student"]['productid'] == $student::UTAHPROID ? true : false;
    else
        $isUtah = $student -> productid == $student::UTAHPROID ? true : false;

?>
<?php
    if(isset($_SESSION['Serial']) || isset($_SESSION['postpurchase']))
        include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';
    else
        include_once $_SERVER['DOCUMENT_ROOT'].'/shared/header-admin.php';
?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Add New Student</h1>
            </div>
            <div class="row"><a href="/admin/tools/students" class="btn btn-primary">Go Back</a></div>
            <?php echo isset($errmsg) ? $errmsg: false; ?>
            <div class="row">
                <p>Please enter the student's information.</p>
            </div>
			<br />
            <div class="row">
                 <form method="POST">
                    <input type="hidden" name="productid" value="<?php echo isset($_SESSION["student"]['productid']) ? $_SESSION["student"]['productid'] : $student -> productid  ?>"/>
                    <input type="hidden" name="tablecode" value="<?php echo isset($_SESSION["student"]['tablecode']) ? $_SESSION["student"]['tablecode'] : $student -> tablecode  ?>"/>
                    <input type="hidden" name="courselink" value="<?php echo isset($_SESSION["student"]['courselink']) ? $_SESSION["student"]['courselink'] : $student -> courselink  ?>"/>
                    <input type="hidden" name="scourselink" value="<?php echo isset($_SESSION["student"]['scourselink']) ? $_SESSION["student"]['scourselink'] : $student -> scourselink  ?>"/>
                    <input type="hidden" name="coursename" value="<?php echo isset($_SESSION["student"]['coursename']) ? $_SESSION["student"]['coursename'] : $student -> coursename  ?>"/>
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> First Name:</label>
                            <input type="text" class="form-control" name="firstname" required maxlength="69"
                            value="<?php echo isset($_SESSION["student"]['firstname']) ? $_SESSION["student"]['firstname'] : ""  ?>" />
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> Last Name:</label>
                            <input type="text" class="form-control" name="lastname" required maxlength="69"
                            value="<?php echo isset($_SESSION["student"]['lastname']) ? $_SESSION["student"]['lastname'] : ""  ?>" />
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger"><?php echo $isDobRequired ? "" : "*"; ?></span> Student Email:</label>
                            <input type="text" class="form-control" name="email" maxlength="69" <?php echo $isDobRequired ? "" : "required"; ?>
                                value="<?php echo isset($_SESSION["student"]['email']) ? $_SESSION["student"]['email'] : ""  ?>" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger"><?php echo $isDobRequired ? "" : "*"; ?></span> Confirm Email:</label>
                            <input type="text" class="form-control" name="confirmemail" id="confirmemail" maxlength="69" <?php echo $isDobRequired ? "" : "required"; ?> />
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for="">Manager Email:</label>
                            <input type="text" class="form-control" name="adminemail" maxlength="69"
                                value="<?php echo isset($_SESSION["student"]['adminemail']) ? $_SESSION["student"]['adminemail'] : ""  ?>" />
                        </div>                        
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> <?php echo $usernameLabel; ?>:</label>
                            <input type="text" class="form-control user-input" name="username" required 
                                value="<?php echo isset($_SESSION["student"]['username']) ? $_SESSION["student"]['username'] : "";  ?>" 
                                <?php echo $isTCOA ? "maxlength = '9'" : "maxlength = '25'"; ?> />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> Training Password:</label>
                            <input type="text" class="form-control pass-input" name="password" required maxlength="24"/>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> Verify Password:</label>
                            <input type="text" class="form-control pass-input" id="confirmpass" name="pass2" required maxlength="24"/>
                        </div>
                        <?php echo $storeNumField; ?>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for=""><span class="text-danger">*</span> Training Program:</label>
                            <input type="text" class="form-control" name="coursename" required disabled 
                            value="<?php echo isset($_SESSION["student"]['coursename']) ? $_SESSION["student"]['coursename'] : $student -> coursename  ?>" />
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for="lang"><span class="text-danger">*</span> Training Language:</label>
                            <select class="form-control" name="lang">
                                <?php if($isSpanish && !$isAlaska)
                                    echo "<option value='english'>English</option><option value='spanish'>Spanish</option>";
                                else if($isAlaska)
                                    echo "<option value='english'>English</option>
                                            <option value='spanish'>Spanish</option>
                                            <option value='mandarin'>Mandarin</option>
                                            <option value='korean'>Korean</option>
                                            <option value='vietnamese'>Vietnamese</option>
                                            <option value='tagalog'>Tagalog</option>";
                                else
                                    echo "<option value='english'>English</option>";
                                ?>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <?php echo $dobField; ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="well <?php echo $isUtah ? '' : 'hidden'?>">
                        <h4>State of Utah required information - <small>The state of Utah requires the following additional information in order for students to recieve a certificate.</small></h4>
                        <div class="col-sm-6">
                        <div class="form-group">
                            <label><span class="text-danger">*</span> Gender: </label>
                            <select class="form-control" name="gender">
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                        </div>                        
                        <div class="form-group">
                            <label><span class="text-danger">*</span> City: </label>
                            <select class="form-control" name="city">
                                <option value="">Click here to view list</option>
                                <option value="Alpine">Alpine</option>
                                <option value="Alta">Alta</option>
                                <option value="Altamont">Altamont</option>
                                <option value="Alton">Alton</option>
                                <option value="Amalga">Amalga</option>
                                <option value="American Fork">American Fork</option>
                                <option value="Annabella">Annabella</option>
                                <option value="Antimony">Antimony</option>
                                <option value="Apple Valley">Apple Valley</option>
                                <option value="Aurora">Aurora</option>
                                <option value="Ballard">Ballard</option>
                                <option value="Bear River">Bear River</option>
                                <option value="Beaver City">Beaver City</option>
                                <option value="Beaver County">Beaver County</option>
                                <option value="Beryl">Beryl</option>
                                <option value="Bicknell">Bicknell</option>
                                <option value="Big Water">Big Water</option>
                                <option value="Blanding">Blanding</option>
                                <option value="Bluffdale">Bluffdale</option>
                                <option value="Bluffdale South">Bluffdale South</option>
                                <option value="Boulder">Boulder</option>
                                <option value="Bountiful">Bountiful</option>
                                <option value="Box Elder County">Box Elder County</option>
                                <option value="Brian Head">Brian Head</option>
                                <option value="Brigham">Brigham</option>
                                <option value="Bryce Canyon">Bryce Canyon</option>
                                <option value="Cache County">Cache County</option>
                                <option value="Cache Valley Transit">Cache Valley Transit</option>
                                <option value="Cannonville">Cannonville</option>
                                <option value="Carbon County">Carbon County</option>
                                <option value="Castle Dale">Castle Dale</option>
                                <option value="Castle Valley">Castle Valley</option>
                                <option value="Cedar City">Cedar City</option>
                                <option value="Cedar Fort">Cedar Fort</option>
                                <option value="Cedar Hills">Cedar Hills</option>
                                <option value="Centerfield">Centerfield</option>
                                <option value="Centerville">Centerville</option>
                                <option value="Central Valley">Central Valley</option>
                                <option value="Charleston">Charleston</option>
                                <option value="Circleville">Circleville</option>
                                <option value="Clarkston">Clarkston</option>
                                <option value="Clawson">Clawson</option>
                                <option value="Clearfield">Clearfield</option>
                                <option value="Cleveland">Cleveland</option>
                                <option value="Clinton">Clinton</option>
                                <option value="Coalville">Coalville</option>
                                <option value="Corinne">Corinne</option>
                                <option value="Cornish">Cornish</option>
                                <option value="Cottonwood Heights">Cottonwood Heights</option>
                                <option value="Daggett County">Daggett County</option>
                                <option value="Daniel">Daniel</option>
                                <option value="Davis County">Davis County</option>
                                <option value="Delta">Delta</option>
                                <option value="Deweyville">Deweyville</option>
                                <option value="Draper">Draper</option>
                                <option value="Draper City South">Draper City South</option>
                                <option value="Duchesne City">Duchesne City</option>
                                <option value="Duchesne County">Duchesne County</option>
                                <option value="Eagle Mountain">Eagle Mountain</option>
                                <option value="East Carbon">East Carbon</option>
                                <option value="Elk Ridge">Elk Ridge</option>
                                <option value="Elmo">Elmo</option>
                                <option value="Elsinore">Elsinore</option>
                                <option value="Elwood">Elwood</option>
                                <option value="Emery City">Emery City</option>
                                <option value="Emery County">Emery County</option>
                                <option value="Enoch">Enoch</option>
                                <option value="Enterprise">Enterprise</option>
                                <option value="Ephraim">Ephraim</option>
                                <option value="Erda">Erda</option>
                                <option value="Escalante">Escalante</option>
                                <option value="Eureka">Eureka</option>
                                <option value="Fairfield">Fairfield</option>
                                <option value="Fairview">Fairview</option>
                                <option value="Falcon Hill Clearfield<">Falcon Hill Clearfield</option>
                                <option value="Falcon Hill Davis">Falcon Hill Davis</option>
                                <option value="Falcon Hill Riverdale">Falcon Hill Riverdale</option>
                                <option value="Falcon Hill Roy">Falcon Hill Roy</option>
                                <option value="Falcon Hill Sunset">Falcon Hill Sunset</option>
                                <option value="Farmington">Farmington</option>
                                <option value="Farr West">Farr West</option>
                                <option value="Fayette">Fayette</option>
                                <option value="Ferron">Ferron</option>
                                <option value="Fielding">Fielding</option>
                                <option value="Fillmore">Fillmore</option>
                                <option value="Fountain Green">Fountain Green</option>
                                <option value="Francis">Francis</option>
                                <option value="Fruit Heights">Fruit Heights</option>
                                <option value="Garden City">Garden City</option>
                                <option value="Garfield County">Garfield County</option>
                                <option value="Garland">Garland</option>
                                <option value="Genola">Genola</option>
                                <option value="Glendale">Glendale</option>
                                <option value="Glenwood">Glenwood</option>
                                <option value="Goshen">Goshen</option>
                                <option value="Grand County">Grand County</option>
                                <option value="Grantsville">Grantsville</option>
                                <option value="Green River">Green River</option>
                                <option value="Gunnison">Gunnison</option>
                                <option value="Hanksville">Hanksville</option>
                                <option value="Harrisville">Harrisville</option>
                                <option value="Hatch">Hatch</option>
                                <option value="Heber">Heber</option>
                                <option value="Helper">Helper</option>
                                <option value="Henefer">Henefer</option>
                                <option value="Henrieville">Henrieville</option>
                                <option value="Herriman">Herriman</option>
                                <option value="Hideout">Hideout</option>
                                <option value="Highland">Highland</option>
                                <option value="Hildale">Hildale</option>
                                <option value="Hinckley">Hinckley</option>
                                <option value="Holden">Holden</option>
                                <option value="Holladay">Holladay</option>
                                <option value="Honeyville">Honeyville</option>
                                <option value="Hooper">Hooper</option>
                                <option value="Howell">Howell</option>
                                <option value="Huntington">Huntington</option>
                                <option value="Huntsville">Huntsville</option>
                                <option value="Hurricane">Hurricane</option>
                                <option value="Hyde Park">Hyde Park</option>
                                <option value="Hyrum">Hyrum</option>
                                <option value="Independence">Independence</option>
                                <option value="Iron County">Iron County</option>
                                <option value="Ivins">Ivins</option>
                                <option value="Joseph">Joseph</option>
                                <option value="Juab County<">Juab County</option>
                                <option value="Junction">Junction</option>
                                <option value="Kamas">Kamas</option>
                                <option value="Kanab">Kanab</option>
                                <option value="Kanarraville">Kanarraville</option>
                                <option value="Kane County">Kane County</option>
                                <option value="Kanosh">Kanosh</option>
                                <option value="Kaysville">Kaysville</option>
                                <option value="Kingston">Kingston</option>
                                <option value="Koosharem">Koosharem</option>
                                <option value="La Verkin">La Verkin</option>
                                <option value="Lakepoint">Lakepoint</option>
                                <option value="Laketown">Laketown</option>
                                <option value="Layton">Layton</option>
                                <option value="Leamington">Leamington</option>
                                <option value="Leeds">Leeds</option>
                                <option value="Lehi">Lehi</option>
                                <option value="Levan">Levan</option>
                                <option value="Lewiston">Lewiston</option>
                                <option value="Lincoln">Lincoln</option>
                                <option value="Lindon">Lindon</option>
                                <option value="Loa">Loa</option>
                                <option value="Logan">Logan</option>
                                <option value="Lyman">Lyman</option>
                                <option value="Lynndyl">Lynndyl</option>
                                <option value="Manila">Manila</option>
                                <option value="Manti">Manti</option>
                                <option value="Mantua">Mantua</option>
                                <option value="Mapleton">Mapleton</option>
                                <option value="Marriott-Slaterville">Marriott-Slaterville</option>
                                <option value="Marysvale">Marysvale</option>
                                <option value="Mayfield">Mayfield</option>
                                <option value="Meadow">Meadow</option>
                                <option value="Mendon">Mendon</option>
                                <option value="Midvale">Midvale</option>
                                <option value="Midway">Midway</option>
                                <option value="Milford">Milford</option>
                                <option value="Millard County">Millard County</option>
                                <option value="Millville">Millville</option>
                                <option value="Minersville">Minersville</option>
                                <option value="Moab">Moab</option>
                                <option value="Mona">Mona</option>
                                <option value="Monroe">Monroe</option>
                                <option value="Monticello">Monticello</option>
                                <option value="Morgan City">Morgan City</option>
                                <option value="Morgan County">Morgan County</option>
                                <option value="Moroni">Moroni</option>
                                <option value="Mt. Pleasant">Mt. Pleasant</option>
                                <option value="Murray">Murray</option>
                                <option value="Myton">Myton</option>
                                <option value="Naples">Naples</option>
                                <option value="Nephi">Nephi</option>
                                <option value="New Harmony">New Harmony</option>
                                <option value="Newton">Newton</option>
                                <option value="Nibley">Nibley</option>
                                <option value="North Logan">North Logan</option>
                                <option value="North Ogden">North Ogden</option>
                                <option value="North Salt Lake">North Salt Lake</option>
                                <option value="Oak City">Oak City</option>
                                <option value="Oakley">Oakley</option>
                                <option value="Ogden">Ogden</option>
                                <option value="Ophir">Ophir</option>
                                <option value="Orangeville">Orangeville</option>
                                <option value="Orderville">Orderville</option>
                                <option value="Orem">Orem</option>
                                <option value="Panguitch">Panguitch</option>
                                <option value="Paradise">Paradise</option>
                                <option value="Paragonah">Paragonah</option>
                                <option value="Park City">Park City</option>
                                <option value="Park City East">Park City East</option>
                                <option value="Parowan">Parowan</option>
                                <option value="Payson">Payson</option>
                                <option value="Perry">Perry</option>
                                <option value="Piute County">Piute County</option>
                                <option value="Plain City">Plain City</option>
                                <option value="Pleasant Grove">Pleasant Grove</option>
                                <option value="Pleasant View">Pleasant View</option>
                                <option value="Plymouth">Plymouth</option>
                                <option value="Portage">Portage</option>
                                <option value="Price">Price</option>
                                <option value="Providence">Providence</option>
                                <option value="Provo">Provo</option>
                                <option value="Randolph">Randolph</option>
                                <option value="Redmond">Redmond</option>
                                <option value="Rich County">Rich County</option>
                                <option value="Richfield">Richfield</option>
                                <option value="Richmond">Richmond</option>
                                <option value="River Heights">River Heights</option>
                                <option value="Riverdale">Riverdale</option>
                                <option value="Riverton">Riverton</option>
                                <option value="Rockville">Rockville</option>
                                <option value="Rocky Ridge Town">Rocky Ridge Town</option>
                                <option value="Roosevelt">Roosevelt</option>
                                <option value="Roy">Roy</option>
                                <option value="Rush Valley">Rush Valley</option>
                                <option value="Salem">Salem</option>
                                <option value="Salina">Salina</option>
                                <option value="Salt Lake City">Salt Lake City</option>
                                <option value="Salt Lake County">Salt Lake County</option>
                                <option value="San Juan County">San Juan County</option>
                                <option value="Sandy">Sandy</option>
                                <option value="Sanpete County">Sanpete County</option>
                                <option value="Santa Clara">Santa Clara</option>
                                <option value="Santaquin">Santaquin</option>
                                <option value="Santaquin South">Santaquin South</option>
                                <option value="Saratoga Springs">Saratoga Springs</option>
                                <option value="Scipio">Scipio</option>
                                <option value="Scofield">Scofield</option>
                                <option value="Sevier County">Sevier County</option>
                                <option value="Sigurd">Sigurd</option>
                                <option value="Smithfield">Smithfield</option>
                                <option value="Snowville">Snowville</option>
                                <option value="Snyderville Basin Tr Dist">Snyderville Basin Tr Dist</option>
                                <option value="South Jordan">South Jordan</option>
                                <option value="South Ogden">South Ogden</option>
                                <option value="South Salt Lake">South Salt Lake</option>
                                <option value="South Weber">South Weber</option>
                                <option value="Spanish Fork">Spanish Fork</option>
                                <option value="Spring City">Spring City</option>
                                <option value="Springdale">Springdale</option>
                                <option value="Springville">Springville</option>
                                <option value="St. George">St. George</option>
                                <option value="Stansbury Park">Stansbury Park</option>
                                <option value="Sterling">Sterling</option>
                                <option value="Stockton">Stockton</option>
                                <option value="Summit County">Summit County</option>
                                <option value="Sunnyside">Sunnyside</option>
                                <option value="Sunset">Sunset</option>
                                <option value="Syracuse">Syracuse</option>
                                <option value="Tabiona">Tabiona</option>
                                <option value="Taylorsville">Taylorsville</option>
                                <option value="Tooele City">Tooele City</option>
                                <option value="Tooele County">Tooele County</option>
                                <option value="Toquerville">Toquerville</option>
                                <option value="Torrey">Torrey</option>
                                <option value="Tremonton">Tremonton</option>
                                <option value="Trenton">Trenton</option>
                                <option value="Tropic">Tropic</option>
                                <option value="Uintah">Uintah</option>
                                <option value="Uintah County">Uintah County</option>
                                <option value="Utah County">Utah County</option>
                                <option value="Utah Data Center SL Co">Utah Data Center SL Co</option>
                                <option value="Utah Data Center Utah Co">Utah Data Center Utah Co</option>
                                <option value="Vernal">Vernal</option>
                                <option value="Vernon">Vernon</option>
                                <option value="Vineyard">Vineyard</option>
                                <option value="Virgin">Virgin</option>
                                <option value="Wales">Wales</option>
                                <option value="Wallsburg">Wallsburg</option>
                                <option value="Wasatch County">Wasatch County</option>
                                <option value="Washington City">Washington City</option>
                                <option value="Washington County">Washington County</option>
                                <option value="Washington Terrace">Washington Terrace</option>
                                <option value="Wayne County">Wayne County</option>
                                <option value="Weber County">Weber County</option>
                                <option value="Wellington">Wellington</option>
                                <option value="Wellsville">Wellsville</option>
                                <option value="Wendover">Wendover</option>
                                <option value="West Bountiful">West Bountiful</option>
                                <option value="West Haven">West Haven</option>
                                <option value="West Jordan">West Jordan</option>
                                <option value="West Point">West Point</option>
                                <option value="West Valley City">West Valley City</option>
                                <option value="Willard">Willard</option>
                                <option value="Woodland Hills">Woodland Hills</option>
                                <option value="Woodruff">Woodruff</option>
                                <option value="Woods Cross">Woods Cross</option>
		                    </select>
                        </div>
                        <div class="form-group">
                            <label><span class="text-danger">*</span> Address: </label>
                            <input class="form-control" name="address1" maxlength = "69"/>
                        </div>
                        <div class="form-group">
                            <label>Apt#: </label>
                            <input class="form-control" name="address2" maxlength = "69"/>
                        </div>
                        <br />
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group">
                            <label><span class="text-danger">*</span> Zip: </label>
                            <input class="form-control" name="zip" maxlength="5"/>
                        </div>
                        <div class="form-group">
                            <label><span class="text-danger">*</span> Phone: </label>
                            <input class="form-control" name="phone" maxlength = "15"/>
                        </div>
                        <div class="form-group">
                            <label><span class="text-danger">*</span> Work Phone: </label>
                            <input class="form-control" name="workphone" maxlength = "15"/>
                        </div>
                        <div class="form-group">
                            <label>Middle Initial: </label>
                            <input class="form-control" name="midinitial" maxlength="1"/>
                        </div>
                    </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <p><span class="text-danger">*</span> - Required Field</p>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit"/>
                    </div>
                </form>
            </div>
			<br />
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/shared/footer-admin.php';?>
</body>
</html>