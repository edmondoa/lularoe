<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLevelsTable extends Migration 
{

	public function up()
	{
		Schema::create('levels', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('ancestor_id');
			$table->integer('level');
			$table->boolean('disabled');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('levels');
	}

}
