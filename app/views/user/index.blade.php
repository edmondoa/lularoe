@section('content')
<div class="row">
    <h1>All Users</h1>
    <a class="btn btn-success" href="{{ url('user/create') }}">New</a>
    {{ Form::open(array('url' => 'users/' . 0, 'method' => 'POST')) }}
    <div class='input-group'>
        <select class="form-control selectpicker actions">
	    	<option value="user/disable" selected>Disable</option>
	    	<option value="user/enable" selected>Enable</option>
	    	<option value="user/delete" selected>Delete</option>
        </select>
        <div class='input-group-btn'>
        	<button class="btn btn-default applyAction" disabled><i class='fa fa-check'></i></button>
        </div>
    </div>
</div>
<div class="row">
    <table class="table">
        <thead>
        	<tr>
        		<th><input type="checkbox"></th>
        		<th>First Name</th><th>Last Name</th><th>Email</th><th>Password</th><th>Gender</th><th>Key</th><th>Code</th><th>Dob</th><th>Phone</th><th>Role Id</th><th>Sponsor Id</th><th>Mobile Plan Id</th><th>Min Commission</th><th>Disabled</th>
        	</tr>
        </thead>
        <tbody>
        @foreach($users as $user)
        <tr>
            <td><input class="bulk-check" type="checkbox" name="ids[]" value="{{ $user->id }}"></td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->first_name }}</a>
            </td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->last_name }}</a>
            </td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->email }}</a>
            </td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->password }}</a>
            </td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->gender }}</a>
            </td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->key }}</a>
            </td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->code }}</a>
            </td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->dob }}</a>
            </td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->phone }}</a>
            </td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->role_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->sponsor_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->mobile_plan_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->min_commission }}</a>
            </td>
            
            <td>
                <a href="{{ url('user/'.$user->id) }}">{{ $user->disabled }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ Form::close() }}
</div>
@stop
