<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddReceiptidtoledger extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ledger', function(Blueprint $table)
		{
			$table->integer('receipt_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ledger', function(Blueprint $table)
		{
			$table->dropColumn('receipt_id');
			
		});
	}

}
