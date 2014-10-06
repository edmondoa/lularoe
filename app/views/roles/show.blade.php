@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing roles</h1>
    <a class="btn btn-primary" href="{{ url('roles/'.$roles->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'roles/' . $roles->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Name:</th>
            <td>{{ $roles->name }}</td>
        </tr>
        
    </table>
</div>
@stop
