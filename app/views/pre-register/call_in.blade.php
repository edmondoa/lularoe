<div class="row">
    <div class="col col-md-12">
    	@include('_helpers.breadcrumbs')
        <h1 class="no-top">Final Step: Activate</h1>
        <table class="table width-auto">
        	<tr>
        		<th>Call to Activate:</th>
        		<td>951-737-7875</td>
        	</tr>
        	<tr>
        		<th>Security Code:</th>
        		<td>{{ $user->id }}-{{ $user->sponsor_id}}</td>
        	</tr>
        </table>
    </div><!-- col -->
</div><!-- row -->
<div class="row">
	<div class="col col-lg-4 col-md-6 col-sm-6 col-xs-12">
		<p class="well">
			This will enable our customer service team to qualify and complete the onboarding process. We are excited to have you as part of our team!
		</p>
	</div>
</div>
<?php
	Mail::send('emails.welcome', compact(''), function($message) use (&$user) {
		$message->to($user->email, $user->first_name.' '.$user->last_name)->subject('Welcome to '.Config::Get('site.company_name').'!');
	});
?>