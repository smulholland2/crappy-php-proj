

<!DOCTYPE html>
<html>
<head>
	<title>States</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans" />

<script>
$(document).ready(function(){

	$("#wrapper").hide();
	$("#wrapper").fadeIn(1500);
  $("input[name=wv_counties]").first().prop('checked', true);
  $("input[name=ca_handlers]").first().prop('checked', true);

  $("input[name=wv_counties]").click(function(){
    var x = $(this).val();
    $("#wv_link").attr("href", ''+ x +'');  
  });

  $("input[name=ca_handlers]").click(function(){
    var y = $(this).val();
    $("#ca_link").attr("href", ''+ y +'');  
  });  


});
</script>

</head>
<body>
<?php include '../menu.php';?>

<!-- CA Modal -->
<div id="CA_Modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Please select one of the courses.</h4>
      </div>
      <div class="modal-body">
        <input type="radio" name="ca_handlers" value="sc_product_options_aa.php?ProID=califsh"> California Food Handler Training (Non San Diego)<br>
        <input type="radio" name="ca_handlers" value="sc_product_options_aa.php?ProID=casd"> County of San Diego approved Food Handler Training<br>
      </div>
      <div class="modal-footer">
        <a href="sc_product_options_aa.php?ProID=califsh" class="btn btn-success" id="ca_link" role="button">OK</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal Ends -->  

<!-- WV Modal -->
<div id="WV_Modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Please select your county.</h4>
      </div>
      <div class="modal-body">
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVBA"> Barbour County<br>
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVMV"> Calhoun County<br>
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVCH"> Cabell-Huntington County<br>
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVMN"> Monroe County<br>
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVPE"> Pendleton County<br>
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVMV"> Pleasants County<br>
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVPO"> Pocahontas County<br>
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVMV"> Ritchie County<br>
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVMV"> Roane County<br>
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVUP"> Upshur County<br>
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVWA"> Wayne County<br>
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVOH"> Wheeling-Ohio County<br>
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVMV"> Wirt County<br>
    <input type="radio" name="wv_counties" value="sc_product_options_aa.php?ProID=WVMV"> Wood County<br>
      </div>
      <div class="modal-footer">
        <a href="sc_product_options_aa.php?ProID=WVBA" class="btn btn-success" id="wv_link" role="button">OK</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal Ends -->    


<h1 id="maintext" style="text-align:center;"><span  class="english">Select the state where you work</span><span class="spanish" >Seleccione el estado donde vive</span></h1>
	<p style="text-align:center;font-size:16px"><span class="english">Already paid for the course?</span><span class="spanish">Ya pago por el curso?</span> <a href="https://www.tapseries.com/onlinetraining.htm" style="text-decoration:none;color:#008abf"><span class="english">Login to Course</span><span class="spanish">Entrar al Curso</span></a></p>  
  <div id="wrapper">

  <table class="table table-bordered" style="margin-top: 30px" id="table1">
   
    <tbody>
      <tr>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Alaska</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Alabama</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Arkansas</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=azfsh'">Arizona</td>
        <td data-toggle="modal" data-target="#CA_Modal">California</td>
      </tr>
      <tr>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Colorado</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Conneticut</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">District of Columbia</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Delaware</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=flfsh'">Florida</td>
      </tr>
      <tr>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Georgia</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Hawaii</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Iowa</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=idfsh'">Idaho</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=ilfsh'">Illinois</td>
      </tr>
      <tr>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Indiana</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=ksfsh'">Kansas</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Kentucky</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Louisiana</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Massachusetts</td>
      </tr>
      <tr>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Maryland</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Maine</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Michigan</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Minnesota</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=mofsh'">Missouri</td>
      </tr>
      <tr>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Mississippi</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Montana</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">North Carolina</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">North Dakota</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Nebraska</td>
      </tr>
      <tr>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">New Hampshire</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">New Jersey</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nmfsh'">New Mexico</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Nevada</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">New York</td>
      </tr>
      <tr>
        <td onclick="location.href='sc_product_options_aa.php?ProID=ohfsh'">Ohio</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Oklahoma</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Oregon</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Pennsylvania</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Rhode Island</td>
      </tr>
      <tr>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">South Carolina</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">South Dakota</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Tennessee</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=txfsh'">Texas</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=utfsh'">Utah</td>
      </tr>
      <tr>
        <td onclick="location.href='sc_product_options_aa.php?ProID=vaccfsh'">Virginia</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Vermont</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Washington</td>
        <td onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Wisconsin</td>
        <td data-toggle="modal" data-target="#WV_Modal">West Virginia</td>
      </tr>
      <tr style="border:1px solid white">
      <td  onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Wyoming</td>
      
      </tr>
    </tbody>
  </table>


  <div id="mobile_list" style="margin-top: 30px">
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Alaska</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Alabama</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Arkansas</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=azfsh'">Arizona</p></div>
        <div class="mobile_option" data-toggle="modal" data-target="#CA_Modal"><p>California</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Colorado</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Conneticut</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">District of Columbia</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Delaware</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=flfsh'">Florida</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Georgia</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Hawaii</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Iowa</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=idfsh'">Idaho</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=ilfsh'">Illinois</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Indiana</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=ksfsh'">Kansas</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Kentucky</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Louisiana</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Massachusetts</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Maryland</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Maine</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Michigan</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Minnesota</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=mofsh'">Missouri</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Mississippi</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Montana</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">North Carolina</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">North Dakota</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Nebraska</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">New Hampshire</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">New Jersey</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nmfsh'">New Mexico</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Nevada</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">New York</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=ohfsh'">Ohio</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Oklahoma</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Oregon</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Pennsylvania</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Rhode Island</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">South Carolina</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">South Dakota</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Tennessee</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=txfsh'">Texas</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=utfsh'">Utah</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=vaccfsh'">Virginia</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Vermont</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Washington</p></div>
        <div class="mobile_option"><p onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Wisconsin</p></div>
        <div class="mobile_option" data-toggle="modal" data-target="#WV_Modal"><p>West Virginia</p></div>
      	<div class="mobile_option"><p  onclick="location.href='sc_product_options_aa.php?ProID=nfon'">Wyoming</p></div>
      </div>

  <br><br><br><br><br><br><br><br><br><br>
	  
  </div>  
	
<?php include '../footer.php';?> 	
  
<style>
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 2px solid #ddd;
}	

#maintext{
	margin-top:150px
}

.mobile_option{
	border:2px solid #ddd;
	width: 90%;
	height:50px;
	margin:10px auto;
	
}
.mobile_option p{
	font-size:17px;
	
}
.mobile_option:hover{
	background-color: #333;
	color: white;
}
.mobile_option p{
	margin-top: 15px; 
}
td{
	text-align: center;
	cursor: pointer;
	font-size:16px;
}
td:hover{
	background-color: #333;
	color: white;
	border-color:#333;
}
#wrapper{
  border:1px solid transparent;
  max-width:90%;
  height:auto;
  margin:auto;
  border-radius: 5px;
}
body{
	font-family: 'Open Sans', sans-serif; 
}
p{
	text-align: center;
}
#mobile_list{
	display: none;
	cursor: pointer;
}


@media only screen and (max-width: 550px) {
#maintext{
	margin-top:110px
}

#table1{
	display: none;
}

#mobile_list {
	display: block;
}



}
  </style>

</body>
</html>

