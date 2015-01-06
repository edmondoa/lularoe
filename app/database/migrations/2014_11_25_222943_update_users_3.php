<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateUsers3 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->boolean('hide_gender');
			$table->boolean('hide_dob');
			$table->boolean('hide_billing_address');
			$table->boolean('hide_shipping_address');
			$table->boolean('hide_phone');
			$table->boolean('hide_email');
			$table->boolean('block_email');
			$table->boolean('block_sms');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

	}

}
