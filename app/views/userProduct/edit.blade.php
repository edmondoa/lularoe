@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/userProducts">&lsaquo; Back</a>
	    <h2>Edit userProduct</h2>
	    {{ Form::model($userProduct, array('route' => array('userProduct.update', $userProduct->id), 'method' => 'PUT')) }}
	
	    
	    <div class="form-group">
	        {{ Form::label('product_id', 'Product Id') }}
	        {{ Form::text('product_id', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('disabled', 'Disabled') }}
	        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
	    </div>
	    
	
	    {{ Form::submit('Update UserProduct', array('class' => 'btn btn-success')) }}
	
	    {{Form::close()}}
	</div>
</div>
@stop

