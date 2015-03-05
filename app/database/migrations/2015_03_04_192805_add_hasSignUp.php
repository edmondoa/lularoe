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

<<<<<<< HEAD
		// Schema::table('hasSignUp', function(Blueprint $table)
		// {
			// DB::statement("ALTER TABLE users ADD hasSignUp int not null");
// 			
		// });
=======
		if (!Schema::hasColumn('users','hasSignUp'))
		{
			DB::statement("ALTER TABLE users ADD hasSignUp int not null");
		}
>>>>>>> db7a0d8f619de88bd8db1b9be7c442ba328fc612
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
<<<<<<< HEAD
		// Schema::table('hasSignUp', function(Blueprint $table)
		// {
// 			
		// });
=======
		if (Schema::hasColumn('users','hasSignUp'))
		{
			DB::statement("ALTER TABLE users DROP hasSignUp");
		}
>>>>>>> db7a0d8f619de88bd8db1b9be7c442ba328fc612
	}

}
