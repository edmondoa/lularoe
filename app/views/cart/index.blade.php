@section('content')
<div class="row">
    <h1>All Carts</h1>
    <a class="btn btn-success" href="{{ url('cart/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Product Id</th>
        </thead>
        <tbody>
        @foreach($carts as $cart)
        <tr>
            
            <td>
                <a href="{{ url('cart/'.$cart->id) }}">{{ $cart->product_id }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
