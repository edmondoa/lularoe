<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserRanksTable extends Migration 
{

	public function up()
	{
		Schema::create('user_ranks', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('rank_id');
			$table->boolean('disabled');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('user_ranks');
	}

}
