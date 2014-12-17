@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1 class="no-top">Viewing attachment</h1>
		@if (Auth::user()->hasRole(['Superadmin', 'Admin']))
		    <div class="btn-group" id="record-options">
			    <a class="btn btn-default" href="{{ url('attachments/'.$attachment->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
			    @if ($attachment->disabled == 0)
				    {{ Form::open(array('url' => 'attachments/disable', 'method' => 'DISABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $attachment->id }}">
				    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@else
				    {{ Form::open(array('url' => 'attachments/enable', 'method' => 'ENABLE')) }}
				    	<input type="hidden" name="ids[]" value="{{ $attachment->id }}">
				    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
				    		<i class="fa fa-eye"></i>
				    	</button>
				    {{ Form::close() }}
				@endif
			    {{ Form::open(array('url' => 'attachments/' . $attachment->id, 'method' => 'DELETE', 'onsubmit' => 'return confirm("Are you sure you want to delete this attachment? This cannot be undone.");')) }}
			    	<button class="btn btn-default" title="Delete">
			    		<i class="fa fa-trash" title="Delete"></i>
			    	</button>
			    {{ Form::close() }}
			</div>
		@endif
	</div><!-- row -->
	<div class="row">
		<div class="col col-md-6">
		    <table class="table">
		        
		        <tr>
		            <th>Type:</th>
		            <td>{{ $attachment->type }}</td>
		        </tr>
		        
		        <tr>
		            <th>Url:</th>
		            <td>{{ $attachment->url }}</td>
		        </tr>
		        
		        <tr>
		            <th>User Id:</th>
		            <td>{{ $attachment->user_id }}</td>
		        </tr>
		        
		        <tr>
		            <th>Disabled:</th>
		            <td>{{ $attachment->disabled }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
