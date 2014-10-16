@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/levels">&lsaquo; Back</a>
	    <h1 class="no-top">New Level</h1>
	    {{ Form::open(array('url' => 'level')) }}
	
		    
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
		    
		    <div class="form-group">
		        {{ Form::label('disabled', 'Disabled') }}
		        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control')) }}
		    </div>
		    
	
		    {{ Form::submit('Add Level', array('class' => 'btn btn-success')) }}

	    {{ Form::close() }}
    </div>
</div>
@stop