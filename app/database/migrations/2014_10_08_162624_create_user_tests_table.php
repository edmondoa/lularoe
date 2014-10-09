<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTestsTable extends Migration 
{

	public function up()
	{
		Schema::create('user_tests', function(Blueprint $table) {
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			$table->string('password');
			$table->string('gender');
			$table->string('key');
			$table->string('code');
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

	public function down()
	{
		Schema::dropIfExists('user_tests');
	}

}
