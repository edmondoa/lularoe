@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row">
		<div class="col-md-12">
			@include('_helpers.breadcrumbs')
			<h1 class="no-top">Asset Details</h1>
			<div class="page-actions">
				@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor', ]))
				    <div class="btn-group pull-left" id="record-options">
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
				<button class="btn btn-default">
					<a href="/uploads/{{ $media->url }}" download="/uploads/{{ $media->url }}"><i class="fa fa-download"></i> Download</a>
				</button>
			</div><!-- page-actions -->
		</div><!-- col -->
	</div><!-- row -->
	<br>
	<div class="row">
		@if ($media->type == 'Image')
			<div class="col col-md-6">
				<img src="/uploads/{{ $media->url }}" class="full-image">
				<br>
				<br>
			</div>
		@endif
		<div class="col col-md-6">
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

		        @if (count($tags) > 0)
			        <tr>
			        	<th>Tags:</th>
			            <td class="tag-list">
			            	@foreach($tags as $tag)
				                <span class="label label-default">
				                	{{ $tag->name }}
				                </span>
			                @endforeach
			            </td>
			        </tr>
			    @endif
		        
		        @if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']) && $media->reps)
			        <tr>
			            <th>Shared with Reps:</th>
			            <td><i class="fa fa-check"></i></td>
			        </tr>
		        @endif
		        
		    </table>
	    </div>
	</div>
</div>
@stop
