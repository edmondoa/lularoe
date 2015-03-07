@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
        <div ng-controller="InventoryController" class="my-controller">
			<h1>Thank you for your order</h1>
            <div class="row">
                <div class="col-sm-6">
                    <h3>Your receipt is as follows</h3>
					<div class="well">
						<div class="row">
							<div class="col-sm-2"><h3>Amt</h3></div>
							<div class="col-sm-4"><h3>Model</h3></div>
							<div class="col-sm-3"><h3>Price EA</h3></div>
							<div class="col-sm-3"><h3>Cost</h3></div>
						</div>
@foreach (Session::get('orderdata') as $order) 
						<div class="row">
							<div class="col-sm-2">{{ $order['numOrder'] }}</div>
							<div class="col-sm-4">{{ $order['model'] }} <span class="label label-info">{{ $order['size'] }}</span></div>
							<div class="col-sm-3">${{ number_format($order['price'],2) }}</div>
							<div class="col-sm-3">${{ number_format(floatval($order['price']) * intval($order['numOrder']),2) }}</div>
						</div>
@endforeach
					</div>
@if (Session::get('repsale')) 
                    <h3>Thank you!</h3>
                    <div class="well">
						We hope you will enjoy the wonderful fashionable world of LuLaRoe!
                    </div>

@else
                    <h3>Shipping Information</h3>
                    <div class="well">
						Please allow 3-4 business days
                    </div>
@endif
                </div>
            </div>
    </div><!-- app -->
<?php 
//	Session::forget('orderdata'); 
	print_r(Session::all());
?>
@stop
