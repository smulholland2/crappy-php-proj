var app = angular.module('myApp', []);

app.controller('customersCtrl', function($scope, $http) {
$scope.mainOrder="-Data";

$scope.optionOrder=function(o){
	$scope.mainOrder=o;
}

 $http.get("resultsstats.json")
   .success(function (data) {
   //console.log(data.posts);
    	$scope.names = data.posts;
	$scope.JsonLength=data.posts.length;
	//console.log(data.posts);
});
/*
$scope.count = function(param) {
  var count = 0;

  $scope.names.forEach(function(document) {
      if(document.TPNumber  === param.toString()) {
        count++;
      }
  });

  return count;
};
*/

$scope.count2 = function(param) {
  var count = 0;

  $scope.names.forEach(function(document) {
      if(document.CompanyName  === param.toString() &&  document.Data == 1 ) {
        count++;
      }
  });

  return count;
};


/*
$scope.count2 = function(param) {
  var count = 0;

  $scope.names.forEach(function(document) {
      if(document.TPUserName  === param.toString()) {
        count++;
      }
  });

  return count;
};
 
*/
 
/* 
  $scope.calculateTotal = function(names){
    return names.reduce( function(totalPopulation, s){
      return totalPopulation + s.RevenueShare
    }, 0);
  }
*/  
/* 
 $scope.setTotals = function(s){
        if (s){
            s.total = s.quantity * s.RevenueShare;
            $scope.invoiceCount += s.quantity;
        }
    }
*/
	
});

//////////////////////////////////////////// End of 'app' controller

app.filter('unique', function () {
  return function (items, filterOn) {
    if (filterOn === false) {
      return items;
    }
    if ((filterOn || angular.isUndefined(filterOn)) && angular.isArray(items)) {
      var hashCheck = {}, newItems = [];
      var extractValueToCompare = function (item) {
        if (angular.isObject(item) && angular.isString(filterOn)) {
          return item[filterOn];
        } else {
          return item;
        }
      };
      angular.forEach(items, function (item) {
        var valueToCheck, isDuplicate = false;
        for (var i = 0; i < newItems.length; i++) {
          if (angular.equals(extractValueToCompare(newItems[i]), extractValueToCompare(item))) {
            isDuplicate = true;
            break;
          }
        }
        if (!isDuplicate) {
          newItems.push(item);
        }

      });
      items = newItems;
    }
    return items;
  };
});




/*
app.filter('sumByKey', function () {
    return function (data, key) {
        if (typeof (data) === 'undefined' || typeof (key) === 'undefined') {
            return 0;
        }

        var sum = 0;
        for (var i = data.length - 1; i >= 0; i--) {
            sum += parseInt(data[i][key]);
        }

        return sum;
    };
})
*/