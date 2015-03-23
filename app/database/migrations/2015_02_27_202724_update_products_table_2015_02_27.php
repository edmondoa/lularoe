<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateProductsTable20150227 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function(Blueprint $table)
		{
			$table->integer('user_id');
			$table->string('make');
			$table->string('model');
			$table->string('size');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('products', function(Blueprint $table)
		{
			if (Schema::hasColumn('products', 'user_id'))
			{
				$table->dropColumn('user_id');
			}
			if (Schema::hasColumn('products', 'make'))
			{
				$table->dropColumn('make');
			}
			if (Schema::hasColumn('products', 'model'))
			{
				$table->dropColumn('model');
			}
			if (Schema::hasColumn('products', 'size'))
			{
				$table->dropColumn('size');
			}
		});
	}

}
