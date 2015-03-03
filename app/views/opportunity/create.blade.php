@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New Promotion</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-md-6">
		    {{ Form::open(array('url' => 'opportunities')) }}
			    
			    <div class="form-group">
			        {{ Form::label('title', 'Title') }}
			        {{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('body', 'Body') }}
			        {{ Form::textarea('body', Input::old('body'), array('class' => 'wysiwyg')) }}
			    </div>
			    
			    <h3>Visibility</h3>
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
			        	{{ Form::checkbox('reps') }} FC's
			        </label>
			    </div>
			    
			    <h3>Lead Capture Form</h3>
			    
			    <div class="form-group">
			        <label>
			        	{{ Form::checkbox('include_form') }} Include Lead Capture Form
			        </label>
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('deadline', 'Application Deadline') }}
			        {{ Form::text('deadline', null, array('class' => 'form-control datepicker width-auto')) }}
			    </div>
			    
			    {{ Form::submit('Create Promotion', array('class' => 'btn btn-primary')) }}
			    
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop
@section('scripts')
	<script>
	
		// enable/disable date field
		function toggleDeadlineField() {
			if (!($('input[name="include_form"]').is(':checked'))) {
				$('#deadline').attr('disabled', 'disabled');
			}
			else {
				$('#deadline').removeAttr('disabled');
			} 
		}
		
		$('input[name="include_form"]').change(function() {
			toggleDeadlineField();
		});
		
		toggleDeadlineField();
		
	</script>
@stop
@section('modals')
	@include('_helpers.wysiwyg_modals')
@stop