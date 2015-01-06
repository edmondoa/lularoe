@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New UserSite</h1>
		    {{ Form::open(array('url' => 'user-sites')) }}
		
			    
			    <div class="form-group">
			        {{ Form::label('user_id', 'User Id') }}
			        {{ Form::text('user_id', Input::old('user_id'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('body', 'Body') }}
			        {{ Form::text('body', Input::old('body'), array('class' => 'form-control')) }}
			    </div>
			    
		
			    {{ Form::submit('Add UserSite', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop