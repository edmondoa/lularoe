@section('content')
<div class="row">
    <h1>All Levels</h1>
    <a class="btn btn-success" href="{{ url('levels/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>User Id</th><th>Ancestor Id</th><th>Level</th>
        </thead>
        <tbody>
        @foreach($levels as $levels)
        <tr>
            
            <td>
                <a href="{{ url('levels/'.$levels->id) }}">{{ $levels->user_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('levels/'.$levels->id) }}">{{ $levels->ancestor_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('levels/'.$levels->id) }}">{{ $levels->level }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
