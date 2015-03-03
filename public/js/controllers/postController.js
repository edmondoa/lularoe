'use strict';

/* PostController */

var module,
    moduleName = "app";
try {
    module = angular.module(moduleName);
} catch(err) {
    module = angular.module(moduleName, []);
}

(function(app, push, check, ctrlpad){
    var newModules = [
            'angularUtils.directives.dirPagination'
        ];
      
    push(app.requires, newModules);  

    app.controller('PostController',
        ['$scope','$http','shared','$q','$interval',
            function($scope, $http, shared, $q, $interval){

        /**
        * operations here
        */
        var path =  ctrlpad.postCtrl.path;
        $scope.countItems = 0;
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        $scope.meals = [];
        
        $scope.isComplete = false;
        $scope.isLoading = function(){
            return !$scope.isComplete;    
        };
        
        $http.get(path).success(function(v) {
            $scope.countItems = v.count;
            $scope.posts = v.data;
            $scope.isComplete = true;
        });
        
        $scope.pageChangeHandler = function(num) {
            
        };
        
		// bulk action checkboxes
		$scope.checkbox = function() {
			var checked = false;
			$('.bulk-check').each(function() {
			if ($(this).is(":checked")) checked = true;
			});
			if (checked == true) $('.applyAction').removeAttr('disabled');
			else $('.applyAction').attr('disabled', 'disabled');
		};
        
    }]);
}(module, pushIfNotFound, checkExists, ControlPad));