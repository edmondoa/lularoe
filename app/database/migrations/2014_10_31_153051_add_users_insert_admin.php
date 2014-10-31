<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUsersInsertAdmin extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_insert_admin', function(Blueprint $table)
		{
			$user = User::create([
				'id' => 1,
				'first_name' => "Jake",
				'last_name' => 'Barlow',
				'email' => 'superadmin@controlpad.com',
				'password' => \Hash::make('Bananapickle!2'),
				'key' => '',
				'phone' => '7189017468',
				'dob' => '1969-12-31',
				'role_id' => 5,
				'sponsor_id' => null,
				'mobile_plan_id' => null,
				'min_commission' => 0,
				'disabled' => false,
				'public_id' => "jbarlow"
			]);
			$user = User::create([
				'id' => 2,
				'first_name' => "Steve",
				'last_name' => 'Gashler',
				'email' => 'admin@controlpad.com',
				'password' => \Hash::make('Bananapickle!2'),
				'key' => '',
				'phone' => '7189017468',
				'dob' => '1969-12-31',
				'role_id' => 4,
				'sponsor_id' => null,
				'mobile_plan_id' => null,
				'min_commission' => 0,
				'disabled' => false,
				'public_id' => "sgashler"
			]);
			$user = User::create([
				'id' => 3,
				'first_name' => "Adam",
				'last_name' => 'Campbell',
				'email' => 'sgashler@controlpad.com',
				'password' => \Hash::make('Bananapickle!2'),
				'key' => '',
				'phone' => '7189017468',
				'dob' => '1969-12-31',
				'role_id' => 3,
				'sponsor_id' => null,
				'mobile_plan_id' => null,
				'min_commission' => 0,
				'disabled' => false,
				'public_id' => "acampbell"
			]);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_insert_admin', function(Blueprint $table)
		{
			
		});
	}

}
