@section('content')
<div class="row">
    <h2>New SmsMessages</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'smsMessages')) }}

    
    <div class="form-group">
        {{ Form::label('body', 'Body') }}
        {{ Form::text('body', Input::old('body'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add SmsMessages', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop