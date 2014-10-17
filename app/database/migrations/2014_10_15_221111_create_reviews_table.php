<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReviewsTable extends Migration 
{

	public function up()
	{
		Schema::create('reviews', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id');
			$table->integer('rating');
			$table->text('comment');
			$table->boolean('disabled');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('reviews');
	}

}
