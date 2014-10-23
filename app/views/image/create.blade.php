@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			<div class="breadcrumbs">
				<a href="/images">&lsaquo; Back</a>
			</div>
		    <h1 class="no-top">New Image</h1>
		    {{ Form::open(array('url' => 'images')) }}
		
			    
			    <div class="form-group">
			        {{ Form::label('type', 'Type') }}
			        {{ Form::text('type', Input::old('type'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('url', 'Url') }}
			        {{ Form::text('url', Input::old('url'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('disabled', 'Disabled') }}
			        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control')) }}
			    </div>
			    
		
			    {{ Form::submit('Add Image', array('class' => 'btn btn-success')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop