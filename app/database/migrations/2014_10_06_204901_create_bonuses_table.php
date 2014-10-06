<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBonusesTable extends Migration 
{

	public function up()
	{
		Schema::create('bonuses', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->boolean('eight_in_eight');
			$table->boolean('twelve_in_twelve');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('bonuses');
	}

}
