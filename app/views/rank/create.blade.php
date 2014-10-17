@extends('layouts.default')
@section('content')
<div class="create">
	<div class="row">
		<div class="col col-md-12">
			<div class="breadcrumbs">
				<a href="/ranks">&lsaquo; Back</a>
			</div>
		    <h1 class="no-top">New Rank</h1>
		    {{ Form::open(array('url' => 'ranks')) }}
		
			    
			    <div class="form-group">
			        {{ Form::label('name', 'Name') }}
			        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
			    </div>
			    
			    <div class="form-group">
			        {{ Form::label('disabled', 'Disabled') }}
			        {{ Form::text('disabled', Input::old('disabled'), array('class' => 'form-control')) }}
			    </div>
			    
		
			    {{ Form::submit('Add Rank', array('class' => 'btn btn-success')) }}
	
		    {{ Form::close() }}
	    </div>
	</div>
</div>
@stop