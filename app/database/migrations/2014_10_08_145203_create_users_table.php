<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration 
{

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('public_id',25);			
			$table->string('first_name',50);
			$table->string('last_name',50);
			$table->string('email');
			$table->string('password');
			$table->string('gender',2);
			$table->string('key');
			$table->date('dob');
			$table->string('phone',15);
			$table->integer('role_id');
			$table->integer('sponsor_id')->nullable();
			$table->integer('mobile_plan_id')->nullable();
			$table->decimal('min_commission',6,2);
			$table->boolean('disabled');
			$table->timestamps();
			$table->rememberToken();
		});

		$user = User::create([
			'id' => 0,
			'first_name' => "SociallyMobile",
			'last_name' => 'Frontline',
			'email' => 'muckitymuck@example.com',
			'password' => \Hash::make('Fr3@k0z0id'),
			'key' => '',
			'phone' => '',
			'dob' => '1969-12-31',
			'role_id' => 5,
			'sponsor_id' => null,
			'mobile_plan_id' => null,
			'min_commission' => 0,
			'disabled' => false,
			'public_id' => "SocMobFrontline"
		]);
		DB::update(DB::raw('UPDATE users SET id=0 WHERE id='.$user->id));
	}

	public function down()
	{
		Schema::dropIfExists('users');
	}

}
