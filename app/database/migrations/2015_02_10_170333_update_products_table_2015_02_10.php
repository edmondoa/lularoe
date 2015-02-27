<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateProductsTable20150210 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function(Blueprint $table)
		{
			$table->string('sku')->unique();
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
			if (Schema::hasColumn('products','sku'))
			{
				$table->dropColumn('sku');
			}
		});
	}

}
