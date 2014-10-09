<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EditAddressesTable extends Migration 
{

	public function up()
	{
		Schema::dropIfExists('addresses');
	}

	public function down()
	{
		Schema::create('addresses', function(Blueprint $table) {
			$table->increments('id');
			$table->string('address_1');
			$table->string('address_2');
			$table->string('city');
			$table->string('state');
			$table->integer('addressable_id');
			$table->integer('zip');
			$table->boolean('disabled');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

}
