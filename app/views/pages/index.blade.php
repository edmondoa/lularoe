@section('content')
<div class="row">
    <h1>All Pages</h1>
    <a class="btn btn-success" href="{{ url('pages/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Name</th><th>Url</th><th>Type</th><th>Opportunity</th>
        </thead>
        <tbody>
        @foreach($pages as $pages)
        <tr>
            
            <td>
                <a href="{{ url('pages/'.$pages->id) }}">{{ $pages->name }}</a>
            </td>
            
            <td>
                <a href="{{ url('pages/'.$pages->id) }}">{{ $pages->url }}</a>
            </td>
            
            <td>
                <a href="{{ url('pages/'.$pages->id) }}">{{ $pages->type }}</a>
            </td>
            
            <td>
                <a href="{{ url('pages/'.$pages->id) }}">{{ $pages->opportunity }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
