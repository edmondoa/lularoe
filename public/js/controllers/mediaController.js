'use strict';

/* MediaController */

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

    app.controller('MediaController',
        ['$scope','$http','shared','$q','$interval','$window',
            function($scope, $http, shared, $q, $interval, $window){

        /**
        * operations here
        */
        var path =  ctrlpad.mediaCtrl.media_url;
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
            $scope.media = v.data;
            $scope.isComplete = true;
            // hide if object empty
            $scope.val = "";

            // Shows/hides the options on hover
            $scope.hoverOn = function(media) {
                return media.showOptions = true;
            };
            $scope.hoverOff = function(media) {
                return media.showOptions = false;
            };
            
            // download file
            $scope.download = function(url) {
                $window.location.href = '/uploads/' + url;
            }
        });
        
        path =  ctrlpad.mediaCtrl.count_url;
        
        $http.get(path).success(function(media_counts) {
            $scope.media_counts = media_counts;
        });
        
        $scope.pageChangeHandler = function(num) {
            
        };
    }]);
}(module, pushIfNotFound, checkExists, ControlPad));