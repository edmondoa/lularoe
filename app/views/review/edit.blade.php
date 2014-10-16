@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/reviews">&lsaquo; Back</a>
	    <h2>Edit review</h2>
	    {{ Form::model($review, array('route' => array('review.update', $review->id), 'method' => 'PUT')) }}
	
	    
	    <div class="form-group">
	        {{ Form::label('product_id', 'Product Id') }}
	        {{ Form::text('product_id', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('rating', 'Rating') }}
	        {{ Form::text('rating', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('comment', 'Comment') }}
	        {{ Form::text('comment', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('disabled', 'Disabled') }}
	        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
	    </div>
	    
	
	    {{ Form::submit('Update Review', array('class' => 'btn btn-success')) }}
	
	    {{Form::close()}}
	</div>
</div>
@stop

