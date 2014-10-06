@section('content')
<div class="row">
    <h2>New Images</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'images')) }}

    
    <div class="form-group">
        {{ Form::label('type', 'Type') }}
        {{ Form::text('type', Input::old('type'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('url', 'Url') }}
        {{ Form::text('url', Input::old('url'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Images', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop