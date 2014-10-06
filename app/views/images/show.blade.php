@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing images</h1>
    <a class="btn btn-primary" href="{{ url('images/'.$images->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'images/' . $images->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Type:</th>
            <td>{{ $images->type }}</td>
        </tr>
        
        <tr>
            <th>Url:</th>
            <td>{{ $images->url }}</td>
        </tr>
        
    </table>
</div>
@stop
