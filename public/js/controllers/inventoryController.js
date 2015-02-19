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
                 inventory.doNag = false;   
                 inventory.numOrder = 1;   
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
            var checkedItems = n.sizes.filter(function(s){
                return s.checked;
            });
            
            if(!checkedItems.length){
                n.doNag = "none-selected";
            }else n.doNag = false;
            
            angular.forEach(n.sizes, function(size){
                if(!$scope.isInOrder($scope.orders, n, size)){
                    if(size.checked){
                        var quantity = n.numOrder;
                        if(size.value > quantity){
                            size.numOrder = quantity;
                            size.value -= quantity;
                            if(!size.value || size.value < 0) size.value = 0;
                            $scope.orders.push({'itemnumber':n.itemnumber,'size':size.key,'numOrder':quantity,'price':n.price});
                        }else{
                            n.doNag = "volume-too-large";
                        }
                    }    
                }
            });   
        };
        
        $scope.plus = function(n){
            n.numOrder++;
        };
        
        $scope.minus = function(n){
            n.numOrder--;
            if(!n.numOrder) n.numOrder = 1;
        };
        
        $scope.close = function(i){
            $scope.orders.splice(i,1);
        };

        $scope.cancel = function(){
            $scope.orders.splice(0);
        };
        
        $scope.toggleCheck = function(array,n){
            angular.forEach($scope.inventories, function(inventory){
                if(inventory.itemnumber == array.itemnumber){
                    angular.forEach(inventory.sizes, function(size){
                        if(size.key == n.key){
                            size.checked = !n.checked;
                            if(!size.value) size.checked = false;
                        }
                    }) 
                }    
            });
        };
        
        $scope.isInOrder = function(array,n, size){
            if(array.length){
                var res = array.filter(function(o){
                    if(o.itemnumber == n.itemnumber && o.size == size.key){
                        angular.forEach(n.sizes, function(size){
                            if(size.checked && o.size ==size.key && size.value){
                                if(size.value > n.numOrder){
                                    if(o.numOrder){
                                        if((size.value - n.numOrder) >= 0)
                                        o.numOrder += n.numOrder;
                                    }else{
                                        o.numOrder = n.numOrder;  
                                    }
                                    size.value -= n.numOrder;
                                    if(!size.value || size.value < 0) size.value = 0;
                                }else{
                                    n.doNag = "volume-too-large";
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