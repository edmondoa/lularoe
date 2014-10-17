@extends('layouts.default')
@section('content')
<div class="row">
	<div class="col col-md-12">
		<a class="breadcrumbs" href="/profiles">&lsaquo; Back</a>
	    <h2>Edit profile</h2>
	    {{ Form::model($profile, array('route' => array('profile.update', $profile->id), 'method' => 'PUT')) }}
	
	    
	    <div class="form-group">
	        {{ Form::label('public_name', 'Public Name') }}
	        {{ Form::text('public_name', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('public_content', 'Public Content') }}
	        {{ Form::text('public_content', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('receive_company_email', 'Receive Company Email') }}
	        {{ Form::text('receive_company_email', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('receive_company_sms', 'Receive Company Sms') }}
	        {{ Form::text('receive_company_sms', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('receive_upline_email', 'Receive Upline Email') }}
	        {{ Form::text('receive_upline_email', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('receive_upline_sms', 'Receive Upline Sms') }}
	        {{ Form::text('receive_upline_sms', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('receive_downline_email', 'Receive Downline Email') }}
	        {{ Form::text('receive_downline_email', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('receive_downline_sms', 'Receive Downline Sms') }}
	        {{ Form::text('receive_downline_sms', null, array('class' => 'form-control')) }}
	    </div>
	    
	    <div class="form-group">
	        {{ Form::label('disabled', 'Disabled') }}
	        {{ Form::text('disabled', null, array('class' => 'form-control')) }}
	    </div>
	    
	
	    {{ Form::submit('Update Profile', array('class' => 'btn btn-success')) }}
	
	    {{Form::close()}}
	</div>
</div>
@stop

