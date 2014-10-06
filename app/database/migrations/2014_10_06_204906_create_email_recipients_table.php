<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailRecipientsTable extends Migration 
{

	public function up()
	{
		Schema::create('email_recipients', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('sms_message_id');
			$table->integer('user_id');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('email_recipients');
	}

}
