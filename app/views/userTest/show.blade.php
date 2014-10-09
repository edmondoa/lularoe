@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing userTest</h1>
    <a class="btn btn-primary" href="{{ url('userTest/'.$userTest->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'userTest/' . $userTest->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>First Name:</th>
            <td>{{ $userTest->first_name }}</td>
        </tr>
        
        <tr>
            <th>Last Name:</th>
            <td>{{ $userTest->last_name }}</td>
        </tr>
        
        <tr>
            <th>Email:</th>
            <td>{{ $userTest->email }}</td>
        </tr>
        
        <tr>
            <th>Password:</th>
            <td>{{ $userTest->password }}</td>
        </tr>
        
        <tr>
            <th>Gender:</th>
            <td>{{ $userTest->gender }}</td>
        </tr>
        
        <tr>
            <th>Key:</th>
            <td>{{ $userTest->key }}</td>
        </tr>
        
        <tr>
            <th>Code:</th>
            <td>{{ $userTest->code }}</td>
        </tr>
        
        <tr>
            <th>Dob:</th>
            <td>{{ $userTest->dob }}</td>
        </tr>
        
        <tr>
            <th>Phone:</th>
            <td>{{ $userTest->phone }}</td>
        </tr>
        
        <tr>
            <th>Role Id:</th>
            <td>{{ $userTest->role_id }}</td>
        </tr>
        
        <tr>
            <th>Sponsor Id:</th>
            <td>{{ $userTest->sponsor_id }}</td>
        </tr>
        
        <tr>
            <th>Mobile Plan Id:</th>
            <td>{{ $userTest->mobile_plan_id }}</td>
        </tr>
        
        <tr>
            <th>Min Commission:</th>
            <td>{{ $userTest->min_commission }}</td>
        </tr>
        
        <tr>
            <th>Disabled:</th>
            <td>{{ $userTest->disabled }}</td>
        </tr>
        
    </table>
</div>
@stop
