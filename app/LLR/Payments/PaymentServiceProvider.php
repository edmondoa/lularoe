<?php namespace LLR\Payments;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider{


	public function register()
	{
		$this->app->bind('cmspayment', 'LLR\Payments\CMSPayment');
	}
}
?>