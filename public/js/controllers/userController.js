'use strict';

/* UserController */

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

    app.controller('UserController',
        ['$scope','$http','shared','$q','$interval',
            function($scope, $http, shared, $q, $interval){

        /**
        * operations here
        */
        var defaultPath = ctrlpad.userCtrl.path,
			defaultLimit = 10,
            defaultOrderField = "last_name";
        $scope.orderByField = defaultOrderField;
        $scope.users = [];
        $scope.usersData = [];
        $scope.currentPage = 1;
        $scope.pageSize = defaultLimit;
        $scope.countItems = 0;
        $scope.meals = [];
        $scope.loadedPages = [];
        $scope.stop = undefined;
        $scope.prevJump = false;
        $scope.jumpData = [];
        
        $scope.counter = 0;
        $scope.isComplete = false;
        $scope.isLoading = function(){
            return !$scope.isComplete;    
        };
        
        var dRetriever = function(curPage,  limit, orderByField, sequence, nPath){
            var path = nPath;
            path += '?p='+curPage;
            if(limit != defaultLimit){
                path += '&l='+limit;
            }
            if(orderByField != undefined && orderByField != defaultOrderField){
                path += '&o='+orderByField;
            }
            if(sequence != undefined && sequence != 'asc'){
                path += '&s='+sequence;
            }
            
            if(shared.requestPromise && shared.getIsLoading()){
                shared.requestPromise.abort();    
            }
            shared.requestPromise = shared.requestData(path, $scope.search);
            var promise = shared.requestPromise.then(function(v){
                $scope.countItems = v.count;
                $scope.isComplete = true;
                $scope.users = v.data;
                
                return v;
            },function(r){
                return( $q.reject( "Something went wrong" ) );
            });
            
            return promise;    
        }
		
		$scope.pageChangeHandler = function(num) {
            
		};
        
        /*
        $scope.stopRequestPages = function() {
          if (angular.isDefined($scope.stop)) {
            $interval.cancel($scope.stop);
            $scope.stop = undefined;
          }
        };
        
        */
        
        /*
        $scope.checkLoadedPages = function(curPage){
            var beenLoaded = [];
            beenLoaded = $scope.loadedPages.filter(function(n){
                return n == curPage;  
            });
            
            return !beenLoaded.length; 
        };
        */
        
	    /* 
        $scope.$watch("pageSize", function(n, o){
            if(n != o){
                $scope.stopRequestPages();
                var promise = dRetriever($scope.currentPage, n, $scope.orderByField, $scope.reverseSort, defaultPath);
                //console.log("pagesize currentpage: "+$scope.currentPage);
            }
        });
        */
        /*
        $scope.$watch("currentPage", function(n, o){
            console.log("scope.search");
            console.log($scope.search);
            var promise = dRetriever(n, $scope.pageSize,$scope.orderByField, $scope.reverseSort, defaultPath);
            promise.then(function(v){
                var curPage = n; 
                
                $scope.users = v.data;
                
                if ( angular.isDefined($scope.stop) ) {
                    return;   
                }
                
            },function(r){
                return( $q.reject( "Something went wrong" ) );
            });
        });
        */
        
        $scope.$watch("usersData.length", function(n, o){
            //console.log($scope.usersData);
        });
        
        /*
        $scope.$on('$destroy', function() {
          $scope.stopRequestPages();
        });
        */

        /*
		$scope.$watch('search.$', function (n,o) {
            if( n != undefined){
			    console.log('search changes');
                $scope.isComplete = false;
			    console.log(n);
			    $scope.stopRequestPages();
                
                var path = "/api/search-user/"+n+"?type=all";
                
                if(n == ""){
                    dRetriever(n, $scope.pageSize,$scope.orderByField, $scope.reverseSort, defaultPath);
                }
                else{
                    if(shared.requestPromise && shared.getIsLoading()){
                        shared.requestPromise.abort();    
                    }
                    shared.requestPromise = shared.requestData(path);
                    var promise = shared.requestPromise.then(function(v){
                        $scope.countItems = v.count;
                        $scope.isComplete = true;
                        $scope.users = v.data;
                        $scope.currentPage = 1;
                        
                        return v;
                    },function(r){
                        return( $q.reject( "Something went wrong" ) );
                    });
                }
            }
        });
        
        */
        
        // bulk action checkboxes
        $scope.checkbox = function() {
            var checked = false;
            $('.bulk-check').each(function() {
            if ($(this).is(":checked")) checked = true;
            });
            if (checked == true) $('.applyAction').removeAttr('disabled');
            else $('.applyAction').attr('disabled', 'disabled');
        };
        
        dRetriever(1, $scope.pageSize,$scope.orderByField, $scope.reverseSort, defaultPath);
    }]);
}(module, pushIfNotFound, checkExists, ControlPad));