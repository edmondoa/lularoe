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

		if (!Schema::hasColumn('users','hasSignUp'))
		{
			DB::statement("ALTER TABLE users ADD hasSignUp int not null");
		}
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasColumn('users','hasSignUp'))
		{
			DB::statement("ALTER TABLE users DROP hasSignUp");
		}
	}

}
