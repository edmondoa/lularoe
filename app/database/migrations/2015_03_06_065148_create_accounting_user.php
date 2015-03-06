<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountingUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounting_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('account_name');	
			$table->decimal('account_balance',8,2);	
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('accounting_user');
	}

}
