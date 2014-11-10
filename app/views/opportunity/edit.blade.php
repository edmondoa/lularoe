@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1>Edit opportunity</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-md-6">
		    {{ Form::model($opportunity, array('route' => array('opportunities.update', $opportunity->id), 'method' => 'PUT')) }}
		
			    <div class="form-group">
			        {{ Form::label('title', 'Title') }}
			        {{ Form::text('title', null, array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('body', 'Body') }}
			        {{ Form::textarea('body', null, array('class' => 'wysiwyg')) }}
			    </div>
			    
			    <div class="form-group">
			        <label>
			        	{{ Form::checkbox('include_form') }} Include Lead Capture Form
			        </label>
			    </div>
			    
			    <h2>Availabel To:</h2>
			    <div class="form-group">
			        <label>
			        	{{ Form::checkbox('public') }} Public
			        </label>
			        <br>
			        <label>
			        	{{ Form::checkbox('customers') }} Customers
			        </label>
			        <br>
			        <label>
			        	{{ Form::checkbox('reps') }} Reps
			        </label>
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('deadline', 'Deactivation Date') }}
			        {{ Form::text('deadline', null, array('class' => 'form-control datepicker width-auto')) }}
			    </div>
		    
		
		    {{ Form::submit('Update Opportunity', array('class' => 'btn btn-primary')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

