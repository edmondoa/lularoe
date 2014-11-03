<?php namespace SociallyMobile\Payments;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider{


	public function register()
	{
		$this->app->bind('cmspayment', 'SociallyMobile\Payments\CMSPayment');
	}
}
?>