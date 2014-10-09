@section('content')
<div class="row">
	<a href="{{ URL::previous() }}">&lsaquo; Back</a>
</div>
<div class="row">
    <h1>Viewing product</h1>
    <a class="btn btn-primary" href="{{ url('product/'.$product->id .'/edit') }}">Edit</a>
    {{ Form::open(array('url' => 'product/' . $product->id, 'method' => 'DELETE')) }}
    {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
    {{ Form::close() }}
</div>
<div class="row">
    <table class="table">
        
        <tr>
            <th>Name:</th>
            <td>{{ $product->name }}</td>
        </tr>
        
        <tr>
            <th>Blurb:</th>
            <td>{{ $product->blurb }}</td>
        </tr>
        
        <tr>
            <th>Description:</th>
            <td>{{ $product->description }}</td>
        </tr>
        
        <tr>
            <th>Price:</th>
            <td>{{ $product->price }}</td>
        </tr>
        
        <tr>
            <th>Quantity:</th>
            <td>{{ $product->quantity }}</td>
        </tr>
        
        <tr>
            <th>Disabled:</th>
            <td>{{ $product->disabled }}</td>
        </tr>
        
    </table>
</div>
@stop
