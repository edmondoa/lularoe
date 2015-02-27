@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		<!-- @include('_helpers.breadcrumbs') -->
		<h1 class="no-top">{{ $party->name }}</h1>
		@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
		    <div class="btn-group" id="record-options">
			    <a class="btn btn-default" href="{{ url('parties/'.$party->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
			    @if ($party->disabled == 0)
				    {{ Form::open(array('url' => 'parties/disable', 'method' => 'DISABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $party->id }}">
				    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@else
				    {{ Form::open(array('url' => 'parties/enable', 'method' => 'ENABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $party->id }}">
				    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@endif
			    {{ Form::open(array('url' => 'parties/' . $party->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this record? This cannot be undone.");')) }}
			    	<button class="btn btn-default" title="Delete">
			    		<i class="fa fa-trash" title="Delete"></i>
			    	</button>
			    {{ Form::close() }}
			</div>
		@endif
		<a class="btn btn-primary" target="_blank" href="/party/{{ $party->id }}"><i class="fa fa-globe"></i> View Public Party Page</a>
	</div><!-- row -->
	<div class="row">
		<div class="col-md-4 col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 div class="panel-title">Details
						<a class="pull-right" href="{{ url('parties/'.$party->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
					</h2>
				</div>
			    <table class="table table-striped">
			        
			        <tr>
			            <th>Description:</th>
			            <td>{{ $party->description }}</td>
			        </tr>
			        @if ($party->local_start_date == $party->local_end_date)
				        <tr>
				            <th>Local Date/Time:</th>
				            <td>{{ $party->local_start_date }}, {{ $party->local_start_time }} - {{ $party->local_end_time }}</td>
				        </tr>
			        @else
				        <tr>
				        	<th>Local Start Time:</th>
				        	<td>{{ $party->local_start_date }}, {{ $party->local_start_time }}</td>
				        </tr>
				        <tr>
				        	<th>Local End Time:</th>
				        	<td>{{ $party->local_end_date }}, {{ $party->local_end_time }}</td>
				        </tr>
			        @endif
			        <tr>
			        	<th>Organizer:</th>
			        	<td>{{ $party->organizer_name }}</td>
			        </tr>
			        @if ($party->host_id != 0)
				        <tr>
				        	<th>Host:</th>
				        	<td>{{ $party->host_name }}</td>
				        </tr>
				    @endif
			        @if (Auth::user()->hasRole(['Superadmin', 'Admin']))
	
				        <tr>
				            <th>Status:</th>
				            <td>{{ $party->status }}</td>
				        </tr>
				        
				        <tr>
				        	<th>Visibility:</th>
				        	<td>
				        		<table>
				        			<tr>
				        				<td>@if ($party->public == 1)<i class="fa fa-check"></i>@endif</td>
				        				<td>&nbsp;Public</td>
				        			</tr>
				        			<tr>
				        				<td>@if ($party->customers == 1)<i class="fa fa-check"></i>@endif</td>
				        				<td>&nbsp;Customers</td>
				        			</tr>
				        			<tr>
				        				<td>@if ($party->reps == 1)<i class="fa fa-check"></i>@endif</td>
				        				<td>&nbsp;Reps</td>
				        			</tr>
				        			<!--<tr>
				        				<td>@if ($party->editors == 1)<i class="fa fa-check"></i>@endif</td>
				        				<td>&nbsp;Editors</td>
				        			</tr>
				        			<tr>
				        				<td>@if ($party->admins == 1)<i class="fa fa-check"></i>@endif</td>
				        				<td>&nbsp;Admins</td>
				        			</tr>-->
				        		</table>
				        	</td>
				        </tr>
			        @endif
			        
			    </table>
			</div>
	    </div>
	    <div class="col-md-4 col-sm-6">
			@if (isset($address))
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 div class="panel-title">Address
							<a class="pull-right" href="{{ url('addresses/'.$address->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
						</h2>
					</div>
				    <table class="table table-striped">
				    	@if (isset($address->label))
					        <tr>
					            <td>{{ $address->label }}</td>
					        </tr>
					    @endif
				        <tr>
				            <td>{{ $address->address_1 }}</td>
				        </tr>
				        
				        @if (!empty($address->address_2))
					        <tr>
					            <td>{{ $address->address_2 }}</td>
					        </tr>
				        @endif
				        <tr>
				            <td>{{ $address->city }}, {{ $address->state }} {{ $address->zip }}</td>
				        </tr>
				    </table>
				</div><!-- panel -->
			@endif
			@if (count($attachment_images > 0))
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title">Images <a href="/parties/{{ $party->id }}/edit#image-list" class="pull-right"><i class="fa fa-pencil"></i></a></h2>
					</div>
					<div class="panel-body">
						@foreach ($attachment_images as $image)
							<a href="/parties/{{ $party->id }}/edit#image-list"><img class="thumb thumb-md" src="/uploads/{{ $image }}"></a>
						@endforeach
					</div>
				</div>
			@endif
	    </div><!-- col -->
	    <div class="col-md-4 col-sm-6">
	    	
	    	<?php // leads attending ?>
	    	<div class="panel panel-default">
	    		<div class="panel-heading">
	    			<h2 class="panel-title">Guests Attending</h2>
	    		</div>
	    		@if (count($leads_attending) > 0)
	    			<table class="table table-striped">
		    			@foreach ($leads_attending as $lead)
		    				<tr>
		    					<td>
		    						<a href="/leads/{{ $lead->id }}">{{ $lead->first_name }} {{ $lead->last_name }}</a>
		    						@if ($lead->id == $party->host_id)
		    							<span class="label label-default">Host</span>
		    						@endif
		    					</td>
		    				</tr>
		    			@endforeach
	    			</table>
	    		@else
	    			<div class="panel-body">
		    			<p class="no-top">(No confirmed guests yet)</p>
		    			<a class="btn btn-primary" href="/leads">Send invitations</a>
	    			</div>
	    		@endif
	    	</div><!-- panel -->
	    	
	    	<?php // users attending ?>
	    	@if (count($users_attending) > 0)
		    	<div class="panel panel-default">
		    		<div class="panel-heading">
		    			<h2 class="panel-title">{{ Config::get('site.company_name') }} Reps Attending</h2>
		    		</div>
	    			<table class="table table-striped">
		    			@foreach ($users_attending as $user)
		    				<tr>
		    					<td>
		    						<a href="/users/{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</a>
		    					</td>
		    				</tr>
		    			@endforeach
	    			</table>
		    	</div><!-- panel -->
		    @endif
		    
	    	<?php // leads declined ?>
	    	@if (count($leads_declined) > 0)
		    	<div class="panel panel-default">
		    		<div class="panel-heading">
		    			<h2 class="panel-title">Guests Declined</h2>
		    		</div>
	    			<table class="table table-striped">
		    			@foreach ($leads_declined as $lead)
		    				<tr>
		    					<td>
		    						<a href="/leads/{{ $lead->id }}">{{ $lead->first_name }} {{ $lead->last_name }}</a>
		    					</td>
		    				</tr>
		    			@endforeach
	    			</table>
		    	</div><!-- panel -->
	    	@endif
	    	
	    	<?php // users declined ?>
	    	@if (count($users_declined) > 0)
		    	<div class="panel panel-default">
		    		<div class="panel-heading">
		    			<h2 class="panel-title">{{ Config::get('site.company_name') }} Reps Declined</h2>
		    		</div>
	    			<table class="table table-striped">
		    			@foreach ($users_declined as $user)
		    				<tr>
		    					<td>
		    						<a href="/users/{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</a>
		    					</td>
		    				</tr>
		    			@endforeach
	    			</table>
		    	</div><!-- panel -->
	    	@endif
	    	
	    </div><!-- col -->
	</div>
</div>
@stop
