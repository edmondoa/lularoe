<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration 
{

	public function up()
	{
		Schema::create('images', function(Blueprint $table) {
			$table->increments('id');
			$table->string('type');
			$table->string('url');
			$table->string('disabled');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('images');
	}

}
