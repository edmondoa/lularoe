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
        .when('/products',{
            templateUrl: '/template/preregister/products',
            controller: 'PreRegisterController'
        })
        .when('/additional-info',{
            templateUrl: '/template/preregister/additional-info',
            controller: 'PreRegisterController'
        })
        .when('/:screen',{
            templateUrl: function(params){
                return '/template/preregister/'+params.screen;
            },
            controller: 'PreRegisterController',
        })
        .otherwise({
            templateUrl: '/template/preregister',
            controller: 'PreRegisterController',
            redirectTo: '/'
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
                
                $scope.$on('handleUpdateSignUpData',function(){
                    $scope.user = shared.signupData;   
                });
                
                $scope.log = function(){
                    console.log('loging shared');
                    console.log(shared);
                };
                
                /*$scope.$watch('$location.path()',function(n,o){
                    if(n != "/" &&  !$scope.hasOwnProperty('user')){
                        $location.path('/');
                    }*/    
               /* });  */ 
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
        $scope.changePasswd = {
            status : 'failed',
            message : ''
        };
        
        
        
        $scope.inventories = [];
        
        $scope.addProduct = function(){
            var tempProduct = {
                model: 'sample',
                description: 'Some description here',
                price: 0,
                sizes: [
                    {
                        'key' : 'a',
                        'value': 100
                    },
                    {
                        'key' : 'b',
                        'value': 15454
                    },
                    {
                        'key' : 'c',
                        'value': 15465
                    },
                    {
                        'key' : 'd',
                        'value': 12545
                    }
                ]
            };
            var newProduct = angular.copy({},tempProduct);
            newProduct.model = "Product"+($scope.inventories.length+1);
            var len = $scope.inventories.length; 
            $scope.inventories.splice(len+1,0,newProduct);     
        };
        
        $scope.showGenAddProd = function(){

        };
        
        $scope.isPassError =false;
        
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
        
        $scope.changepasswd = function(){
            console.log($scope.loginForm);
            $http.post('/change-password',jQuery('form').serializeArray()).success(function(data){
                if(data.status == 'success'){
                    $scope.next = true;
                    $scope.isPassError = false;
                }else{
                    $scope.isPassError = true;
                }
                $scope.changePasswd.message = data.message;    
            });
        };
        
        $scope.goto = function(p){
            $scope.next = false;
            if(p == '/purchase-agreement'){
                $http.post('/register',$scope.user).success(function(data){
                    console.log(data)
                });    
            }else{
                shared.updateSignUpData($scope.user);
                $location.path(p);        
            }
        };
        
        $scope.$on('handleUpdateSignUpData',function(){;
            $scope.user = shared.signupData;   
        });
        
        $scope.log2 = function(){
            console.log('loging shared');
            console.log(shared);
        };
        
        $scope.checkPoint = function(){
            if($scope.hasOwnProperty('user')){
                if($scope.user.hasOwnProperty('first_name')){
                    if($scope.user.first_name != ''){
                        return true;
                    }
                }
            }
            return false;
        };
        
        $scope.checkEmail = function(email){
            $http.get('/preregister/checkEmailIfExist/'+email).success(function(d) {
                console.log(d.message);
                $scope.emailAlertMessage = d.message;
            });
        };
        
        $scope.hasEmailAlertMessage = function(){
            
        };
        
        $scope.processform1 = function(){
             $http.post('/register',$scope.user).success(function(data){
                console.log(data)
            });       
        }; 
    }]);
}(module, pushIfNotFound, checkExists, ControlPad));