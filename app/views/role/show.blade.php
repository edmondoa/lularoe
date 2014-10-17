@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		<div class="breadcrumbs">
			<a href="/roles">&lsaquo; Back</a>
		</div>
		<h1 class="no-top">Viewing role</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('roles/'.$role->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($role->disabled == 0)
			    {{ Form::open(array('url' => 'roles/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $role->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'roles/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $role->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'roles/' . $role->id, 'method' => 'DELETE')) }}
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
		            <th>Name:</th>
		            <td>{{ $role->name }}</td>
		        </tr>
		        
		        <tr>
		            <th>Disabled:</th>
		            <td>{{ $role->disabled }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
