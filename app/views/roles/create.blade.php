@section('content')
<div class="row">
    <h2>New Roles</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'roles')) }}

    
    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Roles', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop