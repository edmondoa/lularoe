@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			<div class="breadcrumbs">
				<a href="/pages">&lsaquo; Back</a>
			</div>
		    <h1 class="no-top">New Page</h1>
		    {{ Form::open(array('url' => 'pages')) }}
		
			    
			    <div class="form-group">
			        {{ Form::label('title', 'Title') }}
			        {{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('url', 'Url') }}
			        {{ Form::text('url', Input::old('url'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('type', 'Type') }}
			        {{ Form::text('type', Input::old('type'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('body', 'Body') }}
			        {{ Form::text('body', Input::old('body'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('disabled', 'Disabled') }}
			        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control')) }}
			    </div>
			    
		
			    {{ Form::submit('Add Page', array('class' => 'btn btn-success')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop