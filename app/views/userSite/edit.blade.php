@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-6">
			@include('_helpers.breadcrumbs')
		    <h1>Edit Site</h1>
		    
		    {{ Form::model($userSite, array('route' => array('user-sites.update', $userSite->id, 'files' => true), 'method' => 'PUT')) }}

			    <!-- <div class="form-group">
			        {{ Form::label('user_id', 'User Id') }}
			        {{ Form::text('user_id', null, array('class' => 'form-control')) }}
			    </div> -->
			    
			    <div class="form-group">
			        <!-- {{ Form::label('body', 'Content') }} -->
			        {{ Form::textarea('body', null, array('class' => 'wysiwyg')) }}
			    </div>

			    {{ Form::submit('Update Site', array('class' => 'btn btn-primary')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

