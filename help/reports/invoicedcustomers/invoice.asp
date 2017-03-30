<!-- #include file="../../../engine.asp" -->
<!-- #include file="../../../addstu_engine_1.asp" -->
<!-- #include file="../../../addstu_engine_2.asp" -->
<!-- #include file="../../../addstu_engine_3.asp" -->
<!-- #include file="../../../addstu_engine_4.asp" -->
<!-- #include file="../../../addstu_engine_5.asp" -->
<!-- #include file="../../../addstu_engine_6.asp" -->
<!-- #include file="../../../addstu_engine_7.asp" -->
<!-- #include file="../../../addstu_engine_8.asp" -->
<!-- #include file="../../../addstu_engine_9.asp" -->
<!-- #include file="../../../addstu_engine_10.asp" -->
<!-- #include file="../../../addstu_engine_11.asp" -->
<!-- #include file="../../../addstu_engine_12.asp" -->
<!-- #include file="../../../addstu_engine_13.asp" -->
<!-- #include file="../../../addstu_engine_14.asp" -->
<!-- #include file="../../../addstu_engine_15.asp" -->
<!-- #include file="../../../addstu_engine_16.asp" -->
<!-- #include file="../../../addstu_engine_17.asp" -->
<%

price=Request.QueryString("price")
total=Request.QueryString("total")
count=Request.QueryString("count")
courseraw=Request.QueryString("course")
course=getFullProductName(courseraw)
acct=Request.QueryString("acct")


%>
<html>
<head>
	<title>Invoiced Customers</title>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<style>
	body *{
	font-size:10px;
	}
	
	
	table, th , td  {
  border: 1px solid grey;
  border-collapse: collapse;
  padding: 2px;
  max-width: 670px;
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
	<script src="scripts/results.js"></script>
</head>
<body ng-app="myApp" ng-controller="customersCtrl">

<br>

<h1 align="center">Invoiced Customers</h1>
<p style="text-align:center">Report Date: <span style="color:red"> {{names[0].StartDate}}</span> - <span style="color:red">{{names[0].EndDate}}</span> </p> <!-- &nbsp; <span style="font-size:20px; color:green">{{count1(Data)}}</span>-->



<br>
<!--
<input style="margin-left:20px" ng-model="globalSearch" placeholder="SEARCH">&nbsp;<span class="glyphicon glyphicon-search"></span>-->
<!--{{s|sumByKey:'s.(s.TPUserName)'|currency}}-->
<!--<p>Total : {{calculateTotal (RevenueShare)}}</p>-->


<div id="mainTable" ng-show="mainTable"> 

<!--
<table  class="table table-hover" style="width:80%; margin:auto" >
<tr>
<td>tap series</td>
</tr>
<tr>
<td><%=Date%></td>
</tr>
<tr>
<td>Invoice #</td>
</tr>
<tr>
<td>bill to</td>
</tr>
<tr>
<td>Quantity</td>
<tr>
<td><%=count%> &nbsp;<%=course%> &nbsp;<%=price%></td>
</tr>
<tr>
<td>Total: <%=total%></td>
</tr>
</table>
-->



<table style="width:100%;margin:auto">
  <tr>
    <td>Description</td>
    <td>Quantity</td> 
    <td>Unit Price</td>
    <td>Amount</td>
  </tr>
  <tr>
    <td><%=course%></td>
    <td><%=count%></td> 
    <td><%=price%></td>
    <td><%=total%></td>
  </tr>
</table>


	
</body>
</html>
