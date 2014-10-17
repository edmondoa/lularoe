@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/addresses">&lsaquo; Back</a>
	    <h2>Edit address</h2>
	    {{ Form::model($address, array('route' => array('address.update', $address->id), 'method' => 'PUT')) }}
	
	    
	    <div class="form-group">
	        {{ Form::label('address_1', 'Address 1') }}
	        {{ Form::text('address_1', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('address_2', 'Address 2') }}
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
	        {{ Form::label('addressable_id', 'Addressable Id') }}
	        {{ Form::text('addressable_id', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('zip', 'Zip') }}
	        {{ Form::text('zip', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('disabled', 'Disabled') }}
	        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
	    </div>
	    
	
	    {{ Form::submit('Update Address', array('class' => 'btn btn-success')) }}
	
	    {{Form::close()}}
	</div>
</div>
@stop

