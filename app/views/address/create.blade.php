@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New Address</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-3 col-md-4 col-sm-6">
		    {{ Form::open(array('url' => 'addresses')) }}
		
			    <div class="form-group">
			        {{ Form::label('label', 'Type') }}
			        {{ Form::select('label', [
			        	'Billing' => 'Billing',
			        	'Shipping' => 'Shipping'
			        ], null, array('class' => 'form-control')) }}
			    </div>
			    
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
			        {{ Form::label('zip', 'Zip') }}
			        {{ Form::text('zip', null, array('class' => 'form-control')) }}
			    </div>
		
			    {{ Form::submit('Add Address', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop