@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New Post</h1>
		</div>
	</div>
	<div class="row">
		{{ Form::open(array('url' => 'posts')) }}
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
				    		{{ Form::radio('publish_immediately', 1, null, ['id' => 'publish_immediately', 'checked' => 'checked']) }} Publish Immediately
				    	</label>
				    	<br>
				    	<label>
				    		{{ Form::radio('publish_immediately', 0) }} Schedule for:
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
					   			{{ Form::checkbox('reps') }} ISM's
					        </label>
				    	</div>
			    	</div>
			    </div><!-- panel -->
			    
			    {{ Form::submit('Add Post', array('class' => 'btn btn-primary')) }}
			    
			</div><!-- col -->
	    {{ Form::close() }}
	</div><!-- row -->
</div>
@stop
@section('scripts')
    {{ HTML::script('js/metaCharacterCounter.js') }}
	<script>
	
		$(document).ready(function() {
			// alternate visibility options
			function toggleVisibility() {
				if ($("#show_to_everyone").is(':checked')) {
					$("#only_show_to_list input").attr('disabled', 'disabled');
					$("#only_show_to_list label").addClass('semitransparent');
				}
				if (!$("#show_to_everyone").is(':checked')) {
					$("#only_show_to_list input").removeAttr('disabled');
					$("#only_show_to_list label").removeClass('semitransparent');
				}
				if ($("#publish_immediately").is(':checked')) {
					$("[data-id='publish_date']").attr('disabled', 'disabled');
				}
				else {
					$("[data-id='publish_date']").removeAttr('disabled');
				}
			}
			toggleVisibility();
			$('input[type="radio"]').click(function() {
				toggleVisibility();
			});
			
			// generate url
			var activatedURL = false;
			$('input#url').focus(function() {
				activatedURL = true;
			});
			$('input#title').keyup(function() {
				if (activatedURL == false) {
					var text = $('input#title').val();
					cleanURL(text);
					$('input#url').val(cleaned_text);
				}
			});
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