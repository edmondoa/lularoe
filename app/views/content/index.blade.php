@section('content')
<div class="row">
    <h1>All Contents</h1>
    <a class="btn btn-success" href="{{ url('content/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Page Id</th><th>Section</th><th>Content</th>
        </thead>
        <tbody>
        @foreach($contents as $content)
        <tr>
            
            <td>
                <a href="{{ url('content/'.$content->id) }}">{{ $content->page_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('content/'.$content->id) }}">{{ $content->section }}</a>
            </td>
            
            <td>
                <a href="{{ url('content/'.$content->id) }}">{{ $content->content }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
