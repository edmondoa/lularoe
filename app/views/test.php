<!DOCTYPE html>
<html ng-app="dropApp">

  <head>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
    <script src="//code.angularjs.org/1.3.1/angular.js"></script>
  </head>

  <body class="container">
    <h2 class="page-header">Lists</h2>
    <div ng-controller="dropController">
    
      <div class="form-horizontal">
        <div class="form-group">
          <label class="control-label col-sm-2">Category:</label>
          <div class="col-sm-10">
            <select id="categories" ng-model="search" class="form-control">
            	<option value="">All Categories</option>
                <option ng-repeat="productCategory in productCategories">{{ productCategory.name }}</option>
            </select>
            <!-- <select ng-model="selectedCategory" ng-options="c for c in categories" class="form-control"></select>     -->
          </div>
        </div>
        
        <div class="form-group">
          <label class="control-label col-sm-2">Sub Category:</label>
          <div class="col-sm-10">
            <select ng-model="categories" class="form-control">
            	<option value="">All Tags</option>
                <option ng-repeat="productTag in productCategories">{{ productTag.name }}</option>
            </select>
            <!-- <select ng-model="selectedSubCategory" ng-options="c for c in selectedSubCategoryValues" class="form-control"></select> -->
          </div>
        </div>
      </div>
      
      {{selectedCategory}}
      <br />
      {{selectedSubCategory}}
    </div>
    <script>
      
      (function () {
        
        angular.module('dropApp', []);
        
        angular.module('dropApp').controller('dropController', ['$scope', dropController]);
        
        function dropController($scope) {
        	
			$http.get('/api/all-product-categories').success(function(productCategories) {
				$scope.productCategories = productCategories;
				console.log($scope.productCategories);
			});
        	
          // $scope.categories = [
            // "Meat",
            // "Dairy"
          // ];
//           
          // $scope.subCategories = [
            // { name: "Meat",
            // values: [
              // "Pig",
              // "Cow",
              // "Sheep",
              // "Chicken"]
            // },{
              // name: "Dairy",
              // values: [
                // "Butter",
                // "Milk"]
            // }
          // ];
          
          $scope.selectedCategory = "";
          $scope.selectedSubCategoryValues = [];
          $scope.selectedSubCategory = "";
          
          $scope.$watch('selectedCategory', function(newValue) {
            for (var i = 0; i < $scope.subCategories.length; i++){
              if ($scope.subCategories[i].name === newValue){
                $scope.selectedSubCategoryValues = $scope.subCategories[i].values;
              }
            }
          });
        }
        
      })();
      
    </script>
  </body>

</html>
