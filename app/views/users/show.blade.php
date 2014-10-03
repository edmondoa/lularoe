@section('content')
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
            <td>First:</td>
            <td>{{ $users->first }}</td>
        </tr>
        
        <tr>
            <td>Last:</td>
            <td>{{ $users->last }}</td>
        </tr>
        
        <tr>
            <td>Email:</td>
            <td>{{ $users->email }}</td>
        </tr>
        
        <tr>
            <td>Password:</td>
            <td>{{ $users->password }}</td>
        </tr>
        
    </table>
</div>
@stop
