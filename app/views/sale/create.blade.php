@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New Sale</h1>
		    {{ Form::open(array('url' => 'sales')) }}
		
			    
			    <div class="form-group">
			        {{ Form::label('product_id', 'Product Id') }}
			        {{ Form::text('product_id', Input::old('product_id'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('user_id', 'User Id') }}
			        {{ Form::text('user_id', Input::old('user_id'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('sponsor_id', 'Sponsor Id') }}
			        {{ Form::text('sponsor_id', Input::old('sponsor_id'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('quantity', 'Quantity') }}
			        {{ Form::text('quantity', Input::old('quantity'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('disabled', 'Disabled') }}
			        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control')) }}
			    </div>
			    
		
			    {{ Form::submit('Add Sale', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop