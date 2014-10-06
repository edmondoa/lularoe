<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmsMessagesTable extends Migration 
{

	public function up()
	{
		Schema::create('sms_messages', function(Blueprint $table) {
			$table->increments('id');
			$table->string('body');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('sms_messages');
	}

}
