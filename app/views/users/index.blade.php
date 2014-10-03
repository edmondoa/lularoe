@section('content')
<div class="row">
    <h1>All Users</h1>
    <a class="btn btn-success" href="{{ url('users/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>First</th><th>Last</th><th>Email</th><th>Password</th>
        </thead>
        <tbody>
        @foreach($users as $users)
        <tr>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->first }}</a>
            </td>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->last }}</a>
            </td>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->email }}</a>
            </td>
            
            <td>
                <a href="{{ url('users/'.$users->id) }}">{{ $users->password }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
