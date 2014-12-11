<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pages', function(Blueprint $table)
		{
			$table->string('short_title');
			$table->boolean('public');
			$table->boolean('reps');
			$table->boolean('customers');
			$table->boolean('public_header');
			$table->boolean('public_footer');
			$table->boolean('back_office_header');
			$table->boolean('back_office_footer');
			$table->string('template');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pages', function(Blueprint $table)
		{
			
		});
	}

}
