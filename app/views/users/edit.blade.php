@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit users</h2>
</div>
<div class="row">
    {{ Form::model($users, array('route' => array('users.update', $users->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('first_name', 'First Name') }}
        {{ Form::text('first_name', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('last_name', 'Last Name') }}
        {{ Form::text('last_name', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('email', 'Email') }}
        {{ Form::text('email', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('password', 'Password') }}
        {{ Form::text('password', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('key', 'Key') }}
        {{ Form::text('key', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('code', 'Code') }}
        {{ Form::text('code', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('phone', 'Phone') }}
        {{ Form::text('phone', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('role_id', 'Role Id') }}
        {{ Form::text('role_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('sponsor_id', 'Sponsor Id') }}
        {{ Form::text('sponsor_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('mobile_plan_id', 'Mobile Plan Id') }}
        {{ Form::text('mobile_plan_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('min_commission', 'Min Commission') }}
        {{ Form::text('min_commission', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Users', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

