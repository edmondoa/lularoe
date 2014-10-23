@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			<div class="breadcrumbs">
				<a href="/reviews">&lsaquo; Back</a>
			</div>
		    <h1 class="no-top">New Review</h1>
		    {{ Form::open(array('url' => 'reviews')) }}
		
			    
			    <div class="form-group">
			        {{ Form::label('product_id', 'Product Id') }}
			        {{ Form::text('product_id', Input::old('product_id'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('rating', 'Rating') }}
			        {{ Form::text('rating', Input::old('rating'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('comment', 'Comment') }}
			        {{ Form::text('comment', Input::old('comment'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('disabled', 'Disabled') }}
			        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control')) }}
			    </div>
			    
		
			    {{ Form::submit('Add Review', array('class' => 'btn btn-success')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop