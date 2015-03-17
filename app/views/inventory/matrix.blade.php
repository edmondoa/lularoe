@extends('layouts.default')
@section('content')
<style>	
	.toggleBg { background : #efefef }
</style>
<div ng-app="app" class="index">
    {{ Form::open(array('url' => 'inv/checkout', 'method' => 'POST','name'=>'inven')) }}
        <div ng-controller="InventoryController" class="my-controller">
            <div class="row">
                <div class="col-md-4">
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
                                    <td colspan="2">
										<span class="label label-info">Please allow 3 days for shipping</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
										<h4 ng-show="!showCheckoutButton" class="pull-right">You must add 33 items to checkout</h4>
                                        <button type="button" ng-show="showCheckoutButton" class="pull-right btn btn-sm btn-success" ng-click="checkout()">Checkout</button>
                                        <button type="button" ng-click="cancel()" class="pull-left btn btn-sm btn-danger">Cancel</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3>Selected Items<span ng-if="countSelect()"> : <span ng-bind="orders.length">0</span></span></h3>
				</div>
			</div>
                <div class="col-md-12 col-sm-12 col-lg-12">
                    <div class="clearfix">
                        <h3 class="pull-left no-pull-xs">Available Inventory</h3>
						<div class="pull-right">
							<div class="btn btn-info" ng-click="setGroup('A')">Group A</div>
							<div class="btn btn-info" ng-click="setGroup('B')">Group B</div>
							<div class="btn btn-info" ng-click="setGroup('C')">Group C</div>
							<div class="btn btn-info" ng-click="setGroup('L')">Leggings</div>
							<div class="btn btn-info" ng-click="setGroup('K')">Kids Package</div>
						</div>
                    </div>
                    @include('_helpers.loading')
					<table class="table table-bordered table-striped" id="currentinventory" width="100%">
                        <tr class="media" dir-paginate-start="inventory in inventories | filter:search | itemsPerPage: pageSize " current-page="currentPage" total-items="countItems">
							<td style="background:url(/img/media/@{{inventory.model}}.jpg);background-size:contain;background-repeat:no-repeat;width:2.5em">
								<!-- <input  class="bulk-check" type="checkbox" name="size_@{{key}}_@{{$index}}" ng-model="size.checked" ng-checked="size.checked" value="@{{key}}">  -->
							</td>
							<td>
								<div><span ng-bind="inventory.model"></span></div>
							</td>
							<td>
								<div style="color:black" class="pull-right">$<span ng-bind="inventory.price" class="itemprice"></span></div>
							</td>
							<td>
								<table id="@{{inventory.model|nospace}}">
									<tr valign="middle">
									<td ng-repeat="(key,size) in inventory.sizes">
										<small ng-bind="size.key"></small><Br />
											<!-- <input ng-change="fixInvalidNumber(order)" type="number" min="1" ng-model="order.numOrder" ng-init="order.numOrder=0" class="form-control" placeholder="0" aria-describedby="basic-addon1" style="width:3em" size="3"> -->
											<input ng-model="size.numOrder" ng-init="size.numOrder=0" ng-change="massAdd(inventory,size)" type="number" style="width:3em" size="3" value="0"> 
<div class="col-lg-8 col-md-8 col-sm-9 col-xs-9">
									</td>
									</tr>
								</table>
							</td>
                    	<tr dir-paginate-end></tr>
					</table>
                </div>
            </div>
        {{ Form::close() }}
    </div><!-- app -->
@stop
@section('scripts')
{{ HTML::script('js/controllers/inventoryController.js') }}
<script>
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
