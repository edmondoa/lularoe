@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'products/disable', 'method' => 'POST')) }}
	    <div ng-controller="ProductController" class="my-controller">
	    	<div class="page-actions">
		        <div class="row">
		            <div class="col col-md-8">
		                <h1 class="no-top">All Products</h1>
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
		                    <a class="btn btn-success pull-left margin-right-1" title="New" href="{{ url('products/create') }}"><i class="fa fa-plus"></i></a>
		                    <div class="pull-left">
		                        <div class="input-group">
		                            <select class="form-control selectpicker actions">
		                                <option value="products/disable" selected>Disable</option>
		                                <option value="products/enable">Enable</option>
		                                <option value="products/delete">Delete</option>
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
                        		
                            	<th class="link" ng-click="orderByField='blurb'; reverseSort = !reverseSort">Blurb
                            		<span>
                            			<span ng-show="orderByField == 'blurb'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='description'; reverseSort = !reverseSort">Description
                            		<span>
                            			<span ng-show="orderByField == 'description'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='price'; reverseSort = !reverseSort">Price
                            		<span>
                            			<span ng-show="orderByField == 'price'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='quantity'; reverseSort = !reverseSort">Quantity
                            		<span>
                            			<span ng-show="orderByField == 'quantity'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='category_id'; reverseSort = !reverseSort">Category Id
                            		<span>
                            			<span ng-show="orderByField == 'category_id'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='disabled'; reverseSort = !reverseSort">Disabled
                            		<span>
                            			<span ng-show="orderByField == 'disabled'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
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
	                        <tr ng-class="{highlight: address.new == 1}" dir-paginate-start="product in products | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
	                            <td ng-click="checkbox()">
	                            	<input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.product_id')">
	                            </td>
								
					            <td>
					                <a href="/products/@include('_helpers.product_id')"><span ng-bind="product.name"></span></a>
					            </td>
					            
					            <td>
					                <a href="/products/@include('_helpers.product_id')"><span ng-bind="product.blurb"></span></a>
					            </td>
					            
					            <td>
					                <a href="/products/@include('_helpers.product_id')"><span ng-bind="product.description"></span></a>
					            </td>
					            
					            <td>
					                <a href="/products/@include('_helpers.product_id')"><span ng-bind="product.price"></span></a>
					            </td>
					            
					            <td>
					                <a href="/products/@include('_helpers.product_id')"><span ng-bind="product.quantity"></span></a>
					            </td>
					            
					            <td>
					                <a href="/products/@include('_helpers.product_id')"><span ng-bind="product.category_id"></span></a>
					            </td>
					            
					            <td>
					                <a href="/products/@include('_helpers.product_id')"><span ng-bind="product.disabled"></span></a>
					            </td>
					            
					            <td>
					            	<a href="/products/@include('_helpers.product_id')"><span ng-bind="product.updated_at"></span></a>
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
	
	function ProductController($scope, $http) {
	
		$http.get('/api/all-products').success(function(products) {
			$scope.products = products;
			
			@include('_helpers.bulk_action_checkboxes')
			
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