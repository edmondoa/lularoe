@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/users">&lsaquo; Back</a>
	    <h1 class="no-top">Viewing user</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('user/'.$user->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($user->disabled == 0)
			    {{ Form::open(array('url' => 'user/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $user->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'user/enable', 'method' => 'ENABLE')) }}
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
		<br>
		<br>
	    <table class="table">
	        
	        <tr>
	            <th>Public Id:</th>
	            <td>{{ $user->public_id }}</td>
	        </tr>
	        
	        <tr>
	            <th>First Name:</th>
	            <td>{{ $user->first_name }}</td>
	        </tr>
	        
	        <tr>
	            <th>Last Name:</th>
	            <td>{{ $user->last_name }}</td>
	        </tr>
	        
	        <tr>
	            <th>Email:</th>
	            <td>{{ $user->email }}</td>
	        </tr>
	        
	        <tr>
	            <th>Password:</th>
	            <td>{{ $user->password }}</td>
	        </tr>
	        
	        <tr>
	            <th>Gender:</th>
	            <td>{{ $user->gender }}</td>
	        </tr>
	        
	        <tr>
	            <th>Key:</th>
	            <td>{{ $user->key }}</td>
	        </tr>
	        
	        <tr>
	            <th>Dob:</th>
	            <td>{{ $user->dob }}</td>
	        </tr>
	        
	        <tr>
	            <th>Phone:</th>
	            <td>{{ $user->phone }}</td>
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
	            <th>Mobile Plan Id:</th>
	            <td>{{ $user->mobile_plan_id }}</td>
	        </tr>
	        
	        <tr>
	            <th>Min Commission:</th>
	            <td>{{ $user->min_commission }}</td>
	        </tr>
	        
	        <tr>
	            <th>Disabled:</th>
	            <td>{{ $user->disabled }}</td>
	        </tr>
	        
	    </table>
    </div>
</div>
@stop
