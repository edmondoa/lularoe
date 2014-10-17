@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			<div class="breadcrumbs">
				<a href="/userRanks">&lsaquo; Back</a>
			</div>
		    <h1 class="no-top">New UserRank</h1>
		    {{ Form::open(array('url' => 'userRanks')) }}
		
			    
			    <div class="form-group">
			        {{ Form::label('user_id', 'User Id') }}
			        {{ Form::text('user_id', Input::old('user_id'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('rank_id', 'Rank Id') }}
			        {{ Form::text('rank_id', Input::old('rank_id'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('disabled', 'Disabled') }}
			        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control')) }}
			    </div>
			    
		
			    {{ Form::submit('Add UserRank', array('class' => 'btn btn-success')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop