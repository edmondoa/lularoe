@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New EmailMessage</h1>
		    {{ Form::open(array('url' => 'emailMessages')) }}
		
			    
			    <div class="form-group">
			        {{ Form::label('sender_id', 'Sender Id') }}
			        {{ Form::text('sender_id', Input::old('sender_id'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('recipient_id', 'Recipient Id') }}
			        {{ Form::text('recipient_id', Input::old('recipient_id'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('subject', 'Subject') }}
			        {{ Form::text('subject', Input::old('subject'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('body', 'Body') }}
			        {{ Form::text('body', Input::old('body'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('disabled', 'Disabled') }}
			        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control')) }}
			    </div>
			    
		
			    {{ Form::submit('Add EmailMessage', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop