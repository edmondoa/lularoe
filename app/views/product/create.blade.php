@extends('layouts.default')
@section('content')
<div class="create">
	{{ Form::open(array('url' => 'products', 'files' => true)) }}
		<div class="row">
			<div class="col col-md-12">
				@include('_helpers.breadcrumbs')
			    <h1 class="no-top">New Product</h1>
			</div>
		</div>
		<div class="row">
			<div class="col col-lg-6">			
				    		    
			    <div class="form-group">
			        {{ Form::label('name', 'Name') }}
			        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			    </div>
	    
			    <div class="form-group">
			        {{ Form::label('blurb', 'Brief Description') }}
			        {{ Form::textarea('blurb', Input::old('blurb'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('description', 'Long Description') }}
			        {{ Form::textarea('description', Input::old('description'), array('class' => 'wysiwyg form-control')) }}
			    </div>
			    
			</div><!-- col -->
		</div><!-- row -->
		<div class="row">
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
				
				<div class="form-group">
					<label>Images</label>
					<ul id="image-list" class="list-group no-bottom"></ul>
					<button type="button" class="btn btn-default margin-top-2" id="add-image"><i class="fa fa-plus"></i> Add Image</button>
				</div>
			    
			    <div class="form-group">
			        {{ Form::label('retail_price', 'Retail Price') }}
			        <div class="input-group">
			        	<span class="input-group-addon">$</span>
			        	{{ Form::text('retail_price', Input::old('retail_price'), array('class' => 'form-control')) }}
			        </div>
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('rep_price', 'Rep Price') }}
			        <div class="input-group">
			        	<span class="input-group-addon">$</span>
			        	{{ Form::text('rep_price', Input::old('rep_price'), array('class' => 'form-control')) }}
			        </div>
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('quantity', 'Quantity') }}
			        {{ Form::text('quantity', Input::old('quantity'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			    	{{ Form::label('category_id', 'Category') }}
			    	<br>
			    	{{ Form::select('category_id', $selectCategories, null, ['class' => 'form-control']) }}
			    </div>
			    
			    <div class="form-group">
					{{ Form::label('tags', 'Tags') }}
			    	<div class="input-group">
						{{ Form::text('', '', ['class' => 'form-control','id' =>'tagger']) }}
						<div class='input-group-btn'>
							<button type="button" class='btn btn-default' id="addTag"><i class='fa fa-plus'></i></button>
			            </div>
			    	</div>
			    	<div class="tag-list"></div>
		        </div>
			    
			    <div class="form-group">
			        {{ Form::label('disabled', 'Status') }}
			        <br>
			    	{{ Form::select('disabled', [
			    		0 => 'Active',
			    		1 => 'Disabled'
			    	], null, ['class' => 'form-control']) }}
			    </div>
			    
			    {{ Form::submit('Add Product', array('class' => 'btn btn-primary')) }}
		
		    </div>
		</div>
	{{ Form::close() }}
</div>
@stop
@section('modals')
	@include('_helpers.wysiwyg_modals')
@stop
@section('scripts')
	<script>
		var product_id = 0;
		var attachment_images_count = 0;
	</script>
@stop