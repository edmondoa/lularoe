@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New Product</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-6">
		    {{ Form::open(array('url' => 'products')) }}
		
			    
			    <div class="form-group">
			        {{ Form::label('name', 'Name') }}
			        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('blurb', 'Blurb') }}
			        {{ Form::textarea('blurb', Input::old('blurb'), array('class' => 'wysiwyg form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('description', 'Description') }}
			        {{ Form::textarea('description', Input::old('description'), array('class' => 'wysiwyg form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('price', 'Price') }}
			        {{ Form::text('price', Input::old('price'), array('class' => 'form-control width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('quantity', 'Quantity') }}
			        {{ Form::text('quantity', Input::old('quantity'), array('class' => 'form-control width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('category_id', 'Category Id') }}
			        {{ Form::text('category_id', Input::old('category_id'), array('class' => 'form-control width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('disabled', 'Disabled') }}
			        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control width-auto')) }}
			    </div>
			    
		
			    {{ Form::submit('Add Product', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop