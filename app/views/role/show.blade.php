@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing role</h1>
    <a class="btn btn-primary" href="{{ url('role/'.$role->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'role/' . $role->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Name:</th>
            <td>{{ $role->name }}</td>
        </tr>
        
        <tr>
            <th>Disabled:</th>
            <td>{{ $role->disabled }}</td>
        </tr>
        
    </table>
</div>
@stop
