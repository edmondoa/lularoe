'use strict';

/* DownlineController */

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

    app.controller('DownlineController',
        ['$scope','$http','shared','$q','$interval',
            function($scope, $http, shared, $q, $interval){

        /**
        * operations here
        */
        var path =  ctrlpad.downlineCtrl.path;
        $scope.countItems = 0;
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        $scope.meals = [];
        $scope.range = 7;
        
        $http.get(path).success(function(v) {
            $scope.countItems = v.count;
            $scope.users = v.data;
        });
        
        $scope.getStartDate = function(range) {
            var d = new Date();
            d.setDate(d.getDate() - range);
            var yyyy = d.getFullYear();
            var mm = d.getMonth()+1; //January is 0!
            var dd = d.getDate();
            var hh = d.getHours();
            var ii = d.getMinutes();
            var ss = d.getSeconds();
            if(dd<10){
                dd='0'+dd
            } 
            if(mm<10){
                mm='0'+mm
            } 
            if(hh<10){
                hh='0'+hh
            } 
            if(ii<10){
                ii='0'+ii
            }
            if(ss<10){
                ss='0'+ss
            }
            return $scope.startDate = yyyy + '-' + mm + '-' + dd + ' ' + hh + ':' + ii + ':' + ss;
        }
        $scope.getStartDate($scope.range);
        $scope.greaterThan = function(prop, val){
            return function(item){
              if (item[prop] > val) return true;
            }
        }
        
        $scope.$watch("currentPage", function(n, o){
            console.log('page: '+n+' -o: '+o);  
        });
        
        $scope.pageChangeHandler = function(num) {
            console.log('page: '+num);    
        };
    }]);
}(module, pushIfNotFound, checkExists, ControlPad));