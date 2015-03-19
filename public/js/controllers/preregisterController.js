'use strict';

/* PreRegisterController */

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
			'ngResource',
			'xeditable'
		];
	  
	push(app.requires, newModules); 
	
	app.run(function(editableOptions) {
	  editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
	});
	
	app.config(function($routeProvider, $locationProvider){
		$routeProvider
		.when('/:screen',{
			templateUrl: function(params){
				return '/template/preregister/'+params.screen;
			},
			controller: 'PreRegisterController',
		})
		.otherwise({
			templateUrl: '/template/preregister',
			controller: 'PreRegisterController',
			redirectTo: '/change_password'
		});
		if(window.history && window.history.pushState){
			//$locationProvider.html5Mode(true).hashPrefix('!');
		}    
	}); 

	app.controller('MainController',
		['$scope','$http','shared','$q','$interval','$window', '$route', '$routeParams', '$location',
			function($scope, $http, shared, $q, $interval, $window, $route, $routeParams, $location){
			
				$scope.$route = $route;
				$scope.$location = $location;
				$scope.$routeParams = $routeParams;
				
				$scope.log = function(){
					console.log('loging shared');
					console.log(shared);
				};
				
				$scope.$on("handleUpdateNext",function(){
					//$scope.next = shared.next;
				});
				
				$scope.$watch('$location.path()',function(n,o){
					if(n != o){
						shared.updateLocalNext(true);
						console.log('path changed');
						/*if(n != "/" &&  !$scope.hasOwnProperty('user')){
							$location.path('/');
						}*/    
					}
				});
	}]);
	
	app.controller('PreRegisterController',
		['$scope','$http','shared','$q','$interval','$window', '$route', '$routeParams', '$location',
			function($scope, $http, shared, $q, $interval, $window, $route, $routeParams, $location){

		/**
		* operations here
		*/
		var path =  ctrlpad.preRegisterCtrl.path;
		$scope.name = "PreRegisterController";
		$scope.params = $routeParams;
		$scope.countItems = 0;
		$scope.currentPage = 1;
		$scope.pageSize = 10;
		$scope.data = [];
		$scope.emailAlertMessage = "";
		
		$scope.isPassError =false;
		
		$scope.changePasswd = {
			status : false,
			message : ''
		};
		
		$scope.productForm = {
			status : false,
			message : '',
			checkName : function(d){
				if(d == ""){
					return "Must not be empty";
				}    
			},
			checkSize : function(d){
				if(d == ""){
					return "Must not be empty";
				} 
			},
			checkQuantity : function(d){
				if(d < 1){
					return "Must be a positive number.";
				} 
			},
			checkprice : function(d){
				if(d < 1){
					return "Must be a positive number.";
				}
			}
		};
		
		
		
		$scope.products = [];
		
		$scope.addProduct = function(){
			var tempProduct = {
				name: '',
				description: '',
				price: 0,
				quantity:1,
				size:"",
				save:false
			};
			var hasNewForm = $scope.products.filter(function(product){
				console.log(product);
				return product.size == 0;    
			});
			console.log(hasNewForm);
			if(!hasNewForm.length){
				var newProduct = angular.copy({},tempProduct);
				newProduct.name = "Product"+($scope.products.length+1);
				newProduct.description = "";
				newProduct.rep_price = parseFloat(0.00);
				newProduct.quantity = 1;
				newProduct.size = "";
				newProduct.save = false;
				
				var len = $scope.products.length; 
				$scope.products.splice(len+1,0,newProduct);
				$scope.next = false;
			}else{
				$scope.productForm.status = false;
				$scope.productForm.message = "Please edit and submit the last form before adding another item";
			}     
		};

		$scope.saveShippingAddress = function(){
			$http.post('/shipping_address',jQuery('form').serialize()).success(function(data){
				if(data.status == 'success'){
					$scope.goto(data.next_page);
					$scope.next = true;
					$scope.isBankError = false;
				}else{
					$scope.isBankError = true;
				}
			});
		};

		$scope.saveBankinfo = function(){
			$http.post('/bank-info',jQuery('form').serializeArray()).success(function(data){
				if(data.status == 'success'){
					$scope.next = true;
					$scope.isBankError = false;
					$scope.goto(data.next_page);
				}else{
					$scope.isBankError = true;
				}
			});
		};

		$scope.checkTermsAcceptance = function(){
			var request = $http({
				method  : 'POST',
				url     : '/accept-terms',
				data    : jQuery('form').serialize(),  // pass in data as strings
				headers : { 'Content-Type': 'application/x-www-form-urlencoded' },  // set the headers so angular passing info as form data (not request payload)
			});
			request.success(
				function(data){
					console.log(data);
					if(data.status == 'success'){
						$scope.next = true;
						// alert('yeehaw');
						//$scope.isBankError = false;
						$scope.goto(data.next_page);
					}else{
						//$scope.isBankError = true;
					}
				}			
			);
		};

		$scope.saveProduct = function(d){
			console.log(d);
			$http.post('/add-product',d).success(function(data){
				//d.id = data.id;
				$http.get('/api/all-products').success(function(all){
					$scope.products.splice(0);
					$scope.products = all.data;
				});
				console.log(data); 
			}).error(function(error){
				console.log(error);
			});
			d.save = true;
			console.log(d);
			console.log("Final Destination?");
			//document.location.href = '/inventories'; // Final destination
		};
		
		$scope.next = false;
		
		$scope.isComplete = true;
		$scope.isLoading = function(){
			return !$scope.isComplete;    
		};

		$scope.pageChangeHandler = function(num) {
			
		};
		
		$scope.showAlert = function(){
			return false;    
		};
		
		$scope.checkPassMsg = function(){
			return $scope.changePasswd.message != "";    
		};
		
		$scope.checkProductMsg = function(){
			return $scope.productForm.message != "";
		};
		
		$scope.changepasswd = function(){
			$http.post('/change-password',jQuery('form').serializeArray()).success(function(data){
				if(data.status == 'success'){
					$scope.next = true;
					$scope.isPassError = false;
					$scope.goto(data.next_page);
					
				}else{
					$scope.isPassError = true;
				}
				$scope.changePasswd.message = data.message;    
			});
		};
		
		$scope.goto = function(p){
			console.log(p);
			//console.log($location);
			//return;
			if(p == '/purchase-agreement'){
				$http.post('/register',$scope.user).success(function(data){
					$scope.goto(data.next_page);
					console.log(data)
				});    
			}else{
				shared.updateSignUpData($scope.user);
				$location.path(p);        
			}
		};
		
		$scope.log2 = function(){
			console.log('loging shared');
			console.log(shared);
		};

		$scope.$watch('next',function(n,o){
			if(n!=o){
				shared.updateNext(n);
				console.log('next update');
				console.log(n);
			}
		});
		
		$scope.$on("handleUpdateNext",function(){
			$scope.next = shared.next;
		});
		
		$scope.$on("handleUpdateLocalNext",function(){
			console.log('handleUpdateLocalNext');
			console.log(shared.next);
			$scope.next = shared.next; 
		});
		
		
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
