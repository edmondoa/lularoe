@section('content')
<div class="row">
    <h2>Edit users</h2>
</div>
<div class="row">
    {{ Form::model($users, array('route' => array('users.update', $users->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('first', 'First') }}
        {{ Form::text('first', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('last', 'Last') }}
        {{ Form::text('last', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('email', 'Email') }}
        {{ Form::text('email', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('password', 'Password') }}
        {{ Form::text('password', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Users', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

