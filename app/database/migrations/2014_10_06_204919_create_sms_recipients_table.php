<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmsRecipientsTable extends Migration 
{

	public function up()
	{
		Schema::create('sms_recipients', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('email_message_id');
			$table->integer('user_id');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('sms_recipients');
	}

}
