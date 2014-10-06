@section('content')
<div class="row">
    <h1>All Bonuses</h1>
    <a class="btn btn-success" href="{{ url('bonuses/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>User Id</th><th>Eight In Eight</th><th>Twelve In Twelve</th>
        </thead>
        <tbody>
        @foreach($bonuses as $bonuses)
        <tr>
            
            <td>
                <a href="{{ url('bonuses/'.$bonuses->id) }}">{{ $bonuses->user_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('bonuses/'.$bonuses->id) }}">{{ $bonuses->eight_in_eight }}</a>
            </td>
            
            <td>
                <a href="{{ url('bonuses/'.$bonuses->id) }}">{{ $bonuses->twelve_in_twelve }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
