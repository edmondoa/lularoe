<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditUsersTable extends Migration 
{

	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->string('public_id');
		});
	}

	public function down()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->dropColumn('public_id');
		});
	}

}
