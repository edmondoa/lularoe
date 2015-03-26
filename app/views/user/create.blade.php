@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-lg-4 col-xs-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New User</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-3 col-md-4 col-sm-6">
		    {{ Form::open(array('url' => 'users')) }}
		
			    
			    <div class="form-group">
			        {{ Form::label('public_id', 'Public ID') }}
			        <br><small>Example for John Doe: jdoe</small>
			        {{ Form::text('public_id', Input::old('public_id'), array('class' => 'form-control')) }}
			    </div>
			    
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
			        {{ Form::label('password_confirm', 'Confirm Password') }}
			        {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
			    </div>
			    
				<div class="form-group">
					{{ Form::radio('gender', 'F', false, array('id' => 'gender_female')) }}
					{{ Form::label('gender_female', 'Female') }}
					<br>
					{{ Form::radio('gender', 'M', true, array('id' => 'gender_male')) }}
					{{ Form::label('gender_male', 'Male') }}
				</div>
			       
			    <div class="form-group">
			        {{ Form::label('dob', 'DOB') }}
			        {{ Form::text('dob', Input::old('dob'), array('class' => 'form-control dateonlypicker ')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('phone', 'Phone') }}
			        {{ Form::text('phone', Input::old('phone'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
		    		{{ Form::label('role_id', 'Role') }}<br>
		    		{{ Form::select('role_id', array(
				    	'1' => 'Customer',
				    	'2' => Config::get('site.rep_title'),
				    	'3' => 'Editor',
				    	'4' => 'Admin'
				    ), null, array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('sponsor_id', 'Sponsor ID') }}
			        {{ Form::text('sponsor_id', Input::old('sponsor_id'), array('class' => 'form-control')) }}
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
			        {{ Form::select('state',State::orderBy('full_name')->lists('full_name', 'abbr'), null, array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('zip', 'Zip') }}
			        {{ Form::text('zip', Input::old('zip'), array('class' => 'form-control')) }}
			    </div>
			    
			    <!-- <div class="form-group">
			        {{ Form::label('mobile_plan_id', 'Mobile Plan Id') }}
			        {{ Form::text('mobile_plan_id', Input::old('mobile_plan_id'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('min_commission', 'Min Commission') }}
			        {{ Form::text('min_commission', Input::old('min_commission'), array('class' => 'form-control')) }}
			    </div>
			    -->
			    
			    <div class="form-group">
			        {{ Form::label('disabled', 'Status') }}
			        <br>
			    	{{ Form::select('disabled', [
			    		0 => 'Active',
			    		1 => 'Disabled'
			    	], null, ['class' => 'form-control']) }}
			    </div>
		
			    {{ Form::submit('Add User', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop
