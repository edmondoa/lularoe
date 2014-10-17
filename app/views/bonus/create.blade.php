@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/bonuses">&lsaquo; Back</a>
	    <h1 class="no-top">New Bonus</h1>
	    {{ Form::open(array('url' => 'bonus')) }}
	
		    
		    <div class="form-group">
		        {{ Form::label('user_id', 'User Id') }}
		        {{ Form::text('user_id', Input::old('user_id'), array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('eight_in_eight', 'Eight In Eight') }}
		        {{ Form::text('eight_in_eight', Input::old('eight_in_eight'), array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('twelve_in_twelve', 'Twelve In Twelve') }}
		        {{ Form::text('twelve_in_twelve', Input::old('twelve_in_twelve'), array('class' => 'form-control')) }}
		    </div>
		    
		    <div class="form-group">
		        {{ Form::label('disabled', 'Disabled') }}
		        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control')) }}
		    </div>
		    
	
		    {{ Form::submit('Add Bonus', array('class' => 'btn btn-success')) }}

	    {{ Form::close() }}
    </div>
</div>
@stop