@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
			<h1>Edit {{ $site_config->key }}</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-3 col-md-4 col-sm-6">
			{{ Form::model($site_config, array('action' => array('SiteConfigController@update', $site_config->id), 'method' => 'PUT')) }}
		
				<div class="alert alert-warning">
					{{ $site_config->description}}
				</div>
				
				<div class="form-group">
					{{ Form::label('value', 'Value') }}
					{{ Form::text('value', null, array('class' => 'form-control')) }}
				</div>
		
				{{ Form::submit('Update Setting', array('class' => 'btn btn-primary')) }}
		
			{{Form::close()}}
		</div>
	</div>
</div>
@stop

