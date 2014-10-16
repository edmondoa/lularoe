@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/carts">&lsaquo; Back</a>
	    <h2>Edit cart</h2>
	    {{ Form::model($cart, array('route' => array('cart.update', $cart->id), 'method' => 'PUT')) }}
	
	    
	    <div class="form-group">
	        {{ Form::label('product_id', 'Product Id') }}
	        {{ Form::text('product_id', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('disabled', 'Disabled') }}
	        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
	    </div>
	    
	
	    {{ Form::submit('Update Cart', array('class' => 'btn btn-success')) }}
	
	    {{Form::close()}}
	</div>
</div>
@stop

