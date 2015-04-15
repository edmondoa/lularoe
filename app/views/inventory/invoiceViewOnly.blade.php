<?php    
 	$balanceAmount	= $invoice->balance;
	$orderdata		= json_decode($invoice->data);
	Session::put('invoice', $invoice->id);
?>
@extends('layouts.default')
@section('content')
<style>
	.shrinktext td { font-size:11px }
</style>
	<div class="row" style="padding-top:-50px;margin-top:-50px">
		<div class="col-lg-12 col-sm-12 col-md-12">
			<div class="panel well pull-left" style="margin:3px;">
				<fieldset style="margin:0px">
					<legend><h4>{{$invoice->label}} {{$invoice->to_firstname}} {{$invoice->to_lastname}} / {{$invoice->to_email}}</h4></legend>
					<div>{{$invoice->address->address_1}}</div>
				@if (!empty($invoice->address->address_2))
					<div>{{$invoice->address->address_2}}</div>
				@endif
					<div>{{$invoice->address->city}}</div>
					<div>{{$invoice->address->state}}</div>
					<div>{{$invoice->address->zip}}</div>
				</fieldset>
			</div>
			<div class="panel well pull-right" style="margin:3px;">
				<fieldset style="margin:0px">
					<legend><h4>Order #{{$invoice->id}}</h4></legend>
							<b>Tax</b> ${{ money_format($invoice->tax,2) }}
							<b>SubTotal</b> ${{ number_format($invoice->subtotal,2) }}
							<div class="{{ ($invoice->balance > 0) ? 'danger' : 'success' }}"><b>Balance</b>${{number_format($invoice->balance,2)}}</div>
				</fieldset>
			</div>
		</div>
	</div>

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
			</div> <!-- creditcard -->
		</div>
	</div>
@stop
@section('scripts')
<script>
</script>
@stop
