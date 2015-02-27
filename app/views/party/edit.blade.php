@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-lg-4 col-md-6">
			@include('_helpers.breadcrumbs')
		    <h1>Edit party</h1>
		    {{ Form::model($party, array('route' => array('parties.update', $party->id), 'method' => 'PUT')) }}
		
			    <div class="form-group">
			        {{ Form::label('name', 'Name') }}
			        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('description', 'Description') }}
			        {{ Form::textarea('description', Input::old('description'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('date_start', 'Starting Time') }}
			        {{ Form::text('date_start', Input::old('date_start'), array('class' => 'form-control datepicker width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('date_end', 'Ending Time') }}
			        {{ Form::text('date_end', Input::old('date_end'), array('class' => 'form-control datepicker width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			    	{{ Form::label('timezone', 'Time Zone') }}
					{{ Timezone::selectForm($party->timezone, null, ['id' => 'timezone', 'name' => 'timezone', 'class' => 'form-control width-auto']) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('label', 'Address Description') }}
			        {{ Form::text('label', Input::old('label'), array('class' => 'form-control', 'placeholder' => 'Ex: The John and Jane Doe Residence')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('address_1', 'Address Line 1') }}
			        {{ Form::text('address_1', Input::old('address_1'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('address_2', 'Address Line 2') }}
			        {{ Form::text('address_2', Input::old('address_2'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('city', 'City') }}
			        {{ Form::text('city', Input::old('city'), array('class' => 'form-control width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('state', 'State') }}
			        <br>
			        {{ Form::select('state',State::orderBy('full_name')->lists('full_name', 'abbr'), null, array('class' => 'form-control width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('zip', 'Zip') }}
			        {{ Form::text('zip', Input::old('zip'), array('class' => 'form-control width-auto')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('public', 'Party Visibility') }}
		   			{{ Form::select('public', [
		   				'0' => 'Limit to people I or my guests invite',
		   				'1' => 'Display publicly',
		   			], null, array('class' => 'form-control width-auto')) }}
			    </div>	    
		
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
		
		    {{ Form::submit('Update party', array('class' => 'btn btn-primary')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop
@section('modals')
	@include('_helpers.wysiwyg_modals')
@stop
@section('scripts')
	<script>
		var product_id = {{ $party->id }};
		var attachment_images_count = {{ $attachment_images_count }};
	</script>
@stop