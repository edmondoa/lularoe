<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRegistrationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('registrations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->morphs('registerable');
			$table->morphs('person');
			$table->string('status');
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
		Schema::drop('registrations');
	}

}
