@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">Upload Media</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-3 col-md-4 col-sm-6">
		    {{ Form::open(array('url' => 'attachments', 'files' => true)) }}
			    
                <div class="form-group">
                	<input type="hidden" name="something" value="whatever">
                    <input type="file" name="file">
                    <br>
                    <small>Max File Size: 1M</small>
                </div>
                
                <div class="form-group">
                	{{ Form::label('title', 'Title') }}
                	{{ Form::text('title', null, ['class' => 'form-control']) }}
                </div>
                
                <div class="form-group">
                	{{ Form::label('description', 'Description') }}
                	{{ Form::textarea('description', null, ['class' => 'form-control']) }}
                </div>
		
			    {{ Form::submit('Upload Media', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop