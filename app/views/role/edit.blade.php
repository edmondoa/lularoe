@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit role</h2>
</div>
<div class="row">
    {{ Form::model($role, array('route' => array('role.update', $role->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('disabled', 'Disabled') }}
        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Role', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

