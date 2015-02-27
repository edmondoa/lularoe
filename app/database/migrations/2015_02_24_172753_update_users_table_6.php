<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateUsersTable6 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->integer('original_sponsor_id')->nullable()->after('sponsor_id')->index();
		});
		foreach($users = User::all() as $user)
		{
			$user->original_sponsor_id = $user->sponsor_id;
			$user->save();
		}

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
			$table->dropIndex('users_original_sponsor_id_index');
			if (Schema::hasColumn('users', 'original_sponsor_id'))
			{
				$table->dropColumn('original_sponsor_id');
			}
		});
	}

}
