@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing users</h1>
    <a class="btn btn-primary" href="{{ url('users/'.$users->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'users/' . $users->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>First Name:</th>
            <td>{{ $users->first_name }}</td>
        </tr>
        
        <tr>
            <th>Last Name:</th>
            <td>{{ $users->last_name }}</td>
        </tr>
        
        <tr>
            <th>Email:</th>
            <td>{{ $users->email }}</td>
        </tr>
        
        <tr>
            <th>Password:</th>
            <td>{{ $users->password }}</td>
        </tr>
        
        <tr>
            <th>Key:</th>
            <td>{{ $users->key }}</td>
        </tr>
        
        <tr>
            <th>Code:</th>
            <td>{{ $users->code }}</td>
        </tr>
        
        <tr>
            <th>Phone:</th>
            <td>{{ $users->phone }}</td>
        </tr>
        
        <tr>
            <th>Role Id:</th>
            <td>{{ $users->role_id }}</td>
        </tr>
        
        <tr>
            <th>Sponsor Id:</th>
            <td>{{ $users->sponsor_id }}</td>
        </tr>
        
        <tr>
            <th>Mobile Plan Id:</th>
            <td>{{ $users->mobile_plan_id }}</td>
        </tr>
        
        <tr>
            <th>Min Commission:</th>
            <td>{{ $users->min_commission }}</td>
        </tr>
        
    </table>
</div>
@stop
