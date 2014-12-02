<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUventsTable extends Migration 
{

	public function up()
	{
		Schema::create('uvents', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('description');
			$table->integer('date_start');
			$table->integer('date_end');
			$table->boolean('public');
			$table->boolean('customers');
			$table->boolean('reps');
			$table->boolean('editors');
			$table->boolean('admins');
			$table->boolean('disabled');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('uvents');
	}

}
