@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		@include('_helpers.breadcrumbs')
		<h1 class="no-top">Viewing smsMessage</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('smsMessages/'.$smsMessage->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($smsMessage->disabled == 0)
			    {{ Form::open(array('url' => 'smsMessages/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $smsMessage->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'smsMessages/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $smsMessage->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'smsMessages/' . $smsMessage->id, 'method' => 'DELETE')) }}
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
		            <th>Sender Id:</th>
		            <td>{{ $smsMessage->sender_id }}</td>
		        </tr>
		        
		        <tr>
		            <th>Recipient Id:</th>
		            <td>{{ $smsMessage->recipient_id }}</td>
		        </tr>
		        
		        <tr>
		            <th>Body:</th>
		            <td>{{ $smsMessage->body }}</td>
		        </tr>
		        
		        <tr>
		            <th>Disabled:</th>
		            <td>{{ $smsMessage->disabled }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
