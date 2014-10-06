<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserProductsTable extends Migration 
{

	public function up()
	{
		Schema::create('user_products', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('user_products');
	}

}
