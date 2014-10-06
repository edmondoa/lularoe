@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing content</h1>
    <a class="btn btn-primary" href="{{ url('content/'.$content->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'content/' . $content->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Page Id:</th>
            <td>{{ $content->page_id }}</td>
        </tr>
        
        <tr>
            <th>Section:</th>
            <td>{{ $content->section }}</td>
        </tr>
        
        <tr>
            <th>Content:</th>
            <td>{{ $content->content }}</td>
        </tr>
        
    </table>
</div>
@stop
