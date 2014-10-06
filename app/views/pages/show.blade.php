@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing pages</h1>
    <a class="btn btn-primary" href="{{ url('pages/'.$pages->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'pages/' . $pages->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Name:</th>
            <td>{{ $pages->name }}</td>
        </tr>
        
        <tr>
            <th>Url:</th>
            <td>{{ $pages->url }}</td>
        </tr>
        
        <tr>
            <th>Type:</th>
            <td>{{ $pages->type }}</td>
        </tr>
        
        <tr>
            <th>Opportunity:</th>
            <td>{{ $pages->opportunity }}</td>
        </tr>
        
    </table>
</div>
@stop
