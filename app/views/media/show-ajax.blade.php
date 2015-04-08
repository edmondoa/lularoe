<div class="show">
	<div class="row">
		<div class="col-md-12">
			<div class="page-actions">
				@if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor', ]))
				    <div class="btn-group pull-left margin-right-1" id="record-options">
					    <a class="btn btn-default" href="{{ url('media/'.$media->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
					    @if ($media->disabled == 0)
						    {{ Form::open(array('url' => 'media/disable', 'method' => 'DISABLE')) }}
						    	<input type="hidden" name="ids[]" value="{{ $media->id }}">
						    	<button class="btn btn-default active" title="Currently enabled. Click to disable." style="margin-left:-1px;">
						    		<i class="fa fa-eye"></i>
						    	</button>
						    {{ Form::close() }}
						@else
						    {{ Form::open(array('url' => 'media/enable', 'method' => 'ENABLE')) }}
						    	<input type="hidden" name="ids[]" value="{{ $media->id }}">
						    	<button class="btn btn-default" title="Currently disabled. Click to enable." style="margin-left:-1px;">
						    		<i class="fa fa-eye"></i>
						    	</button>
						    {{ Form::close() }}
						@endif
					    {{ Form::open(array('url' => 'media/' . $media->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this media? This cannot be undone.");')) }}
					    	<button class="btn btn-default" title="Delete" style="left:0px !important; border-top-right-radius:4px !important; border-bottom-right-radius:4px !important;">
					    		<i class="fa fa-trash" title="Delete"></i>
					    	</button>
					    {{ Form::close() }}
					</div>
				@endif
				<a class="btn btn-default margin-right-1" href="/uploads/{{ $media->url }}" download="/uploads/{{ $media->url }}"><i class="fa fa-download"></i> Download</a>
				<div class="btn-group changeFileButtons">
					<button type="button" class="changeFile btn btn-default btn-group" data-direction="backward"><i class="fa fa-arrow-left"></i></button>
					<button type="button" class="changeFile btn btn-default btn-group" data-direction="forward"><i class="fa fa-arrow-right"></i></button>
				</div>
	            <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-times"></i></button>
			</div><!-- page-actions -->
		</div><!-- col -->
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-12">
			@if ($media->type == 'Image')
				<img src="/uploads/{{ $media->url }}" class="gallery-image pull-left">
			@endif
		    <table class="table margin-left-2 margin-right-2 pull-left">

				@if ($media->title != '')
			        <tr>
			            <th>Title:</th>
			            <td class="break-word">{{ $media->title }}</td>
			        </tr>
			    @endif
		        
		        @if ($media->description != '')
			        <tr>
			            <th>Description:</th>
			            <td class="break-word">{{ $media->description }}</td>
			        </tr>
		        @endif
		        
		        <tr>
		            <th>Type:</th>
		            <td>{{ $media->type }}</td>
		        </tr>
		        
		        <tr>
		            <th>URL:</th>
		            <td class="break-word"><a class="break-word" href="/uploads/{{ $media->url }}" title="{{ $media->url }}">{{ url() }}/uploads/{{ substr($media->url, 0, 20) . '...' }}</a></td>
		        </tr>
		        
		        <tr>
		            <th>Owner:</th>
		            <td class="break-word"><a href='/users/{{ $media->user_id }}'>{{ $media->owner }}</a></td>
		        </tr>

		        @if (count($tags) > 0)
			        <tr>
			        	<th>Tags:</th>
			            <td class="tag-list break-word">
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
			            <th>Shared:</th>
			            <td class="break-word"><i class="fa fa-check"></i></td>
			        </tr>
			    @endif
			        
			    @if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor']))
			        <tr>
			            <th>Status:</th>
			            <td>
			            	@if ($media->disabled == true)
			            		Disabled
			            	@else
			            		Active
			            	@endif
			            </td>
			        </tr>
		        @endif
		        
		    </table>
	    </div>
	</div>
</div>