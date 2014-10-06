<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration 
{

	public function up()
	{
		Schema::create('addresses', function(Blueprint $table) {
			$table->increments('id');
			$table->string('address_1');
			$table->string('address_2');
			$table->string('city');
			$table->string('state');
			$table->integer('addressable_id');
			$table->integer('zip');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('addresses');
	}

}
