<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddHasSignUp extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('hasSignUp', function(Blueprint $table)
		{
			DB::statement("ALTER TABLE users ADD hasSignUp int not null");
			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('hasSignUp', function(Blueprint $table)
		{
			
		});
	}

}
