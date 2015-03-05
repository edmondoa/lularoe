@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">Upload Asset</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-3 col-md-4 col-sm-6">
		    {{ Form::open(array('url' => 'media', 'files' => true)) }}
			    
                <div class="form-group">
                    <input type="file" name="media">
                    <!-- <small>Max Media Size: 1M</small> -->
                </div>
                
                <div class="form-group">
                	{{ Form::label('title', 'Title') }}
                	{{ Form::text('title', null, ['class' => 'form-control', 'onclick' => 'disableEnterKey(event)']) }}
                </div>
                
                <div class="form-group">
                	{{ Form::label('description', 'Description') }}
                	{{ Form::textarea('description', null, ['class' => 'form-control']) }}
                </div>
                
			    <div class="form-group">
					{{ Form::label('tags', 'Existing Tags') }}
			    	<div class="input-group margin-bottom-2">
						<select class="form-control tagger">
							@foreach ($tags as $tag)
								<option>{{ $tag->name }}</option>
							@endforeach
						</select>
						<div class='input-group-btn'>
							<button type="button" class="btn btn-default addTag"><i class='fa fa-plus'></i></button>
			            </div>
			    	</div>
					{{ Form::label('tags', 'New Tag') }}
			    	<div class="input-group">
						{{ Form::text('', '', ['class' => 'form-control tagger new']) }}
						<div class='input-group-btn'>
							<button type="button" class="btn btn-default addTag"><i class='fa fa-plus'></i></button>
			            </div>
			    	</div>
			    	<div class="tag-list"></div>
		        </div>
                
                @if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
	                <div class="form-group">
	                	<label>
	                		{{ Form::checkbox('reps', null, ['checked' => 'checked']) }} Share with FC's
	                	</label>
	                </div>
	            @endif
		
			    {{ Form::submit('Upload Asset', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop
