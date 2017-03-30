var app = angular.module('myApp', []);

app.filter('deleteTAP', function() {
  return function(input, scope) {
    if (input!=null)
    return input.slice(4,10);
  }
});
app.filter('deleteHour', function() {
  return function(input, scope) {
    if (input!=null)
    return input.slice(0,10);
  }
});


//This function gives the 
app.filter('sumByKey', function () {
    return function (data, key) {
        if (typeof (data) === 'undefined' || typeof (key) === 'undefined') {
            return 0;
        }

        var sum = 0;
        for (var i = data.length - 1; i >= 0; i--) {
            sum += parseFloat(data[i][key]);
        }

        return sum;
    };
})





/*
app.filter('total', function () {
			return function (input, property) {
				var i = input instanceof Array ? input.length : 0;
				if (typeof property === 'undefined' || i === 0) {
					return i;
				} else if (isNaN(input[0][property])) {
					throw 'filter total can count only numeric values';
				} else {
					var total = 0;
					while (i--)
						total += input[i][property];
					return total;
				}
			};
		})
*/



app.controller('customersCtrl', function($scope, $http) {

 $http.get("results3.json")
   .success(function (data) {
   //console.log(data.posts);
       	$scope.names = data.posts;
		$scope.JsonLength=data.posts.length;
		//console.log(data.posts);
		

		

});




/*
// This function turns 'incomplete' transactions red
   $scope.set_color = function (s) {
        if (s.Payment =="incomplete") {
            return {
                color: "red"
            }
        }
    }
*/


	
});

//////////////////////////////////////////// End of 'app' controller
