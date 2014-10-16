<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesTable extends Migration 
{

	public function up()
	{
		Schema::create('sales', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id');
			$table->integer('user_id');
			$table->integer('sponsor_id');
			$table->integer('quantity');
			$table->boolean('disabled');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('sales');
	}

}
