@extends('layouts.centered')
@section('content')
<div class="row">
	<div class="col col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<h2>Sign Up</h2>
	    {{ Form::open(array('action' => 'PreRegisterController@store', 'class' => 'full')) }}
        {{ Form::hidden('sponsor_id', $sponsor->id) }}
        @if (isset($sponsor->id))
        <div class="alert alert-success">Your Sponsor is {{ $sponsor->first_name }} {{ $sponsor->last_name }}</div>
        @endif
	    <div class="form-group">
	        {{ Form::label('first_name', 'First Name') }}
	        {{ Form::text('first_name', Input::old('first_name'), array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('last_name', 'Last Name') }}
	        {{ Form::text('last_name', Input::old('last_name'), array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('email', 'Email') }}
	        {{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
	        <small>You will use this email to log in.</small>
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('password', 'Password') }}
	        {{ Form::password('password', array('class' => 'form-control')) }}
	    </div>
	    
		<div class="form-group">
			{{ Form::label('password_confirmation','Enter it again') }}
			{{ Form::password('password_confirmation', array('class' => 'form-control')) }}
		</div>
		
	    <div class="form-group">
	        {{ Form::label('public_id', 'Public ID') }}
	        {{ Form::text('public_id', Input::old('public_id'), array('class' => 'form-control')) }}
	        <small>This will be used in the URL of your public website. Example for John Doe: "jdoe"</small>
	    </div>
	    
		<div class="form-group">
			{{ Form::radio('gender', 'M', true, array('id' => 'gender_male')) }}
			{{ Form::label('gender_male', 'Male') }}
			<br>
			{{ Form::radio('gender', 'F', false, array('id' => 'gender_female')) }}
			{{ Form::label('gender_female', 'Female') }}
		</div>
	    
	    <div class="form-group">
		    {{ Form::label('dob', 'Date of Birth') }}
	        {{ Form::text('dob', Input::old('dob'), array('class' => 'dateonlypicker form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('phone', 'Phone') }}
	        {{ Form::text('phone', Input::old('phone'), array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('address_1', 'Address 1') }}
	        {{ Form::text('address_1', Input::old('address_1'), array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('address_2', 'Address 2') }}
	        {{ Form::text('address_2', Input::old('address_2'), array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('city', 'City') }}
	        {{ Form::text('city', Input::old('city'), array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('state', 'State') }}
	        <br>
	        {{ Form::select('state',State::orderBy('full_name')->lists('full_name', 'abbr'), null, array('class' => 'form-control width-auto')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('zip', 'Zip') }}
	        {{ Form::text('zip', Input::old('zip'), array('class' => 'form-control')) }}
	    </div>
	    <br>
	<div class="alert alert-success">Prelaunch Membership Fee: ${{number_format(Config::get('settings.pre-registration-fee'),2)}}</div>

	    
	<div class="form-group">
		{{ Form::label('name_on_card','* Name on Card') }}
		{{ Form::text('name_on_card',null, array('class' => 'form-control')) }}
	</div>
	
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

	<div class="form-group">
		<label for="agree" style="font-size:10pt; !important; max-width:250px; display:inline-block; vertical-align:top;">
			{{ Form::checkbox('agree', null, null, array('id' => 'agree')) }}
			&nbsp;I agree to the <a target="_blank" href="/terms-conditions">terms and conditions</a>.
		</label>
	</div>
	<div style="position:relative; top:-10px;">
		<small class="tiny">October 14, 2014 - December 31, 2014 is considered "Beta Launch Pad" wherein you can enroll for as little as $100. The $100, or any other promotional amount at the time of your enrollment, is fully refundable by sending an email to cancellations@lularoe.com. No commissions are being paid during this Beta Launch phase. 100% of the $100 collected in Beta will be credited toward your fees in January.</small>
	</div>
	<br>
   
	    {{ Form::submit('Sign Up', array('class' => 'btn btn-primary')) }}
	
	    {{ Form::close() }}
	</div>
</div>
@stop
