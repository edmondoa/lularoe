@extends('layouts.public')
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
	        {{ Form::text('dob', Input::old('dob'), array('placeholder'=>'YYYY-MM-DD','class' => 'dateonlypicker form-control')) }}
	    </div>

	    <div class="form-group">
	        {{ Form::label('phone', 'Driver License#') }}
	        {{ Form::text('phone', Input::old('phone'), array('class' => 'form-control','placeholder'=>'UT############')) }}
	    </div>

	    <div class="form-group">
	        {{ Form::label('phone', 'Social Security #') }}
	        {{ Form::text('phone', Input::old('ssn'), array('class' => 'form-control')) }}
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

	<div class="form-group">
		<label for="agree" style="font-size:10pt; !important; max-width:250px; display:inline-block; vertical-align:top;">
			{{ Form::checkbox('agree', null, null, array('id' => 'agree')) }}
			&nbsp;I agree to the <a target="_blank" href="/terms-conditions">terms and conditions</a>.
		</label>
	</div>
	<br>
   
	    {{ Form::submit('Sign Up', array('class' => 'btn btn-primary')) }}
	
	    {{ Form::close() }}
	</div>
</div>
@stop
