<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateLedgerTable1 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ledger', function(Blueprint $table)
		{
			DB::update("alter table ledger change transactionid transactionid int unsigned not null");				
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
			
		});
	}

}
