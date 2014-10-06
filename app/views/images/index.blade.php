@section('content')
<div class="row">
    <h1>All Images</h1>
    <a class="btn btn-success" href="{{ url('images/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Type</th><th>Url</th>
        </thead>
        <tbody>
        @foreach($images as $images)
        <tr>
            
            <td>
                <a href="{{ url('images/'.$images->id) }}">{{ $images->type }}</a>
            </td>
            
            <td>
                <a href="{{ url('images/'.$images->id) }}">{{ $images->url }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
