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
            'angularUtils.directives.dirPagination',
            'ngRoute',
            'ngResource'
        ];
      
    push(app.requires, newModules);

/*
    app.config(function($routeProvider, $locationProvider){
        $routeProvider
        .when('/checkout',{
            templateUrl: '/template/inventories_checkout',
            controller: 'InventoryController'
        })
        .otherwise({
            templateUrl: '/template/inventories',
            controller: 'InventoryController',
            redirectTo: '/'
        });
        if(window.history && window.history.pushState){
            //$locationProvider.html5Mode(true).hashPrefix('!');;
        }    
    });
*/
	app.controller('BalanceController', ['$scope', 
        function($scope) {
			$scope.balance = ctrlpad.balanceCtrl.balance;
			$scope.$watch('amount',function(n,o) {
				console.log('New: '+n);
				console.log('Old: '+o);
			});
            $scope.updateBalance = function(amt) {
				if (amt > 0 || amt == null || amt == undefined) 
					$scope.balance = parseFloat(ctrlpad.balanceCtrl.balance) - parseFloat(amt);
				else $scope.balance = ctrlpad.balanceCtrl.balance;
            };
    }]);

    app.controller('MainController',
        ['$scope','$http','shared','$q','$interval','$window', '$route', '$routeParams', '$location',
            function($scope, $http, shared, $q, $interval, $window, $route, $routeParams, $location){
                
                $scope.cart = [];
                
                $scope.$route = $route;
                $scope.$location = $location;
                $scope.$routeParams = $routeParams;
                
                $scope.$watch('$location.path()',function(n,o){
                    if(n!= o){
                            $scope.orders = shared.cart;
                            console.log(shared);
                            console.log('locationpath changed in Main');
                            console.log(n);
                    }
                });
                
                /* event handlers */
                $scope.$on('handleUpdateCart',function(){
                    console.log('handle - updateCart');
                    $scope.cart = shared.cart;
                });
    }]);
    
    app.controller('InventoryController',
        ['$scope','$http','shared','$q','$interval','$window', '$route', '$routeParams', '$location',
            function($scope, $http, shared, $q, $interval, $window, $route, $routeParams, $location){

        /**
        * operations here
        */
        var path =  ctrlpad.inventoryCtrl.path;
        
        $scope.name = "InventoryController";
        $scope.params = $routeParams;
        $scope.cart = [];
        $scope.countItems = 0;
        $scope.tax = 0;
        $scope.discounts = [];
        $scope.total = 0;
        $scope.subtotalnum = 0;
        $scope.orders = [];
        $scope.inventories = [];
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        $scope.showCheckoutButton = true;
        
        $scope.isComplete = false;
        $scope.isLoading = function(){
            return !$scope.isComplete;    
        };
        
        $http.get(path).success(function(v) {
            shared.updateLocalCart();
            for(var i in v){
                $scope.inventories.push(v[i]);    
            }
            $scope.countItems = $scope.inventories.length;
            $scope.pageSize = $scope.inventories.length;
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
        
        $scope.removeOrder = function(n, key){
            for(var i=0; i< $scope.orders.length; i++){
                if(n.itemnumber == $scope.orders[i].itemnumber && n.model == $scope.orders[i].model &&  $scope.orders[i].size == key){
                   $scope.orders.splice(i,1);
                }
            }
        };
        
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
                        if(size.value >= quantity){
                            size.numOrder = quantity;
                            size.value -= quantity;
                            if(!size.value || size.value < 0) size.value = 0;
                            
                            $scope.orders.push({
                                'id':n.id,
                                'model':n.model,
                                'itemnumber':n.itemnumber,
                                'size':size.key,
                                'numOrder':quantity,
                                'price':n.price
                            });
                            shared.updateCart($scope.orders);
                        }else{
                            n.doNag = "volume-too-large";
                        }
                    }    
                }
            });   
        };
        
        $scope.plus = function(n){
            angular.forEach($scope.inventories, function(inventory){
                if(inventory.itemnumber == n.itemnumber && inventory.model == n.model){
                    angular.forEach(inventory.sizes, function(size,i){
                        if(size.key == n.size){
                            if(size.value-1 >= 0){
                                n.numOrder++;
                                size.value--;
                            }
                            if(size.value < 0) size.value = 0;
                        }
                    });    
                }    
            });
        };
        
        $scope.minus = function(n){
            angular.forEach($scope.inventories, function(inventory){
                if(inventory.itemnumber == n.itemnumber && inventory.model == n.model){
                    angular.forEach(inventory.sizes, function(size){
                        if(size.key == n.size){
                            if(n.numOrder -1 >= 0){
                                n.numOrder--;                
                                size.value++;
                            }
                            if(n.numOrder < 0) n.numOrder = 0;
                        }
                    });    
                }    
            });
        };
        
        $scope.close = function(i){
            $scope.orders.splice(i,1);
        };

        $scope.cancel = function(){
            $scope.orders.splice(0);
        };
        
        $scope.toggleCheck = function(array,n){
            angular.forEach($scope.inventories, function(inventory){
                if(inventory.itemnumber == array.itemnumber && inventory.model == array.model){
                    angular.forEach(inventory.sizes, function(size){
                        if(size.key == n.key){
                            size.checked = !n.checked;
                            if(!size.value) size.checked = false;
                            if(size.checked){
                                $scope.addOrder(array);     
                            }else{
                                $scope.removeOrder(array, size.key);
                            }
                        }
                    }) 
                }    
            });
        };
        
        $scope.isInOrder = function(array,n, size){
            if(array.length){
                var res = array.filter(function(o){
                    if(o.itemnumber == n.itemnumber && o.model == n.model && o.size == size.key){
                        angular.forEach(n.sizes, function(size){
                            if(size.checked && o.size ==size.key && size.value){
                                if(size.value >= n.numOrder){
                                    if(o.numOrder){
                                        /*
                                        if((size.value - n.numOrder) >= 0)
                                        o.numOrder += n.numOrder;
                                        */
                                    }else{
                                        o.numOrder = n.numOrder;  
                                    }
                                    /*size.value -= n.numOrder;*/
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
            var total = 0;
            var totalQuantity = 0;
            angular.forEach($scope.orders, function (order){
                total += order.numOrder * order.price; 
                totalQuantity += order.numOrder;   
            });
            
            //need to detect if its only reorder
            if(totalQuantity < 33){
                $scope.showCheckoutButton = false;
            }else{
                $scope.showCheckoutButton = true;
            }
            //$scope.tax = total * 0.0825; // Get this from avalara?
            //$scope.total = $scope.tax + total;
			$scope.subtotalnum = total;
            return total;
        };

/*
        $scope.doSale = function(){
			if ($scope.orders.length > 0) 
			{
				$http.post('/llrapi/v1/reorder/',$scope.orders)
					.success(function(data, status,headers,config){
						console.log(data.message);
						$window.location.href = "/inv/checkout";
					})
					.error(function(data, status, headers, config){
						console.log(data.message);
					});
			}
        };
*/
        
        $scope.checkout = function(){
			if ($scope.orders.length > 0) 
			{
				$http.post('/llrapi/v1/reorder/',$scope.orders)
					.success(function(data, status,headers,config){
						console.log(data.message);
						$window.location.href = "/inv/checkout";
					})
					.error(function(data, status, headers, config){
						console.log(data.message);
					});
			}
        };
        
        $scope.fixInvalidNumber = function(n){
            if(n.numOrder == undefined){
                n.numOrder = 0;
            }
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
        
        $scope.$watch('subtotalnum', function(n,o){
            if(n){
                    $scope.isComplete = false;
						// Pre-tax discounts
                        if(shared.requestPromise && shared.getIsLoading()){
                            shared.requestPromise.abort();    
                        }
                        shared.requestPromise = shared.requestData('discounts/'+n);
                        shared.requestPromise.then(function(data){
                            $scope.discounts = data; 
                            n = n - data.total;
                            
                            if(shared.requestPromise && shared.getIsLoading()){
                                shared.requestPromise.abort();    
                            }
                            shared.requestPromise = shared.requestData('tax/'+n);
                            shared.requestPromise.then(function(data){
                                $scope.tax = data.Tax; 
                                $scope.total = data.Tax + n;
                                $scope.isComplete = true;
                            });    
                        });
            }
            else{
                $scope.discounts = [];
                $scope.tax = 0;
                $scope.total = 0;    
            } 
        });
            
        $scope.cancelCheckout = function(){
            $location.path('/'); 
        };
        
        $scope.$watch('$location.path()',function(n,o){
            if(n!= o){
                if(shared.cart.length){
                    $scope.orders = shared.cart;
                    console.log(shared);
                    console.log('locationpath changed');
                    console.log(n);
                }
            }
        });
        
        /* event handlers */
        
        $scope.$on('handleUpdateLocalCart',function(){
            console.log('handle - updateLocalCart');
            $scope.cart = shared.cart;
        });
    }]);
}(module, pushIfNotFound, checkExists, ControlPad));
