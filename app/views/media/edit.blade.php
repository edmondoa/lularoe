@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1>Edit Resource</h1>
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
                
                @if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
	                <div class="form-group">
	                	<label>
	                		{{ Form::checkbox('reps') }} Share with {{ Config::get('site.rep_title') }}
	                	</label>
	                </div>
	            @endif
		    
		    {{ Form::submit('Update Resource', array('class' => 'btn btn-primary')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

