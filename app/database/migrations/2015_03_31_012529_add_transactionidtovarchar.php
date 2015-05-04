<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTransactionidtovarchar extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('ledger', function(Blueprint $table)
        {
            DB::update("alter table ledger change transactionid transactionid varchar(16) not null");
            //DB::update("alter table ledger add receipt_id int unsigned not null");
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
            DB::update("alter table ledger change transactionid transactionid int unsigned not null");
            //DB::update("alter table ledger drop receipt_id");
		});
	}

}
