@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing ranks</h1>
    <a class="btn btn-primary" href="{{ url('ranks/'.$ranks->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'ranks/' . $ranks->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Name:</th>
            <td>{{ $ranks->name }}</td>
        </tr>
        
    </table>
</div>
@stop
