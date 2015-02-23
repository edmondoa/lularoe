'use strict';

/* Common Controllers */


angular.module('ControlPadControllers',[])

.controller('OtherController',['$scope',function($scope){
    $scope.pageChangeHandler = function(num) {
        //console.log("OtherController - pageChangeHandler: " +num+" curPage: "+$scope.currentPage);    
    };
}]);
