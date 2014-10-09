@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing user</h1>
    <a class="btn btn-primary" href="{{ url('user/'.$user->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'user/' . $user->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
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
            <th>Code:</th>
            <td>{{ $user->code }}</td>
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
@stop
