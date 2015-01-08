<!DOCTYPE html>
<html ng-app="app">

<head>
  <link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
  <script data-require="angular.js@1.3.0-beta.5" data-semver="1.3.0-beta.5" src="https://code.angularjs.org/1.3.0-beta.5/angular.js"></script>
  <script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
  <script data-require="bootstrap@3.1.1" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css" />
  <script>
// Code goes here

var myApp = angular.module('app', ['angularUtils.directives.dirPagination']);

function MyController($scope) {

  $scope.currentPage = 1;
  $scope.pageSize = 10;
  $scope.meals = [];

  var dishes = [
    'noodles',
    'sausage',
    'beans on toast',
    'cheeseburger',
    'battered mars bar',
    'crisp butty',
    'yorkshire pudding',
    'wiener schnitzel',
    'sauerkraut mit ei',
    'salad',
    'onion soup',
    'bak choi',
    'avacado maki'
  ];
  var sides = [
    'with chips',
    'a la king',
    'drizzled with cheese sauce',
    'with a side salad',
    'on toast',
    'with ketchup',
    'on a bed of cabbage',
    'wrapped in streaky bacon',
    'on a stick with cheese',
    'in pitta bread'
  ];
  for (var i = 1; i <= 100; i++) {
    var dish = dishes[Math.floor(Math.random() * dishes.length)];
    var side = sides[Math.floor(Math.random() * sides.length)];
    $scope.meals.push('meal ' + i + ': ' + dish + ' ' + side);
  }
  
  $scope.pageChangeHandler = function(num) {
      
  };
}

function OtherController($scope) {
  $scope.pageChangeHandler = function(num) {
    console.log('going to page ' + num);
  };
}
  </script>
  <script src="/packages/dirpagination/dirPagination.js"></script>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div ng-controller="MyController" class="my-controller">
          <h1>Tasty Paginated Menu</h1>

          <small>this is in "MyController"</small>


          <div class="row">
            <div class="col-xs-4">
              <h3>Meals Page: <div ng-bind="currentPage"></div></h3>
            </div>
            <div class="col-xs-4">
              <label for="search">Search:</label>
              <input ng-model="q" id="search" class="form-control" placeholder="Filter text">
            </div>
            <div class="col-xs-4">
              <label for="search">items per page:</label>
              <input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
            </div>
          </div>
          <br>
          <div class="panel panel-default">
            <div class="panel-body">

              <ul>
                <li dir-paginate-start="meal in meals | filter:q | itemsPerPage: pageSize" current-page="currentPage"><span ng-bind="meal"></span></li>
                <li dir-paginate-end></li>
                
              </ul>
            </div>
          </div>
        </div>

        <div ng-controller="OtherController" class="other-controller">
          <small>this is in "OtherController"</small>
          <div class="text-center">
          <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="/packages/dirpagination/dirPagination.tpl.html"></dir-pagination-controls>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
