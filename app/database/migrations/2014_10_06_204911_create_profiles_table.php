<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfilesTable extends Migration 
{

	public function up()
	{
		Schema::create('profiles', function(Blueprint $table) {
			$table->increments('id');
			$table->string('public_name');
			$table->text('public_content');
			$table->boolean('receive_company_email');
			$table->boolean('receive_company_sms');
			$table->boolean('receive_upline_email');
			$table->boolean('receive_upline_sms');
			$table->boolean('receive_downline_email');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
	}

	public function down()
	{
		Schema::dropIfExists('profiles');
	}

}
