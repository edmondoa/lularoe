@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a href="{{ URL::previous() }}">&lsaquo; Back</a>
	    <h1 class="no-top">Viewing product</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('product/'.$product->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($product->disabled == 0)
			    {{ Form::open(array('url' => 'product/' . $product->id, 'method' => 'DISABLE', 'class' => 'btn btn-default')) }}
			    	<button class="btn btn-default" title="Click to Disable"><i class="fa fa-eye"></i></button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'product/' . $product->id, 'method' => 'ENABLE', 'class' => 'btn btn-default')) }}
			    	<button class="btn btn-default" title="Click to Enable"><i class="fa fa-eye"></i></button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'product/' . $product->id, 'method' => 'DELETE', 'class' => 'btn btn-default')) }}
		    	<button title="Delete"><i class="fa fa-trash"></i></button>
		    {{ Form::close() }}
		</div>
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
	            <th>Category Id:</th>
	            <td>{{ $product->category_id }}</td>
	        </tr>
	        
	        <tr>
	            <th>Disabled:</th>
	            <td>{{ $product->disabled }}</td>
	        </tr>
	        
	    </table>
    </div>
</div>
@stop
