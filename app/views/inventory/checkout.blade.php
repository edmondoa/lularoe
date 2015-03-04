@extends('layouts.default')
@section('content')
<div ng-app="app" class="index">
<?php 
	$subtotal	= 0; 
	$inittotal	= 0; 
?>
@foreach (Session::get('orderdata') as $order) 
	<?php $inittotal += floatval($order['price']) * intval($order['numOrder']); ?>
@endforeach
<?php
	// Corona California tax
	$data = file_get_contents('https://1100053163:F62F796CE160CBC7@avatax.avalara.net/1.0/tax/33.8667,-117.5667/get?saleamount='.$inittotal);
	$tax = json_decode($data);
    
	// Bank info
	$bi =  Auth::user()->bankinfo;

	Session::put('subtotal',$inittotal);
	Session::put('tax',$tax->Tax);
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
	@foreach (Session::get('orderdata') as $order) 
							
							<tr>
								<td>{{ $order['numOrder'] }}</td>
								<td>{{ $order['model'] }} <span class="label label-info">{{ $order['size'] }}</span></td>
								<td>${{ number_format($order['price'],2) }}</td>
								<td>${{ number_format(floatval($order['price']) * intval($order['numOrder']),2) }}</td>
							</tr>
	@endforeach
							<tr>
								<td colspan="3" align="right"><b>Tax</b></td>
								<td>${{ number_format($tax->Tax,2) }}</td>
							</tr>
							<tr>
								<td colspan="3"align="right"><b>Total</b></td>
								<td>${{number_format($inittotal + $tax->Tax,2)}}</td>
							</tr>
						</table>
                    </div>
				</div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
				<h3>Payment Information</h3>
				<ul class="nav nav-tabs">
					<li class="nav active"><a href="#bankinfo" data-toggle="tab">ACH / Bank Account</a></li>
					<li class="nav"><a href="#creditcard" data-toggle="tab">Credit Card</a></li>
				</ul>

				<div class="tab-content">
                    <div class="well tab-pane fade in active" id="bankinfo">
						<div class="row">
							<div class="col-lg-12 col-sm-12 col-md-12">
						{{ Form::open(array('url' => 'inv/achpurchase', 'method' => 'post','name'=>'inven')) }}
						{{ Form::label('bankinfo', 'Bank Account') }}
						{{ Form::select('state',$bi->lists('bank_name'), null, array('class' => 'form-control')) }}
							<button type="submit" class="pull-right btn btn-sm btn-success">Place order</button>
							<button type="button" ng-click="cancel()" class="pull-left btn btn-sm btn-danger">Cancel</button>
							</div>
						</div>
						{{ Form::close() }}
                    </div><!-- ACH -->
					
                    <div class="well tab-pane fade" id="creditcard">
						{{ Form::open(array('url' => 'inv/purchase', 'method' => 'post','name'=>'inven')) }}
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>name on card</td>
                                    <td align="right"><input size="16" style="width:16em" name="accountname"></td>
                                </tr>
                                <tr>
                                    <td>billing street address </td>
                                    <td align="right"><input size="16" style="width:16em" name="address"></td>
                                </tr>
                                <tr>
                                    <td>billing zip </td>
                                    <td align="right"><input size="16" style="width:10em" name="zip"></td>
                                </tr>
                                <tr>
                                    <td>card # </td>
                                    <td align="right"><input size="16" style="width:16em" name="cardno"></td>
                                </tr>
                                <tr>
                                    <td>card expiration</td>
                                    <td align="right"><input size="16" placeholder="mmyy" style="width:4em" name="cardexp"></td>
                                </tr>
                                <tr>
                                    <td>security code (# on back of card)</td>
                                    <td align="right"><input size="16" style="width:4em" name="cvv"></td>
                                </tr>
                                    <td colspan="2">
                                        <button type="submit" class="pull-right btn btn-sm btn-success">Place order</button>
                                        <button type="button" ng-click="cancel()" class="pull-left btn btn-sm btn-danger">Cancel</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
						{{ Form::close() }}
                    </div> <!-- creditcard -->
				</div> <!-- tabcontent -->
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
