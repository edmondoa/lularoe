@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/userRanks">&lsaquo; Back</a>
	    <h2>Edit userRank</h2>
	    {{ Form::model($userRank, array('route' => array('userRank.update', $userRank->id), 'method' => 'PUT')) }}
	
	    
	    <div class="form-group">
	        {{ Form::label('user_id', 'User Id') }}
	        {{ Form::text('user_id', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('rank_id', 'Rank Id') }}
	        {{ Form::text('rank_id', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('disabled', 'Disabled') }}
	        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
	    </div>
	    
	
	    {{ Form::submit('Update UserRank', array('class' => 'btn btn-success')) }}
	
	    {{Form::close()}}
	</div>
</div>
@stop

