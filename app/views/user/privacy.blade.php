@extends('layouts.default')
@section('content')
<div class="edit">
	<div class="row">
		<div class="col col-md-12">
			@include('_helpers.breadcrumbs')
			@if (Auth::user()->id == $user->id)
				<h1>Privacy &amp; Communication Preferences</h1>
			@else
		    	<h1>Edit {{ $user->first_name }} {{ $user->last_name }}</h1>
		    @endif
		    <br>
		</div>
	</div>
	<div class="row">
		<div class="col col-md-6">
			{{ Form::open(array('action' => array('UserController@updatePrivacy', $user->id), 'method' => 'POST')) }}
				<div class="row">
					<div class="col col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h2 class="panel-title"><i class="fa fa-lock"></i> Privacy Settings</h2>
							</div>
							<div class="panel-body">
								<p>Which information you would like to share with {{ Config::get('site.rep_title') }}'s and customers?*</p>
						        <label>{{ Form::checkbox('hide_gender', null, $checked['hide_gender']) }} Gender</label><br>
						        <label>{{ Form::checkbox('hide_dob', null, $checked['hide_dob']) }} Date of Birth</label><br>
						        <label>{{ Form::checkbox('hide_email', null, $checked['hide_email']) }} Email</label><br>
						        <label>{{ Form::checkbox('hide_phone', null, $checked['hide_phone']) }} Phone</label><br>
						        <label>{{ Form::checkbox('hide_billing_address', null, $checked['hide_billing_address']) }} Billing Address</label><br>
						        <label>{{ Form::checkbox('hide_shipping_address', null, $checked['hide_shipping_address']) }} Shipping Address</label><br>
							</div>
						</div>
					</div>
					<div class="col col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h2 class="panel-title"><i class="fa fa-mobile-phone"></i> Communication Preferences</h2>
							</div>
							<div class="panel-body">
								<p>Which kinds of communication would you like to receive from {{ Config::get('site.rep_title') }}'s who have you in their downline?</p>
						        <label>{{ Form::checkbox('block_email', null, $checked['block_email']) }} Email</label><br>
						        <label>{{ Form::checkbox('block_sms', null, $checked['block_sms']) }} Text Messages (SMS)</label>
							</div>
						</div>
					</div>
				</div>
			    {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
				<br>
				<br>
				<p><small>* For more information about how {{ Config::get('site.company_name') }} collects and displays your information, see the <a target="_blank" href="/privacy-policy">Privacy Policy.</a></small></p>
		    {{Form::close()}}
		</div>
	</div>
</div>
@stop

