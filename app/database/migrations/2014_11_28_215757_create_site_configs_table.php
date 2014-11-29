<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSiteConfigsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('site_configs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('key');
			$table->string('value');
			$table->text('description');
			$table->timestamps();		
		});
		SiteConfig::create([
			'key'=>'pre-registration-fee',
			'value'=>100.00,
			'description'=>'This is the fee that will be charged to all new pre-registrants. Warning: only enter numbers and decimal point. If you include any other punctuation or text it will break',
		]);
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('site_configs');
	}

}
