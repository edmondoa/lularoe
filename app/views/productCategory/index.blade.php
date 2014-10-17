@extends('layouts.default')
@section('content')
<div ng-app="app">
    {{ Form::open(array('url' => 'productCategory/disable', 'method' => 'POST')) }}
	    <div ng-controller="ProductCategoryController" class="my-controller">
	        <div class="row">
	            <div class="col col-md-8">
	                <h1 class="no-top">All ProductCategories</h1>
	            </div>
	            <div class="col col-md-4">
	                <div class="pull-right">
	                    <div class="input-group">
	                        <span class="input-group-addon">Count</span>
	                        <input type="number" min="1" class="form-control itemsPerPage" ng-model="pageSize">
	                    </div>
	                </div>
	                <h4 class="pull-right no-top currentPage margin-right-1">Page <span ng-bind="currentPage"></span></h4>
	            </div>
	        </div><!-- row -->
	        <div class="row">
	            <div class="col col-md-12">
	                <div class="pull-left">
	                    <a class="btn btn-success pull-left margin-right-1" title="New" href="{{ url('productCategory/create') }}"><i class="fa fa-plus"></i></a>
	                    <div class="pull-left">
	                        <div class="input-group">
	                            <select class="form-control selectpicker actions">
	                                <option value="productCategory/disable" selected>Disable</option>
	                                <option value="productCategory/enable">Enable</option>
	                                <option value="productCategory/delete">Delete</option>
	                            </select>
	                            <div class="input-group-btn">
	                                <button class="btn btn-default applyAction" disabled>
	                                    <i class="fa fa-check"></i>
	                                </button>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="pull-right">
	                    <div class="input-group">
	                        <input class="form-control ng-pristine ng-valid" placeholder="Search" name="new_tag" ng-model="search.$" onkeypress="return disableEnterKey(event)" type="text">
	                        <span class="input-group-btn">
	                            <button class="btn btn-default" type="button">
	                                <i class="fa fa-search"></i>
	                            </button>
	                        </span>
	                    </div>
	                </div>
	            </div><!-- col -->
	        </div><!-- row -->
	        <div class="row">
	            <div class="col col-md-12">
	                <table class="table">
	                    <thead>
	                        <tr>
	                            <th>
	                            	<input type="checkbox">
	                            </th>
                            	
                            	<th ng-click="orderByField='name'; reverseSort = !reverseSort">Name
                            		<span class='link' href='#'>
                            			<span ng-show="orderByField == 'name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th ng-click="orderByField='disabled'; reverseSort = !reverseSort">Disabled
                            		<span class='link' href='#'>
                            			<span ng-show="orderByField == 'disabled'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <tr dir-paginate-start="productCategory in productCategories | filter:search | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
	                            <td ng-click="checkbox()">
	                            	<input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.productCategory_id')">
	                            </td>
								
					            <td>
					                <a href="/productCategories/@include('_helpers.productCategory_id')"><span ng-bind="productCategory.name"></span></a>
					            </td>
					            
					            <td>
					                <a href="/productCategories/@include('_helpers.productCategory_id')"><span ng-bind="productCategory.disabled"></span></a>
					            </td>
					            
	                        </tr>
	                        <tr dir-paginate-end></tr>
	                    </tbody>
	                </table>
	                <div ng-controller="OtherController" class="other-controller">
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
	
		$http.get('/api/all-productCategories').success(function(productCategories) {
			$scope.productCategories = productCategories;
		});
		
		$scope.currentPage = 1;
		$scope.pageSize = 10;
		$scope.meals = [];
		
		$scope.pageChangeHandler = function(num) {
			console.log('meals page changed to ' + num);
		};
		
	}
	
	function OtherController($scope) {
		$scope.pageChangeHandler = function(num) {
		};
	}

</script>
@stop