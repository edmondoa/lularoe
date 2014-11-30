<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserSitesTable extends Migration 
{

	public function up()
	{
		Schema::create('user_sites', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->string('title');
			$table->text('body');
			$table->string('banner');
			$table->boolean('display_phone');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('user_sites');
	}

}
