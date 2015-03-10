'use strict';

/* UserEditController */

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

    app.controller('UserEditController',
        ['$scope','$http','shared','$q','$interval',
            function($scope, $http, shared, $q, $interval){

        /**
        * operations here
        */
        $scope.sponsor_name = "";
        $scope.sponsor = "";
        $scope.update_sponsor = function(user){
            $scope.sponsor = user.id;
            $scope.sponsor_name = user.name; 
        };
        
        $scope.check_sponsor = function(){
            if($scope.sponsor.length > 1){
                return "open";
            }else{
                $scope.sponsor_name = "";
                return false;
            }
        };
        
        $scope.showName = function(){
            if($scope.sponsor.length > 1 && $scope.sponsor_name !== ""){
                return true;
            }else return false; 
        };
    }]);
}(module, pushIfNotFound, checkExists, ControlPad));