@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New Page</h1>
		</div>
	</div>
	<div class="row">
		{{ Form::open(array('url' => 'pages')) }}
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
					<div class="col-md-6">
						
					    <div class="form-group">
					        {{ Form::label('short_title', 'Short Title') }}
					        <small>(To be used in menus)</small>
					        {{ Form::text('short_title', Input::old('url'), array('class' => 'form-control')) }}
					    </div>
					
					</div>
					<div class="col-md-6">
						
					    <div class="form-group">
					        {{ Form::label('url', 'URL') }}
					        <small>{{ url() }}/pages/</small>
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

			</div>
			<div class="col col-lg-3 col-md-4 col-sm-12">
				
			    <div class="form-group">
			        {{ Form::label('template', 'Template') }}
			        <br>
			    	{{ Form::select('template', [
			    		'public' => 'Public',
			    		'default' => 'Back Office',
			    		'gray' => 'Minimal',
			    	], null, ['class' => 'selectpicker form-control']) }}
			    </div>
			    
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
			    
			    <div class="panel panel-default">
			    	<div class="panel-heading">
			    		<h2 class="panel-title">Show in Navigation</h2>
			    	</div>
				    <div class="panel-body">
				        <label>
				   			{{ Form::checkbox('public_header') }} Public Header
				        </label>
				        <br>
				        <label>
				   			{{ Form::checkbox('public_footer') }} Public Footer
				        </label>
				        <br>
				        <label>
				   			{{ Form::checkbox('back_office_header') }} Back Office Header
				        </label>
				        <br>
				        <label>
				   			{{ Form::checkbox('back_office_footer') }} Back Office Footer
				        </label>
			    	</div>
			    </div><!-- panel -->
			    
			    {{ Form::submit('Add Page', array('class' => 'btn btn-primary')) }}
			    
			</div><!-- col -->
	    {{ Form::close() }}
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
			var activatedURL = false;
			$('input#url').focus(function() {
				activatedURL = true;
			});
			$('input#short_title').keyup(function() {
				if (activatedURL == false) {
					var text = $('input#short_title').val();
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
