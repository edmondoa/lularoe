@section('content')
<div class="row">
    <h2>New Levels</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'levels')) }}

    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', Input::old('user_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('ancestor_id', 'Ancestor Id') }}
        {{ Form::text('ancestor_id', Input::old('ancestor_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('level', 'Level') }}
        {{ Form::text('level', Input::old('level'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Levels', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop