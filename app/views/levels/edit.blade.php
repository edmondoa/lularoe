@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h2>Edit levels</h2>
</div>
<div class="row">
    {{ Form::model($levels, array('route' => array('levels.update', $levels->id), 'method' => 'PUT')) }}

    
    <div class="form-group">
        {{ Form::label('user_id', 'User Id') }}
        {{ Form::text('user_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('ancestor_id', 'Ancestor Id') }}
        {{ Form::text('ancestor_id', null, array('class' => 'form-control')) }}
    </div>
    
    <div class="form-group">
        {{ Form::label('level', 'Level') }}
        {{ Form::text('level', null, array('class' => 'form-control')) }}
    </div>
    

    {{ Form::submit('Edit Levels', array('class' => 'btn btn-success')) }}

    {{Form::close()}}
</div>
@stop

