@section('content')
<div class="row">
    <h1>All Roles</h1>
    <a class="btn btn-success" href="{{ url('roles/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Name</th>
        </thead>
        <tbody>
        @foreach($roles as $roles)
        <tr>
            
            <td>
                <a href="{{ url('roles/'.$roles->id) }}">{{ $roles->name }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
