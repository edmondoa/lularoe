@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1>Edit Account Info</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-3 col-md-4 col-sm-6">
		    {{ Form::model($bankinfo, array('route' => array('bankinfo.update', $bankinfo->id), 'method' => 'PUT')) }}

		    <div class="form-group">
		        {{ Form::label('bank_name', 'Bank Name') }}
		        {{ Form::text('bank_name', null, array('class' => 'form-control','placeholder'=>'e.g. Chase Bank')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('bank_routing', 'Routing #') }}
		        {{ Form::text('bank_routing', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('bank_account', 'Account #') }}
		        {{ Form::text('bank_account', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('license_state', 'Driver License State') }}
		        {{ Form::text('license_state', null, array('class' => 'form-control')) }}
		    </div>

		    <div class="form-group">
		        {{ Form::label('license_number', 'Driver License Number') }}
		        {{ Form::text('license_number', null, array('class' => 'form-control')) }}
		    </div>
		    
		    {{ Form::submit('Update Bank Info', array('class' => 'btn btn-primary pull-right')) }}
		    {{ Form::close() }}

			{{ Form::open(array('url' => 'bankinfo/' . $bankinfo->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this record? This cannot be undone.");')) }}
		    {{ Form::submit('Delete', array('class' => 'btn btn-warning pull-left')) }}{{ Form::close() }}
		</div>
	</div>
</div>
@stop

