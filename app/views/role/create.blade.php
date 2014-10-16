@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/roles">&lsaquo; Back</a>
	    <h1 class="no-top">New Role</h1>
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
</div>
@stop