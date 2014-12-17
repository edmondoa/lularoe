@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1>Edit smsMessage</h1>
		    {{ Form::model($smsMessage, array('route' => array('smsMessages.update', $smsMessage->id), 'method' => 'PUT')) }}
		
		    
		    <div class="form-group">
		        {{ Form::label('sender_id', 'Sender Id') }}
		        {{ Form::text('sender_id', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('recipient_id', 'Recipient Id') }}
		        {{ Form::text('recipient_id', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('body', 'Body') }}
		        {{ Form::text('body', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('disabled', 'Disabled') }}
		        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
		    </div>
		    
		
		    {{ Form::submit('Update SmsMessage', array('class' => 'btn btn-primary')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

