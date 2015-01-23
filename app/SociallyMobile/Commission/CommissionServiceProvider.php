<?php namespace SociallyMobile\Commission;

use Illuminate\Support\ServiceProvider;

class CommissionServiceProvider extends ServiceProvider{


	public function register()
	{
		$this->app->bind('commission', 'SociallyMobile\Commission\Commission');
	}
}
?>