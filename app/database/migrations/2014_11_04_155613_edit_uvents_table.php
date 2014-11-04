<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditUventsTable extends Migration 
{

	public function up()
	{
		Schema::dropIfExists('uvents');
	}

	public function down()
	{
		Schema::create('uvents', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('description');
			$table->date('date');
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

}
