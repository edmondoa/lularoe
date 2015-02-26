@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
<?php 
	$subtotal = 0; 
	$inittotal = 0; 
?>
@foreach (Session::get('orderdata') as $order) 
	<?php $inittotal += floatval($order['price']) * intval($order['numOrder']); ?>
@endforeach
<?php
	// Corona California tax
	$data = file_get_contents('https://1100053163:F62F796CE160CBC7@avatax.avalara.net/1.0/tax/33.8667,-117.5667/get?saleamount='.$inittotal);
	$tax = json_decode($data);

?>
    {{ Form::open(array('url' => 'inventories/checkout', 'method' => 'POST','name'=>'inven')) }}
        <div ng-controller="InventoryController" class="my-controller">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Selected Items<span ng-if="countSelect()"> : @{{orders.length}}</span></h3>
                    <div ng-if="isEmpty()">
						<div class="well">
							<div class="row">
								<div class="col-sm-6"><h3>Model</h3></div>
								<div class="col-sm-3"><h3>Price EA</h3></div>
								<div class="col-sm-3"><h3>Cost</h3></div>
							</div>
@foreach (Session::get('orderdata') as $order) 
							<div class="row">
								<div class="col-sm-6">{{ $order['model'] }} <span class="label label-info">{{ $order['size'] }}</span></div>
								<div class="col-sm-3">${{ number_format($order['price'],2) }}x {{ $order['numOrder'] }}</div>
								<div class="col-sm-3">${{ number_format(floatval($order['price']) * intval($order['numOrder']),2) }}</div>
							</div>
@endforeach
							<div class="row">
								<div class="col-sm-12">--</div>
							</div>
							<div class="row">
								<div class="col-sm-6"></div>
								<div class="col-sm-3"><b>Tax</b></div>
								<div class="col-sm-3">${{ number_format($tax->Tax,2) }}</div>
							</div>
							<div class="row">
								<div class="col-sm-6"></div>
								<div class="col-sm-3"><b>Total</b></div>
								<div class="col-sm-3">${{number_format($inittotal + $tax->Tax,2)}}</div>
							</div>
						</div>
                    </div>
                    <h3>Payment Information</h3>
                    <div class="well">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Name on card</td>
                                    <td align="right"><input size="16" style="width:16em" name="accountname"></td>
                                </tr>
                                <tr>
                                    <td>Billing street address </td>
                                    <td align="right"><input size="16" style="width:16em" name=""></td>
                                </tr>
                                <tr>
                                    <td>Billing zip </td>
                                    <td align="right"><input size="16" style="width:10em" name=""></td>
                                </tr>
                                <tr>
                                    <td>Card # </td>
                                    <td align="right"><input size="16" style="width:16em" name=""></td>
                                </tr>
                                <tr>
                                    <td>Card Expiration</td>
                                    <td align="right"><input size="16" placeholder="mmyy" style="width:4em" name=""></td>
                                </tr>
                                <tr>
                                    <td>Security Code (# on back of card)</td>
                                    <td align="right"><input size="16" style="width:4em" name=""></td>
                                </tr>
								<tr>
									<td colspan="2">
										<div class="well">
											<table class="table">
												<tbody>
													<tr>
														<td>Your account will be charged</td>
														<td align="right">${{number_format($inittotal + $tax->Tax,2)}}</td>
													</tr>
												</tbody>
											</table>
										</div>
									</td>
                                <tr>
                                    <td colspan="2">
                                        <button type="button" class="pull-right btn btn-sm btn-success" ng-click="checkout()">Place Order</button>
                                        <button type="button" ng-click="cancel()" class="pull-left btn btn-sm btn-danger">Cancel</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <ul class="media-list">
                            <li class="media">
                                <div class="well clearfix" ng-repeat="(idx,order) in orders | orderBy: 'model'">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-2 col-xs-2">
                                            <div class="label label-info">$@{{order.price}} / @{{order.size}}</div>
                                            <br/><img src="/img/media/@{{order.model}}.jpg" width="50" />
                                            <div style="width:80px">
                                                <span class="btn btn-xs btn-success" style="display:none;" ng-click="plus(order)">+</span>
                                                <span class="btn btn-xs btn-danger" style="display:none;" ng-click="minus(order)">-</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-9 col-xs-9">
                                            <h4 class="media-heading"> @{{order.model}} - @{{order.size}}</h4>
                                            <p class="">Some semblance of a description could go here</p>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                    <div class="input-group">
                                                      <span class="input-group-addon" id="basic-addon1">x</span>
                                                      <input ng-change="fixInvalidNumber(order)" type="number" min="1" ng-model="order.numOrder" ng-init="order.numOrder=1" class="form-control width-auto" placeholder="0" aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="pull-right">
                                                        <b>$@{{(order.numOrder * order.price) | number}}</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right"><a ng-click="close(idx)" href='#'><i class='fa fa-close'></i></a></div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div><!-- app -->
@stop
@section('scripts')
<script>
    angular.extend(ControlPad, (function(){                
                return {
                    inventoryCtrl : {
                        path : '/llrapi/v1/get-inventory/'
                    }
                };
            }()));    
</script>
{{ HTML::script('js/controllers/inventoryController.js') }}
@stop
