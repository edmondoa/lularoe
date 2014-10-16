@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/pages">&lsaquo; Back</a>
	    <h2>Edit page</h2>
	    {{ Form::model($page, array('route' => array('page.update', $page->id), 'method' => 'PUT')) }}
	
	    
	    <div class="form-group">
	        {{ Form::label('title', 'Title') }}
	        {{ Form::text('title', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('url', 'Url') }}
	        {{ Form::text('url', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('type', 'Type') }}
	        {{ Form::text('type', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('body', 'Body') }}
	        {{ Form::text('body', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('disabled', 'Disabled') }}
	        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
	    </div>
	    
	
	    {{ Form::submit('Update Page', array('class' => 'btn btn-success')) }}
	
	    {{Form::close()}}
	</div>
</div>
@stop

