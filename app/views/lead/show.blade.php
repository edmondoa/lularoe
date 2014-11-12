@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1 class="no-top">Viewing lead</h1>
		@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
		    <div class="btn-group">
			    <a class="btn btn-default" href="{{ url('leads/'.$lead->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
			    @if ($lead->disabled == 0)
				    {{ Form::open(array('url' => 'leads/disable', 'method' => 'DISABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $lead->id }}">
				    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@else
				    {{ Form::open(array('url' => 'leads/enable', 'method' => 'ENABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $lead->id }}">
				    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@endif
			    {{ Form::open(array('url' => 'leads/' . $lead->id, 'method' => 'DELETE')) }}
			    	<button class="btn btn-default" title="Delete">
			    		<i class="fa fa-trash" title="Delete"></i>
			    	</button>
			    {{ Form::close() }}
			</div>
		@endif
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-6">
		    <table class="table">
		        
		        <tr>
		            <th>First Name:</th>
		            <td>{{ $lead->first_name }}</td>
		        </tr>
		        
		        <tr>
		            <th>Last Name:</th>
		            <td>{{ $lead->last_name }}</td>
		        </tr>
		        
		        <tr>
		            <th>Email:</th>
		            <td>{{ $lead->email }}</td>
		        </tr>
		        
		        <tr>
		            <th>Gender:</th>
		            <td>{{ $lead->gender }}</td>
		        </tr>
		        
		        <tr>
		            <th>Date of Birth:</th>
		            <td>{{ $lead->dob }}</td>
		        </tr>
		        
		        <tr>
		            <th>Phone:</th>
		            <td>{{ $lead->phone }}</td>
		        </tr>
		        
		        <tr>
		            <th>Sponsor:</th>
		            <td>{{ $lead->sponsor_name }}</td>
		        </tr>
		        
		        <tr>
		            <th>Opportunity:</th>
		            <td>{{ $lead->opportunity_name }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
