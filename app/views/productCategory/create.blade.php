@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
		    <h1 class="no-top">New ProductCategory</h1>
		</div>
	</div>
	<div class="row">
		<div class="col col-lg-3 col-md-4 col-sm-6">
		    {{ Form::open(array('url' => 'productCategories')) }}
		
			    <div class="form-group">
			        {{ Form::label('name', 'Name') }}
			        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			    </div>
			    
			    <!-- <div class="form-group">
			    	{{ Form::label('parent_id', 'Parent Category') }}
			    	{{ Form::select('parent_id', $selectCategories, null, ['class' => 'form-control']) }}
			    </div> -->
			    
			    <!-- <div class="form-group">
			        {{ Form::label('disabled', 'Status') }}
			        <br>
			    	{{ Form::select('disabled', [
			    		0 => 'Active',
			    		1 => 'Disabled'
			    	], null, ['class' => 'selectpicker form-control width-auto']) }}
			    </div> -->
				
				<br>
			    {{ Form::submit('Add ProductCategory', array('class' => 'btn btn-primary')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop