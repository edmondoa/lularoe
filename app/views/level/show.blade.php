@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1 class="no-top">Viewing level</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('levels/'.$level->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($level->disabled == 0)
			    {{ Form::open(array('url' => 'levels/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $level->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'levels/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $level->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'levels/' . $level->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this record? This cannot be undone.");')) }}
		    	<button class="btn btn-default" title="Delete">
		    		<i class="fa fa-trash" title="Delete"></i>
		    	</button>
		    {{ Form::close() }}
		</div>
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-12">
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
</div>
@stop
