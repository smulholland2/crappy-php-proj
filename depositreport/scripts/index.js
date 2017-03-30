var app = angular.module('myApp', ['ui.bootstrap']);
app.controller('customersCtrl', function($scope, $http) {
//var start1=$scope.starting;
//var end1=$scope.ending;

 $scope.example1 = {
       value1: new Date(1970, 0, 1, 14, 30, 0)
     };

$scope.example2 = {
       value2: new Date(1970, 0, 1, 14, 29, 0)
     };




//  CALENDARS
$scope.calendar = {
    opened: {},
    dateFormat: 'MM/dd/yyyy',
    dateOptions: {},
    open: function($event, which) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.calendar.opened[which] = true;
    } 
};



$scope.stateSelector=function(x){
 $scope.courseNumber=x;
};

$scope.maxDate = new Date();


  
    $scope.$watch('starting', function(newval, oldval){
        if($scope.ending < $scope.starting) {
         $scope.starting = '';    
		 alert("start date is incorrect");
    };
    });
	
	 $scope.$watch('ending', function(newval, oldval){
        if($scope.ending < $scope.starting) {
            $scope.ending = '';
			alert("end date is incorrect");
        };
    });
    
    
});


