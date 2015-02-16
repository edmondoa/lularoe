'use strict';

/* SiteConfigController */

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

    app.controller('SiteConfigController',
        ['$scope','$http','shared','$q','$interval',
            function($scope, $http, shared, $q, $interval){

        /**
        * operations here
        */
        var path =  ctrlpad.siteConfigCtrl.path;
        
        $http.get(path).success(function(site_configs) {
            $scope.site_configs = site_configs;
        });
        
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        $scope.meals = [];
        
        $scope.pageChangeHandler = function(num) {
            
        };
    }]);
}(module, pushIfNotFound, checkExists, ControlPad));