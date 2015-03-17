<div style="max-width:600px; margin:0 auto; font-family:helvetica, arial; font-weight:300; color:#7d7d7d; text-align:center; font-size:12pt; line-height:1.5em;">
	<img src="<?php echo $message->embed('img/email/audrey-header.png'); ?>" style="width:100%;">
	<p>Dear {{ $user->first_name }},</p>
	<p>
		We are thrilled to introduce the next steps in our transition to Audrey. This is an exciting time for LuLaRoe and we believe Audrey will help you maximize your time to more efficiently run your business. At this point you should have received an email instructing you to track your current inventory as the first step in your transition to Audrey. If you have not done so already, please take the time to catalogue your current inventory before following these next steps.
	</p>
	<p>
		When you are ready, please use your computer and click the link below. This link is specific to you and will take you to a page in your web browser utilizing your current username. You will be asked to create a new password and then you will be taken to a setup page. Audrey will guide you through these easy to use steps.
	</p>
	<p>
		<a href="{{$verification_link}}">Click here to verify your email address and continue the sign up process.</a>
	</p>
	<p>
		After you complete the setup process, follow the prompts and you will be able to enter your current inventory into the new system. This will allow you to use Audrey going forward to manage your current and future inventory. We are excited about this transition and know that you are as excited as we are to begin this next chapter in the growth of LuLaRoe.
	</p>
	<p>
		If you have any questions please contact Consultant Support at Info@lularoe.com
	</p>
	<p>
		Sincerely,<br>
		{{ Config::get('site.company_name') }}
	</p>
	<img src="<?php echo $message->embed('img/email/audrey-footer.jpg'); ?>" style="width:100%;">
</div>