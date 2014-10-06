@section('content')
<div class="row">
    <h2>New EmailRecipients</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'emailRecipients')) }}

    
    <div class="form-group">
        {{ Form::label('sms_message_id', 'Sms Message Id') }}
        {{ Form::text('sms_message_id', Input::old('sms_message_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', Input::old('user_id'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add EmailRecipients', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop