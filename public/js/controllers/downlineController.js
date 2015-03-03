'use strict';

/* DownlineController */

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

    app.controller('DownlineController',
        ['$scope','$http','shared','$q','$interval',
            function($scope, $http, shared, $q, $interval){

        /**
        * operations here
        */
        var path =  ctrlpad.downlineCtrl.path;
        var defaultPath = ctrlpad.downlineCtrl.path,
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
        $scope.range = 7;
        
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
                
                //$scope.usersData.push({'page':curPage,'data':res});
                
                return v;
            },function(r){
                return( $q.reject( "Something went wrong" ) );
            });
            
            return promise;    
        };
        
        $scope.getStartDate = function(range) {
            var d = new Date();
            d.setDate(d.getDate() - range);
            var yyyy = d.getFullYear();
            var mm = d.getMonth()+1; //January is 0!
            var dd = d.getDate();
            var hh = d.getHours();
            var ii = d.getMinutes();
            var ss = d.getSeconds();
            if(dd<10){
                dd='0'+dd
            } 
            if(mm<10){
                mm='0'+mm
            } 
            if(hh<10){
                hh='0'+hh
            } 
            if(ii<10){
                ii='0'+ii
            }
            if(ss<10){
                ss='0'+ss
            }
            return $scope.startDate = yyyy + '-' + mm + '-' + dd + ' ' + hh + ':' + ii + ':' + ss;
        };
        $scope.getStartDate($scope.range);
        $scope.greaterThan = function(prop, val){
            return function(item){
              if (item[prop] > val) return true;
            };
        };
        
        $scope.$watch("currentPage", function(n, o){
            var promise = dRetriever(n, $scope.pageSize,$scope.orderByField, $scope.reverseSort, defaultPath);
                promise.then(function(v){
                    $scope.isComplete = true;
                },function(r){
                    return( $q.reject( "Something went wrong" ) );    
                });
        });
        
        $scope.pageChangeHandler = function(num) {
            console.log('page: '+num);    
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