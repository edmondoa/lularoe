@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12">
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
	        <small>Example for John Doe: "jdoe"</small>
	    </div>
	    
		<div class="form-group">
			{{ Form::radio('gender', 'M', true, array('id' => 'gender_male')) }}
			{{ Form::label('gender_male', 'Male') }}
			<br>
			{{ Form::radio('gender', 'F', false, array('id' => 'gender_female')) }}
			{{ Form::label('gender_female', 'Female') }}
		</div>
	    
	    <div class="form-group">
		    <?php $name = 'dob' ?>
			@include('_helpers.dob')
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
	        {{ Form::text('state', Input::old('state'), array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('zip', 'Zip') }}
	        {{ Form::text('zip', Input::old('zip'), array('class' => 'form-control')) }}
	    </div>
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
		<select name="expires_month" class="selectpicker">
			<?php
				for ($y = 1; $y <= 12; $y ++) {
					if ($y < 10) $y = "0" . $y;
					echo "<option>$y</option>";
				}
			?>
		</select>
		<select name="expires_year" class="selectpicker">
			<?php
				$y = date('Y');
				$x = $y + 10;
				for ($y = date('Y'); $y <= $x; $y ++) {
					echo "<option>$y</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		{{ Form::label('security','* Security Code') }}
		{{ Form::text('security', null, array('class' => 'form-control', 'style' => 'width:50px')) }}
	</div>

	<div class="form-group">
		<label for="agree" style="font-size:10pt; !important; max-width:250px; display:inline-block; vertical-align:top;">
			<input type="checkbox" name="agree" id="agree">
			&nbsp;I agree to the <a target="_blank" href="http://sociallymobile.com/terms-conditions/">terms and conditions</a>.
		</label>
	</div>
   
	    {{ Form::submit('Sign Up', array('class' => 'btn btn-success')) }}
	
	    {{ Form::close() }}
	</div>
</div>
@stop