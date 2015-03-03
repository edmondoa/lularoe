'use strict';

/* ProductController */

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

    app.controller('ProductController',
        ['$scope','$http','shared','$q','$interval',
            function($scope, $http, shared, $q, $interval){

        /**
        * operations here
        */
        var path =  ctrlpad.productCtrl.all_products_url;
        var defaultPath = ctrlpad.productCtrl.all_products_url,
            defaultLimit = 10,
            defaultOrderField = "name";
        $scope.orderByField = defaultOrderField;
        $scope.products = [];
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
            shared.requestPromise = shared.requestData(path);
            var promise = shared.requestPromise.then(function(v){
                $scope.loadedPages.push(curPage);
                $scope.countItems = v.count;
                var totalPages = Math.ceil($scope.countItems/limit);
                var tempPages = Math.ceil($scope.products.length/limit);

                var res = [];
                var res = v.data.map(function(user, i){
                    var a = [],offset = (curPage -1) * limit + i;
                    a = $scope.products.filter(function(n){
                        return n.id == user.id;
                    });
                    
                    if(!a.length){
                        var i= $scope.products.length;  
                        for(;i <= offset; i++){
                            $scope.products.splice(i,0,user);
                        }    
                        
                        $scope.products.splice(offset,1,user);    
                    }

                    return user;    
                });
                
                //$scope.productsData.push({'page':curPage,'data':res});
                
                return v;
            },function(r){
                return( $q.reject( "Something went wrong" ) );
            });
            
            return promise;    
        }
        
        /*
        $http.get(path).success(function(v) {
            $scope.countItems = v.count;
            $scope.products = v.data;
            $scope.isComplete = true;
        });
        */
        
        path =  ctrlpad.productCtrl.all_product_categories_url;
        
        $http.get(path).success(function(productCategories) {
            $scope.productCategories = productCategories;
            console.log($scope.productCategories);
        });
        
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
        
        $scope.$watch('search', function(newValue) {
            //index = jQuery('#categories option:selected').attr('data-index');
            //if (index != undefined) $scope.selectedSubCategoryValues = $scope.productCategories[index].tags;
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