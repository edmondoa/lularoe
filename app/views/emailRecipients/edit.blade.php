@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit emailRecipients</h2>
</div>
<div class="row">
    {{ Form::model($emailRecipients, array('route' => array('emailRecipients.update', $emailRecipients->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('sms_message_id', 'Sms Message Id') }}
        {{ Form::text('sms_message_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit EmailRecipients', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

