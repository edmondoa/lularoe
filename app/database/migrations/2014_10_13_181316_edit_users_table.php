<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditUsersTable extends Migration 
{

	public function up()
	{
		Schema::dropIfExists('users');
	}

	public function down()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			$table->string('password');
			$table->string('gender');
			$table->string('key');
			$table->string('remember_token');
			$table->string('public_id');
			$table->date('dob');
			$table->integer('phone');
			$table->integer('role_id');
			$table->integer('sponsor_id');
			$table->integer('mobile_plan_id');
			$table->integer('min_commission');
			$table->boolean('disabled');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

}
