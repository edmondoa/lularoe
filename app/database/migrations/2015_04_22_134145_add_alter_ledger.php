<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAlterLedger extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ledger', function(Blueprint $table)
		{
			DB::statement("ALTER TABLE ledger MODIFY COLUMN txtype ENUM('CASH','CARD','ACH','TRADE','VOID','REFUND','DEBIT','CONS')");
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
			DB::statement("ALTER TABLE ledger MODIFY COLUMN txtype ENUM('CASH','CARD','ACH','TRADE','VOID','REFUND','DEBIT')");
		});
	}

}
