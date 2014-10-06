<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentsTable extends Migration 
{

	public function up()
	{
		Schema::create('contents', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('page_id');
			$table->string('section');
			$table->text('content');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('contents');
	}

}
