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
        
        $http.get(path).success(function(products) {
            $scope.products = products;
        });
        
        path =  ctrlpad.productCtrl.all_product_categories_url;
        
        $http.get(path).success(function(productCategories) {
            $scope.productCategories = productCategories;
            console.log($scope.productCategories);
        });
        
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        $scope.meals = [];
        
        $scope.pageChangeHandler = function(num) {
            
        };
        
        $scope.$watch('search', function(newValue) {
            index = jQuery('#categories option:selected').attr('data-index');
            if (index != undefined) $scope.selectedSubCategoryValues = $scope.productCategories[index].tags;
        });
    }]);
}(module, pushIfNotFound, checkExists, ControlPad));