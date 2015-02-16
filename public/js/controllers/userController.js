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
        
        var mUser = function(curPage,  limit, orderByField, sequence){
            var path = defaultPath+curPage;
            path += '?a=1';
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
            shared.requestPromise = shared.requestData(path);
            var promise = shared.requestPromise.then(function(v){
                $scope.loadedPages.push(curPage);
                $scope.countItems = v.count;
                var totalPages = Math.ceil($scope.countItems/limit);
                var tempPages = Math.ceil($scope.users.length/limit);

                var res = [];
                var res = v.data.map(function(user, i){
                    var a = [],offset = (curPage -1) * limit + i;
                    a = $scope.users.filter(function(n){
                        return n.id == user.id;
                    });
                    
                    if(!a.length){
                        var i= $scope.users.length;  
                        for(;i <= offset; i++){
                            $scope.users.splice(i,0,user);
                        }    
                        
                        $scope.users.splice(offset,1,user);    
                    }

                    return user;    
                });
                
                $scope.usersData.push({'page':curPage,'data':res});
                
                return v;
            },function(r){
                return( $q.reject( "Something went wrong" ) );
            });
            
            return promise;    
        }
		
		$scope.pageChangeHandler = function(num) {
            
		};
        
        $scope.stopRequestPages = function() {
          if (angular.isDefined($scope.stop)) {
            $interval.cancel($scope.stop);
            $scope.stop = undefined;
          }
        };
        
        $scope.checkLoadedPages = function(curPage){
            var beenLoaded = [];
            beenLoaded = $scope.loadedPages.filter(function(n){
                return n == curPage;  
            });
            
            return !beenLoaded.length; 
        };
        
	     
        $scope.$watch("pageSize", function(n, o){
            if(n != o){
                $scope.stopRequestPages();
                var promise = mUser($scope.currentPage, n, $scope.orderByField, $scope.reverseSort);
                //console.log("pagesize currentpage: "+$scope.currentPage);
            }
        });
    
        $scope.$watch("currentPage", function(n, o){
            var totalPages = Math.ceil($scope.countItems/$scope.pageSize);
            var tempPages = Math.ceil($scope.users.length/$scope.pageSize);
            if(n!= undefined && o != undefined && n-1 != o && n != o ){
                $scope.prevJump = true;
            }
        
            if($scope.checkLoadedPages(n) && (!$scope.countItems || tempPages < totalPages))
            {
                var promise = mUser(n, $scope.pageSize,$scope.orderByField, $scope.reverseSort);
                promise.then(function(v){
                    var totalPages = Math.ceil($scope.countItems/$scope.pageSize);
                    var curPage = n; 
                    
                    if ( angular.isDefined($scope.stop) ) {
                        return;   
                    }
                    
                    $scope.stop = $interval(function() {
                        if(!shared.getIsLoading()){
                            curPage++;
                            if($scope.prevJump){
                                curPage = 1;
                                $scope.prevJump = false;    
                            }
                            if ($scope.checkLoadedPages(curPage) && curPage <= totalPages) {
                                mUser(curPage, $scope.pageSize,$scope.orderByField,$scope.reverseSort);
                            }
                        }
                        
                        if($scope.loadedPages.length == totalPages){
                            $scope.stopRequestPages();
                        }
                        
                    }, 1);
                    /**/
                },function(r){
                    return( $q.reject( "Something went wrong" ) );
                });
            }
        });
        
        $scope.$watch("usersData.length", function(n, o){
            //console.log($scope.usersData);
        });
        
        $scope.$on('$destroy', function() {
          $scope.stopRequestPages();
        });
    }]);
}(module, pushIfNotFound, checkExists, ControlPad));