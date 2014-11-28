@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-lg-4 col-md-6">
			@include('_helpers.breadcrumbs')
		    <h1>Edit event</h1>
		    {{ Form::model($event, array('route' => array('events.update', $event->id), 'method' => 'PUT')) }}
		
		    
			    <div class="form-group">
			        {{ Form::label('name', 'Name') }}
			        {{ Form::text('name', null, array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('description', 'Description') }}
			        {{ Form::textarea('description', null, array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('date_start', 'Starting Time') }}
			        {{ Form::text('date_start', $event->formatted_start_date . ' ' . $event->formatted_start_time, array('class' => 'form-control datepicker width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('date_end', 'Ending Time') }}
			        {{ Form::text('date_end',  $event->formatted_end_date . ' ' . $event->formatted_end_time, array('class' => 'form-control datepicker width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('disabled', 'Status') }}
			        <br>
			    	{{ Form::select('disabled', [
			    		0 => 'Active',
			    		1 => 'Disabled'
			    	], $event->disabled, ['class' => 'selectpicker']) }}
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
		
		    {{ Form::submit('Update event', array('class' => 'btn btn-primary')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

