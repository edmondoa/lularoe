@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
<?php 
	$subtotal	= 0; 
	$inittotal	= 0; 
?>
@foreach (Session::get('orderdata') as $order) 
	<?php $inittotal += floatval($order['price']) * intval($order['numOrder']); ?>
@endforeach
<?php
	// Corona California tax
	$data = file_get_contents('https://1100053163:F62F796CE160CBC7@avatax.avalara.net/1.0/tax/33.8667,-117.5667/get?saleamount='.$inittotal);
	$tax = json_decode($data);

	Session::put('subtotal',$inittotal);
	Session::put('tax',$tax->Tax);
?>
        <div ng-controller="InventoryController" class="my-controller">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Selected Inventory</h3>
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
						{{ Form::open(array('url' => 'inventories/purchase', 'method' => 'POST','name'=>'inven')) }}
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Name on card</td>
                                    <td align="right"><input size="16" style="width:16em" name="accountname"></td>
                                </tr>
                                <tr>
                                    <td>Billing street address </td>
                                    <td align="right"><input size="16" style="width:16em" name="address"></td>
                                </tr>
                                <tr>
                                    <td>Billing zip </td>
                                    <td align="right"><input size="16" style="width:10em" name="zip"></td>
                                </tr>
                                <tr>
                                    <td>Card # </td>
                                    <td align="right"><input size="16" style="width:16em" name="cardno"></td>
                                </tr>
                                <tr>
                                    <td>Card Expiration</td>
                                    <td align="right"><input size="16" placeholder="mmyy" style="width:4em" name="cardexp"></td>
                                </tr>
                                <tr>
                                    <td>Security Code (# on back of card)</td>
                                    <td align="right"><input size="16" style="width:4em" name="cvv"></td>
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
                                        <button type="submit" class="pull-right btn btn-sm btn-success">Place Order</button>
                                        <button type="button" ng-click="cancel()" class="pull-left btn btn-sm btn-danger">Cancel</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
						{{ Form::close() }}
                    </div>
                </div>
            </div>
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
