@section('content')
<div class="row">
    <h1>All UserTests</h1>
    <a class="btn btn-success" href="{{ url('userTest/create') }}">New</a>
    {{ Form::open(array('url' => 'userTests/' . 0, 'method' => 'POST')) }}
    <div class='input-group'>
        <select class="form-control selectpicker actions">
	    	<option value="userTest/disable" selected>Disable</option>
	    	<option value="userTest/enable" selected>Enable</option>
	    	<option value="userTest/delete" selected>Delete</option>
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
        @foreach($userTests as $userTest)
        <tr>
            <td><input class="bulk-check" type="checkbox" name="ids[]" value="{{ $userTest->id }}"></td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->first_name }}</a>
            </td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->last_name }}</a>
            </td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->email }}</a>
            </td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->password }}</a>
            </td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->gender }}</a>
            </td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->key }}</a>
            </td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->code }}</a>
            </td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->dob }}</a>
            </td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->phone }}</a>
            </td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->role_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->sponsor_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->mobile_plan_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->min_commission }}</a>
            </td>
            
            <td>
                <a href="{{ url('userTest/'.$userTest->id) }}">{{ $userTest->disabled }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ Form::close() }}
</div>
@stop
