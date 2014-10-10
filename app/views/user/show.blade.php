@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
    @if (Auth::user()->hasRole(['Admin','Superadmin']))
    	<a class="btn btn-primary" href="{{ url('user/'.$user->id .'/edit') }}">Edit</a>
	    {{ Form::open(array('url' => 'user/' . $user->id, 'method' => 'DELETE')) }}
	    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
	    {{ Form::close() }}
	    <br>
	    <br>
	@endif
</div>
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
		            <th>Gender:</th>
		            <td>{{ $user->gender }}</td>
		        </tr>
		        
		        <tr>
		            <th>Phone:</th>
		            <td>{{ $user->phone }}</td>
		        </tr>
		        
				@if (Auth::user()->hasRole(['Admin','Superadmin']))
				
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
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 div class="panel-title">Address</h2>
			</div>
		    <table class="table table-striped">
		        <tr>
		            <td>{{ $address[0]->address_1 }}</td>
		        </tr>
		        
		        @if (isset($address->address_2))
			        <tr>
			            <td>{{ $address[0]->address_2 }}</td>
			        </tr>
		        @endif
		        <tr>
		            <td>{{ $address[0]->city }}, {{ $address[0]->state }} {{ $address[0]->zip }}</td>
		        </tr>
		        
		    </table>
		</div><!-- panel -->
	</div><!-- row -->
</div><!-- row -->
@stop
