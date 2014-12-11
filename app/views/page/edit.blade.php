@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1>Edit Page</h1>
		    <div class="btn-group" id="record-options">
			    @if ($page->disabled == 0)
				    {{ Form::open(array('url' => 'pages/disable', 'method' => 'DISABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $page->id }}">
				    	<button class="btn btn-default active" style="border-top-left-radius:4px !important; border-bottom-left-radius:4px !important;" title="Currently enabled. Click to disable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@else
				    {{ Form::open(array('url' => 'pages/enable', 'method' => 'ENABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $page->id }}">
				    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@endif
			    {{ Form::open(array('url' => 'pages/' . $page->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this record? This cannot be undone.");')) }}
			    	<button class="btn btn-default" title="Delete">
			    		<i class="fa fa-trash" title="Delete"></i>
			    	</button>
			    {{ Form::close() }}
			</div>
			<a target="_blank" class="btn btn-primary" href="/pages/{{ $page->url }}"><i class="fa fa-globe"></i> View Page</a>
		</div>
	</div><!-- row -->
	<br>
	<div class="row">
		{{ Form::model($page, array('route' => array('pages.update', $page->id), 'method' => 'PUT')) }}
			<div class="col col-lg-6 col-md-8 col-sm-12">
			
			    <div class="form-group">
			        {{ Form::label('title', 'Title') }}
			        {{ Form::text('title', null, array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('url', 'URL') }}
			        {{ Form::text('url', null, array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('body', 'Body') }}
			        {{ Form::textarea('body', null, array('class' => 'form-control wysiwyg')) }}
			    </div>
			    
			</div><!-- col -->
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
			      
			    <div class="panel panel-default">
			    	<div class="panel-heading">
			    		<h2 class="panel-title">Visibility</h2>
			    	</div>
				    <div class="panel-body">
				        <label>
				   			{{ Form::checkbox('public') }} Public
				        </label>
				        <br>
				        <label>
				   			{{ Form::checkbox('customers') }} Customers
				        </label>
				        <br>
				        <label>
				   			{{ Form::checkbox('reps') }} ISM's
				        </label>
			    	</div>
			    </div><!-- panel -->
			    
			    <div class="panel panel-default">
			    	<div class="panel-heading">
			    		<h2 class="panel-title">Visibility</h2>
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
			    
			    {{ Form::submit('Update Page', array('class' => 'btn btn-primary')) }}
			    
			</div><!-- col -->
		{{Form::close()}}
	</div><!-- row -->
</div>
@stop

