@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1 class="no-top">Media Details</h1>
		@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
		    <div class="btn-group" id="record-options">
			    <a class="btn btn-default" href="{{ url('media/'.$media->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
			    @if ($media->disabled == 0)
				    {{ Form::open(array('url' => 'media/disable', 'method' => 'DISABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $media->id }}">
				    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@else
				    {{ Form::open(array('url' => 'media/enable', 'method' => 'ENABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $media->id }}">
				    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@endif
			    {{ Form::open(array('url' => 'media/' . $media->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this media? This cannot be undone.");')) }}
			    	<button class="btn btn-default" title="Delete">
			    		<i class="fa fa-trash" title="Delete"></i>
			    	</button>
			    {{ Form::close() }}
			</div>
		@endif
		@if (Auth::user()->hasRole(['Rep']))
		    <div class="btn-group" id="record-options-rep">
			    <a class="btn btn-default" href="{{ url('media/'.$media->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
			    {{ Form::open(array('url' => 'media/' . $media->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this media? This cannot be undone.");')) }}
			    	<button class="btn btn-default" title="Delete">
			    		<i class="fa fa-trash" title="Delete"></i>
			    	</button>
			    {{ Form::close() }}
			</div>
		@endif
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-6">
			@if ($media->type == 'Image')
				<img src="/uploads/{{ $media->url }}" style="width:100%;">
				<br>
				<br>
			@endif
		    <table class="table">

		        <tr>
		            <th>Title:</th>
		            <td>{{ $media->title }}</td>
		        </tr>
		        
		        <tr>
		            <th>Description:</th>
		            <td>{{ $media->description }}</td>
		        </tr>
		        
		        <tr>
		            <th>Type:</th>
		            <td>{{ $media->type }}</td>
		        </tr>
		        
		        <tr>
		            <th>URL:</th>
		            <td>{{ url() }}/uploads/{{ $media->url }}</td>
		        </tr>
		        
		        <tr>
		            <th>Owner:</th>
		            <td><a href='/users/{{ $media->user_id }}'>{{ $media->owner }}</a></td>
		        </tr>
		        
		        @if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) && $media->reps)
			        <tr>
			            <th>Shared with ISM's:</th>
			            <td><i class="fa fa-check"></i></td>
			        </tr>
		        @endif
		        
		    </table>
	    </div>
	</div>
</div>
@stop
