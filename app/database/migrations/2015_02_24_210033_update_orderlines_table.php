<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateOrderlinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orderlines', function(Blueprint $table)
		{
			$table->integer('points_each');
			$table->integer('points_ext');			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orderlines', function(Blueprint $table)
		{
			if (Schema::hasColumn('orderlines', 'points_each'))
			{
				$table->dropColumn('points_each');
			}
			if (Schema::hasColumn('orderlines', 'points_ext'))
			{
				$table->dropColumn('points_ext');
			}
		});
	}

}
