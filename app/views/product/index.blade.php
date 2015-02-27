@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'products/disable', 'method' => 'POST')) }}
	    <div ng-controller="ProductController" class="my-controller">
	    	<div class="page-actions">
		        <div class="row">
		            <div class="col-md-12">
		                <h1 class="no-top pull-left no-pull-xs">All Products</h1>
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
		            <div class="col-md-9 col-sm-8 col-xs-12 page-actions-left">
		                <div class="pull-left">
		                    <a class="btn btn-primary pull-left margin-right-1" title="New" href="{{ url('products/create') }}"><i class="fa fa-plus"></i></a>
		                    <div class="pull-left">
		                    	<?php /* record actions */ ?>
		                        <div class="input-group pull-left margin-right-2">
		                            <select class="form-control selectpicker actions">
		                                <option value="products/disable" selected>Disable</option>
		                                <option value="products/enable">Enable</option>
		                                <option value="products/delete">Delete</option>
		                            </select>
		                            <div class="input-group-btn no-width">
		                                <button class="btn btn-default applyAction" disabled>
		                                    <i class="fa fa-check"></i>
		                                </button>
		                            </div>
		                        </div>
		                        <?php /* select categories */ ?>
		                        <div class="pull-left margin-right-1">
		                            <select ng-model="search" id="categories" class="form-control">
		                            	<option value="">All Categories</option>
		                                <option ng-repeat="productCategory in productCategories" data-index="@include('_helpers.index')">@include('_helpers.productCategory_name')</option>
		                            </select>
		                    	</div>
		                        <?php /* select tags */ ?>
		                        <div class="pull-left">
		                            <select ng-model="search" id="tags" class="form-control">
		                            	<option value="">All Tags</option>
		                                <option ng-repeat="productTag in selectedSubCategoryValues" value="@include('_helpers.productTag_name')">@include('_helpers.productTag_name')</option>
		                            </select>
		                    	</div>
		                    </div>
		                </div>
			        </div>
			        <div class="col-md-3 col-sm-4 col-xs-12">
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

	                            <th>
	                            	Image
	                            </th>
                            	
                            	<th class="link" ng-click="orderByField='name'; reverseSort = !reverseSort">Name
                            		<span>
                            			<span ng-show="orderByField == 'name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="link" ng-click="orderByField='retail_price'; reverseSort = !reverseSort">Retail Price
                            		<span>
                            			<span ng-show="orderByField == 'retail_price'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="hidable-xs link" ng-click="orderByField='quantity'; reverseSort = !reverseSort">Quantity
                            		<span>
                            			<span ng-show="orderByField == 'quantity'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="hidable-xs link" ng-click="orderByField='category_name'; reverseSort = !reverseSort">Category
                            		<span>
                            			<span ng-show="orderByField == 'category_name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="hidable-xs link" ng-click="orderByField='tag_name'; reverseSort = !reverseSort">Tags
                            		<span>
                            			<span ng-show="orderByField == 'tag_name'">
	                            			<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
	                            			<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
                            			</span>
                            		</span>
                        		</th>
                        		
                            	<th class="hidable-xs link" ng-click="orderByField='updated_at'; reverseSort = !reverseSort">Modified
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
	                        <tr ng-class="{ highlight : product.new == 1, semitransparent : product.disabled == 1 }" ng-class="{highlight: address.new == 1}" dir-paginate-start="product in products | filter:search | orderBy: '-updated_at' | orderBy:orderByField:reverseSort | itemsPerPage: pageSize" current-page="currentPage">
	                            <td ng-click="checkbox()">
	                            	<input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.product_id')">
	                            </td>
	                            
					            <td>
					                <a href="/products/@include('_helpers.product_id')">
					                	<img class="thumb" src="/uploads/@include('_helpers.attachment_image_sm')">
					                </a>
					            </td>
								
					            <td>
					                <a href="/products/@include('_helpers.product_id')"><span ng-bind="product.name"></span></a>
					            </td>
					            
					            <td>
					               	<span ng-bind="product.retail_price | currency"></span>
					            </td>
					            
					            <td class="hidable-xs">
					                <span ng-bind="product.quantity"></span>
					            </td>
					            
					            <td class="hidable-xs">
					                <a class="link" ng-click="$parent.search=product.category_name"><span ng-bind="product.category_name"></span></a>
					            </td>
					            
					            <td class="hidable-xs tag-list">
					                <span class="label label-default" ng-repeat="tag in product.tags">
					                	<a class="link" ng-click="$parent.$parent.search=tag.name"><span ng-bind="tag.name"></span></a>
					                </span>
					            </td>
					            
					            <td class="hidable-xs">
					            	<span ng-bind="product.updated_at"></span>
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
	
	function ProductController($scope, $http) {
	
		$http.get('/api/all-products').success(function(products) {
			$scope.products = products;
			@include('_helpers.bulk_action_checkboxes')
		});
		
		$http.get('/api/all-product-categories').success(function(productCategories) {
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

	}

	function OtherController($scope) {
		$scope.pageChangeHandler = function(num) {
		};
	}

</script>
@stop