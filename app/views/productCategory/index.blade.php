@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'productCategories/disable', 'method' => 'POST')) }}
        <div ng-controller="ProductCategoryController" class="my-controller">
            <div class="page-actions">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="no-top pull-left no-pull-xs">All Product Categories</h1>
                        <div class="pull-right hidable-xs">
                            <div class="input-group pull-right">
                                <span class="input-group-addon no-width">Count</span>
                                <input class="form-control itemsPerPage width-auto" ng-model="pageSize" type="number" min="1">
                            </div>
                            <h4 class="pull-right margin-right-1">Page <span ng-bind="currentPage"></span></h4>
                        </div>
                    </div>
                </div><!-- row -->
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12 page-actions-left">
                        <div class="pull-left">
                            <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('productCategories/create') }}"><i class="fa fa-plus"></i></a>
                            <div class="pull-left">
                                <div class="input-group">
                                    <select class="form-control selectpicker actions">
                                        <option value="productCategories/disable" selected>Disable</option>
                                        <option value="productCategories/enable">Enable</option>
                                        <option value="productCategories/delete">Delete</option>
                                    </select>
                                    <div class="input-group-btn no-width">
                                        <button class="btn btn-default applyAction" disabled>
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="input-group pull-right no-pull-xs">
                            <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(event)" type="text">
                            <span class="input-group-btn no-width">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div><!-- col -->
                </div><!-- row -->
            </div><!-- page-actions -->
            <div class="row">
                <div class="col col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox">
                                </th>
                                 
                                <th class="link" ng-click="orderByField='name'; reverseSort = !reverseSort">Name
                                    <span>
                                        <span ng-show="orderByField == 'name'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                 
                                <!-- <th class="link" ng-click="orderByField='parent_name'; reverseSort = !reverseSort">Parent
                                    <span>
                                        <span ng-show="orderByField == 'parent_name'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th> -->
                                 
                                <th class="link" ng-click="orderByField='updated_at'; reverseSort = !reverseSort">Modified
                                    <span>
                                        <span ng-show="orderByField == 'updated_at'">
                                            <span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
                                            <span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                                        </span>
                                    </span>
                                </th>
                                 
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-class="{ highlight : productCategory.new == 1, semitransparent : productCategory.disabled }" dir-paginate-start="productCategory in productCategories | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
                                <td ng-click="checkbox()">
                                    <input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.productCategory_id')">
                                </td>
                                 
                                <td>
                                    <a href="/productCategories/@include('_helpers.productCategory_id')"><span ng-bind="productCategory.name"></span></a>
                                </td>
                                 
                                <!-- <td>
                                    <a href="/productCategories/@include('_helpers.productCategory_parent_id')"><span ng-bind="productCategory.parent_name"></span></a>
                                </td> -->
                                 
                                <td>
                                    <a href="/productCategories/@include('_helpers.productCategory_id')"><span ng-bind="productCategory.updated_at"></span></a>
                                </td>
                            </tr>
                            <tr dir-paginate-end></tr>
                        </tbody>
                    </table>
                    @include('_helpers.loading')<div ng-controller="OtherController" class="other-controller">
                        <div class="text-center">
                            <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="/packages/dirpagination/dirPagination.tpl.html"></dir-pagination-controls>
                        </div>
                    </div>
                </div><!-- col -->
            </div><!-- row -->
        {{ Form::close() }}
    </div><!-- app -->
@stop
@section('scripts')
<script>
 
    var app = angular.module('app', ['angularUtils.directives.dirPagination']);
     
    function ProductCategoryController($scope, $http) {
     
        $http.get('/api/all-product-categories').success(function(productCategories) {
            $scope.productCategories = productCategories;
            console.log($scope.productCategories);
            @include('_helpers.bulk_action_checkboxes')
             
        });
         
        $scope.currentPage = 1;
        $scope.pageSize = 10;
        $scope.meals = [];
         
        $scope.pageChangeHandler = function(num) {
             
        };
         
    }
     
    function OtherController($scope) {
        $scope.pageChangeHandler = function(num) {
        };
    }
 
</script>
@stop