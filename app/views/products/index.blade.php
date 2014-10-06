@section('content')
<div class="row">
    <h1>All Products</h1>
    <a class="btn btn-success" href="{{ url('products/create') }}">New</a>
</div>
<div class="row">
    <table class="table">
        <thead>
        <th>Name</th><th>Blurb</th><th>Description</th><th>Price</th><th>Quantity</th>
        </thead>
        <tbody>
        @foreach($products as $products)
        <tr>
            
            <td>
                <a href="{{ url('products/'.$products->id) }}">{{ $products->name }}</a>
            </td>
            
            <td>
                <a href="{{ url('products/'.$products->id) }}">{{ $products->blurb }}</a>
            </td>
            
            <td>
                <a href="{{ url('products/'.$products->id) }}">{{ $products->description }}</a>
            </td>
            
            <td>
                <a href="{{ url('products/'.$products->id) }}">{{ $products->price }}</a>
            </td>
            
            <td>
                <a href="{{ url('products/'.$products->id) }}">{{ $products->quantity }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop
