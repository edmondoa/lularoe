@section('content')
<div class="row" ng-controller="ProductsController">
    <h1>All Products</h1>
	{{ Form::open(array('url' => 'product/disable/0', 'method' => 'POST')) }}
	    <div class="pull-left">
		    <a class="btn btn-success pull-left margin-right-1" href="{{ url('product.create') }}">New</a>
		    <div class="pull-left">
			    <div class="input-group">
			        <select class="form-control selectpicker actions">
				    	<option value="product/disable" selected>Disable</option>
				    	<option value="product/enable" selected>Enable</option>
				    	<option value="product/delete" selected>Delete</option>
			        </select>
			        <div class="input-group-btn">
			        	<button class="btn btn-default applyAction" disabled><i class="fa fa-check"></i></button>
			        </div>
			    </div>
			</div>
		</div><!-- col -->
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
	    <table class="table">
	        <thead>
	        	<tr>
	        		<th><input type="checkbox"></th>
	        		<th>Name</th><th>Blurb</th><th>Description</th><th>Price</th><th>Quantity</th><th>Category Id</th><th>Disabled</th>
	        	</tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="product in products | filter:search | orderBy : 'created_at':reverse">
		            <td ng-click="checkbox()"><input class="bulk-check" type="checkbox" name="ids[]" value="@include('_helpers.product_id')"></td>
		            
		            <td>
		                <a href="product.id"><span ng-bind="product.name"></a>
		            </td>
		            
		            <td>
		                <a href="product.id"><span ng-bind="product.blurb"></a>
		            </td>
		            
		            <td>
		                <a href="product.id"><span ng-bind="product.description"></a>
		            </td>
		            
		            <td>
		                <a href="product.id"><span ng-bind="product.price"></a>
		            </td>
		            
		            <td>
		                <a href="product.id"><span ng-bind="product.quantity"></a>
		            </td>
		            
		            <td>
		                <a href="product.id"><span ng-bind="product.category_id"></a>
		            </td>
		            
		            <td>
		                <a href="product.id"><span ng-bind="product.disabled"></a>
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