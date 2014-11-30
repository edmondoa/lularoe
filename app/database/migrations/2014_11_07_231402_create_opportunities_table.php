<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOpportunitiesTable extends Migration 
{

	public function up()
	{
		Schema::create('opportunities', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->text('body');
			$table->boolean('include_form');
			$table->boolean('public');
			$table->boolean('customers');
			$table->boolean('reps');
			$table->integer('deadline')->nullable();
			$table->boolean('disabled');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('opportunities');
	}

}
