@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/productCategories">&lsaquo; Back</a>
	    <h2>Edit productCategory</h2>
	    {{ Form::model($productCategory, array('route' => array('productCategory.update', $productCategory->id), 'method' => 'PUT')) }}
	
	    
	    <div class="form-group">
	        {{ Form::label('name', 'Name') }}
	        {{ Form::text('name', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('disabled', 'Disabled') }}
	        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
	    </div>
	    
	
	    {{ Form::submit('Update ProductCategory', array('class' => 'btn btn-success')) }}
	
	    {{Form::close()}}
	</div>
</div>
@stop

