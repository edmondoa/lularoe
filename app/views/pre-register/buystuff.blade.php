<?php
	$user->hasSignUp = true;
	$user->verified  = true;
	$user->save();
?>
<div class="row onboarding">
    <div class="col col-md-12">
        <h1 class="no-top">Thank you</h1>
    </div>
</div>
<div class="onboarding_form">
	<form name='loginForm'>
	    <div class="row">
			<div class="col col-md-6">
				<h3>Now on to the fun part</h3>
				<blockquote>You will now have the opportunity to purchase your initial inventory now.
				</blockquote>
				<span class="btn btn-large btn-success pull-right">
					<a href="/inventories" style="color:white">Click here to continue</a>
				</span><!-- col -->
			</div>
		</div>
    </form>
</div>
