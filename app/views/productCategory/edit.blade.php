@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1>Edit Product Category</h1>
		    {{ Form::model($productCategory, array('route' => array('productCategories.update', $productCategory->id), 'method' => 'PUT')) }}
		    
                <div class="form-group">
                    {{ Form::label('name', 'Name') }}
                    {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                </div>
                 
                <!-- <div class="form-group">
                    {{ Form::label('parent_id', 'Parent Category') }}
                    {{ Form::select('parent_id', $selectCategories, null, ['class' => 'form-control']) }}
                </div> -->
                 
                <!-- <div class="form-group">
                    {{ Form::label('disabled', 'Status') }}
                    <br>
                    {{ Form::select('disabled', [
                        0 => 'Active',
                        1 => 'Disabled'
                    ], null, ['class' => 'selectpicker form-control width-auto']) }}
                </div> -->
		
		    {{ Form::submit('Update Product Category', array('class' => 'btn btn-primary')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

