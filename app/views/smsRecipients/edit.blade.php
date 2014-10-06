@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit smsRecipients</h2>
</div>
<div class="row">
    {{ Form::model($smsRecipients, array('route' => array('smsRecipients.update', $smsRecipients->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('email_message_id', 'Email Message Id') }}
        {{ Form::text('email_message_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit SmsRecipients', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

