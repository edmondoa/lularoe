@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
		@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
		    <div class="btn-group">
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
			    {{ Form::open(array('url' => 'users/' . $user->id, 'method' => 'DELETE')) }}
			    	<button class="btn btn-default" title="Delete">
			    		<i class="fa fa-trash" title="Delete"></i>
			    	</button>
			    {{ Form::close() }}
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
			            <th>Email:</th>
			            <td>{{ $user->email }}</td>
			        </tr>
			        
			        <tr>
			            <th>Phone:</th>
			            <td>{{ $user->phone }}</td>
			        </tr>
			        
					@if (Auth::user()->hasRole(['Admin','Superadmin']))
					
			        <tr>
			            <th>Gender:</th>
			            <td>{{ $user->gender }}</td>
			        </tr>
					
			        <tr>
			            <th>DOB:</th>
			            <td>{{ $user->dob }}</td>
			        </tr>
					  
			        <tr>
			            <th>Role Id:</th>
			            <td>{{ $user->role_id }}</td>
			        </tr>
			
					
			        <tr>
			            <th>Sponsor Id:</th>
			            <td>{{ $user->sponsor_id }}</td>
			        </tr>
			        
			        <tr>
			            <th>Min Commission:</th>
			            <td>{{ $user->min_commission }}</td>
			        </tr>
			        
			        <tr>
			            <th>Disabled:</th>
			            <td>{{ $user->disabled }}</td>
			        </tr>
			        
			        <tr>
			            <th>Mobile Plan Id:</th>
			            <td>{{ $user->mobile_plan_id }}</td>
			        </tr>
			        
					@endif
			        
			    </table>
			</div><!-- panel -->
		</div><!-- col -->
		<div class="col col-md-6 col-sm-12">
			@foreach ($addresses as $address)
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 div class="panel-title">Address</h2>
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
