@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New Lead</h1>
		</div>
	<div class="row">
		<div class="col col-lg-3 col-md-4 col-sm-6">
		    {{ Form::open(array('url' => 'leads')) }}
		
			    
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
			        {{ Form::label('phone', 'Phone') }}
			        {{ Form::text('phone', Input::old('phone'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('dob', 'Date of Birth') }}
			        {{ Form::text('dob', Input::old('dob'), array('class' => 'form-control dateonlypicker')) }}
			    </div>
			    
			    <div class="form-group">
		    		{{ Form::label('gender', 'Gender') }}<br>
		    		{{ Form::select('gender', array(
				    	'M' => 'Male',
				    	'F' => 'Female',
				    ), null, array('class' => 'selectpicker form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('sponsor_id', 'Assign to') }}
			        {{ Form::text('sponsor_id', Input::old('sponsor_id'), array('class' => 'form-control', 'placeholder' => 'ISM ID')) }}
			    </div>
			    
			    <!-- <div class="form-group">
			        {{ Form::label('opportunity_id', 'Opportunity Id') }}
			        {{ Form::text('opportunity_id', Input::old('opportunity_id'), array('class' => 'form-control')) }}
			    </div> -->
			    
			    {{ Form::submit('Add Lead', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop