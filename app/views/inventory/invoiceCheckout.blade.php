@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
<?php    
 	$balanceAmount = $invoice->balance;
?>
        <div ng-controller="InventoryController" class="my-controller">
            <div class="row">
                <div class="col-lg-8 col-sm-8 col-md-8">
					<h3>{{$invoice->to_firstname}} {{ $invoice->to_lastname }} - {{ $invoice->to_email }}</h3>
					<table class="table">
						<thead>
							<tr>	
								<th style="Border-bottom:1px solid black;text-align:left">Model</th>
								<th style="Border-bottom:1px solid black;text-align:left">Price EA</th>
								<th style="Border-bottom:1px solid black;text-align:left">Sizes</th>
								<th style="Border-bottom:1px solid black;text-align:left">Total</th>
							</tr>
						</thead>
						<thead>
							@foreach ($orderdata as $order) 
							<tr class="table-striped">
								<td>{{ $order->model }}</td>
								<td>{{ $order->price }}</td>
								<td>
							@foreach ($order->quantities as $size=>$num)
									<span class="label label-info">{{$size}}</span> X {{ $num }}
							@endforeach
								</td>
								<td>${{ money_format($num * $order->price,2)}}</td>
							</tr>
							@endforeach

							<tr>
								<td colspan="3" align="right"><b>Tax</b></td>
								<td align="right">${{ money_format($invoice->tax,2) }}</td>
							</tr>
							<tr>
								<td colspan="3" align="right"><b>SubTotal</b></td>
								<td align="right">${{ number_format($invoice->subtotal,2) }}</td>
							</tr>

							<tr>
								<td colspan="3"align="right"><b>Balance</b></td>
								<td align="right" class="{{ ($invoice->balance > 0) ? 'danger' : 'success' }}">${{number_format($invoice->balance,2)}}</td>
							</tr>
						</tbody>
					</table>
				</div>
                <div class="col-lg-4 col-sm-4 col-md-4">
					<p>
						<fieldset>
							<legend><h3>Notes</h3></legend>
							{{$invoice->note}}
						</fieldset>
					</p>
				</div>
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="well" id="creditcard">
						{{ Form::open(array('url' => '/inv/purchase', 'method' => 'post','name'=>'inven')) }}
						<div class="row">
							<div class="col-lg-5 col-sm-5 col-md-5">
								<table class="table">
									<thead>
										<tr><th colspan="2">Billing Information</th></tr>
									</thead>
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
											<td>Card expiration</td>
											<td align="right"><input size="16" placeholder="mmyy" style="width:4em" name="cardexp"></td>
										</tr>
										<tr>
											<td>Security code (# on back of card)</td>
											<td align="right"><input size="16" style="width:4em" name="cvv"></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-lg-5 col-sm-5 col-md-5">
								<table class="table">
									<thead>
										<tr><th colspan="2">Shipping Address</th></tr>
									</thead>
									<tbody>
										<tr>
											<td>Recipient Name</td>
											<td align="right"><input size="16" style="width:16em" name="shipping[to_name]"></td>
										</tr>
										<tr>
											<td>Shipping Street</td>
											<td align="right"><input size="16" style="width:16em" name="shipping[address1]"></td>
										</tr>
										<tr>
											<td>Shipping Street 2</td>
											<td align="right"><input size="16" style="width:16em" name="shipping[address2]"></td>
										</tr>
										<tr>
											<td>Shipping City</td>
											<td align="right"><input size="16" style="width:16em" name="shipping[city]"></td>
										</tr>
										<tr>
											<td>Shipping State</td>
											<td align="right">
											{{ Form::select('shipping[state]',State::orderBy('full_name')->lists('full_name', 'abbr'), null, array('class' => 'form-control')) }}
											</td>
										</tr>
										<tr>
											<td>Shipping Zip</td>
											<td align="right"><input size="16" style="width:10em" name="shipping[zip]"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-5 col-sm-5 col-md-5">
								<blockquote class="well">By submitting this form I authorize my credit card to be charged the complete amount of:
									<div align="right"><h3>${{ $balanceAmount }}</h3>
										<input type="hidden" name="amount" value="{{ $balanceAmount }}">
										<input type="hidden" name="invoice" value="{{ $invoice->id }}">
									</div>
								</blockquote>
								<button type="submit" class="pull-right btn btn-sm btn-success">Place order</button>
								<button type="button" ng-click="cancel()" class="pull-left btn btn-sm btn-danger">Cancel</button>
							</div>
						</div>
                    </div> <!-- creditcard -->
					{{ Form::close() }}
			</div>
		</div>
    </div>
</div><!-- app -->
@stop
@section('scripts')
<script>
</script>
@stop
