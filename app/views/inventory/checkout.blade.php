@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
<?php    
	if (Input::get('discount')) {
		Session::put('customdiscount',floatval(Input::get('discount')));
	}

	// Bank info
	if (Input::get('nuke')) {
		Session::forget('paidout');
        Session::forget('emailto');
        Session::forget('repsale');
        //Session::forget('orderdata');
        Session::forget('subtotal');
        Session::forget('customdiscount');
        Session::forget('tax');
        Session::forget('paidout');
        Session::forget('payments');
        Session::forget('paymentdata');
	}

	
	// This means the superadmin can set a user to "order for someone" 
	// more on this functionality later
	if (Auth::user()->hasRole(array('Superadmin','Admin')) && Session::has('userbypass')) {
		$currentuser = User::find(Session::get('userbypass'));
	}
	else {
		$currentuser = Auth::user();
	}

	$invnumber = count($currentuser->receipts);
	$invnumber++;

	$bi =  $currentuser->bankinfo;

	$has_bank = (!empty($bi->first())) ? $bi->first()->bank_name : false;
	$consignment_bal = $currentuser->consignment;

 	$balanceAmount = $inittotal + $tax - Session::get('paidout');
?>
        <div ng-controller="InventoryController" class="my-controller">
            <div class="row">
                <div class="col-lg-8 col-sm-8 col-md-8">
                    <h3>Selected Inventory</h3>
					<h5>{{ Session::get('orderinfo.emailto') }}</h5>
					<table class="table">
						<thead>
							<tr>	
								<th style="Border-bottom:1px solid black;text-align:left"><h3>Amt</h3></th>
								<th style="Border-bottom:1px solid black;text-align:left"><h3>Model</h3></th>
								<th style="Border-bottom:1px solid black;text-align:left"><h3>Price EA</h3></th>
								<th style="Border-bottom:1px solid black;text-align:left"><h3>Total</h3></th>
							</tr>
						</thead>
						<thead>
							@foreach ($orders as $order) 
							<tr class="table-striped">
								<td>{{ $order['numOrder'] }}</td>
								<td>{{ $order['model'] }} <span class="label label-info">{{ $order['size'] }}</span></td>
								<td>${{ number_format($order['price'],2) }}</td>
								<td>${{ number_format(floatval($order['price']) * intval($order['numOrder']),2) }}</td>
							</tr>
							@endforeach

							@if (Session::get('repsale'))
<!--
							<tr>
								<td colspan="2">Set Discount</td>
								<td colspan="2"><form method="GET" action="#disc"><input type="text" name="discount" placeholder="0.00"><input type="submit" value="Apply"></form>
							</tr>
-->
							@endif

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

							@if (Session::get('repsale'))
							<tr>
								<td colspan="3" align="right"><b>Tax</b></td>
								<td align="right">${{ number_format($tax,2) }}</td>
							</tr>
							@endif

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
				<h3>Payment Information @if (!Session::get('repsale')) for #{{$currentuser->id}} ({{$currentuser->first_name}} {{$currentuser->last_name}})@endif</h3>
				<ul class="nav nav-tabs">
@if ($has_bank && !Session::get('repsale'))
					<li class="nav"><a href="#bankinfo" data-toggle="tab">Pay With ACH / Bank Account</a></li>
@endif
					<li class="nav"><a href="#creditcard" data-toggle="tab">Pay With Credit Card</a></li>
@if ($consignment_bal > 0 && !Session::get('repsale')) 
					<li class="nav"><a href="#consignment" data-toggle="tab">Pay With Consignment: ${{ number_format($consignment_bal,2) }}</a></li>
@endif
@if (Session::get('repsale'))  <!-- // and has wallet balance.. ? -->
					<li class="nav"><a href="#cash" data-toggle="tab">Cash Sale</a></li>
					<li class="nav"><a href="#invoice" data-toggle="tab">Send Invoice</a></li>
@endif
				</ul>

				<div class="tab-content">
					 <div class="well tab-pane fade" id="cash">
						<div class="row">
							<div class="col-lg-12 col-sm-12 col-md-12">
								{{ Form::open(array('url' => 'inv/cashpurchase', 'method' => 'post','name'=>'inven')) }}
								{{ Form::label('cash', 'Cash Amount') }}
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
					</div>

					 <div class="well tab-pane fade" id="invoice">
						{{ Form::open(array('url' => 'inv/invoice', 'method' => 'post','name'=>'inven')) }}
						<div class="row">
							<div class="col-lg-7 col-sm-5 col-md-5">
								<h3>Invoice #{{$invnumber}}</h3>
								<table class="table table-striped">
									<tr>
										<td>Send Invoice To</td>
										<td align="right">
											<input type="text" name="customername" placeholder="Customer Name" value="">
										</td>
									</tr>
									<tr>
										<td>Email</td>
										<td align="right">
											<input type="text" name="emailto" placeholder="Email Address" value="">
										</td>
									</tr>
									<tr>
										<td>Invoice Amount</td>
										<td align="right">$<input type="text" name="amount" value="{{ $balanceAmount }}"></td>
									</tr>
									<tr>
										<td>Optional Note</td>
										<td align="right">
											<textarea name="note" style="width:100%;height:7em">Thank you for your order.</textarea>
										</td>
									</tr>
								</table>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-7 col-sm-12 col-md-12">
								<button type="submit" class="pull-right btn btn-sm btn-success">Send Invoice</button>
								<button type="button" ng-click="cancel()" class="pull-left btn btn-sm btn-danger">Cancel</button>
							</div>
						</div>
						{{ Form::close() }}
					</div>

                    <div class="well tab-pane fade" id="consignment">
						{{ Form::open(array('url' => 'inv/conspurchase', 'method' => 'post','name'=>'inven')) }}
						<h2>Consignment</h2>
						<table class="table">
							<tr>
								<td></td>
								<td>
									<div class="pull-right"><h3>Current Balance: {{ number_format($consignment_bal,2) }}</h3></div>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<div class="pull-right">
										<div>
											<h4>Amount to apply to this order</h4>
											$<input type="text" name="amount" value="{{ (($balanceAmount) < $consignment_bal) ? ($balanceAmount) : $consignment_bal }}">
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
                    </div><!-- /CONSIGNMENT -->
					{{ Form::close() }}
                    <div class="well tab-pane fade" id="bankinfo">
						{{ Form::open(array('url' => 'inv/achpurchase', 'method' => 'post','name'=>'inven')) }}
						<div class="row">
							<div class="col-lg-12 col-sm-12 col-md-12">
								{{ Form::label('bankinfo', 'Bank Account') }}
								<select name="account" class="form-control">
								@foreach ($bi as $bank)
									<option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
								@endforeach
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-sm-6 col-md-6"></div>
							<div class="col-lg-6 col-sm-6 col-md-6">
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
							<div class="col-lg-5 col-sm-12 col-md-12">
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
