@extends('layouts.gray')
@section('content')
	<div ng-app ng-controller="CartController">
		<div class="row cart-actions">
			<div class="col-md-12">
				@include('_helpers.breadcrumbs')
				<h1 class="no-top">Shopping Cart</h1>
			</div>
		</div><!-- row -->
		<div class="row">
			<div class="col-md-12">
			    <table class="table table-striped">
			    	<thead>
				        <tr class="align-left">
				            <th style="width:0;">Product</th>
				            <th style="width:100%;"></th>
				            <th style="width:75px;">Quantity</th>
				            <th style="width:125px;">Price</th>
				            <th style="width:0;"></th>
				        </tr>
			    	</thead>
			        <tbody>
						<tr ng-repeat="product in products">
						    <td><img class="thumb" src="/uploads/{{'{'.'{product.image_sm}'.'}'}}"></td>
							<td><span ng-bind="product.name"></span></td>
							<td><input type="text" ng-model="product.purchase_quantity" min="1" class="form-control" ng-change="changeQuantity($index)"></td>
							<td>
								@if(Session::get('party_id') != NULL)
									<small><s class="red"><span class="amount" ng-bind="product.retail_price * product.purchase_quantity | currency"></span></s></small>
									<strong><span class="amount" ng-bind="product.rep_price * product.purchase_quantity | currency"></span></strong>
								@else
									<strong><span class="amount" ng-bind="product.retail_price * product.purchase_quantity | currency"></span></strong>
								@endif
							</td>
							<td class="align-center"><i class="fa fa-times pointer" ng-click="remove($index)"></i></td>
						</tr>
			        </tbody>
					<tfoot>
						<tr>
							<td colspan="2"></td>
							<th class="align-right">Total:</th>
							<td>
								@if(Session::get('party_id') != NULL)
									<s class="red"><span ng-bind='getRetailPriceTotal() | currency'></span></s>
									<strong class="font-size-2"><span ng-bind='getRepPriceTotal() | currency'></span></strong>
								@endif
								<strong class="font-size-2"><span ng-bind='getTotal() | currency'></span></strong>
							</td>
							<td></td>
						</tr>
					</tfoot>
			    </table>
			    @if(Session::get('party_id') != NULL)
				    <div class="alert alert-success inline-block pull-right">You're saving <span ng-bind="retail_price_total - rep_price_total | currency"></span> by purchasing from {{ $organizer->full_name }}!</div>
				    <div class="clear"></div>
				@endif
			    <a href="/sales/create" class="btn btn-primary pull-right">Proceed to Checkout <i class="fa fa-angle-right"></i></a>
		    </div>
		</div>
	</div>
@stop
@section('scripts')
	<script>
		function CartController($scope, $http) {
			$http.get('/api/cart').success(function(response) {
				$scope.products = response;
				$scope.remove = function(index) {
					$http.post('/cart/remove/' + index).success(function() {
						$scope.products.splice($scope.products[index], 1);
					});
				}
				
				// get retail total
				$scope.getRetailPriceTotal = function() {
				    var total = 0;
				    for(var i = 0; i < $scope.products.length; i++){
				        var product = $scope.products[i];
				        total += (product.retail_price * product.purchase_quantity);
				    }
				    return $scope.retail_price_total = total;
				}
				
				// get rep price total
				$scope.getRepPriceTotal = function() {
				    var total = 0;
				    for(var i = 0; i < $scope.products.length; i++){
				        var product = $scope.products[i];
				        total += (product.rep_price * product.purchase_quantity);
				    }
				    return $scope.rep_price_total = total;
				}
				
				// update quantity
				$scope.changeQuantity = function(index) {
					// console.log(index);
					//index ++;
					purchase_quantity = $scope.products[index].purchase_quantity;
					//index --;
					$http.post('/cart/change-quantity', {
						index : index,
						purchase_quantity : purchase_quantity
					}).success(function(result) {
						console.log(result);
					});
				}
			});
		}
	</script>
@stop
