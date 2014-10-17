@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			<div class="breadcrumbs">
				<a href="/carts">&lsaquo; Back</a>
			</div>
		    <h1>Edit cart</h1>
		    {{ Form::model($cart, array('route' => array('carts.update', $cart->id), 'method' => 'PUT')) }}
		
		    
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
</div>
@stop

