<?php namespace LLR\Commission;

use Illuminate\Support\ServiceProvider;

class CommissionServiceProvider extends ServiceProvider{


	public function register()
	{
		$this->app->bind('commission', 'LLR\Commission\Commission');
	}
}
?>