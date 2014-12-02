@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
			<h1>Edit address</h1>
			{{ Form::model($site_config, array('action' => array('SiteConfigController@update', $site_config->id), 'method' => 'PUT')) }}
		
			
			<div class="bs-callout bs-callout-warning">
				{{ $site_config->description}}
			</div>
			
			<div class="form-group">
				{{ Form::label('value', 'Value') }}
				{{ Form::text('value', null, array('class' => 'form-control')) }}
			</div>
			
<!-- 		    <div class="form-group">
				{{ Form::label('address_2', 'Configuration 2') }}
				{{ Form::text('address_2', null, array('class' => 'form-control')) }}
			</div>
			
			<div class="form-group">
				{{ Form::label('city', 'City') }}
				{{ Form::text('city', null, array('class' => 'form-control')) }}
			</div>
			
			<div class="form-group">
				{{ Form::label('state', 'State') }}
				{{ Form::text('state', null, array('class' => 'form-control')) }}
			</div>
			
			<div class="form-group">
				{{ Form::label('addressable_id', 'Configurationable Id') }}
				{{ Form::text('addressable_id', null, array('class' => 'form-control')) }}
			</div>
			
			<div class="form-group">
				{{ Form::label('zip', 'Zip') }}
				{{ Form::text('zip', null, array('class' => 'form-control')) }}
			</div>
 -->		    
			<!-- <div class="form-group">
				{{ Form::label('disabled', 'Disabled') }}
				{{ Form::text('disabled', null, array('class' => 'form-control')) }}
			</div> -->
			
		
			{{ Form::submit('Update Configuration', array('class' => 'btn btn-primary')) }}
		
			{{Form::close()}}
		</div>
	</div>
</div>
@stop

