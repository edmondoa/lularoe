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
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('ranks');
	}

}
