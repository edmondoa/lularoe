@section('content')
<div class="row">
    <h1>All Products</h1>
    <a class="btn btn-success" href="{{ url('product/create') }}">New</a>
    {{ Form::open(array('url' => 'products/' . 0, 'method' => 'POST')) }}
    <div class='input-group'>
        <select class="form-control selectpicker actions">
	    	<option value="product/disable" selected>Disable</option>
	    	<option value="product/enable" selected>Enable</option>
	    	<option value="product/delete" selected>Delete</option>
        </select>
        <div class='input-group-btn'>
        	<button class="btn btn-default applyAction" disabled><i class='fa fa-check'></i></button>
        </div>
    </div>
</div>
<div class="row">
    <table class="table">
        <thead>
        	<tr>
        		<th><input type="checkbox"></th>
        		<th>Name</th><th>Blurb</th><th>Description</th><th>Price</th><th>Quantity</th><th>Disabled</th>
        	</tr>
        </thead>
        <tbody>
        @foreach($products as $product)
        <tr>
            <td><input class="bulk-check" type="checkbox" name="ids[]" value="{{ $product->id }}"></td>
            
            <td>
                <a href="{{ url('product/'.$product->id) }}">{{ $product->name }}</a>
            </td>
            
            <td>
                <a href="{{ url('product/'.$product->id) }}">{{ $product->blurb }}</a>
            </td>
            
            <td>
                <a href="{{ url('product/'.$product->id) }}">{{ $product->description }}</a>
            </td>
            
            <td>
                <a href="{{ url('product/'.$product->id) }}">{{ $product->price }}</a>
            </td>
            
            <td>
                <a href="{{ url('product/'.$product->id) }}">{{ $product->quantity }}</a>
            </td>
            
            <td>
                <a href="{{ url('product/'.$product->id) }}">{{ $product->disabled }}</a>
            </td>
            
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ Form::close() }}
</div>
@stop
