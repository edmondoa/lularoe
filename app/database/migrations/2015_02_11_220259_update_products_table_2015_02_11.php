<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateProductsTable20150211 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function(Blueprint $table)
		{
			$table->decimal('retail_price');
			$table->decimal('rep_price');
			$table->decimal('cv_price');
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
			$table->dropColumn('retail_price');
			$table->dropColumn('rep_price');
			$table->dropColumn('cv_price');
		});
	}

}
