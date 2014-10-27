@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			<div class="breadcrumbs">
				<a href="/users">&lsaquo; Back</a>
			</div>
			@if (Auth::user()->id == $user->id)
				<h1>Edit Profile</h1>
			@else
		    	<h1>Edit {{ $user->first_name }} {{ $user->last_name }}</h1>
		    @endif
		    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}
		
		    <div class="form-group">
		        {{ Form::label('first_name', 'First Name') }}
		        {{ Form::text('first_name', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('last_name', 'Last Name') }}
		        {{ Form::text('last_name', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('public_id', 'Public Id') }}
		        {{ Form::text('public_id', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('email', 'Email') }}
		        {{ Form::text('email', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('password', 'New Password') }}
		        {{ Form::password('password', array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('password_confirm', 'Confirm New Password') }}
		        {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('gender', 'Gender') }}
		        {{ Form::text('gender', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('key', 'Key') }}
		        {{ Form::text('key', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('dob', 'DOB') }}
		        {{ Form::text('dob', null, array('class' => 'form-control dateonlypicker')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('phone', 'Phone') }}
		        {{ Form::text('phone', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('role_id', 'Role Id') }}
		        {{ Form::text('role_id', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('sponsor_id', 'Sponsor Id') }}
		        {{ Form::text('sponsor_id', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('mobile_plan_id', 'Mobile Plan Id') }}
		        {{ Form::text('mobile_plan_id', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('min_commission', 'Min Commission') }}
		        {{ Form::text('min_commission', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('disabled', 'Disabled') }}
		        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
		    </div>
		    
		
		    {{ Form::submit('Update User', array('class' => 'btn btn-success')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

