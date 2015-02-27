<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePartiesTable extends Migration 
{

	public function up()
	{
		Schema::create('parties', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('description');
			$table->integer('date_start');
			$table->integer('date_end');
			$table->integer('organizer_id');
			$table->integer('host_id');
			$table->boolean('public');
			$table->boolean('disabled');
			$table->string('timezone');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('parties');
	}

}
