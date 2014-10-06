@section('content')
<div class="row">
    <h2>New SmsRecipients</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'smsRecipients')) }}

    
    <div class="form-group">
        {{ Form::label('email_message_id', 'Email Message Id') }}
        {{ Form::text('email_message_id', Input::old('email_message_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', Input::old('user_id'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add SmsRecipients', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop