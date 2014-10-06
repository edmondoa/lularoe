@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing levels</h1>
    <a class="btn btn-primary" href="{{ url('levels/'.$levels->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'levels/' . $levels->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>User Id:</th>
            <td>{{ $levels->user_id }}</td>
        </tr>
        
        <tr>
            <th>Ancestor Id:</th>
            <td>{{ $levels->ancestor_id }}</td>
        </tr>
        
        <tr>
            <th>Level:</th>
            <td>{{ $levels->level }}</td>
        </tr>
        
    </table>
</div>
@stop
