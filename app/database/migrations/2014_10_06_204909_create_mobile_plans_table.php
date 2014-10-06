<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMobilePlansTable extends Migration 
{

	public function up()
	{
		Schema::create('mobile_plans', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('blurb');
			$table->text('description');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('mobile_plans');
	}

}
