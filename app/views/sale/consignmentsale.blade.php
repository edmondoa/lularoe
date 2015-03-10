@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
<?php    
	// Bank info
	if (Input::get('nuke')) {
        Session::forget('payments');
        Session::forget('paymentdata');
		Session::forget('paidout');
	}
	$has_bank			= $user->bankinfo;
	$consignment_bal 	= $user->consignment;

	$orders[] = ['numOrder'=>1,'price'=>2500,'model'=>'Consignment'];
	$balanceAmount = $orders[0]['price'];

	Session::forget('repsale');
	Session::forget('subtotal');
	Session::forget('orderdata');

	Session::put('emailto',$user->email);
	Session::put('consignment_purchase',$user->id);
	Session::put('tax',0);
	Session::put('repsale',false);
	Session::put('subtotal',2500);
	Session::put('orderdata',$orders);
	Session::put('notax',true);

?>
        <div ng-controller="InventoryController" class="my-controller">
            <div class="row">
                <div class="col-lg-8 col-sm-8 col-md-8">
					<h2>{{ $user->first_name }} {{ $user->last_name}}</h2>
					<h3>{{ $user->id }} - {{ $user->sponsor_id }}</h3>
					<table class="table">
						<thead>
							<tr>	
								<th style="Border-bottom:1px solid black;text-align:left"><h3>Amt</h3></th>
								<th style="Border-bottom:1px solid black;text-align:left"><h3>Item</h3></th>
								<th style="Border-bottom:1px solid black;text-align:left"><h3>Price EA</h3></th>
								<th style="Border-bottom:1px solid black;text-align:left"><h3>Total</h3></th>
							</tr>
						</thead>
						<thead>
							@foreach ($orders as $order) 
							<tr class="table-striped">
								<td>{{ $order['numOrder'] }}</td>
								<td>{{ $order['model'] }}</td>
								<td>${{ number_format($order['price'],2) }}</td>
								<td>${{ number_format(floatval($order['price']) * intval($order['numOrder']),2) }}</td>
							</tr>
							@endforeach

<!--
							@if (!empty($discounts) && $discounts['total'] > 0)
								@foreach ($discounts as $discount) @if (!empty($discount['amount']))
								<tr>
									<td>{{$discount['title']}}</td>
									<td colspan="2" align="right">${{number_format($discount['amount'],2)}}</td>
									<td></td>
								</tr>
								@endif @endforeach
								<tr>
									<td>Total Discounts</td>
									<td colspan="2"></td>
									<td align="right">-${{number_format($discounts['total'],2)}}</td>
								</tr>
							@endif
-->
							@if (Session::get('paidout') > 0)
							<tr>
								<td colspan="3"align="right"><b>Paid</b></td>
								<td align="right">${{number_format(Session::get('paidout',0),2)}}</td>
							</tr>
							@endif
							<tr>
								<td colspan="3"align="right"><b>Balance</b></td>
								<td align="right" class="{{ ($balanceAmount > 0) ? 'danger' : 'success' }}">${{number_format($balanceAmount,2)}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
				<h3>Payment Information</h3>
				<ul class="nav nav-tabs">
					<li class="nav"><a href="#bankinfo" data-toggle="tab">Pay With ACH / Bank Account</a></li>
					<li class="nav"><a href="#creditcard" data-toggle="tab">Pay With Credit Card</a></li>
				</ul>

				<div class="tab-content">
					{{ Form::close() }}
                    <div class="well tab-pane fade" id="bankinfo">
						{{ Form::open(array('url' => 'inv/cashpurchase', 'method' => 'post','name'=>'inven')) }}
						<div class="row">
							<div class="col-lg-6 col-sm-6 col-md-6"></div>
							<div class="col-lg-6 col-sm-6 col-md-6">
								<a class="btn btn-success" href="https://zb.rpropayments.com/Buyer/CheckOutFormPay/oTHKVswiXCL-mf--W-YJdq7tyd0-" TARGET="_BLANK">Payment Portal for ACH</a>
								<h4>Amount to apply to this order</h4>
								$<input type="text" name="amount" value="{{ $balanceAmount }}">
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-sm-12 col-md-12">
								<button type="submit" class="pull-right btn btn-sm btn-success">Place order</button>
								<button type="button" ng-click="cancel()" class="pull-left btn btn-sm btn-danger">Cancel</button>
							</div>
						</div>
						{{ Form::close() }}
                    </div><!-- ACH -->
					
                    <div class="well tab-pane fade" id="creditcard">
						{{ Form::open(array('url' => 'inv/purchase', 'method' => 'post','name'=>'inven')) }}
						<div class="row">
							<div class="col-lg-12 col-sm-12 col-md-12">
								<table class="table">
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
									<tr>
										<td colspan="2">
											<div class="pull-right">
												<div>
													<h4>Amount to apply to this order</h4>
													$<input type="text" name="amount" value="{{ $balanceAmount }}">
												</div>
											</div>
										</td>
									</tr>
								</table>
								<div class="row">
									<div class="col-lg-12 col-sm-12 col-md-12">
										<button type="submit" class="pull-right btn btn-sm btn-success">Place order</button>
										<button type="button" ng-click="cancel()" class="pull-left btn btn-sm btn-danger">Cancel</button>
									</div>
								</div>
							</div>
						</div>
                    </div> <!-- creditcard -->
					{{ Form::close() }}
				</div> <!-- tabcontent -->
			</div>
		</div>
    </div>
</div><!-- app -->
@stop
