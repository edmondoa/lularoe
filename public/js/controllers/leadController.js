'use strict';

/* LeadController */

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

    app.controller('LeadController',
        ['$scope','$http','shared','$q','$interval',
            function($scope, $http, shared, $q, $interval){

        /**
        * operations here
        */
        var path =  ctrlpad.leadCtrl.path;
        var defaultPath = ctrlpad.leadCtrl.path,
            defaultLimit = 10,
            defaultOrderField = "last_name";
        $scope.orderByField = defaultOrderField;
        $scope.leads = [];
        $scope.levelsData = [];
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
            shared.requestPromise = shared.requestData(path);
            var promise = shared.requestPromise.then(function(v){
                $scope.loadedPages.push(curPage);
                $scope.countItems = v.count;
                var totalPages = Math.ceil($scope.countItems/limit);
                var tempPages = Math.ceil($scope.leads.length/limit);

                var res = [];
                var res = v.data.map(function(user, i){
                    var a = [],offset = (curPage -1) * limit + i;
                    a = $scope.leads.filter(function(n){
                        return n.id == user.id;
                    });
                    
                    if(!a.length){
                        var i= $scope.leads.length;  
                        for(;i <= offset; i++){
                            $scope.leads.splice(i,0,user);
                        }    
                        
                        $scope.leads.splice(offset,1,user);    
                    }

                    return user;    
                });
                
                //$scope.levelsData.push({'page':curPage,'data':res});
                
                return v;
            },function(r){
                return( $q.reject( "Something went wrong" ) );
            });
            
            return promise;    
        }
        
        $scope.pageChangeHandler = function(num) {
            
        };
        
        $scope.$watch("currentPage", function(n, o){
            var promise = dRetriever(n, $scope.pageSize,$scope.orderByField, $scope.reverseSort, defaultPath);
                promise.then(function(v){
                    $scope.isComplete = true;
                },function(r){
                    return( $q.reject( "Something went wrong" ) );    
                }) 
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