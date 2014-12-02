<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeadsTable extends Migration 
{

	public function up()
	{
		Schema::create('leads', function(Blueprint $table) {
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			$table->string('gender');
			$table->date('dob');
			$table->integer('phone');
			$table->integer('sponsor_id');
			$table->integer('opportunity_id');
			$table->boolean('disabled');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('leads');
	}

}
