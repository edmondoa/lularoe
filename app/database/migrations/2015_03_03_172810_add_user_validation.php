<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUserValidation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
            $table->boolean('verified');
			$table->boolean('hasSignUp');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
            if (Schema::hasColumn('users', 'verified'))
            {
                $table->dropColumn('verified');
            }
            
            if (Schema::hasColumn('users', 'hasSignUp'))
            {
                $table->dropColumn('hasSignUp');
            }
		});
	}

}
