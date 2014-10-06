@section('content')
<div class="row">
    <h1>All Commissions</h1>
    <a class="btn btn-success" href="{{ url('commissions/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>User Id</th><th>Amount</th><th>Description</th>
        </thead>
        <tbody>
        @foreach($commissions as $commissions)
        <tr>
            
            <td>
                <a href="{{ url('commissions/'.$commissions->id) }}">{{ $commissions->user_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('commissions/'.$commissions->id) }}">{{ $commissions->amount }}</a>
            </td>
            
            <td>
                <a href="{{ url('commissions/'.$commissions->id) }}">{{ $commissions->description }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
