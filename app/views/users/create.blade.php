@section('content')
<div class="row">
    <h2>New Users</h2>
</div>
<div class="row">
    {{ Form::open(array('url' => 'users')) }}

    
    <div class="form-group">
        {{ Form::label('first_name', 'First Name') }}
        {{ Form::text('first_name', Input::old('first_name'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('last_name', 'Last Name') }}
        {{ Form::text('last_name', Input::old('last_name'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('email', 'Email') }}
        {{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('password', 'Password') }}
        {{ Form::text('password', Input::old('password'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('key', 'Key') }}
        {{ Form::text('key', Input::old('key'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('code', 'Code') }}
        {{ Form::text('code', Input::old('code'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('phone', 'Phone') }}
        {{ Form::text('phone', Input::old('phone'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('role_id', 'Role Id') }}
        {{ Form::text('role_id', Input::old('role_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('sponsor_id', 'Sponsor Id') }}
        {{ Form::text('sponsor_id', Input::old('sponsor_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('mobile_plan_id', 'Mobile Plan Id') }}
        {{ Form::text('mobile_plan_id', Input::old('mobile_plan_id'), array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('min_commission', 'Min Commission') }}
        {{ Form::text('min_commission', Input::old('min_commission'), array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Add Users', array('class' => 'btn btn-success')) }}

    {{ Form::close() }}
</div>
@stop