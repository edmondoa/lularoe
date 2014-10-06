@section('content')
<div class="row">
    <h1>All Sales</h1>
    <a class="btn btn-success" href="{{ url('sales/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Product Id</th><th>User Id</th><th>Sponsor Id</th><th>Quantity</th>
        </thead>
        <tbody>
        @foreach($sales as $sales)
        <tr>
            
            <td>
                <a href="{{ url('sales/'.$sales->id) }}">{{ $sales->product_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('sales/'.$sales->id) }}">{{ $sales->user_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('sales/'.$sales->id) }}">{{ $sales->sponsor_id }}</a>
            </td>
            
            <td>
                <a href="{{ url('sales/'.$sales->id) }}">{{ $sales->quantity }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
