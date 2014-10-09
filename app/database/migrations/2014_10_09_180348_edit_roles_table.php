<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditRolesTable extends Migration 
{

	public function up()
	{
		Schema::dropIfExists('roles');
	}

	public function down()
	{
		Schema::create('roles', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->boolean('disabled');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

}
