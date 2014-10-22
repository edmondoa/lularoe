@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			<div class="breadcrumbs">
				<a href="/emailMessages">&lsaquo; Back</a>
			</div>
		    <h1>Edit emailMessage</h1>
		    {{ Form::model($emailMessage, array('route' => array('emailMessages.update', $emailMessage->id), 'method' => 'PUT')) }}
		
		    
		    <div class="form-group">
		        {{ Form::label('sender_id', 'Sender Id') }}
		        {{ Form::text('sender_id', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('recipient_id', 'Recipient Id') }}
		        {{ Form::text('recipient_id', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('subject', 'Subject') }}
		        {{ Form::text('subject', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('body', 'Body') }}
		        {{ Form::text('body', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('disabled', 'Disabled') }}
		        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
		    </div>
		    
		
		    {{ Form::submit('Update EmailMessage', array('class' => 'btn btn-success')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

