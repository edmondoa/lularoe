@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/smsMessages">&lsaquo; Back</a>
	    <h2>Edit smsMessage</h2>
	    {{ Form::model($smsMessage, array('route' => array('smsMessage.update', $smsMessage->id), 'method' => 'PUT')) }}
	
	    
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
	    
	
	    {{ Form::submit('Update SmsMessage', array('class' => 'btn btn-success')) }}
	
	    {{Form::close()}}
	</div>
</div>
@stop

