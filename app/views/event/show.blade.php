@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1 class="no-top">Viewing event</h1>
		@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
		    <div class="btn-group">
			    <a class="btn btn-default" href="{{ url('events/'.$event->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
			    @if ($event->disabled == 0)
				    {{ Form::open(array('url' => 'events/disable', 'method' => 'DISABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $event->id }}">
				    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@else
				    {{ Form::open(array('url' => 'events/enable', 'method' => 'ENABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $event->id }}">
				    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@endif
			    {{ Form::open(array('url' => 'events/' . $event->id, 'method' => 'DELETE')) }}
			    	<button class="btn btn-default" title="Delete">
			    		<i class="fa fa-trash" title="Delete"></i>
			    	</button>
			    {{ Form::close() }}
			</div>
		@endif
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-12">
		    <table class="table">
		        
		        <tr>
		            <th>Name:</th>
		            <td>{{ $event->name }}</td>
		        </tr>
		        
		        <tr>
		            <th>Description:</th>
		            <td>{{ $event->description }}</td>
		        </tr>
		        
		        <tr>
		            <th>Starting Time:</th>
		            <td>{{ $event->date_start }}</td>
		        </tr>
		        
		        <tr>
		            <th>Ending Time:</th>
		            <td>{{ $event->date_end }}</td>
		        </tr>
		        
		        @if (Auth::user()->hasRole(['Superadmin', 'Admin']))

			        <tr>
			            <th>Status:</th>
			            <td>{{ $event->status }}</td>
			        </tr>
			        
			        <tr>
			        	<th>Visibility:</th>
			        	<td>
			        		<table>
			        			<tr>
			        				<td>@if ($event->public == 1)<i class="fa fa-check"></i>@endif</td>
			        				<td>&nbsp;Public</td>
			        			</tr>
			        			<tr>
			        				<td>@if ($event->customers == 1)<i class="fa fa-check"></i>@endif</td>
			        				<td>&nbsp;Customers</td>
			        			</tr>
			        			<tr>
			        				<td>@if ($event->reps == 1)<i class="fa fa-check"></i>@endif</td>
			        				<td>&nbsp;ISM's</td>
			        			</tr>
			        			<tr>
			        				<td>@if ($event->editors == 1)<i class="fa fa-check"></i>@endif</td>
			        				<td>&nbsp;Editors</td>
			        			</tr>
			        			<tr>
			        				<td>@if ($event->admins == 1)<i class="fa fa-check"></i>@endif</td>
			        				<td>&nbsp;Admins</td>
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
