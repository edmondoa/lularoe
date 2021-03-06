@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
	    <div class="btn-group" id="record-options">
			@if (Auth::user()->id != $user->id)
				@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
		    		<a class="btn btn-default" href="{{ url('users/'.$user->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
				    @if ($user->disabled == 0)
					    {{ Form::open(array('url' => 'users/disable', 'method' => 'DISABLE')) }}
					    	<input type="hidden" name="ids[]" value="{{ $user->id }}">
					    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
					    		<i class="fa fa-eye"></i>
					    	</button>
					    {{ Form::close() }}
					@else
					    {{ Form::open(array('url' => 'users/enable', 'method' => 'ENABLE')) }}
					    	<input type="hidden" name="ids[]" value="{{ $user->id }}">
					    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
					    		<i class="fa fa-eye"></i>
					    	</button>
					    {{ Form::close() }}
					@endif
				    {{ Form::open(array('url' => 'users/' . $user->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this record? This cannot be undone.");')) }}
				    	<button class="btn btn-default" title="Delete">
				    		<i class="fa fa-trash" title="Delete"></i>
				    	</button>
				    {{ Form::close() }}
				@endif
			@endif
		</div>
		@if (!$user->block_email && !$user->block_sms)
			<div class="btn-group" id="communication-options">
		@endif
				@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Rep']))
					@if (!$user->block_email)
						{{ Form::open(array('url' => '/users/email', 'method' => 'POST')) }}
		            		{{ Form::hidden('user_ids[]', $user->id) }}
		            		<button class="btn btn-default" title="Send Email">
		            			<i class="fa fa-envelope"></i>
		            		</button>
		            	{{ Form::close() }}
		            @endif
		            @if (!$user->block_sms)
						{{ Form::open(array('url' => '/users/sms', 'method' => 'POST')) }}
		            		{{ Form::hidden('user_ids[]', $user->id) }}
		            		<button class="btn btn-default" title="Send Text Message (SMS)">
		            			<i class="fa fa-mobile-phone"></i>
		            		</button>
		            	{{ Form::close() }}
		            @endif
	            @endif
		@if (!$user->block_email && !$user->block_sms)
			</div>
		@endif
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-6 col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 div class="panel-title">Information</h2>
				</div>
			    <table class="table table-striped">
			        <tr>
			            <th>
			            	@if ($user->role_name == 'Rep')
			            		ISM ID:
			            	@else
			            		User ID:
			            	@endif
			            </th>
			            <td>{{ $user->id }}</td>
			        </tr>
			        <tr>
			            <th>
			            	Rank:
			            </th>
			            <td>
			            	{{ $user->rank_name }} (Rank {{ $user->rank_id }})
			            </td>
			        </tr>
			        @if ($user->hide_email != true || Auth::user()->hasRole(['Superadmin', 'Admin']) || Auth::user()->rank_id >= 9)
				        <tr>
				            <th>Email:</th>
				            <td>
				            	{{ $user->email }}
				            	@if ($user->block_email)
				            		<br>
				            		<span class="label label-warning">
				            			{{ $user->first_name }} has opted out of receiving emails.
				            		</span>
				            	@endif
				            </td>
				        </tr>
				        <tr>
				            <th>Phone:</th>
				            <td>
				            	{{ $user->phone }}
				            	@if ($user->block_sms)
				            		<br>
				            		<span class="label label-warning">
				            			{{ $user->first_name }} has opted out of receiving text messages.
				            		</span>
				            	@endif
				            </td>
				        </tr>	
				        <tr>
				            <th>Gender:</th>
				            <td>{{ $user->gender }}</td>
				        </tr>
						
				        <tr>
				            <th>DOB:</th>
				            <td>{{ $user->dob }}</td>
				        </tr>
						  
				        <tr>
				            <th>Role:</th>
				            <td>{{ $user->formatted_role_name }}</td>
				        </tr>
				
				        <tr>
				            <th>Sponsor:</th>
				            <td>
				            	<a href="/users/{{ $user->sponsor_id }}">
				            		@if (isset($user->sponsor->first_name))
				            			{{ $user->sponsor->first_name }} {{ $user->sponsor->last_name }}
				            		@endif
				            	</a>
				            </td>
				        </tr>
					@endif
			    </table>
			</div><!-- panel -->
		</div><!-- col -->
		<div class="col col-md-6 col-sm-12">
			@foreach ($addresses as $address)
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 div class="panel-title">{{ $address->label }} Address</h2>
					</div>
				    <table class="table table-striped">
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
			@endforeach
		</div><!-- row -->
	</div><!-- row -->
@stop
