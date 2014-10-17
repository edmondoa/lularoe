@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/carts">&lsaquo; Back</a>
	    <h1 class="no-top">Viewing cart</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('cart/'.$cart->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($cart->disabled == 0)
			    {{ Form::open(array('url' => 'cart/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $cart->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'cart/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $cart->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'carts/' . $cart->id, 'method' => 'DELETE')) }}
		    	<button class="btn btn-default" title="Delete">
		    		<i class="fa fa-trash" title="Delete"></i>
		    	</button>
		    {{ Form::close() }}
		</div>
		<br>
		<br>
	    <table class="table">
	        
	        <tr>
	            <th>Product Id:</th>
	            <td>{{ $cart->product_id }}</td>
	        </tr>
	        
	        <tr>
	            <th>Disabled:</th>
	            <td>{{ $cart->disabled }}</td>
	        </tr>
	        
	    </table>
    </div>
</div>
@stop
