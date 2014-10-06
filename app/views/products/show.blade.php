@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing products</h1>
    <a class="btn btn-primary" href="{{ url('products/'.$products->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'products/' . $products->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Name:</th>
            <td>{{ $products->name }}</td>
        </tr>
        
        <tr>
            <th>Blurb:</th>
            <td>{{ $products->blurb }}</td>
        </tr>
        
        <tr>
            <th>Description:</th>
            <td>{{ $products->description }}</td>
        </tr>
        
        <tr>
            <th>Price:</th>
            <td>{{ $products->price }}</td>
        </tr>
        
        <tr>
            <th>Quantity:</th>
            <td>{{ $products->quantity }}</td>
        </tr>
        
    </table>
</div>
@stop
