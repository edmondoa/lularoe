<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

<<<<<<< HEAD
class CreateMediaTable extends Migration {
=======
class CreatemediaTable extends Migration {
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type');
			$table->string('url');
			$table->string('title');
			$table->text('description');
			$table->integer('user_id');
			$table->boolean('disabled');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('media');
	}

}
