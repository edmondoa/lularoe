<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditProductCategoriesTable extends Migration 
{

	public function up()
	{
		Schema::dropIfExists('product_categories');
	}

	public function down()
	{
		Schema::create('product_categories', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->boolean('disabled');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

}
