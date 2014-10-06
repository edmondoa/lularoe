@section('content')
<div class="row">
    <h1>All Users</h1>
    <a class="btn btn-success" href="{{ url('users/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>First Name</th><th>Last Name</th><th>Email</th><th>Password</th><th>Key</th><th>Code</th><th>Phone</th><th>Role Id</th><th>Sponsor Id</th><th>Mobile Plan Id</th><th>Min Commission</th>
        </thead>
        <tbody>
        @foreach($users as $users)
        <tr>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->first_name }}</a>
            </td>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->last_name }}</a>
            </td>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->email }}</a>
            </td>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->password }}</a>
            </td>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->key }}</a>
            </td>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->code }}</a>
            </td>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->phone }}</a>
            </td>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->role_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->sponsor_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->mobile_plan_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->min_commission }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
