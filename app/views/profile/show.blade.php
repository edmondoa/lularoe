@extends('layouts.default')
@section('content')
<div class="show">
	<div class="row page-actions">
		<div class="breadcrumbs">
			<a href="/profiles">&lsaquo; Back</a>
		</div>
		<h1 class="no-top">Viewing profile</h1>
	    <div class="btn-group">
		    <a class="btn btn-default" href="{{ url('profiles/'.$profile->id .'/edit') }}" title="Edit"><i class="fa fa-pencil"></i></a>
		    @if ($profile->disabled == 0)
			    {{ Form::open(array('url' => 'profiles/disable', 'method' => 'DISABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $profile->id }}">
			    	<button class="btn btn-default active" title="Currently enabled. Click to disable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@else
			    {{ Form::open(array('url' => 'profiles/enable', 'method' => 'ENABLE')) }}
			    	<input type="hidden" name="ids[]" value="{{ $profile->id }}">
			    	<button class="btn btn-default" title="Currently disabled. Click to enable.">
			    		<i class="fa fa-eye"></i>
			    	</button>
			    {{ Form::close() }}
			@endif
		    {{ Form::open(array('url' => 'profiles/' . $profile->id, 'method' => 'DELETE')) }}
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
		            <th>Public Name:</th>
		            <td>{{ $profile->public_name }}</td>
		        </tr>
		        
		        <tr>
		            <th>Public Content:</th>
		            <td>{{ $profile->public_content }}</td>
		        </tr>
		        
		        <tr>
		            <th>Receive Company Email:</th>
		            <td>{{ $profile->receive_company_email }}</td>
		        </tr>
		        
		        <tr>
		            <th>Receive Company Sms:</th>
		            <td>{{ $profile->receive_company_sms }}</td>
		        </tr>
		        
		        <tr>
		            <th>Receive Upline Email:</th>
		            <td>{{ $profile->receive_upline_email }}</td>
		        </tr>
		        
		        <tr>
		            <th>Receive Upline Sms:</th>
		            <td>{{ $profile->receive_upline_sms }}</td>
		        </tr>
		        
		        <tr>
		            <th>Receive Downline Email:</th>
		            <td>{{ $profile->receive_downline_email }}</td>
		        </tr>
		        
		        <tr>
		            <th>Receive Downline Sms:</th>
		            <td>{{ $profile->receive_downline_sms }}</td>
		        </tr>
		        
		        <tr>
		            <th>Disabled:</th>
		            <td>{{ $profile->disabled }}</td>
		        </tr>
		        
		    </table>
	    </div>
	</div>
</div>
@stop
