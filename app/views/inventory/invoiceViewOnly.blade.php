<?php    
 	$balanceAmount	= $invoice->balance;
	$orderdata		= json_decode($invoice->data);
	Session::put('invoice', $invoice->id);

	// IF we dont' have address data, then grab it from the user addressables
	if (empty($invoice->address->address_1)) {
		$user			= User::where('email',$invoice->to_email)->first();
		foreach($user->addresses as $a) {
			if ($a->label == 'Shipping') $invoice->address = $a;
		}
		if (empty($invoice->address)) {
			$invoice->address = $user->addresses[0];
			$invoice->label	  = 'VERIFY';
		}
	}

?>
@extends('layouts.default')
@section('content')
<style>
	.shrinktext td { font-size:11px }
	table.shrinktext { width:100% }
</style>
	<div class="row" style="padding-top:-50px;margin-top:-50px">
		<div class="col-lg-12 col-sm-12 col-md-12">
			<div class="panel well pull-left" style="margin:3px;">
				<fieldset style="margin:0px">
					<legend><h4>{{$invoice->label}} {{$invoice->to_firstname}} {{$invoice->to_lastname}} / {{$invoice->to_email}}</h4></legend>
				@if (!empty($invoice->address->address_1)) 
						<div>{{$invoice->address->address_1}}</div>
					@if (!empty($invoice->address->address_2))
						<div>{{$invoice->address->address_2}}</div>
					@endif
						<div>{{$invoice->address->city}}</div>
						<div>{{$invoice->address->state}}</div>
						<div>{{$invoice->address->zip}}</div>
					@if ($invoice->label == 'VERIFY')
						<b>Please call and verify this shipping address: {{$user->phone}}</b>
					@endif
				@else 
					<div>Call for shipping address: {{$user->phone}}</div>
				@endif
				</fieldset>
			</div>
			<div class="panel well pull-right" style="margin:3px;">
				<fieldset style="margin:0px">
					<legend><h4>Order #{{$invoice->id}} @ {{$invoice->created_at}}</h4></legend>
							<div><b>Tax</b> ${{ money_format($invoice->tax,2) }}</div>
							<div><b>SubTotal</b> ${{ number_format($invoice->subtotal,2) }}</div>
							<div class="{{ ($invoice->balance > 0) ? 'danger' : 'success' }}"><b>Balance</b> ${{number_format($invoice->balance,2)}}</div>
							@if ($invoice->date_paid != '0000-00-00 00:00:00') <em>PAID: {{$invoice->date_paid}}</em>@endif
				</fieldset>
			</div>
		</div>
	</div>
	@if ($invoice->note)
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12">
			<div class="panel well" style="margin:3px;">
				<fieldset>	
					<legend><h5>Notes</h5></legend>
					{{$invoice->note}}
				</fieldset>
			</div>
		</div>
	</div>
	@endif

	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12">
			<div class="panel well" style="margin:3px;">
				<fieldset>	
					<legend><h4>Items in Order</h4></legend>
					{{$orderTable}}
				</fieldset>
			</div>
		</div>
	</div>

<!--
	<div class="row hidden-print">
		<div class="col-lg-12 col-sm-12 col-md-12">
			<div class="well" id="creditcard">
				<div class="row">
					<div class="col-lg-5 col-sm-5 col-md-5">
					</div>
				</div>
				<div class="row">
					<div class="col-lg-5 col-sm-5 col-md-5">
						<button type="submit" class="pull-right btn btn-sm btn-success">Mark as Shipped</button>
					</div>
				</div>
			</div> 
		</div>
	</div>
-->

@stop
@section('scripts')
<script>
</script>
@stop
