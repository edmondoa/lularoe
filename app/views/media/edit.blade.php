@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1>Edit Asset</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-3 col-md-4 col-sm-6">
		    {{ Form::model($media, array('route' => array('media.update', $media->id), 'method' => 'PUT', 'files' => true)) }}
		
                <div class="form-group">
                    <input type="file" name="media">
                    <!-- <small>Max Media Size: 1M</small> -->
                </div>
                
                <div class="form-group">
                	{{ Form::label('title', 'Title') }}
                	{{ Form::text('title', null, ['class' => 'form-control']) }}
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
						{{ Form::text('', '', ['class' => 'form-control tagger new', 'onclick' => 'disableEnterKey(event)']) }}
						<div class='input-group-btn'>
							<button type="button" class="btn btn-default addTag"><i class='fa fa-plus'></i></button>
			            </div>
			    	</div>
			    	<div class="tag-list">
			    		@foreach ($assigned_tags as $assigned_tag)
							<span class="label label-default">
								{{ $assigned_tag->name }} &nbsp;
								<i class="fa fa-times removeTag" data-tag-id="{{ $assigned_tag->id }}"></i>
							</span>
			    		@endforeach
			    	</div>
		        </div>
                
                @if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
	                <div class="form-group">
	                	<label>
	                		{{ Form::checkbox('reps') }} Share with FC's
	                	</label>
	                </div>
	            @endif
		    
		    {{ Form::submit('Update Asset', array('class' => 'btn btn-primary')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

