@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1 class="no-top">Viewing Account Info</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('bankinfo/'.$bankinfo->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($bankinfo->disabled == 0)
			    {{ Form::open(array('url' => 'addresses/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $bankinfo->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'addresses/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $bankinfo->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'addresses/' . $bankinfo->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this record? This cannot be undone.");')) }}
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
		            <th>Bank Name:</th>
		            <td>{{ $bankinfo->bank_name }}</td>
		        </tr>
		        
		        <tr>
		            <th>Routing #:</th>
		            <td>{{ $bankinfo->bank_routing }}</td>
		        </tr>
		        
		        <tr>
		            <th>Account #:</th>
		            <td>{{ $bankinfo->bank_account }}</td>
		        </tr>
		        
		        <tr>
		            <th>Driver License State:</th>
		            <td>{{ $bankinfo->license_state }}</td>
		        </tr>
		        
		        <tr>
		            <th>Driver License Number:</th>
		            <td>{{ $bankinfo->license_number }}</td>
		        </tr>
		        
		        
		        <tr>
		            <th>Disabled:</th>
		            <td>{{ $bankinfo->disabled }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
