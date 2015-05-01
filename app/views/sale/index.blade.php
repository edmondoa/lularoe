<?php
	$by_group = false; 
    Session::put('repsale',true);
    Session::put('paidout',0);
    $userkey = Auth::user()->key;
    @list($key,$timeout) = explode('|',$userkey);
?>

@extends('layouts.default') @section('content') <style>	
	.toggleBg { background : #efefef }
</style>
<div ng-app="app" class="index">
	<h1>Your Sales Inventory</h1>
	{{ Form::open(array('url' => 'inv/checkout', 'method' => 'POST','name'=>'inven')) }}
		<div ng-controller="InventoryController" class="my-controller">
			<div class="row">
				<div class="col col-md-8">
					@if ($by_group)
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
						@if ($by_group)
							<tr class="media" ng-repeat="inventory in inventories | filter:filterRows">
						@else
							<tr class="media" ng-repeat="inventory in inventories">
						@endif
							@if ($by_group)
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
										<input ng-model="size.numOrder" ng-bind="size.numOrder" placeholder="@{{size.value}}" ng-model-options="{ debounce: 1000 }" ng-change="massAdd(inventory,size); $rollbackViewValue();" type="number" style="width:3em" size="3" value="0">
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
									<td># Items Selected</td>
									<td align="right"><span ng-bind="totalQuantity"></span></td>
								</tr>
								<tr>
									<td>Subtotal</td>
									<td align="right">$<span id="subtotalnum" ng-bind="subtotal()|number:2">0.00</span></td>
								</tr>
								<tr ng-repeat="(idx,discount) in discounts">
									<td ng-if="discount.amount"><span ng-bind="discount.title"></span></td>
									<td ng-if="discount.amount" align="right">$<span ng-bind="discount.amount|number:2">0.00</span></td>
								</tr>
								<tr ng-if="discounts.total">
									<td>Total Discounts</td>
									<td align="right">$<span ng-bind="discounts.total|number:2">0.00</span></td>
								</tr>

                                <tr>
                                    <td colspan="2"><button id="disco" class="btn btn-sm">D</button>
                                    <input type="text" placeholder="discount" name="customdiscount" id="customdiscount" style="display:none">
                                    </td>
                                </tr>

								<tr>
									<td><input type="checkbox" name="hasTax" value="1" id="taxable" ng-click="setTaxable()" checked="checked"> Tax</td>
									<td align="right">$<span ng-bind="tax|number:2">0.00</span></td>
								</tr>
								<tr>
									<td><label>Total</label></td>
									<td align="right">$<span ng-bind="total|number:2">0.00</span></td>
								</tr>
								<tr>
									<td colspan="2">
										<div class="pull-right" style="position:relative;">
											@include('_helpers.loading')
										</div>
										<h4 ng-show="(totalQuantity < 1)" class="pull-right">You must add items to checkout</h4>
									<button type="button" ng-show="(totalQuantity > 0)" class="pull-right btn btn-sm btn-success" ng-click="checkout()">
										Checkout (<span ng-bind="totalQuantity"></span>)
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

$(document).ready(function() {
    $('#disco').on('click',function(e) {
        e.preventDefault();
        $(this).toggle();
        $('#customdiscount').toggle().focus();
    });

    $('#customdiscount').on('change',function(e) {
        $.get('/discounts/0?discount='+$('#customdiscount').val())
		if ($(this).val() == 0 || $(this).val() == '') {
			$(this).hide();
			$('#disco').show();
		}
    });
});

    angular.extend(ControlPad, (function(){                
                return {
                    inventoryCtrl : {
                        path : '/llrapi/v2/get-inventory/<?=$key?>/'
                    }
                };
            }()));    

$('.nav-tabs li').click(function() {
	$('.nav-tabs li.active').removeClass('active');
	$(this).addClass('active');
});
</script>
@stop
