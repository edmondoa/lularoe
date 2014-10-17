@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/emailMessages">&lsaquo; Back</a>
	    <h1 class="no-top">Viewing emailMessage</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('emailMessage/'.$emailMessage->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($emailMessage->disabled == 0)
			    {{ Form::open(array('url' => 'emailMessage/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $emailMessage->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'emailMessage/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $emailMessage->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'emailMessages/' . $emailMessage->id, 'method' => 'DELETE')) }}
		    	<button class="btn btn-default" title="Delete">
		    		<i class="fa fa-trash" title="Delete"></i>
		    	</button>
		    {{ Form::close() }}
		</div>
		<br>
		<br>
	    <table class="table">
	        
	        <tr>
	            <th>Sender Id:</th>
	            <td>{{ $emailMessage->sender_id }}</td>
	        </tr>
	        
	        <tr>
	            <th>Recipient Id:</th>
	            <td>{{ $emailMessage->recipient_id }}</td>
	        </tr>
	        
	        <tr>
	            <th>Subject:</th>
	            <td>{{ $emailMessage->subject }}</td>
	        </tr>
	        
	        <tr>
	            <th>Body:</th>
	            <td>{{ $emailMessage->body }}</td>
	        </tr>
	        
	        <tr>
	            <th>Disabled:</th>
	            <td>{{ $emailMessage->disabled }}</td>
	        </tr>
	        
	    </table>
    </div>
</div>
@stop
