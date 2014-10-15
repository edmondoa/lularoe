<?php namespace SociallyMobile\Payments;

use Illuminate\Support\ServiceProvider;

class PaymentsServiceProvider extends ServiceProvider{


	public function register()
	{
		$this->app->bind('payment', 'SociallyMobile\Payments\Payments')
	}
}
?>