<?php
/*
ALTER TABLE userstats DROP FOREIGN KEY userstats_user_id_foreign
ALTER TABLE userstats DROP INDEX userstats_user_id_index
ALTER TABLE userstats DROP INDEX userstats_commission_period_index


*/
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateUserstatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('userstats', function(Blueprint $table)
		{
			$table->foreign('user_id')->references('id')->on('users');
			$table->index('commission_period');
			$table->index('user_id');
			$table->unique(['commission_period','user_id']);
			$table->renameColumn('volume', 'personal_dollar_volume');
			$table->integer('personal_points_volume')->after('user_id');
			$table->double('business_dollar_volume')->after('user_id');
			$table->double('business_points_volume')->after('user_id');
			$table->double('fl_points_volume')->after('user_id');
			$table->double('fl_dollar_volume')->after('user_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('userstats', function(Blueprint $table)
		{
			$table->renameColumn('personal_dollar_volume','volume');
			$table->dropForeign('userstats_user_id_foreign');
			$table->dropUnique('userstats_commission_period_user_id_unique');
			$table->dropIndex('userstats_commission_period_index');
			$table->dropIndex('userstats_user_id_index');
			if (Schema::hasColumn('userstats', 'personal_points_volume'))
			{
				$table->dropColumn('personal_points_volume');
			}
			if (Schema::hasColumn('userstats', 'business_dollar_volume'))
			{
				$table->dropColumn('business_dollar_volume');
			}
			if (Schema::hasColumn('userstats', 'business_points_volume'))
			{
				$table->dropColumn('business_points_volume');
			}
			if (Schema::hasColumn('userstats', 'fl_points_volume'))
			{
				$table->dropColumn('fl_points_volume');
			}
			if (Schema::hasColumn('userstats', 'fl_dollar_volume'))
			{
				$table->dropColumn('fl_dollar_volume');
			}
		});
	}

}
