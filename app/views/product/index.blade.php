@extends('layouts.default')
@section('content')
<div class="row" ng-controller="ProductsController">
	<h1>All Products</h1>
	{{ Form::open(array('url' => 'product/disable', 'method' => 'POST')) }}
		<div class="pull-left">
			<a class="btn btn-success pull-left margin-right-1" title="New" href="{{ url('product/create') }}"><i class="fa fa-plus"></i></a>
			<div class="pull-left">
			    <div class="input-group">
			        <select class="form-control selectpicker actions">
				    	<option value="product/disable" selected>Disable</option>
				    	<option value="product/enable">Enable</option>
				    	<option value="product/delete">Delete</option>
			        </select>
			        <div class="input-group-btn">
			        	<button class="btn btn-default applyAction" disabled><i class="fa fa-check"></i></button>
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
		<div class="clear"></div>
	    <table class="table table-striped">
	        <thead>
	        	<tr>
	        		<th><input type="checkbox"></th>
	        		<th ng-click="orderByField='name'; reverseSort = !reverseSort">
						 <span class='link' href='#'>Name
						 	<span ng-show="orderByField == 'name'">
								<span ng-show="!reverseSort"><i class='fa fa-sort-asc'></i></span>
								<span ng-show="reverseSort"><i class='fa fa-sort-desc'></i></span>
							</span>
						</span>
	        		</th>
	        		<th>Blurb</th><th>Description</th><th>Price</th><th>Quantity</th><th>Category Id</th><th>Disabled</th>
	        	</tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="product in products | filter:search | orderBy:orderByField:reverseSort">
		            <td ng-click="checkbox()"><input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.product_id')"></td>
		            
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
		            
		        </tr>
	        </tbody>
	    </table>
    {{ Form::close() }}

</div>
<script>

	// AngularJS controller
	function ProductsController($scope, $http) {
		$http.get('/api/all-products').success(function(products) {
		
			$scope.products = products;
			
			// bulk action checkboxes
			$scope.checkbox = function() {
				var checked = false;
				$('.bulk-check').each(function() {
					if ($(this).is(":checked")) checked = true;
				});
				if (checked == true) $('.applyAction').removeAttr('disabled');
				else $('.applyAction').attr('disabled', 'disabled');
			};
			
		});	
	}

</script>
@stop