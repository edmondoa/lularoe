@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-6">
			@include('_helpers.breadcrumbs')
		    <h1>Edit Your Site</h1>
		    {{ Form::model($userSite, array('route' => array('user-sites.update', $userSite->id), 'method' => 'PUT', 'files' => true)) }}

			    <!-- <div class="form-group">
			        {{ Form::label('user_id', 'User Id') }}
			        {{ Form::text('user_id', null, array('class' => 'form-control')) }}
			    </div> -->
			    
			    <div class="form-group">
					{{ Form::label('banner','Your Banner') }}
					{{ Form::file('banner') }}
					<small>Ideal Dimensions: 1170 &times; 340 | Max File Size: 1M</small>
			    </div>
			    
			    <div class="form-group">
					{{ Form::label('image','Your Picture') }}
					{{ Form::file('image') }}
					<small>Ideal Dimensions: 500 &times; 500 | Max File Size: 1M</small>
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('title', 'Title') }}
			        {{ Form::text('title', null, array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('body', 'Content') }}
			        {{ Form::textarea('body', null, array('class' => 'wysiwyg')) }}
			    </div>

			    <div class="form-group">
			        <label>{{ Form::checkbox('display_phone') }} Display Phone Number</label>
			    </div>

			    {{ Form::submit('Update Site', array('class' => 'btn btn-primary')) }}
		
		    {{ Form::close() }}
		</div>
	</div>
</div>
@stop

