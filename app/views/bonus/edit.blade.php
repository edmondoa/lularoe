@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/bonuses">&lsaquo; Back</a>
	    <h2>Edit bonus</h2>
	    {{ Form::model($bonus, array('route' => array('bonus.update', $bonus->id), 'method' => 'PUT')) }}
	
	    
	    <div class="form-group">
	        {{ Form::label('user_id', 'User Id') }}
	        {{ Form::text('user_id', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('eight_in_eight', 'Eight In Eight') }}
	        {{ Form::text('eight_in_eight', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('twelve_in_twelve', 'Twelve In Twelve') }}
	        {{ Form::text('twelve_in_twelve', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('disabled', 'Disabled') }}
	        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
	    </div>
	    
	
	    {{ Form::submit('Update Bonus', array('class' => 'btn btn-success')) }}
	
	    {{Form::close()}}
	</div>
</div>
@stop

