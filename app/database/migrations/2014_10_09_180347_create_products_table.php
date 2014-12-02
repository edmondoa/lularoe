<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration 
{

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('blurb');
			$table->text('description');
			$table->decimal('price',10,2);
			$table->integer('quantity');
			$table->boolean('disabled');
			$table->timestamps();
		});
		Product::create([
			'name'=>'Ulmtd Talk & Text 1G Data',
			'price'=>40.00,
			'created_at'=>date('Y-m-d H:i:s'),
			'updated_at'=> date('Y-m-d H:i:s')
		]);

		Product::create([
			'name'=>'Ulmtd Talk & Text 3G Data',
			'price'=>50.00,
			'created_at'=>date('Y-m-d H:i:s'),
			'updated_at'=> date('Y-m-d H:i:s')
		]);

		Product::create([
			'name'=>'Ulmtd Talk & Text 5G Data',
			'price'=>60.00,
			'created_at'=>date('Y-m-d H:i:s'),
			'updated_at'=> date('Y-m-d H:i:s')
		]);
	}

	public function down()
	{
		Schema::dropIfExists('products');
	}

}
