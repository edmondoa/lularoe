<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddShippednprinted extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('receipts', function(Blueprint $table)
		{
			$table->timestamp('shipped')->default('0000-00-00');
			$table->timestamp('printed')->default('0000-00-00');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('receipts', function(Blueprint $table)
		{
			$table->drip('shipped');
			$table->drip('printed');
		});
	}

}
