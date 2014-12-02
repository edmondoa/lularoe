<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration 
{

	public function up()
	{
		Schema::create('roles', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->boolean('disabled');
			$table->timestamps();
		});
		Role::create(["name"=>"Customer"]);
		Role::create(["name"=>"Rep"]);
		Role::create(["name"=>"Editor"]);
		Role::create(["name"=>"Admin"]);
		Role::create(["name"=>"Superadmin"]);
	}

	public function down()
	{
		Schema::dropIfExists('roles');
	}

}
