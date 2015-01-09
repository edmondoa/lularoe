@extends('layouts.default')
@section('content')
<div class="create">
<<<<<<< HEAD
<<<<<<< HEAD
	{{ Form::open(array('url' => 'products', 'files' => true)) }}
		<div class="row">
			<div class="col col-md-12">
				@include('_helpers.breadcrumbs')
			    <h1 class="no-top">New Product</h1>
			</div>
		</div>
		<div class="row">
			<div class="col col-lg-6">			    
=======
=======
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New Product</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-6">
		    {{ Form::open(array('url' => 'products')) }}
		
				<button data-toggle="modal" data-target="#media-library" type="button" class="btn btn-default" id="media-library"><i class="fa fa-th-large"></i> Media Library</button>
						    
<<<<<<< HEAD
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
=======
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
			    <div class="form-group">
			        {{ Form::label('name', 'Name') }}
			        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
<<<<<<< HEAD
<<<<<<< HEAD
			        {{ Form::label('blurb', 'Brief Description') }}
=======
			        {{ Form::label('blurb', 'Blurb') }}
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
=======
			        {{ Form::label('blurb', 'Blurb') }}
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
			        {{ Form::textarea('blurb', Input::old('blurb'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
<<<<<<< HEAD
<<<<<<< HEAD
			        {{ Form::label('description', 'Long Description') }}
			        {{ Form::textarea('description', Input::old('description'), array('class' => 'wysiwyg form-control')) }}
			    </div>
			</div><!-- col -->
		</div><!-- row -->
		<div class="row">
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
				    
					<div class="form-group">
						{{ Form::label('image', 'Upload Image') }}
						{{ Form::file('image', null, array('class' => 'form-control')) }}
					</div>
					
					<div class="form-group">
						{{ Form::label('name', 'Or Choose from Media Library') }}
						<div class="input-group">
							<span class="input-group-btn">
								<button data-toggle="modal" data-target="#mediaLibrary" type="button" class="btn btn-default" id="media-library">
									<i class="fa fa-th-large"></i>
								</button>
							</span>
							{{ Form::text('image_url', null, array('class' => 'form-control inline-block', 'id' => 'image_url')) }}
						</div>
					</div>
				    
				    <div class="form-group">
				        {{ Form::label('price', 'Price') }}
				        <div class="input-group">
				        	<span class="input-group-addon">$</span>
				        	{{ Form::text('price', Input::old('price'), array('class' => 'form-control')) }}
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
				    <br>
				    {{ Form::submit('Add Product', array('class' => 'btn btn-primary')) }}
		
		    </div>
		</div>
	{{ Form::close() }}
</div>
@stop
@section('modals')
	@include('_helpers.modals')
=======
=======
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
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
<<<<<<< HEAD
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
=======
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
@stop