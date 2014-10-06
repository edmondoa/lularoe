@section('content')
<div class="row">
    <h2>New Pages</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'pages')) }}

    
    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('url', 'Url') }}
        {{ Form::text('url', Input::old('url'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('type', 'Type') }}
        {{ Form::text('type', Input::old('type'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('opportunity', 'Opportunity') }}
        {{ Form::text('opportunity', Input::old('opportunity'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Pages', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop