<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateUsers5 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			
		});
		$user = User::create([
			'id' => 0,
			'first_name' => "Controlpad",
			'last_name' => 'Superadmin',
			'email' => 'superadmin@controlpad.com',
			'password' => \Hash::make('Bananapickle!2'),
			'key' => '',
			'phone' => '7143428595',
			'dob' => '1970-01-01',
			'role_id' => 5,
			'sponsor_id' => null,
			'mobile_plan_id' => null,
			'min_commission' => 0,
			'disabled' => false,
			'public_id' => "controlpad"
		]);
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
			
		});
	}

}
