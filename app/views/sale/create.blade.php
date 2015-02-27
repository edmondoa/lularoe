@extends('layouts.centered')
@section('content')
<div class="row" ng-app>
	<div class="col col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<h2>Checkout</h2>
		
		<table class="table table-striped">
			<tbody>
				<thead>
					<tr>
						<th>Product</th>
						<th>Quantity</th>
						<th>Price</th>
					</tr>
				</thead>
				@foreach (Session::get('products') as $product)
					<tr>
						<td>
							{{ $product->name }}
						</td>
						<td>
							{{ $product->purchase_quantity }}
						</td>
						<td>
							@if(Session::get('party_id') != NULL)
			            		{{ money($product->rep_price * $product->purchase_quantity) }}
			               	@else
			               		{{ money($product->retail_price * $product->purchase_quantity) }}
			               	@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<table class="table table-striped width-auto">
			<tbody>
				<tr>
					<th>Subtotal</th>
					<td>
						{{ money($subtotal) }}
					</td>
				</tr>
				<tr>
					<th>Tax</th>
					<td>{{ money($tax) }}</td>
				</tr>
				<tr>
					<th>Shipping</th>
					<td>{{ money($shipping) }}</td>
				</tr>
				<tr>
					<th>Total</th>
					<td><strong>{{ money($total) }}</strong></td>
				</tr>
			</tbody>
		</table>
		
	    {{ Form::open(array('action' => 'SaleController@store', 'class' => 'full')) }}
	    
	    	{{ Form::hidden('amount', $total) }}
	    
		    <h3>Contact Information</h3>
		    <div class="form-group">
		        {{ Form::label('first_name', 'First Name') }}
		        {{ Form::text('first_name', $user->first_name, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('last_name', 'Last Name') }}
		        {{ Form::text('last_name', $user->last_name, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('email', 'Email') }}
		        {{ Form::text('email', $user->email, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('phone', 'Phone') }}
		        {{ Form::text('phone', $user->phone, array('class' => 'form-control')) }}
		    </div>
		    
		    <div id="address-billing">
		    	<h3>Billing Address</h3>
		    	{{ Form::hidden('type', 'billing') }}
			    <div class="form-group">
			        {{ Form::label('address[0]["address_1"]', 'Address 1') }}
			        {{ Form::text('address[0]["address_1"]', $billing_address['address_1'], array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('address[0]["address_2"]', 'Address 2') }}
			        {{ Form::text('address[0]["address_2"]', $billing_address['address_2'], array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('address[0]["city"]', 'City') }}
			        {{ Form::text('address[0]["city"]', $billing_address['city'], array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('address[0]["state"]', 'State') }}
			        <br>
			        {{ Form::select('address[0]["state"]', State::orderBy('full_name')->lists('full_name', 'abbr'), $billing_address['state'], array('class' => 'form-control width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('address[0]["zip"]', 'Zip') }}
			        {{ Form::text('address[0]["zip"]', $billing_address['zip'], array('class' => 'form-control')) }}
			    </div>
		    </div>
		    
		    <div class="form-group">
			    <label>
			    	<input type="checkbox" ng-click="show=!show" checked>
			    	Shipping address same as billing address
			    </label>
			</div>
		   	
		    <div id="address-shipping" ng-if="show">
		    	<h3>Shipping Address</h3>
		    	{{ Form::hidden('type', 'shipping') }}
			    <div class="form-group">
			        {{ Form::label('address[0]["address_1"]', 'Address 1') }}
			        {{ Form::text('address[0]["address_1"]', $shipping_address['address_1'], array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('address[0]["address_2"]', 'Address 2') }}
			        {{ Form::text('address[0]["address_2"]', $shipping_address['address_2'], array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('address[0]["city"]', 'City') }}
			        {{ Form::text('address[0]["city"]', $shipping_address['city'], array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('address[0]["state"]', 'State') }}
			        <br>
			        {{ Form::select('address[0]["state"]', State::orderBy('full_name')->lists('full_name', 'abbr'), $shipping_address['state'], array('class' => 'form-control width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('address[0]["zip"]', 'Zip') }}
			        {{ Form::text('address[0]["zip"]', $shipping_address['zip'], array('class' => 'form-control')) }}
			    </div>
		    </div>
		    
			<h3>Billing Information</h3>
		
			<!-- <div class="form-group">
				{{ Form::label('name_on_card','* Name on Card') }}
				{{ Form::text('name_on_card',null, array('class' => 'form-control')) }}
			</div> -->
			
			<div class="form-group">
				{{ Form::label('card_number','* Card Number') }}
				{{ Form::text('card_number',null, array('class' => 'form-control')) }}
			</div>
		
			<div class="form-group">
				{{ Form::label('expires_year','* Expires') }}
				<br>
				<?php
				
					// generate months
					$months = [];
					for ($m = 1; $m <= 12; $m ++) {
						if ($m < 10) $m = "0" . $m;
						$months[$m] = $m;
						// echo '</pre>'; print_r($months); echo '</pre>';
						// exit;
					}
					
					// generate years
					$y = date('Y');
					$x = $y + 10;
					$years = [];
					for ($y = date('Y'); $y <= $x; $y ++) {
						$years[$y] = $y;
					}
					
				?>
				{{ Form::select('expires_month', $months, null, ['class' => 'form-control inline-block width-auto']) }}
				{{ Form::select('expires_year', $years, null, ['class' => 'form-control inline-block width-auto']) }}
			</div>
		
			<div class="form-group">
				{{ Form::label('security','* Security Code') }}
				{{ Form::text('security', null, array('class' => 'form-control', 'style' => 'width:50px')) }}
			</div>
		
			<!-- <div class="form-group">
				<label for="agree" style="font-size:10pt; !important; max-width:250px; display:inline-block; vertical-align:top;">
					{{ Form::checkbox('agree', null, null, array('id' => 'agree')) }}
					&nbsp;I agree to the <a target="_blank" href="/terms-conditions">terms and conditions</a>.
				</label>
			</div> -->
			<br>
	   
		    {{ Form::submit('Sign Up', array('class' => 'btn btn-primary')) }}
	
	    {{ Form::close() }}
	</div>
</div>
@stop
