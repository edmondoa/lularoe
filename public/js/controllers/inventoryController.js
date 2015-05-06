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
	app.filter('urlencode', function () {
		return function (value) {
			return (!value) ? '' : escape(value);
		};
	});

	app.filter('nospace', function () {
		return function (value) {
			return (!value) ? '' : value.replace(/\W/g, '_');
		};
	});

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
		$scope.orderdata 		= [];
		$scope.minQuantity		= 33;
		$scope.totalQuantity	= 0;
        $scope.params 			= $routeParams;
        $scope.cart 			= [];
        $scope.countItems 		= 0;
        $scope.tax 				= 0;
		$scope.taxable 			= 1;
        $scope.discounts 		= [];
        $scope.total 			= 0;
        $scope.subtotalnum 		= 0;
        $scope.orders 			= [];
        $scope.inventories 		= [];
        $scope.currentPage 		= 1;
        $scope.pageSize 		= 10;
        $scope.showCheckoutButton = true;
        
        $scope.isComplete = false;
        $scope.isLoading = function(){
            return !$scope.isComplete;    
        };
        
        $http.get(path).success(function(v) {
            shared.updateLocalCart();

            var b = new RegExp('Sloan');
            for(var i in v){
                var isInsideInventory = [];
                isInsideInventory = $scope.inventories.filter(function(inventory){
					return false;
                    //return b.test(inventory.model);
                });

                if(isInsideInventory.length == 0){
                    $scope.inventories.push(v[i]);        
                }
                if(isInsideInventory.length == 1){
                    $scope.inventories.splice(i-1,0,v[i]);
                }
                
            }
            $scope.countItems = $scope.inventories.length;
            $scope.pageSize = $scope.inventories.length;
            $scope.isComplete = true;

            angular.forEach($scope.inventories, function(inventory){
                 inventory.sizes = [];   
                 inventory.doNag = false;   
                 inventory.numOrder = 0;  // was 1
                 var b = new RegExp("Kid's Leggings");
                 var tst = b.test(inventory.model);
                 if(!tst){  
                     angular.forEach(inventory.quantities, function(v, i){
                           inventory.sizes.push({checked:false,key:i,value:v});                       
                     });   
                 }else{
                     angular.forEach(inventory.quantities, function(v, i){
                         if(!inventory.sizes.length){
                             inventory.sizes.push({checked:false,key:i,value:v});    
                         }else{
                             inventory.sizes.unshift({checked:false,key:i,value:v});
                         }
                     });
                 }
            });

            console.log($scope.inventories);

        });

    $scope.groups = {
		'A' : [
			'Maxi',
			'Cassie',
			'Azure',
			'Lucy',
			'Lola',
			'Madison'
			],
		'B' : [
			'Amelia',
			'Nicole',
			'Julia',
			'Ana'
			],
		'C' : [
			'Irma',
			'Randy',
			'Monroe'
			],
		'L' : [
			'Adult Leggings (2 Pack)',
			'Tall and Curvy Leggings (2 Pack)'
			],
		'K' : [
			'Sloan (2-8)',
			'Sloan (10-14)',
			'Dotdotsmile Lucy Sleeve',
			'Dotdotsmile Lucy Tank',
			'Kid\'s Leggings (2 Pack)'
		]
	};

    $scope.groupMatrix = {
		'Maxi':{
			'quantities': [5,9,14,14,14,9,5,5],
			'group': 'A'
		},
		'Cassie':{
			'quantities': [0,10,15,15,15,10,5,5],
			'group': 'A'
		},
		'Azure':{
			'quantities': [0,10,15,15,15,10,10,0],
			'group': 'A'
		},
		'Lucy':{
			'quantities': [5,10,15,15,15,10,5,0],
			'group': 'A'
		},
		'Lola':{
			'quantities': [5,10,15,15,15,10,5,0],
			'group': 'A'
		},    
		'Madison':{
			'quantities': [0,15,15,15,15,15,0,0],
			'group': 'A'
		},
		'Amelia':{
			'quantities': [0,7,10,10,10,7,0,0],
			'group': 'B'
		},
		'Nicole':{
			'quantities': [0,10,10,10,10,10,0,0],
			'group': 'B'
		},
		'Julia':{
			'quantities': [5,10,10,10,10,10,0,0],
			'group': 'B'
		} ,   
		'Ana':{
			'quantities': [0,6,8,8,8,6,6,6],
			'group': 'B'
		},
		'Irma':{
			'quantities': [10,15,15,15,10,10,0,0],
			'group': 'C'
		},
		'Randy':{
			'quantities': [5,10,15,15,15,10,5,0],
			'group': 'C'
		},
		'Monroe':{
			'quantities': [0,0,25,0,25,0,0,0],
			'group': 'C'
		},
		'Adult Leggings (2 Pack)':{
			'quantities': [35],
			'group': 'L'
		},
		'Tall and Curvy Leggings (2 Pack)':{
			'quantities': [0],
			'group': 'L'
		},
		'Sloan (2-8)':{
			'quantities': [4,4,4,4],
			'group': 'K'
		},
		'Sloan (10-14)': {
			'quantities': [4,4,4],
			'group': 'K'
		},
		'Dotdotsmile Lucy Sleeve':{
			'quantities': [6,6,6,6],
			'group': 'K'
		},
		'Dotdotsmile Lucy Tank':{
			'quantities': [6,6,6,6],
			'group': 'K'
		},   
		'Kid\'s Leggings (2 Pack)':{
			'quantities': [23,0],
			'group': 'K'
		}
	};
    
    	// filter rows by group
	    $scope.filteredRows = $scope.groups['A'];
	    $scope.activeGroup = 'A';
	    $scope.filterRows = function(inventory) {
	        return ($scope.filteredRows.indexOf(inventory.model) !== -1);
	        // console.log($scope.activeGroup);
	    };

		// $scope.selectedRows = [];

		// Sets the group value information
		$scope.extra;
		$scope.selectedRows = [];
		$scope.extraRow = [];
		$scope.extra = '';
		$scope.old_extra;
		$scope.selectRow = function(model, extra) {

           	var quantities = $scope.groupMatrix[model]['quantities'];
           	// var group = $scope.groupMatrix[model]['group'];
           	var group = $scope.activeGroup;
           	// console.log(group);
			$scope.selected_lines = $scope.groupMatrix[model]['group'];
            angular.forEach($scope.inventories, function(inventory) {
				if(inventory.model == model){
					angular.forEach(inventory.sizes, function(size,sidx){
						size.checked = true;
						size.numOrder = quantities[sidx];
						inventory.numOrder = quantities[sidx];
						inventory.sizes[sidx].numOrder = quantities[sidx];
						$scope.addOrder(inventory);
					});
				}
            });
			// $scope.selectedRows[group] = model;

            // remove other selected rows in group
            // console.log($scope.extra);
    		// angular.forEach($scope.inventories, function(inventory) {
    			// if(typeof extra === 'undefined' && inventory.model != model && jQuery.inArray(inventory.model, $scope.groups[group]) != -1) {
					// angular.forEach(inventory.sizes, function(size,sidx){
						// size.checked = false;
						// size.numOrder = '';
						// inventory.numOrder = '';
						// inventory.sizes[sidx].numOrder = '';
						// $scope.removeOrder(inventory, size.key);
					// });
					// // remove from array of selected rows
					// // console.log($scope.groups[group]);
					// // if (typeof extra === 'undefined') $scope.selectedRows[group] = model;
				// }
				// // console.log($scope.selectedRows[group] + ' : ' + inventory.model);
// 
// 				
				// // else if(inventory.model == $scope.old_extra){
					// // angular.forEach(inventory.sizes, function(size,sidx){
						// // size.checked = false;
						// // size.numOrder = '';
						// // inventory.numOrder = '';
						// // inventory.sizes[sidx].numOrder = '';
						// // $scope.removeOrder(inventory, size.key);
					// // });
				// // }
// 
				// // else if (inventory.model != model && jQuery.inArray(inventory.model, $scope.groups[group]) != -1 && $scope.selectedRows[group] !== inventory.model && $scope.extra !== inventory.model) {
					// // angular.forEach(inventory.sizes, function(size,sidx){
						// // size.checked = false;
						// // size.numOrder = '';
						// // inventory.numOrder = '';
						// // inventory.sizes[sidx].numOrder = '';
						// // $scope.removeOrder(inventory, size.key);
					// // });
				// // }
// 
// 				
			// });
			
			// if (typeof extra !== 'undefined') {
				// $scope.extraRow = extra;
				// console.log('extra', $scope.extra);
			// }
			
						$scope.selectedRows[group] = model;

			// add to array of selected rows
			// if (typeof extra === 'undefined') $scope.selectedRows[group] = model;
			// console.log($scope.selectedRows);
			shared.updateCart($scope.orders);
		};
		
		// choose size
		$scope.addAllInRepSize = function() {
            angular.forEach($scope.inventories, function(inventory) {
				angular.forEach(inventory.sizes, function(size,sidx){
					// console.log(size.key);
					if (size.key == $scope.repSize) {
						
						// increment up
						size.checked = true;
						size.numOrder = parseInt(size.numOrder) + 1;
						// inventory.numOrder ++;
						// inventory.sizes[sidx].numOrder ++;
						$scope.addOrder(inventory);
					}
				});
            });
		};
		
		// $scope.setGroup = function(groupid) {
            // angular.forEach($scope.inventories, function(inventory) {
				// angular.forEach($scope.groupMatrix[groupid], function(group_quantities,group_model) {
					// if(inventory.model == group_model){
						// //console.log('Set group' ,group_model);
						// angular.forEach(inventory.sizes, function(size,sidx){
// 
							// size.checked = true;
							// size.numOrder = group_quantities[sidx];
							// inventory.numOrder = group_quantities[sidx];
							// inventory.sizes[sidx].numOrder = group_quantities[sidx];
							// $scope.addOrder(inventory);
						// });
					// }
                // });
            // });
			// shared.updateCart($scope.orders);
		// };
        
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


        $scope.addOrder = function(inventoryItem) {

/*
            var checkedItems = n.sizes.filter(function(s){
                return s.checked;
            });
            
            if(!checkedItems.length){
                n.doNag = "none-selected";
            }else n.doNag = false;
*/
            
            angular.forEach(inventoryItem.sizes, function(size, sidx){

				console.log('TEST 4: '+inventoryItem.model+' size '+size.key+' #'+sidx+' has a numOrder '+size.numOrder+' / '+size.value);
				// make sure we have an integer parsable numOrder value
				if(typeof size.numOrder != undefined && parseInt(size.numOrder) > 0) {
					// Make sure we never over order.
					if(size.numOrder > size.value) size.numOrder = size.value;

					var quantity = parseInt(size.numOrder);

					console.log('Updating to : '+quantity + ' / '+size.value);

					// Make sure we don't add more quantity than we have on hand
					if(size.value >= quantity && size.numOrder > 0) {
						size.numOrder	= quantity;
/*
						size.value		-= quantity;
*/
						if(!size.value || size.value < 0) size.value = 0;
						
						if($scope.isInOrder($scope.orders, inventoryItem, size) == false) {
							// Push the inventory Item into the orders!
							$scope.orders.push({
								'id':inventoryItem.id,
								'model':inventoryItem.model,
								'itemnumber':inventoryItem.itemnumber,
								'size':size.key,
								'numOrder':quantity,
								'price':inventoryItem.price,
								'image':inventoryItem.image
							});
						} 
						else {
							$scope.updateOrder($scope.orders, inventoryItem, size);
						}
					} else {
						size.numOrder = size.value;
						inventoryItem.doNag = "volume-too-large";
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
        
		// array = inventory
		// n = size chart
		$scope.massAdd = function(inventoryItem, itemSizes) {

			console.log('ITEM SIZES: ',itemSizes);
            angular.forEach($scope.inventories, function(inventory){
				// If we've selected the appropriate scope level inventory with the passed array inventory
                console.log('TEST 1: '+inventory.id+' == '+inventoryItem.id + ' && ' + inventory.model + ' == ' + inventoryItem.model);

                if((inventory.id == inventoryItem.id) && (inventory.model == inventoryItem.model)) {

					// Go through each size if the scope level inventory until we find the passed in size chart key
                    angular.forEach(inventory.sizes, function(size, sidx){
						console.log('TEST 2: '+size.key+' == '+itemSizes.key);
                        if(size.key == itemSizes.key) {
									
							console.log('TEST 3: '+size.numOrder+' > 0');
                            if(parseInt(size.numOrder) > 0){
                                $scope.addOrder(inventoryItem);     
                            }else{
								console.log('REMOVING ORDER');
								size.numOrder = '';
								size.checked = false;
                                $scope.removeOrder(inventoryItem, size.key);
                            };
                        };
                    });
                };
            });
        };

        $scope.toggleCheck = function(array,n){
            angular.forEach($scope.inventories, function(inventory){
                if(inventory.itemnumber == array.itemnumber && inventory.model == array.model){
                    angular.forEach(inventory.sizes, function(size){
                        if(size.key == n.key){
                            size.checked = !n.checked;
                            if(!size.value) size.checked = false;
                            if(size.checked){
               //                 $scope.addOrder(array);     
                            }else{
                //                $scope.removeOrder(array, size.key);
                            };
                        };
                    });
                } ;   
            });
        };

		$scope.updateOrder = function(orderManifest, currentItem, currentSize) {
			console.log('I GOT UPDATE,',orderManifest);
			var returnmode = false;

			angular.forEach(orderManifest, function (manifestItem) {
				console.log('TEST 6: '+manifestItem.size+' == '+currentSize.key);
				if ((manifestItem.id == currentItem.id) && (manifestItem.model == currentItem.model) && (manifestItem.size == currentSize.key))  {
					console.log('Update order manifest for '+manifestItem.model+': '+currentSize.key+ ' = '+currentSize.numOrder);
					manifestItem.numOrder = currentSize.numOrder;
					// Update order amount
				}
			});
		}

        $scope.isInOrder = function(orderManifest, currentItem, currentSize){
			console.log('I GOT JERE,',orderManifest);
			var returnmode = false;

			angular.forEach(orderManifest, function (manifestItem) {
				console.log('TEST 5: '+manifestItem.size+' == '+currentSize.key);
				if ((manifestItem.id == currentItem.id) && (manifestItem.model == currentItem.model) && (manifestItem.size == currentSize.key))  {
					console.log('Yup, it\'s in there wanna seee?');
					console.log('ListItem: ',manifestItem);
					console.log('CurrentItem: ',currentItem);
					console.log('Current Size: ',currentSize);
					returnmode = true;
				}
			});
			
			return returnmode;	
		}
        
        $scope.xisInOrder = function(array,n, size){
            if(array.length){
                var res = array.filter(function(o){
                    if(o.itemnumber == n.itemnumber && o.model == n.model && o.size == size.key) {
                        angular.forEach(n.sizes, function(cksize) {
                            if(size.checked && o.size == cksize.key && cksize.value) {
                                if(size.value >= n.numOrder) {
                                    if(o.numOrder){
										console.log(n,o);
                                        /*
                                        if((size.value - n.numOrder) >= 0)
                                        o.numOrder += n.numOrder;
                                        */
                                    }else{
                                        o.numOrder = n.numOrder;  
                                    }
                                    /*size.value -= n.numOrder;*/
                                    if(!cksize.value || cksize.value < 0) cksize.value = 0;
                                }else{
                                    n.doNag = "volume-too-large";
                                }
                            }    
                        });
                        return true;
                    } else return false;
                });    
                return !(!res.length);
            }
            return false;   
        };
        
        $scope.countSelect = function(){
			var totalQuantity = 0;
            angular.forEach($scope.orders, function (order){
                totalQuantity += parseInt(order.numOrder); 
            });
       		console.log(totalQuantity); 
            //return !(!$scope.orders.length);
            return !(!totalQuantity);
        };
        
        $scope.subtotal = function(){
            var total = 0;
            var totalQuantity = 0;
			console.log('subtotal()');

            angular.forEach($scope.orders, function (order){
                total += parseInt(order.numOrder) * order.price; 
                totalQuantity += parseInt(order.numOrder); 
            });

			$scope.totalQuantity = totalQuantity;

            //need to detect if its only reorder
            if(totalQuantity < $scope.minQuantity){
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
				$scope.orderdata = {"orderdata": $scope.orders, 
									"taxamt"   : $scope.tax,
									"taxable"  : ($scope.taxable) ? true : false };

				$http.post('/llrapi/v1/reorder/',$scope.orderdata)
					.success(function(data, status,headers,config){
						console.log(data.message);
						if (data.status == "success") $window.location.href = "/inv/checkout";
					})
					.error(function(data, status, headers, config){
						console.log(data.message);
					});
			}
        };
        
        $scope.fixInvalidNumber = function(n){
            if(typeof n.numOrder == "undefined"){
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
        
		$scope.setTaxable = function() {
			$scope.taxable = !$scope.taxable;
			$scope.subtotalnum -= $scope.tax;
			if (!$scope.taxable) $scope.tax = 0;
			else {
				shared.requestPromise = shared.requestData('/tax/'+$scope.subtotalnum);
				shared.requestPromise.then(function(data){
					$scope.tax = data.Tax; 
					$scope.total = data.Tax + $scope.subtotalnum;
					$scope.isComplete = true;
				});    
			}
		};

        $scope.$watch('subtotalnum', function(n,o){
            if(n){
                    $scope.isComplete = false;
						// Pre-tax discounts
                        if(shared.requestPromise && shared.getIsLoading()){
                            shared.requestPromise.abort();    
                        }
                        shared.requestPromise = shared.requestData('/discounts/'+n);
                        shared.requestPromise.then(function(data){
                        	$scope.discounts = data;
                            n = n - data.total;
                            
                            if(shared.requestPromise && shared.getIsLoading()){
                                shared.requestPromise.abort();    
                            }
							console.log($scope.taxable);
							if ($scope.taxable) { 
								shared.requestPromise = shared.requestData('/tax/'+n);
								shared.requestPromise.then(function(data){
									$scope.tax = data.Tax; 
									$scope.total = data.Tax + n;
									$scope.isComplete = true;
								});    
							}
							else {
								$scope.tax = 0;
								$scope.total = n;
								$scope.isComplete = true;
							}
                        });
            }
            else{
                $scope.discounts = [];
                $scope.tax = 0;
                $scope.total = 0;    
            } 
        });
            
        $scope.cancelCheckout = function(){
			$window.location.href=('/sales');
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
