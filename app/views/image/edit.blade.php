@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			<div class="breadcrumbs">
				<a href="/images">&lsaquo; Back</a>
			</div>
		    <h1>Edit image</h1>
		    {{ Form::model($image, array('route' => array('images.update', $image->id), 'method' => 'PUT')) }}
		
		    
		    <div class="form-group">
		        {{ Form::label('type', 'Type') }}
		        {{ Form::text('type', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('url', 'Url') }}
		        {{ Form::text('url', null, array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('disabled', 'Disabled') }}
		        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
		    </div>
		    
		
		    {{ Form::submit('Update Image', array('class' => 'btn btn-success')) }}
		
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

