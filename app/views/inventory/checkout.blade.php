@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
<?php    
	// Bank info
	if (Input::get('nuke')) {
		Session::forget('paidout');
	}
	Session::forget('tax'); $tax = 0;
	$bi =  Auth::user()->bankinfo;
	$has_bank = (!empty($bi->first())) ? $bi->first()->bank_name : false;
	$consignment_bal = Auth::user()->consignment;

	
	// Calculate all our discounts
	$calcDisc = array();
	foreach (Session::get('discounts') as $discount) {
		$dc = eval('return ('.$inittotal.$discount['math'].');');
		if ($dc){
			$calcDisc[] = array('title'=>$discount['title'],'amount' => $dc);
		}
	}
?>
        <div ng-controller="InventoryController" class="my-controller">
            <div class="row">
                <div class="col-lg-8 col-sm-8 col-md-8">
                    <h3>Selected Inventory</h3>
                    <div ng-if="isEmpty()">
					  <div class="well">
						<table class="table">
							<tr>	
								<th style="Border-bottom:1px solid black;text-align:left"><h3>Amt</h3></th>
								<th style="Border-bottom:1px solid black;text-align:left"><h3>Model</h3></th>
								<th style="Border-bottom:1px solid black;text-align:left"><h3>Price EA</h3></th>
								<th style="Border-bottom:1px solid black;text-align:left"><h3>Total</h3></th>
							</tr>
	@foreach ($orders as $order) 
							
							<tr>
								<td>{{ $order['numOrder'] }}</td>
								<td>{{ $order['model'] }} <span class="label label-info">{{ $order['size'] }}</span></td>
								<td>${{ number_format($order['price'],2) }}</td>
								<td>${{ number_format(floatval($order['price']) * intval($order['numOrder']),2) }}</td>
							</tr>
	@endforeach
<!--
							<tr>
								<td colspan="3" align="right"><b>Tax</b></td>
								<td>${{ number_format($tax,2) }}</td>
							</tr>
-->
							@if (Session::get('paidout') > 0)
							<tr>
								<td colspan="3"align="right"><b>Paid</b></td>
								<td>${{number_format(Session::get('paidout',0),2)}}</td>
							</tr>
							@endif
							@foreach ($calcDisc as $discount)
							<tr>
								<td colspan="3"align="right"><b>{{ $discount['title'] }}</b></td>
								<td><i>${{ number_format($discount['amount'],2)}}</i></td>
							</tr>
							@endforeach
							<tr>
								<td colspan="3"align="right"><b>Balance</b></td>
								<td>${{number_format($inittotal + $tax - Session::get('paidout'),2)}}</td>
							</tr>
						</table>
                    </div>
				</div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
				<h3>Payment Information</h3>
				<ul class="nav nav-tabs">
@if ($has_bank)
					<li class="nav"><a href="#bankinfo" data-toggle="tab">Pay With ACH / Bank Account</a></li>
@endif
					<li class="nav"><a href="#creditcard" data-toggle="tab">Pay With Credit Card</a></li>
@if ($consignment_bal > 0) 
					<li class="nav"><a href="#consignment" data-toggle="tab">Pay With Consignment: ${{ number_format($consignment_bal,2) }}</a></li>
@endif
				</ul>

				<div class="tab-content">
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
										<h4>Amount to apply to this order</h4>
										$<input type="text" name="amount" value="{{ (($inittotal + $tax - Session::get('paidout')) < $consignment_bal) ? ($inittotal+$tax - Session::get('paidout')) : $consignment_bal }}">
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
								$<input type="text" name="amount" value="{{ (($inittotal + $tax - Session::get('paidout')) < $consignment_bal) ? ($inittotal+$tax - Session::get('paidout')) : $consignment_bal }}">
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
										<td></td>
										<td>
											<div class="pull-right">
												<h4>Amount to apply to this order</h4>
												$<input type="text" name="amount" value="{{ (($inittotal + $tax - Session::get('paidout')) < $consignment_bal) ? ($inittotal+$tax - Session::get('paidout')) : $consignment_bal }}">
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
