<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConsignment extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (!Schema::hasColumn('users','consignment'))
        {
            DB::statement("ALTER TABLE users ADD consignment float(9,2) not null default 0.0");
        }
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
    	DB::statement("ALTER TABLE users DROP consignment");
	}

}
