<?php
// Session is tracking all data, I want to spit this into mongodb
// All this data is an order.
$tax		= $sessiondata['tax'];
$orderlist	= $sessiondata['orderdata'];
$inittotal	= $sessiondata['subtotal'];
$discounts  = isset($sessiondata['discounts']) ? $sessiondata['discounts'] : [];

?>
@section('manifest')
	<div style="max-width:600px; box-shadow:0 0 3px rgba(0,0,0,.1); margin:0 auto; font-family:helvetica, arial; font-weight:300; color:#7d7d7d; text-align:center; font-size:12pt; line-height:1.5em;">
		@if (!empty($shipinfo))
			<h3>Shipping Information</h3>
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
		@endif
		<h3>Purchase Receipt</h3>
		<div class="well">
			<table class="table">
				<tr>
					<th style="Border-bottom:1px solid black;text-align:left"><h3>Amt</h3></th>
					<th style="Border-bottom:1px solid black;text-align:left"><h3>Item</h3></th>
					<th style="Border-bottom:1px solid black;text-align:left"><h3>Price EA</h3></th>
					<th style="Border-bottom:1px solid black;text-align:left"><h3>Total</h3></th>
				</tr>
				@foreach ($orderlist as $order)

				@foreach($order['quantities'] as $size=>$numorder)
				<tr>
					<td>{{ $numorder }}</td>
					<td>{{ $order['model'] }} @if (!empty($size)) <span class="label label-info">{{$size}}</span>@endif</td>
					<td>${{ number_format($order['price'],2) }}</td>
					<td>${{ number_format(floatval($order['price']) * intval($numorder),2) }}</td>
				</tr>
				@endforeach

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

				@if (isset($sessiondata['consignment_purchase']) && $sessiondata['consignment_purchase'] > 0)
				<tr>
					<td colspan="4" align="right"><h3>Starter Kit Purchase</h3></td>
				</tr>
				@endif

				@if ($tax > 0)
				<tr>
					<td colspan="3" align="right"><b>Tax</b></td>
					<td>${{ number_format($tax,2) }}</td>
				</tr>
				@endif

				@if ($sessiondata['paidout'] > 0)
				<tr>
					<td colspan="3"align="right"><b>Paid</b></td>
					<td>${{number_format($sessiondata['paidout'],2)}}</td>
				</tr>
				@endif
				<tr>
					<td colspan="3"align="right"><b>Balance</b></td>
					<td>${{number_format($inittotal + $tax - $sessiondata['paidout'],2)}}</td>
				</tr>
			</table>
		</div>
	</div>
@stop
