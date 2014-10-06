<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommissionsTable extends Migration 
{

	public function up()
	{
		Schema::create('commissions', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('amount');
			$table->text('description');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('commissions');
	}

}
