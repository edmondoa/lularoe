@extends('layouts.default')
@section('content')
<?php
// Session is tracking all data, I want to spit this into mongodb
// All this data is an order.
$tax		= Session::get('tax');
$orderlist	= Session::get('orderdata');
$inittotal	= Session::get('subtotal');
$discounts	= Session::get('discounts');
if (!Session::get('repsale'))
	$shipinfo	= Auth::user()->addresses()->where('label','=','Shipping')->first();
?>
<div ng-app="app" class="index">
        <div ng-controller="InventoryController" class="my-controller">
			<h1>Thank you for your order</h1>
            <div class="row">
				<div class="col-lg-12 col-sm-12 col-md-12">
					  <div class="row">
						<div class="col-lg-8 col-sm-8 col-md-8">
@if (Session::get('repsale')) 
                    <h3>Thank you!</h3>
                    <div class="well">
						We hope you will enjoy the wonderful fashionable world of LuLaRoe!
                    </div>

@else
@section('manifest')
                    <h3>Shipping Information</h3>
                    <div class="well">
						<div class="row">
							<div class="col-lg-8 col-sm-8 col-md-8">
							<h4>{{ $shipinfo->address_1 }}</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-8 col-sm-8 col-md-8">
							<h4>{{ $shipinfo->address_2 }}</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-8 col-sm-8 col-md-8">
							<h4>{{ $shipinfo->city }}, {{ $shipinfo->state }}</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-8 col-sm-8 col-md-8">
							<h4>{{ $shipinfo->zip }}</h4>
							</div>
						</div>
                    </div>
@endif
							<h3>Purchase Receipt</h3>
							  <div class="well">
								<table class="table">
									<tr>
										<th style="Border-bottom:1px solid black;text-align:left"><h3>Amt</h3></th>
										<th style="Border-bottom:1px solid black;text-align:left"><h3>Model</h3></th>
										<th style="Border-bottom:1px solid black;text-align:left"><h3>Price EA</h3></th>
										<th style="Border-bottom:1px solid black;text-align:left"><h3>Total</h3></th>
									</tr>
			@foreach ($orderlist as $order)

									<tr>
										<td>{{ $order['numOrder'] }}</td>
										<td>{{ $order['model'] }} <span class="label label-info">{{ $order['size'] }}</span></td>
										<td>${{ number_format($order['price'],2) }}</td>
										<td>${{ number_format(floatval($order['price']) * intval($order['numOrder']),2) }}</td>
									</tr>
			@endforeach

									@if (!empty($discounts))
										@foreach ($discounts as $discount) @if (!empty($discount['amount']))
										<tr>
											<td>{{$discount['title']}}</td>
											<td align="right">${{number_format($discount['amount'],2)}}</td>
										</tr>
										@endif @endforeach
										<tr>
											<td>Total Discounts</td>
											<td align="right">${{number_format($discounts['total'],2)}}</td>
										</tr>
									@endif

									@if (Session::get('repsale') > 0)
									<tr>
										<td colspan="3" align="right"><b>Tax</b></td>
										<td>${{ number_format($tax,2) }}</td>
									</tr>
									@endif

									@if (Session::get('paidout') > 0)
									<tr>
										<td colspan="3"align="right"><b>Paid</b></td>
										<td>${{number_format(Session::get('paidout',0),2)}}</td>
									</tr>
									@endif
									<tr>
										<td colspan="3"align="right"><b>Balance</b></td>
										<td>${{number_format($inittotal + $tax - Session::get('paidout'),2)}}</td>
									</tr>
								</table>
							</div>
						</div>
@stop
@yield('manifest')
                </div>
            </div>
    </div><!-- app -->
@stop
