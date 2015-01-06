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
			$table->boolean('disabled');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('carts');
	}

}
