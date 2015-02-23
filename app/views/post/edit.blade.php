@extends('layouts.default')
@section('content')
<div class="edit">
    <div class="row">
        <div class="col col-md-12">
            @include('_helpers.breadcrumbs')
            <h1>Edit Announcement</h1>
            <div class="btn-group" id="record-options">
                @if ($post->disabled == 0)
                {{ Form::open(array('url' => 'posts/disable', 'method' => 'DISABLE')) }}
                <input type="hidden" name="ids[]" value="{{ $post->id }}">
                <button class="btn btn-default active" style="border-top-left-radius:4px !important; border-bottom-left-radius:4px !important;" title="Currently enabled. Click to disable.">
                    <i class="fa fa-eye"></i>
                </button>
                {{ Form::close() }}
                @else
                {{ Form::open(array('url' => 'posts/enable', 'method' => 'ENABLE')) }}
                <input type="hidden" name="ids[]" value="{{ $post->id }}">
                <button class="btn btn-default" style="border-top-left-radius:4px !important; border-bottom-left-radius:4px !important;" title="Currently disabled. Click to enable.">
                    <i class="fa fa-eye"></i>
                </button>
                {{ Form::close() }}
                @endif
                {{ Form::open(array('url' => 'posts/' . $post->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this record? This cannot be undone.");')) }}
                <button class="btn btn-default" title="Delete">
                    <i class="fa fa-trash" title="Delete"></i>
                </button>
                {{ Form::close() }}
            </div>
            <a target="_blank" class="btn btn-primary" href="/posts/{{ $post->url }}"><i class="fa fa-globe"></i> View Post</a>
        </div>
    </div><!-- row -->
    <br>
    <div class="row">
        {{ Form::model($post, array('route' => array('posts.update', $post->id), 'method' => 'PUT')) }}
			<div class="col col-lg-9 col-md-8 col-sm-12">
				<div class="row">
					<div class="col-md-12">
					    <div class="form-group">
					        {{ Form::label('title', 'Title') }}
					        {{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
					    </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						
					    <div class="form-group">
					        {{ Form::label('url', 'URL') }}
					        <small>{{ url() }}/posts/</small>
					        {{ Form::text('url', Input::old('url'), array('class' => 'form-control')) }}
					    </div>
					    
					</div><!-- col -->
				</div><!-- row -->
				<div class="row">
					<div class="col-md-12">
						
					    <div class="form-group">
					        {{ Form::label('body', 'Body') }}
					        {{ Form::textarea('body', Input::old('body'), array('class' => 'form-control wysiwyg')) }}
					    </div>
						
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						
					    <div class="form-group">
					        {{ Form::label('description', 'Short Description') }}
					        <small>(optional)</small>
					        {{ Form::textarea('description', Input::old('description'), array('class' => 'form-control')) }}
					        <span id="charCount"></span>
					    </div>
						
					</div>
				</div>

			</div>
			<div class="col col-lg-3 col-md-4 col-sm-12">
			    
			    <div class="form-group">
			        {{ Form::label('disabled', 'Status') }}
			        <br>
			    	{{ Form::select('disabled', [
			    		0 => 'Active',
			    		1 => 'Disabled'
			    	], null, ['class' => 'selectpicker form-control']) }}
			    </div>
			    
			    <div class="panel panel-default">
			    	<div class="panel-heading">
			    		<h2 class="panel-title">Visibility</h2>
			    	</div>
				    <div class="panel-body">
				    	<label>
				    		@if ($post->publish_date < 1)
				    			{{ Form::radio('publish_immediately', 1, null, ['id' => 'publish_immediately', 'checked' => 'checked']) }}
				    		@else
				    			{{ Form::radio('publish_immediately', 1, null, ['id' => 'publish_immediately']) }}
				    		@endif
				    			Publish Immediately
				    	</label>
				    	<br>
				    	<label>
				    		@if ($post->publish_date > 1)
				    			{{ Form::radio('publish_immediately', 0, null, ['checked' => 'checked']) }}
				    		@else
				    			{{ Form::radio('publish_immediately', 0, null) }}
				    		@endif
				    		Schedule for:
				    	</label>
				    	<br>
					    {{ Form::text('publish_date', null, ['data-id' => 'publish_date', 'class' => 'datepicker']) }}
				    	<br>
				    	<br>
				    	<label>
				    		{{ Form::radio('public', 1, null, ['id' => 'show_to_everyone', 'checked' => 'checked']) }} Show to everyone
				    	</label>
				    	<br>
				    	<label>
				    		{{ Form::radio('public', 0, null, ['id' => 'only_show_to']) }} Only show to:
				    	</label>
				    	<div id="only_show_to_list">
					        <label>
					   			{{ Form::checkbox('customers') }} Customers
					        </label>
					        <br>
					        <label>
					   			{{ Form::checkbox('reps') }} {{ Config::get('site.rep_title') }}
					        </label>
				    	</div>
			    	</div>
			    </div><!-- panel -->
			    
			    {{ Form::submit('Update Announcement', array('class' => 'btn btn-primary')) }}
			    
			</div><!-- col -->
        {{Form::close()}}
    </div><!-- row -->
</div>
@stop
@section('scripts')
<script>

	$(document).ready(function() {
		// alternate visibility options
		function toggleVisibility() {
			if ($("#show_to_everyone").is(':checked')) {
				$("#only_show_to_list input").attr('disabled', 'disabled');
				$("#only_show_to_list label").addClass('semitransparent');
				$('#only_show_to_list checkbox').each(function() {
					$(this).removeAttr('checked');
				});
			}
			if (!$("#show_to_everyone").is(':checked')) {
				$("#only_show_to_list input").removeAttr('disabled');
				$("#only_show_to_list label").removeClass('semitransparent');
			}
		}
		toggleVisibility();
		$('input[name="public"]').click(function() {
			toggleVisibility();
		});
		
	    // generate url
	    $('input#url').keyup(function() {
	        var text = $('input#url').val();
	        cleanURL(text);
	        $('input#url').val(cleaned_text);
	    });
	});

</script>
@stop
@section('modals')
	@include('_helpers.wysiwyg_modals')
@stop
