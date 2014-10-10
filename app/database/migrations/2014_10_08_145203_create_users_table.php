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
			$table->string('phone');
			$table->integer('role_id');
			$table->integer('sponsor_id')->nullable();
			$table->integer('mobile_plan_id');
			$table->decimal('min_commission',6,2);
			$table->boolean('disabled');
			$table->timestamps();
			$table->rememberToken();
		});
	}

	public function down()
	{
		Schema::dropIfExists('users');
	}

}
