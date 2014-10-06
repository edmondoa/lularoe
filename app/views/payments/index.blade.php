@section('content')
<div class="row">
    <h1>All Payments</h1>
    <a class="btn btn-success" href="{{ url('payments/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>User Id</th><th>Transaction Id</th><th>Amount</th><th>Tender</th><th>Details</th>
        </thead>
        <tbody>
        @foreach($payments as $payments)
        <tr>
            
            <td>
                <a href="{{ url('payments/'.$payments->id) }}">{{ $payments->user_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('payments/'.$payments->id) }}">{{ $payments->transaction_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('payments/'.$payments->id) }}">{{ $payments->amount }}</a>
            </td>
            
            <td>
                <a href="{{ url('payments/'.$payments->id) }}">{{ $payments->tender }}</a>
            </td>
            
            <td>
                <a href="{{ url('payments/'.$payments->id) }}">{{ $payments->details }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
