<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration 
{

	public function up()
	{
		Schema::create('pages', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('url');
			$table->string('type');
			$table->boolean('opportunity');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('pages');
	}

}
