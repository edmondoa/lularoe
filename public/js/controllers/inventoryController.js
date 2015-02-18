'use strict';

/* InventoryController */

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
    
    var isInOrder = function(array,n){
        if(array.length){
            var res = array.filter(function(o){
                if(o.itemnumber == n){
                    if(o.numOrder){
                        o.numOrder++;
                    }else{ 
                        o.numOrder =1;
                    }
                    return true;
                }else return false;
            });    
            return !(!res.length);
        }
        return false;   
    };  

    app.controller('InventoryController',
        ['$scope','$http','shared','$q','$interval',
            function($scope, $http, shared, $q, $interval){

        /**
        * operations here
        */
        var path =  ctrlpad.inventoryCtrl.path;
        $scope.countItems = 0;
        $scope.orders = [];
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        
        $scope.isComplete = false;
        $scope.isLoading = function(){
            return !$scope.isComplete;    
        };
        
        $http.get(path).success(function(v) {
            $scope.inventories = v;
            $scope.isComplete = true;
        });
        
        $scope.pageChangeHandler = function(num) {
            
        };
        
        $scope.isEmpty = function(){
            return !($scope.orders.length);
        }
        
        $scope.addOrder = function(n){
            if(!isInOrder($scope.orders, n.itemnumber)){
                n.numOrder =1;   
                $scope.orders.push(n);    
            }
            console.log($scope.orders);
        };
        
        $scope.plus = function(n){
            
        };
        
        $scope.minus = function(n){
            
        };
        
        $scope.close = function(n){
            
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