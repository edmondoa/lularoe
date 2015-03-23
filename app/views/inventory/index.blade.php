@extends('layouts.default')
@section('content')
<style>	
	.toggleBg { background : #efefef }
</style>
<div ng-app="app" class="index">
	<h1>Order Inventory</h1>
	{{ Form::open(array('url' => 'inv/checkout', 'method' => 'POST','name'=>'inven')) }}
		<div ng-controller="InventoryController" class="my-controller">
			<div class="row">
				<div class="col col-md-8">
					<div class="pull-right" style="position:relative;">
						@include('_helpers.loading')
					</div>
					@if (!isset($full))
						<ul class="nav nav-tabs">
							<!-- <li class="active" ng-click="filterRows('')"><a href="#">All</a></li> -->
							<li class="active" ng-click="filteredRows = groups['A']; activeGroup = 'A'">
								<a href="#">Group A</a>
							</li>
							<li ng-click="filteredRows = groups['B']; activeGroup = 'B'">
								<a href="#">Group B</a>
							</li>
							<li ng-click="filteredRows = groups['C']; activeGroup = 'C'">
								<a href="#">Group C</a>
							</li>
							<li ng-click="filteredRows = groups['L']; activeGroup = 'L'">
								<a href="#">Leggings</a>
							</li>
							<li ng-click="filteredRows = groups['K']; activeGroup = 'K'">
								<a href="#">Kids Package</a>
							</li>
							<li ng-click="chooseSize();">
								<a href="#" data-toggle="modal" data-target="#chooseSize">Choose Size</a>
							</li>
						</ul>
						<div style="z-index:100000" class="modal modal-default fade" id="chooseSize" role="dialog">
						    <div class="modal-dialog modal-sm">
						    	<div class="modal-content">
						    		<div class="modal-body">
								    	<label>What Size are You?</label>
								    	<br>
								    	<select class="form-control width-auto" ng-model="repSize">
								    		<option class="disabled" selected value="">Choose One</option>
								    		<option>XXS</option>
								    		<option>XS</option>
								    		<option>S</option>
								    		<option>M</option>
								    		<option>L</option>
								    		<option>XL</option>
								    		<option>2XL</option>
								    	</select>
								    	<br>
								    	<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
								    	<button type="button" class="btn btn-success" data-dismiss="modal" ng-click="addAllInRepSize()"><i class="fa fa-plus"></i> Add 1 of Everything</button>
						    		</div>
						    	</div>
						    </div><!-- modal-dialog -->
						</div>
					@endif
					<table class="table table-bordered table-striped" id="currentinventory">
						@if (!isset($full))
							<tr class="media" ng-repeat="inventory in inventories | filter:filterRows">
						@else
							<tr class="media" ng-repeat="inventory in inventories">
						@endif
							@if (!isset($full))
								<td style="width:1px;">
									<input id="@{{$index}}" ng-show="!buttonActive" type="radio" name="group[@{{groupMatrix[inventory.model].group}}]" value="inventory.model" ng-click="selectRow(inventory.model)">
									<input id="@{{$index}}b" ng-show="buttonActive" type="radio" name="selected" ng-click="selectRow(inventory.model, 'true')">
								</td>
							@endif
							<td class="align-top">
								<label ng-show="!buttonActive" for="@{{$index}}" class="pull-left margin-right-2">
									<img width="150" src="/img/media/@{{inventory.model|urlencode}}.jpg" class="image-full">
								</label>
								<label ng-show="buttonActive" for="@{{$index}}b" class="pull-left margin-right-2">
									<img width="150" src="/img/media/@{{inventory.model|urlencode}}.jpg" class="image-full">
								</label>
								<h4 style="color:black;" class="no-top no-bottom"><span ng-bind="inventory.model"></span></h4>
								$<span ng-bind="inventory.price" class="itemprice"></span>
								<div id="@{{inventory.model|nospace}}">
									<div ng-repeat="(key,size) in inventory.sizes" class="pull-left margin-right-1">
										<small ng-bind="size.key"></small>
										<Br />
										<input ng-model="size.numOrder" ng-change="massAdd(inventory,size)" type="number" style="width:3em" size="3" value="0">
									</div>
								</div>
							</td>
						</tr>
						<tr ng-show="activeGroup == 'K'">
							<td style="width:1px;"></td>
							<td class="align-top">
								<button type="button" class="btn btn-default" ng-click="buttonActive=!buttonActive" ng-class="{ active : buttonActive }">Choose Adult Package Instead</button>
								<p ng-show="buttonActive" class="alert alert-warning">Select one additional row from groups A, B, or C.</p>
							</td>
						</tr>
					</table>
				</div><!-- col -->
				<div class="col col-md-4">
					<h3>Order Total</h3>
					<div class="well">
						<table class="table">
							<tbody>
								@if (Auth::user()->consignment > 0)
								<tr>
									<td>Account Balance</td>
									<td align="right">${{ Auth::user()->consignment }}</td>
								</tr>
								@endif
								<tr>
									<td>Subtotal</td>
									<td align="right">$<span ng-bind="subtotal()|number:2">0.00</span></td>
								</tr>
								<tr ng-repeat="(idx,discount) in discounts">
									<td ng-if="discount.amount"><span ng-bind="discount.title"></span></td>
									<td ng-if="discount.amount" align="right">$<span ng-bind="discount.amount|number:2">0.00</span></td>
								</tr>
								<tr ng-if="discounts.total">
									<td>Total Discounts</td>
									<td align="right">$<span ng-bind="discounts.total|number:2">0.00</span></td>
								</tr>
								<tr ng-if="tax">
									<td>Tax</td>
									<td align="right">$<span ng-bind="tax|number:2">0.00</span></td>
								</tr>
								<tr>
									<td><label>Total</label></td>
									<td align="right">$<span ng-bind="total|number:2">0.00</span></td>
								</tr>
								<tr>
									<td colspan="2"><span class="label label-info">Please allow 3 days for shipping</span></td>
								</tr>
								<tr>
									<td colspan="2"><h4 ng-show="!showCheckoutButton" class="pull-right">You must add 33 items to checkout</h4>
									<button type="button" ng-show="showCheckoutButton" class="pull-right btn btn-sm btn-success" ng-click="checkout()">
										Checkout
									</button>
									<button type="button" ng-click="cancel()" class="pull-left btn btn-sm btn-danger">
										Cancel
									</button></td>
								</tr>
							</tbody>
						</table>
					</div><!-- well -->
				</div><!-- col -->
			</div><!-- row -->
		</div><!-- controller -->
	{{ Form::close() }}
</div><!-- app -->
@stop
@section('scripts')
{{ HTML::script('js/controllers/inventoryController.js') }}
<script>
$('.nav-tabs li').click(function() {
	$('.nav-tabs li.active').removeClass('active');
	$(this).addClass('active');
});
/*
	var groupMatrix = {
					'A':{
						'Maxi':		[5,9,14,14,14,9,5,5],
						'Cassie':	[0,10,15,15,15,10,5,5],
						'Azure':	[0,10,15,15,15,10,10,0],
						'Lucy':		[5,10,15,15,15,10,5,0],
						'Lola':		[5,10,15,15,15,10,5,0],
						'Madison':	[0,15,15,15,15,15,0,0]
						},
					'B':{
						'Amelia':	[0,7,10,10,10,7,0,0],
						'Nicole':	[0,10,10,10,10,10,0,0],
						'Julia':	[5,10,10,10,10,10,0,0],
						'Ana':		[0,6,8,8,8,6,6,6]
						},
					'C':{
						'Irma':		[10,15,15,15,10,10,0,0],
						'Randy':	[5,10,15,15,15,10,5,0],
						'Monroe':	[0,0,25,0,25,0,0,0]
						},
					'L':{
						'Adult Leggings (2 Pack)':		[35]
						},
					'K':{
						'Sloan (2-8)':				[4,4,4,4],
						'Sloan (10-14)':			[4,4,4],
						'Dotdotsmile Lucy Sleeve':	[6,6,6,6],
						'Dotdotsmile Lucy Tank':	[6,6,6,6],
						'Kid\'s Leggings (2 Pack)':	[23]
						}
					};
	
	// Sets the group value information
	function setGroup(groupid) {
		
		// $.each(groupMatrix[groupid],function(item,vals) {
			// item = item.replace(/\W/g, '_');
// 
			// $('#'+item).parent().toggleClass('toggleBg');
// 
			// $('#'+item).find('input[type=text]').each(function(i,itm) {
				// if ($(this).val().length > 0) {
					// $(this).val('');
				// }
				// else ($(this).val(vals[i]));
// 
				// //:if (typeof this != 'undefined' ) this.val(vals[i]);
			// })
		// });
	}
*/

    angular.extend(ControlPad, (function(){                
                return {
                    inventoryCtrl : {
                        path : '/llrapi/v1/get-inventory/'
                    }
                };
            }()));    
</script>
@stop
