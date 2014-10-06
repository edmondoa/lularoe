@section('content')
<div class="row">
    <h2>New EmailMessages</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'emailMessages')) }}

    
    <div class="form-group">
        {{ Form::label('subject', 'Subject') }}
        {{ Form::text('subject', Input::old('subject'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('body', 'Body') }}
        {{ Form::text('body', Input::old('body'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add EmailMessages', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop