@section('content')
<div class="row">
    <h2>New Role</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'role')) }}

    
    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('disabled', 'Disabled') }}
        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Role', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop