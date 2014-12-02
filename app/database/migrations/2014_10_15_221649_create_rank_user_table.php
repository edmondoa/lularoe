<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRankUserTable extends Migration 
{

	public function up()
	{
		Schema::create('rank_user', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('rank_id');
			$table->boolean('disabled');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('rank_user');
	}

}
