@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-lg-4 col-md-6">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New User</h1>
		    {{ Form::open(array('url' => 'users')) }}
		
			    
			    <div class="form-group">
			        {{ Form::label('public_id', 'Public ID') }}
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
		    		{{ Form::label('gender', 'Gender') }}<br>
		    		{{ Form::select('gender', array(
				    	'M' => 'Male',
				    	'F' => 'Female',
				    ), null, array('class' => 'selectpicker')) }}
			    </div>
			       
			    <div class="form-group">
			        {{ Form::label('dob', 'DOB') }}
			        {{ Form::text('dob', Input::old('dob'), array('class' => 'form-control dateonlypicker')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('phone', 'Phone') }}
			        {{ Form::text('phone', Input::old('phone'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
		    		{{ Form::label('role_id', 'Role') }}<br>
		    		{{ Form::select('gender', array(
				    	'1' => 'Customer',
				    	'2' => 'ISM',
				    	'3' => 'Editor',
				    	'4' => 'Admin'
				    ), null, array('class' => 'selectpicker')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('sponsor_id', 'Sponsor Id') }}
			        {{ Form::text('sponsor_id', Input::old('sponsor_id'), array('class' => 'form-control')) }}
			    </div>
			    
			    <!-- <div class="form-group">
			        {{ Form::label('mobile_plan_id', 'Mobile Plan Id') }}
			        {{ Form::text('mobile_plan_id', Input::old('mobile_plan_id'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('min_commission', 'Min Commission') }}
			        {{ Form::text('min_commission', Input::old('min_commission'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('disabled', 'Disabled') }}
			        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control')) }}
			    </div> -->
		
			    {{ Form::submit('Add User', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop