<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRanksTable extends Migration 
{

	public function up()
	{
		Schema::create('ranks', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->boolean('disabled');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('ranks');
	}

}
