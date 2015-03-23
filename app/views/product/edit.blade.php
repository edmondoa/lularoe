@extends('layouts.default')
@section('content')
<div class="edit">
	{{ Form::model($product, array('route' => array('products.update', $product->id), 'method' => 'PUT', 'files' => true)) }}
		<div class="row">
			<div class="col col-md-12">
				@include('_helpers.breadcrumbs')
			    <h1>Edit inventory</h1>
				</div>
			</div>
			<div class="row">
				<div class="col col-lg-6">			    
				    <div class="form-group">
				        {{ Form::label('name', 'Name') }}
				        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
				    </div>
				    
<!--
				    <div class="form-group">
				        {{ Form::label('blurb', 'Brief Description') }}
				        {{ Form::textarea('blurb', Input::old('blurb'), array('class' => 'form-control')) }}
				    </div>
				    
				    <div class="form-group">
				        {{ Form::label('description', 'Long Description') }}
				        {{ Form::textarea('description', Input::old('description'), array('class' => 'wysiwyg form-control')) }}
				    </div>
-->
				</div><!-- col -->
			</div><!-- row -->
			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
			
					<div class="form-group">
						<label>Images</label>
						<ul id="image-list" class="list-group no-bottom">
							@foreach ($attachment_images as $attachment_image)
					    		<li class="list-group-item">
					    			<input type="hidden" name="images[{{ $attachment_image->id }}][attachment_id]" value="{{ $attachment_image->attachment_id }}">
					    			<div class="display-table width-full">
										<div class="btn-group table-cell">
											<img src="/uploads/{{ $attachment_image->url }}" class="thumb-md">
								    	</div>
										<div class="table-cell" style="vertical-align:top;"><i data-attachment-id="{{ $attachment_image->attachment_id }}" class="fa fa-times removeImage pull-right removeImage"></i></div>
									</div>
									<label class="margin-top-2">
										<input type="radio" <?php if ($attachment_image->featured == 1) echo 'checked' ?> name="images[{{ $attachment_image->id }}][featured]">
										&nbsp;Featured Image
									</label>
					    		</li>
							@endforeach
						</ul>
						<button type="button" class="btn btn-default margin-top-2" id="add-image"><i class="fa fa-plus"></i> Add Image</button>
					</div>
				    
				    <div class="form-group">
				        {{ Form::label('make', 'Make') }}
				        {{ Form::text('make', null, array('class' => 'form-control')) }}
				    </div>
	
				    <div class="form-group">
				        {{ Form::label('model', 'Model') }}
				        {{ Form::text('model', null, array('class' => 'form-control')) }}
				    </div>
					
				    <div class="form-group">
				        {{ Form::label('size', 'Size') }}
				        {{ Form::text('size', null, array('class' => 'form-control')) }}
				    </div>
				    
<!--
				    <div class="form-group">
				        {{ Form::label('retail_price', 'Retail Price') }}
				        <div class="input-group">
				        	<span class="input-group-addon">$</span>
				        	{{ Form::text('retail_price', Input::old('retail_price'), array('class' => 'form-control')) }}
				        </div>
				    </div>
-->				    
				    <div class="form-group">
				        {{ Form::label('rep_price', 'Retail Price') }}
				        <div class="input-group">
				        	<span class="input-group-addon">$</span>
				        	{{ Form::text('rep_price', Input::old('rep_price'), array('class' => 'form-control')) }}
				        </div>
				    </div>
				    
				    <div class="form-group">
				        {{ Form::label('quantity', 'Quantity') }}
				        {{ Form::text('quantity', Input::old('quantity'), array('class' => 'form-control')) }}
				    </div>
					<input type="hidden" name="category_id" value="0">
				    
<!--
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
				    	<div class="tag-list">
				    		@foreach ($tags as $tag)
								<span class="label label-default">
									{{ $tag->name }} &nbsp;
									<i class="fa fa-times removeTag" data-tag-id="{{ $tag->id }}"></i>
								</span>
				    		@endforeach
				    	</div>
			        </div>
-->
				    
				    <div class="form-group">
				        {{ Form::label('disabled', 'Status') }}
				        <br>
				    	{{ Form::select('disabled', [
				    		0 => 'Active',
				    		1 => 'Disabled'
				    	], null, ['class' => 'form-control']) }}
				    </div>
	
			    	{{ Form::submit('Update Inventory', array('class' => 'btn btn-primary')) }}
			
			</div>
		</div>
	{{Form::close()}}
</div>
@stop
@section('modals')
	@include('_helpers.wysiwyg_modals')
@stop
@section('scripts')
	<script>
		var product_id = {{ $product->id }};
		var attachment_images_count = {{ $attachment_images_count }};
	</script>
@stop
