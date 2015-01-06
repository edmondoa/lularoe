<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRanksTable extends Migration 
{

	public function up()
	{
		Schema::create('ranks', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->boolean('disabled');
			$table->timestamps();
		});
		Rank::create(["name"=>"ISM"]);
		Rank::create(["name"=>"Partner"]);
		Rank::create(["name"=>"Promoter"]);
		Rank::create(["name"=>"Executive"]);
		Rank::create(["name"=>"Silver"]);
		Rank::create(["name"=>"Gold"]);
		Rank::create(["name"=>"Round Table"]);
		Rank::create(["name"=>"Platinum"]);
		Rank::create(["name"=>"Diamond"]);
		Rank::create(["name"=>"Black Diamond"]);
		Rank::create(["name"=>"White Diamond"]);
		Rank::create(["name"=>"Blue Diamond"]);
		Rank::create(["name"=>"Crowne Diamond"]);
	}

	public function down()
	{
		Schema::dropIfExists('ranks');
	}

}