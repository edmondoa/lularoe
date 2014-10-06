<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailMessagesTable extends Migration 
{

	public function up()
	{
		Schema::create('email_messages', function(Blueprint $table) {
			$table->increments('id');
			$table->string('subject');
			$table->text('body');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('email_messages');
	}

}
