@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-lg-4 col-md-6">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New event</h1>
		    {{ Form::open(array('url' => 'events')) }}
		
			    <div class="form-group">
			        {{ Form::label('name', 'Name') }}
			        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('description', 'Description') }}
			        {{ Form::textarea('description', Input::old('description'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('date_start', 'Starting Time') }}
			        {{ Form::text('date_start', Input::old('date_start'), array('class' => 'form-control datepicker width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('date_end', 'Ending Time') }}
			        {{ Form::text('date_end', Input::old('date_end'), array('class' => 'form-control datepicker width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			    	@include('_helpers.selectTimeZone')
			    </div>
			    
			    <div class="form-group">
			        <h3>Visibility</h3>
			        <label>
			   			{{ Form::checkbox('public', null, array('class' => 'form-control')) }} Public
			        </label>
			        <br>
			        <label>
			   			{{ Form::checkbox('customers', null, array('class' => 'form-control')) }} Customers
			        </label>
			        <br>
			        <label>
			   			{{ Form::checkbox('reps', null, array('class' => 'form-control')) }} ISM's
			        </label>
			        <!--<br>
			        <label>
			   			{{ Form::checkbox('editors', null, array('class' => 'form-control')) }} Editors
			        </label>
			        <br>
			        <label>
			   			{{ Form::checkbox('admins', null, array('class' => 'form-control')) }} Administrators
			        </label>-->
			    </div>
			    
			    <!-- <div class="form-group">
			        {{ Form::label('disabled', 'Disabled') }}
			        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control')) }}
			    </div> -->
			    
		
			    {{ Form::submit('Add event', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop