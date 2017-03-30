<?php

	session_start();
	$start = $_SESSION["stats"]["start"];
	$end = $_SESSION["stats"]["end"];
	$lang = $_SESSION["stats"]["lang"];
	$students = $_SESSION["stats"]["students"];

?>
<html>
<head>
	<title>ANSI Question Report</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<style>
	body *{
	font-size:10px;
	}
	
	table, th , td  {
  border: 1px solid grey;
  border-collapse: collapse;
  padding: 2px;
  max-width: 170px;
  overflow: auto;
}

table tr:nth-child(odd) {
  background-color: #E0FFFF;
}
table tr:nth-child(even) {
  background-color: #ffffff;
}


.table-hover>tbody>tr:hover>td, .table-hover>tbody>tr:hover>th {
    background-color: yellow;
}
	</style>
	<script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
	<script src="scripts/resultsstats.js"></script>
</head>
<body ng-app="myApp" ng-controller="customersCtrl">

<br>

<h1 style="text-align:center">TAP Course Question Results</h1>

<p style="text-align:center">Report Date:  <span style="color:red"><?php echo $start; ?></span> - <span style="color:red"><?php echo $end; ?></span> </p><!--<span style="color:green">{{JsonLength}}</span>-->

<p style="text-align:center">Total Number of Students: <?php echo $students; ?></p>

<p style="text-align:center">Language: <?php echo $lang; ?></p>

<!--<p style="text-align:center"><input style="margin-left:20px" ng-model="globalSearch" placeholder="SEARCH">&nbsp;<span class="glyphicon glyphicon-search"></span></p>-->
<!--{{s|sumByKey:'s.(s.TPUserName)'|currency}}-->
<!--<p>Total : {{calculateTotal (RevenueShare)}}</p>-->

<!--
<div id="mainTable"> 
<table  class="table table-hover" style="width:800px; margin:auto" ng-show="false">
<tr>
<th>Index</th>
<th style="width:5px" >Course Number</th>
<th>Company Name</th>
<th>Contact Name</th>
<th>Link</th>
<th>TP User Name</th>
<th>Password</th>
<th>Revenue Share</th>
<th style="width:50px"># of Trainings</th>
<th>TOTAL</th>
<th>REP</th>
<th>TP Number</th>
<th>Type</th>
</tr>


	<tr ng-repeat="x in names | unique:'TPNumber'|limitTo:1000000| orderBy:'TPNumber'|filter:search as results" ng-show="false">
	<td>{{ $index +1}}</td>
	<td>{{ x.CourseNum}}</td>
	<td>{{ x.CompanyName}}</td>
	<td>{{ x.ContactName}}</td>
    <td>{{ x.Link }}</td>
 	<td>{{ x.TPUserName}}</td>
    <td>{{ x.Password }}</td>
	<td>{{ x.RevenueShare | currency}}</td>
	<td>{{count(x.TPNumber)}}</td>
	<td>{{count(x.TPNumber) * x.RevenueShare | currency}}</td>
    <td>{{ x.Rep}}</td>
	<td>{{ x.TPNumber }}</td>
    <td>{{ x.type}}</td>
	</tr>
</table>


</div>
-->

<div id="subTable"> 
<table ng-show="true" class="table table-hover" style="width:800px; margin:auto">
<tr>
<th>Question #</th>
<th>Correct</th>
<!--<th>Incorrect </th>
<th>Percent Right </th>
<th>Percent Wrong </th>-->
<!--<th>View Question </th>-->
</tr>


	<tr ng-repeat="s in names" ng-show="true">
	<td>{{ s.QNUM}}</td>
	<td>{{ s.Correct}}</td>
	<!--<td>{{ s.Wrong}}</td>
	<td>{{ (s.Correct/(s.Correct+s.Wrong))*100|number:2}}%</td>
	<td>{{ (s.Wrong/(s.Correct+s.Wrong))*100|number:2}}%</td>-->
   <!-- <td><a href="http://www.tapseries.com/help/student_manager_view_cfh_question_result.asp?strQnum={{ s.QNum}}&lang={{ s.Lang}}">View Question</a></td>-->
 	</tr>
	

</table>

	



</div>

<!--
<input ng-model="search1.TPNumber" id="Moogle"><a href="#top">Go to top</a>
<ul>
<li ng-repeat="s in names |filter:search1"> {{$index + 1}}&nbsp;&nbsp;{{s}}</li>
</ul>
-->




<!--<tr ng-repeat="x in names | unique:'TPNumber'|limitTo:1000000| orderBy:'TPNumber'|filter:search as results" ng-show="true">-->
<!--<input ng-show="true" ng-model="search9.TPNumber" ng-init="search9.TPNumber=x.TPNumber">-->
 <!--<li ng-repeat="s in names |filter:{{search1.TPNumber}} as res_1">-->

  <!--
<input ng-show="true" ng-model="search1.TPNumber" ng-init="search1.TPNumber=x.StudentUserName">
<input ng-show="true" ng-model="search2.TPNumber" ng-init="search2.TPNumber=x.CompanyName">
<input ng-show="true" ng-model="search3.TPNumber" ng-init="search3.TPNumber=x.ContactName">
<input ng-show="true" ng-model="search4.TPNumber" ng-init="search4.TPNumber=x.Link">
<input ng-show="true" ng-model="search5.TPNumber" ng-init="search5.TPNumber=x.TPUserName">
<input ng-show="true" ng-model="search6.TPNumber" ng-init="search6.TPNumber=x.Password">
<input ng-show="true" ng-model="search7.TPNumber" ng-init="search7.TPNumber=x.RevenueShare">
<input ng-show="true" ng-model="search8.TPNumber" ng-init="search8.TPNumber=x.Rep">
<input ng-show="true" ng-model="search9.TPNumber" ng-init="search9.TPNumber=x.TPNumber">
<input ng-show="true" ng-model="search10.TPNumber" ng-init="search10.TPNumber=x.type">
-->
 <!--
<li ng-repeat="x1 in names |filter:search1.TPNumber as res_311">
{{res_311}}
-->


<!--</ul> -->

<!--
<table ng-show="false" class="table table-hover">
<th>Index</th>
<th>User Name</th>
<th>Company Name</th>
<th>Contact Name</th>
<th>Link</th>
<th>TP User Name</th>
<th>Password</th>
<th>Revenue Share</th>
<th>REP</th>
<th>TP Number</th>
<th>Type</th>
-->
  <!--<tr ng-repeat="x in names | unique:'TPNumber'|limitTo:1000000| orderBy:'TPNumber'|filter:search as results" ng-show="false">-->
  <!--<tr ng-repeat="x in names |limitTo:1000000| orderBy:'TPNumber'|filter:search as results" ng-show="true">-->
<!--
    <td>{{ $index +1}}</td>
	<td>{{ x.StudentUserName}}</td>
	<td>{{ x.CompanyName}}</td>
	<td>{{ x.ContactName}}</td>
    <td>{{ x.Link }}</td>
 	<td>{{ x.TPUserName}}</td>
    <td>{{ x.Password }}</td>
	<td>{{ x.RevenueShare | currency}}</td>
    <td>{{ x.Rep}}</td>
	<td>{{ x.TPNumber }}</td>
    <td>{{ x.type}}</td>
-->	
	
<!--
	<script>
	document.write("<ul ng-show="false"><input ng-model="search{{ $index }}.TPNumber" ng-init="search{{ $index }}.TPNumber='{{ x.TPNumber }}'"><li ng-repeat="s in names |filter:search1 as res_{{ x.TPNumber }}">{{s.TPNumber}}</ul>");
	</script>
  </tr >
</table>
-->
<!--
<ul ng-show="false"><input ng-model="search1.TPNumber" ng-init="search1.TPNumber='311'"><li ng-repeat="s in names |filter:search1 as res_311">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search2.TPNumber" ng-init="search2.TPNumber='317'"><li ng-repeat="s in names |filter:search2 as res_317">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search3.TPNumber" ng-init="search3.TPNumber='306'"><li ng-repeat="s in names |filter:search3 as res_306">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search4.TPNumber" ng-init="search4.TPNumber='327'"><li ng-repeat="s in names |filter:search4 as res_327">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search5.TPNumber" ng-init="search5.TPNumber='218'"><li ng-repeat="s in names |filter:search5 as res_218">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search6.TPNumber" ng-init="search6.TPNumber='301'"><li ng-repeat="s in names |filter:search6 as res_301">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search7.TPNumber" ng-init="search7.TPNumber='310'"><li ng-repeat="s in names |filter:search7 as res_310">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search8.TPNumber" ng-init="search8.TPNumber='315'"><li ng-repeat="s in names |filter:search8 as res_315">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search9.TPNumber" ng-init="search9.TPNumber='300'"><li ng-repeat="s in names |filter:search9 as res_300">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search10.TPNumber" ng-init="search10.TPNumber='328'"><li ng-repeat="s in names |filter:search10 as res_328">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search12.TPNumber" ng-init="search12.TPNumber='308'"><li ng-repeat="s in names |filter:search12 as res_308">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search13.TPNumber" ng-init="search13.TPNumber='316'"><li ng-repeat="s in names |filter:search13 as res_316">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search14.TPNumber" ng-init="search14.TPNumber='320'"><li ng-repeat="s in names |filter:search14 as res_320">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search15.TPNumber" ng-init="search15.TPNumber='319'"><li ng-repeat="s in names |filter:search15 as res_319">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search16.TPNumber" ng-init="search16.TPNumber='238'"><li ng-repeat="s in names |filter:search16 as res_238">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search17.TPNumber" ng-init="search17.TPNumber='295'"><li ng-repeat="s in names |filter:search17 as res_295">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search18.TPNumber" ng-init="search18.TPNumber='302'"><li ng-repeat="s in names |filter:search18 as res_302">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search19.TPNumber" ng-init="search19.TPNumber='303'"><li ng-repeat="s in names |filter:search19 as res_303">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search20.TPNumber" ng-init="search20.TPNumber='304'"><li ng-repeat="s in names |filter:search20 as res_304">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search21.TPNumber" ng-init="search21.TPNumber='305'"><li ng-repeat="s in names |filter:search21 as res_305">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search22.TPNumber" ng-init="search22.TPNumber='307'"><li ng-repeat="s in names |filter:search22 as res_307">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search24.TPNumber" ng-init="search24.TPNumber='318'"><li ng-repeat="s in names |filter:search24 as res_318">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search25.TPNumber" ng-init="search25.TPNumber='324'"><li ng-repeat="s in names |filter:search25 as res_324">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search26.TPNumber" ng-init="search26.TPNumber='340'"><li ng-repeat="s in names |filter:search26 as res_340">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search27.TPNumber" ng-init="search27.TPNumber='341'"><li ng-repeat="s in names |filter:search27 as res_341">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search28.TPNumber" ng-init="search28.TPNumber='350'"><li ng-repeat="s in names |filter:search28 as res_350">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search29.TPNumber" ng-init="search29.TPNumber='352'"><li ng-repeat="s in names |filter:search29 as res_352">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search30.TPNumber" ng-init="search30.TPNumber='356'"><li ng-repeat="s in names |filter:search30 as res_356">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search31.TPNumber" ng-init="search31.TPNumber='361'"><li ng-repeat="s in names |filter:search31 as res_361">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search32.TPNumber" ng-init="search32.TPNumber='365'"><li ng-repeat="s in names |filter:search32 as res_365">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search33.TPNumber" ng-init="search33.TPNumber='368'"><li ng-repeat="s in names |filter:search33 as res_368">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search34.TPNumber" ng-init="search34.TPNumber='371'"><li ng-repeat="s in names |filter:search34 as res_371">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search35.TPNumber" ng-init="search35.TPNumber='373'"><li ng-repeat="s in names |filter:search35 as res_373">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search36.TPNumber" ng-init="search36.TPNumber='374'"><li ng-repeat="s in names |filter:search36 as res_374">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search37.TPNumber" ng-init="search37.TPNumber='385'"><li ng-repeat="s in names |filter:search37 as res_385">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search38.TPNumber" ng-init="search38.TPNumber='386'"><li ng-repeat="s in names |filter:search38 as res_386">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search39.TPNumber" ng-init="search39.TPNumber='387'"><li ng-repeat="s in names |filter:search39 as res_387">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search40.TPNumber" ng-init="search40.TPNumber='390'"><li ng-repeat="s in names |filter:search40 as res_390">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search41.TPNumber" ng-init="search41.TPNumber='391'"><li ng-repeat="s in names |filter:search41 as res_391">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search42.TPNumber" ng-init="search42.TPNumber='393'"><li ng-repeat="s in names |filter:search42 as res_393">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search43.TPNumber" ng-init="search43.TPNumber='394'"><li ng-repeat="s in names |filter:search43 as res_394">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search44.TPNumber" ng-init="search44.TPNumber='397'"><li ng-repeat="s in names |filter:search44 as res_397">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search45.TPNumber" ng-init="search45.TPNumber='400'"><li ng-repeat="s in names |filter:search45 as res_400">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search46.TPNumber" ng-init="search46.TPNumber='406'"><li ng-repeat="s in names |filter:search46 as res_406">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search47.TPNumber" ng-init="search47.TPNumber='413'"><li ng-repeat="s in names |filter:search47 as res_413">{{s.TPNumber}}</ul>
<ul ng-show="false"><input ng-model="search48.TPNumber" ng-init="search48.TPNumber='416'"><li ng-repeat="s in names |filter:search48 as res_416">{{s.TPNumber}}</ul>
-->
<!--
<label>218</label>&nbsp;({{res_218.length}})&nbsp;
<label>238</label>&nbsp;({{res_238.length}})&nbsp;
<label>295</label>&nbsp;({{res_295.length}})&nbsp;
<label>300</label>&nbsp;({{res_300.length}})&nbsp;
<label>301</label>&nbsp;({{res_301.length}})&nbsp;
<label>302</label>&nbsp;({{res_302.length}})&nbsp;
<label>303</label>&nbsp;({{res_303.length}})&nbsp;
<label>304</label>&nbsp;({{res_304.length}})&nbsp;
<label>305</label>&nbsp;({{res_305.length}})&nbsp;
<label>306</label>&nbsp;({{res_306.length}})&nbsp;
<label>307</label>&nbsp;({{res_307.length}})&nbsp;
<label>308</label>&nbsp;({{res_308.length}})&nbsp;
<label>310</label>&nbsp;({{res_310.length}})&nbsp;
<label>311</label>&nbsp;({{res_311.length}})&nbsp;
<label>315</label>&nbsp;({{res_315.length}})&nbsp;
<label>316</label>&nbsp;({{res_316.length}})&nbsp;
<label>317</label>&nbsp;({{res_317.length}})&nbsp;
<label>318</label>&nbsp;({{res_318.length}})&nbsp;
<label>319</label>&nbsp;({{res_319.length}})&nbsp;
<label>320</label>&nbsp;({{res_320.length}})&nbsp;
<label>324</label>&nbsp;({{res_324.length}})&nbsp;
<label>327</label>&nbsp;({{res_327.length}})&nbsp;
<label>328</label>&nbsp;({{res_328.length}})&nbsp;
<label>340</label>&nbsp;({{res_340.length}})&nbsp;
<label>341</label>&nbsp;({{res_341.length}})&nbsp;
<label>350</label>&nbsp;({{res_350.length}})&nbsp;
<label>352</label>&nbsp;({{res_352.length}})&nbsp;
<label>356</label>&nbsp;({{res_356.length}})&nbsp;
<label>361</label>&nbsp;({{res_361.length}})&nbsp;
<label>365</label>&nbsp;({{res_365.length}})&nbsp;
<label>368</label>&nbsp;({{res_368.length}})&nbsp;
<label>371</label>&nbsp;({{res_371.length}})&nbsp;
<label>373</label>&nbsp;({{res_373.length}})&nbsp;
<label>374</label>&nbsp;({{res_374.length}})&nbsp;
<label>385</label>&nbsp;({{res_385.length}})&nbsp;
<label>386</label>&nbsp;({{res_386.length}})&nbsp;
<label>387</label>&nbsp;({{res_387.length}})&nbsp;
<label>390</label>&nbsp;({{res_390.length}})&nbsp;
<label>391</label>&nbsp;({{res_391.length}})&nbsp;
<label>393</label>&nbsp;({{res_393.length}})&nbsp;
<label>394</label>&nbsp;({{res_394.length}})&nbsp;
<label>397</label>&nbsp;({{res_397.length}})&nbsp;
<label>400</label>&nbsp;({{res_400.length}})&nbsp;
<label>406</label>&nbsp;({{res_406.length}})&nbsp;
<label>413</label>&nbsp;({{res_413.length}})&nbsp;
<label>416</label>&nbsp;({{res_416.length}})&nbsp;



<div ng-show="false"><label>TP Number Search <input ng-model="search.TPNumber"> {{results.length}}</label><br></div>

-->



<!--{{$index}}&nbsp;{{ x.TPNumber }}&nbsp;{{count(x.TPNumber)}}-->
<!--
<input ng-model="srch" placeholder="SEARCH"><br>
{{names|filter:srch}}
-->
<a href="#top">Go to top</a>
</body>
</html>
<!-- Clear the stats session variable -->