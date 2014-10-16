@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/levels">&lsaquo; Back</a>
	    <h1 class="no-top">Viewing level</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('level/'.$level->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($level->disabled == 0)
			    {{ Form::open(array('url' => 'level/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $level->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'level/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $level->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'levels/' . $level->id, 'method' => 'DELETE')) }}
		    	<button class="btn btn-default" title="Delete">
		    		<i class="fa fa-trash" title="Delete"></i>
		    	</button>
		    {{ Form::close() }}
		</div>
		<br>
		<br>
	    <table class="table">
	        
	        <tr>
	            <th>User Id:</th>
	            <td>{{ $level->user_id }}</td>
	        </tr>
	        
	        <tr>
	            <th>Ancestor Id:</th>
	            <td>{{ $level->ancestor_id }}</td>
	        </tr>
	        
	        <tr>
	            <th>Level:</th>
	            <td>{{ $level->level }}</td>
	        </tr>
	        
	        <tr>
	            <th>Disabled:</th>
	            <td>{{ $level->disabled }}</td>
	        </tr>
	        
	    </table>
    </div>
</div>
@stop
