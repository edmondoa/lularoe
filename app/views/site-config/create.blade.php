@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New Site Setting</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-3 col-md-4 col-sm-6">
		    {{ Form::model($site_configs, array('action' => array('SiteConfigController@store'), 'method' => 'POST')) }}
		
			    <div class="form-group">
			        {{ Form::label('name', 'Name') }}
			        {{ Form::text('name', null, array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('value', 'Value') }}
			        {{ Form::text('value', null, array('class' => 'form-control')) }}
			    </div>
		
			    {{ Form::submit('Add Site Setting', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop