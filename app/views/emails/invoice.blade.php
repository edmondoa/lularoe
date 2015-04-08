@extends('emails.layouts.basic')
<?php 
	$shipinfo = $user->addresses->filter(function($d) { return $d->label == 'Shipping'; })->first(); 
	if (!isset($shipinfo)) $shipinfo = $user->addresses->first();
?>

@section('body')
<body>

<div style="clear:both">
	<table style="width:100%" width="100%" cellspacing=10>
		<tbody>
			@if ($inv->note)
			<tr>
				<td>
				<blockquote>
					{{$inv->note}}
				</blockquote>
				</td>
			</tr>
			@endif

			@if ($inv->balance)
			<tr>
				<td>
					<fieldset><legend>Balance Due</legend>
					This invoice has a balance of ${{ $inv->balance }} Pay Here: <a href="{{ $payment_url }}">{{$payment_url}}</a>
					</fieldset>
				</td>
			</tr>
			@endif
		</tbody>
	</table>
</div>

<div style="clear:both">
	<table style="width:100%" width="100%" cellspacing=10>
		<tbody>
			<tr>
				<td valign="top" width="50%">
					<h2>Billing Details</h2>
					<table>
						<tbody>
							<tr><th colspan="2">{{ date('Y-m-d H:i:s') }}</th></tr>
						@if ($total_items_ordered)
							<tr><td># Items Ordered</td><td>{{$total_items_ordered}}</td></tr>
						@endif
							<tr><td>Tax</td>{{money_format($inv->tax,2)}}</td></tr>
							<tr><td>Sub Total</td>{{money_format($inv->subtotal,2)}}</td></tr>
							<tr><td>Total</td><td>{{money_format($inv->tax + $inv->subtotal,2)}}</td></td>
							<tr><td>Balance</td><td>{{money_format($inv->balance,2)}}</td></tr>
						</tbody>
					</table>
				</td>
				<td valign="top" width="50%">
					<h2>Shipping Information</h2>
					<table>
						<tbody>
							<tr><td>{{$user['first_name']}} {{$user['last_name']}}</td></tr>
							<tr><td>{{ $shipinfo->address_1 }}</td></tr>
							<tr><td>{{ $shipinfo->address_2 }}</td></tr>
							<tr><td>{{ $shipinfo->city }}</td></tr>
							<tr><td>{{ $shipinfo->state }}</td></tr>
							<tr><td>{{ $shipinfo->zip }}</td></tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<h2>Shipping Manifest</h2>
	<font size="+1">
		{{ $body}}
	</font>
</body>
@stop
@section('footer')
	@parent
@stop
