@section('content')
<div class="row">
    <h1>All UserRanks</h1>
    <a class="btn btn-success" href="{{ url('userRanks/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>User Id</th><th>Rank Id</th>
        </thead>
        <tbody>
        @foreach($userRanks as $userRanks)
        <tr>
            
            <td>
                <a href="{{ url('userRanks/'.$userRanks->id) }}">{{ $userRanks->user_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('userRanks/'.$userRanks->id) }}">{{ $userRanks->rank_id }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
