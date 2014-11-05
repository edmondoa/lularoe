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
			$table->text('body');
			$table->string('banner');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('user_sites');
	}

}
