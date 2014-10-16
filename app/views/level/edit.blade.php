@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/levels">&lsaquo; Back</a>
	    <h2>Edit level</h2>
	    {{ Form::model($level, array('route' => array('level.update', $level->id), 'method' => 'PUT')) }}
	
	    
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
	    
	    <div class="form-group">
	        {{ Form::label('disabled', 'Disabled') }}
	        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
	    </div>
	    
	
	    {{ Form::submit('Update Level', array('class' => 'btn btn-success')) }}
	
	    {{Form::close()}}
	</div>
</div>
@stop

