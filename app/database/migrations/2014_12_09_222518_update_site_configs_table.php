<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateSiteConfigsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('site_configs', function(Blueprint $table)
		{
			$table->string('name');
		});
		SiteConfig::findOrFail(1)->update([
			'name'=>'Pre-registration fee',
			'description'=>'This is the fee that will be charged to all new pre-registrants. Warning: only enter numbers and decimal point. If you include any other punctuation or text it will break.'
		]);
		SiteConfig::create([
			'name'=>'Show "Sign Up for Beta Service" link',
			'key'=>'beta-service-link',
			'value'=>1,
			'description'=>'This will add a link to the beta service sign up form on the dashboard.',
		]);
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('config', function(Blueprint $table)
		{
			
		});
	}

}
