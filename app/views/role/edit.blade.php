@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1>Edit role</h1>
		    {{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}
		
		    
		    <div class="form-group">
		        {{ Form::label('name', 'Name') }}
		        {{ Form::text('name', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('disabled', 'Disabled') }}
		        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
		    </div>
		    
		
		    {{ Form::submit('Update Role', array('class' => 'btn btn-primary')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

