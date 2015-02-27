@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">Upload Resource</h1>
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
                	{{ Form::text('title', null, ['class' => 'form-control']) }}
                </div>
                
                <div class="form-group">
                	{{ Form::label('description', 'Description') }}
                	{{ Form::textarea('description', null, ['class' => 'form-control']) }}
                </div>
                
                @if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
	                <div class="form-group">
	                	<label>
	                		{{ Form::checkbox('reps') }} Share with Reps
	                	</label>
	                </div>
	            @endif
		
			    {{ Form::submit('Upload Resource', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop