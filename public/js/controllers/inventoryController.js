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
    
    app.controller('InventoryController',
        ['$scope','$http','shared','$q','$interval',
            function($scope, $http, shared, $q, $interval){

        /**
        * operations here
        */
        var path =  ctrlpad.inventoryCtrl.path;
        $scope.countItems = 0;
        $scope.tax = 0;
        $scope.total = 0;
        $scope.orders = [];
        $scope.inventories = [];
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        
        $scope.isComplete = false;
        $scope.isLoading = function(){
            return !$scope.isComplete;    
        };
        
        $http.get(path).success(function(v) {
            $scope.inventories = v;
            $scope.isComplete = true;
            angular.forEach($scope.inventories, function(inventory){
                 inventory.sizes = [];   
                 angular.forEach(inventory.quantities, function(v, i){
                       inventory.sizes.push({checked:false,key:i,value:v});                       
                 });   
            });
        });
        
        $scope.pageChangeHandler = function(num) {
            
        };
        
        $scope.isEmpty = function(){
            return !($scope.orders.length);
        }
        
        $scope.addOrder = function(n){
            angular.forEach(n.sizes, function(size){
                if(!$scope.isInOrder($scope.orders, n, size)){
                    if(size.checked){
                        size.numOrder = 1;
                        $scope.orders.push({'itemnumber':n.itemnumber,'size':size.key,'numOrder':1,'price':n.price});
                    }    
                }
            });   
        };
        
        $scope.plus = function(n){
            $scope.addOrder(n);
        };
        
        $scope.minus = function(n){
            
        };
        
        $scope.close = function(n){
            
        };
        
        $scope.toggleCheck = function(array,n){
            angular.forEach($scope.inventories, function(inventory){
                if(inventory.itemnumber == array.itemnumber){
                    angular.forEach(inventory.sizes, function(size){
                        if(size.key == n.key){
                            size.checked = !n.checked;    
                        }
                    }) 
                }    
            });
        };
        
        $scope.hasChecked = function(array,n){
            if(array.length){
                var res = array.filter(function(o){
                    if(o.itemnumber == n.itemnumber){
                        angular.forEach(n.sizes, function(size){
                            if(size.checked ){
                                //
                            }    
                        });
                        return true;
                    }else return false;
                });    
                return !(!res.length);
            }
            return false;   
        };
        
        $scope.isInOrder = function(array,n, size){
            if(array.length){
                var res = array.filter(function(o){
                    if(o.itemnumber == n.itemnumber && o.size == size.key){
                        angular.forEach(n.sizes, function(size){
                            if(size.checked && o.size ==size.key){
                                if(o.numOrder){
                                    o.numOrder++;
                                }else{
                                    o.numOrder = 1;  
                                } 
                            }    
                        });
                        return true;
                    }else return false;
                });    
                return !(!res.length);
            }
            return false;   
        };
        
        $scope.countSelect = function(){
            return !(!$scope.orders.length);
        };
        
        $scope.subtotal = function(){
            var $total = 0;
            angular.forEach($scope.orders, function (order){
                $total += order.numOrder * order.price;    
            });
            $scope.tax = $total * 0.0625;
            $scope.total = $scope.tax + $total;
            return $total;
        };
    }]);
}(module, pushIfNotFound, checkExists, ControlPad));