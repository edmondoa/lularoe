<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateStates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('states', function(Blueprint $table)
		{
			Eloquent::unguard();
			State::create(['abbr'=>'PR','full_name'=>"Puerto Rico"]); 
			State::create(['abbr'=>'VI','full_name'=>"US Virgin Islands"]); 
			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('states', function(Blueprint $table)
		{
			
		});
	}

}
