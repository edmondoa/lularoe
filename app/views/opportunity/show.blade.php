@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1 class="no-top">{{ $opportunity->title }}</h1>
		@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
		    <div class="btn-group">
			    <a class="btn btn-default" href="{{ url('opportunities/'.$opportunity->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
			    @if ($opportunity->disabled == 0)
				    {{ Form::open(array('url' => 'opportunities/disable', 'method' => 'DISABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $opportunity->id }}">
				    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@else
				    {{ Form::open(array('url' => 'opportunities/enable', 'method' => 'ENABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $opportunity->id }}">
				    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@endif
			    {{ Form::open(array('url' => 'opportunities/' . $opportunity->id, 'method' => 'DELETE')) }}
			    	<button class="btn btn-default" title="Delete">
			    		<i class="fa fa-trash" title="Delete"></i>
			    	</button>
			    {{ Form::close() }}
			</div>
			<a target="_blank" href="/opportunity/{{ $opportunity->id }}" class="btn btn-primary"><i class="fa fa-globe"></i> View Opportunity</a>
		@endif
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-6">
		    <table class="table">
		       
		        @if ($opportunity->deadline != 0) 
			        <tr>
			            <th>Deadline:</th>
			            <td>{{ $opportunity->formatted_deadline_date }}, {{ $opportunity->formatted_deadline_time }}</td>
			        </tr>
		        @endif
		        @if (Auth::user()->hasRole(['Superadmin', 'Admin']))

			        <tr>
			            <th>Status:</th>
			            <td>{{ $opportunity->status }}</td>
			        </tr>
			    @endif
			    
		        <tr>
		            <th>Includes Form:</th>
		            <td>
		            	@if ($opportunity->include_form == 1)
		            		<i class="fa fa-check"></i>
			            @else
			            	No
			            @endif
		           	</td>
		        </tr>
			        
			    @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
			    
			        <tr>
			        	<th>Visibility:</th>
			        	<td>
			        		<table>
			        			<tr>
			        				<td>@if ($opportunity->public == 1)<i class="fa fa-check"></i>@endif</td>
			        				<td>&nbsp;Public</td>
			        			</tr>
			        			<tr>
			        				<td>@if ($opportunity->customers == 1)<i class="fa fa-check"></i>@endif</td>
			        				<td>&nbsp;Customers</td>
			        			</tr>
			        			<tr>
			        				<td>@if ($opportunity->reps == 1)<i class="fa fa-check"></i>@endif</td>
			        				<td>&nbsp;ISM's</td>
			        			</tr>
			        		</table>
			        	</td>
			        </tr>
		        @endif
		        
		    </table>
	    </div>
	</div>
</div>
@stop
