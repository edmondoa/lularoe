<div class="row onboarding">
    <div class="col col-md-12">
        <h1 class="no-top">Almost Ready!</h1>
    </div>
</div>
<div class="onboarding_form">
	<form name='loginForm'>
	    <div class="row">
			<blockquote>This will enable our customer service team to qualify and complete the onboarding process. <Br/> We are excited to have you as part of our team!
			<br /><br /><b>You may be asked for the security code by one of our team members</b>
			</blockquote>
			<div class="col col-xl-3 col-lg-4 col-md-6 col-sm-6 well">
				<h2>Call in to activate: {{ Config::get('site.customer_service') }}</h3>
			</div><!-- col -->
		</div>
		<div class="row">
	        <div class="col col-xl-3 col-lg-4 col-md-6 col-sm-6 well">
				<fieldset>
					<legend>Security Code</legend>
					<h3>{{ $user->id }}-{{ $user->sponsor_id}}</h3>
				</fieldset>
			</div><!-- col -->
		</div>
    </form>
</div>
