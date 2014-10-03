@section('content')
<div class="row">
    <h2>New Users</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'users')) }}

    
    <div class="form-group">
        {{ Form::label('first', 'First') }}
        {{ Form::text('first', Input::old('first'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('last', 'Last') }}
        {{ Form::text('last', Input::old('last'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('email', 'Email') }}
        {{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('password', 'Password') }}
        {{ Form::text('password', Input::old('password'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Users', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop