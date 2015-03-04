@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1 class="no-top">Viewing address</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('addresses/'.$address->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($address->disabled == 0)
			    {{ Form::open(array('url' => 'addresses/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $address->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'addresses/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $address->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'addresses/' . $address->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this record? This cannot be undone.");')) }}
		    	<button class="btn btn-default" title="Delete">
		    		<i class="fa fa-trash" title="Delete"></i>
		    	</button>
		    {{ Form::close() }}
		</div>
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-12">
		    <table class="table">
		        
		        <tr>
		            <th>Address 1:</th>
		            <td>{{ $address->address_1 }}</td>
		        </tr>
		        
		        <tr>
		            <th>Address 2:</th>
		            <td>{{ $address->address_2 }}</td>
		        </tr>
		        
		        <tr>
		            <th>City:</th>
		            <td>{{ $address->city }}</td>
		        </tr>
		        
		        <tr>
		            <th>State:</th>
		            <td>{{ $address->state }}</td>
		        </tr>
		        
		        <tr>
		            <th>Addressable Id:</th>
		            <td>{{ $address->addressable_id }}</td>
		        </tr>
		        
		        <tr>
		            <th>Zip:</th>
		            <td>{{ $address->zip }}</td>
		        </tr>
		        
		        <tr>
		            <th>Disabled:</th>
		            <td>{{ $address->disabled }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
