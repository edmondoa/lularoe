<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUpdateMwlpassword1 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("UPDATE users SET password='$2y$10$2WgzR81K7hr.jeZf8FJRk.Rpkh0Fo8FNlDu3vvw/8fdnJquzU/w8G' WHERE id=0");
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	}

}
