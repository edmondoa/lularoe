<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartsTable extends Migration 
{

	public function up()
	{
		Schema::create('carts', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('carts');
	}

}
