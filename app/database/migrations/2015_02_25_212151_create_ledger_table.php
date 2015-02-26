<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLedgerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ledger', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('account', 16); 
			$table->decimal('amount'); 
			$table->decimal('tax'); 
			$table->enum('txtype',array('CASH', 'CARD', 'ACH', 'TRADE', 'VOID', 'REFUND', 'DEBIT'))->default('CARD');
			$table->mediumInteger('transactionid')->unsigned();
			$table->binary('data'); 
			$table->dateTime('created_at');
			$table->dateTime('updated_at');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ledger');
	}

}
