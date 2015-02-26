<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateRanksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ranks', function(Blueprint $table)
		{
			$table->integer('pv_minimum');
			$table->integer('gv_minimum');
			$table->integer('downline_min');
			$table->integer('ps_minimum');
			$table->integer('leadership_qty');
			$table->integer('leadership_rank_id');
			$table->decimal('frontline_commission',3,2);
			$table->decimal('org_commission',3,2);
			$table->decimal('gen_one_ldr_commission',3,2);
			$table->decimal('gen_two_ldr_commission',3,2);
			$table->integer('ldr_points_self');
			$table->integer('ldr_points_fl');
			$table->integer('ldr_points_org');

		});
		Eloquent::unguard();
		// we likely have some hold-overs so let's delete those first
		DB::statement("SET foreign_key_checks=0");
		Rank::truncate();
		DB::statement("SET foreign_key_checks=1");
		// now create existing ranks
		Rank::create([
			'name'=>'Fashion Consultant',
			'pv_minimum'=>0,
			'gv_minimum'=>0,
			'downline_min'=>0,
			'leadership_qty'=>'',
			'leadership_rank_id'=>'',
			'frontline_commission'=>'',
			'org_commission'=>'',
			'gen_one_ldr_commission'=>0,
			'gen_two_ldr_commission'=>0,
			'ldr_points_self'=>'',
			'ldr_points_fl'=>'',
			'ldr_points_org'=>'',
		]);
		Rank::create([
			'name'=>'Sponsor',
			'pv_minimum'=>3500,
			'gv_minimum'=>0,
			'downline_min'=>0,
			'leadership_qty'=>1,
			'leadership_rank_id'=>1,
			'frontline_commission'=>0.05,
			'org_commission'=>'0',
			'gen_one_ldr_commission'=>0,
			'gen_two_ldr_commission'=>0,
			'ldr_points_self'=>'',
			'ldr_points_fl'=>'',
			'ldr_points_org'=>'',
		]);
		Rank::create([
			'name'=>'Trainer',
			'pv_minimum'=>5000,
			'gv_minimum'=>35000,
			'downline_min'=>0,
			'leadership_qty'=>3,
			'leadership_rank_id'=>1,
			'frontline_commission'=>0.05,
			'org_commission'=>0.03,
			'gen_one_ldr_commission'=>0.01,
			'gen_two_ldr_commission'=>0,
			'ldr_points_self'=>1,
			'ldr_points_fl'=>1,
			'ldr_points_org'=>'',
		]);
		Rank::create([
			'name'=>'Leader',
			'pv_minimum'=>5000,
			'gv_minimum'=>35000,
			'downline_min'=>10,
			'leadership_qty'=>3,
			'leadership_rank_id'=>3,
			'frontline_commission'=>0.05,
			'org_commission'=>0.03,
			'gen_one_ldr_commission'=>0.01,
			'gen_two_ldr_commission'=>0.01,
			'ldr_points_self'=>2,
			'ldr_points_fl'=>1,
			'ldr_points_org'=>2,
		]);


	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ranks', function(Blueprint $table)
		{
			if (Schema::hasColumn('ranks', 'pv_minimum'))
			{
				$table->dropColumn('pv_minimum');			
			}
			if (Schema::hasColumn('ranks', 'gv_minimum'))
			{
				$table->dropColumn('gv_minimum');			
			}
			if (Schema::hasColumn('ranks', 'downline_min'))
			{
				$table->dropColumn('downline_min');
			}
			if (Schema::hasColumn('ranks', 'ps_minimum'))
			{
				$table->dropColumn('ps_minimum');
			}
			if (Schema::hasColumn('ranks', 'leadership_qty'))
			{
				$table->dropColumn('leadership_qty');
			}
			if (Schema::hasColumn('ranks', 'leadership_rank_id'))
			{
				$table->dropColumn('leadership_rank_id');
			}
			if (Schema::hasColumn('ranks', 'frontline_commission'))
			{
				$table->dropColumn('frontline_commission');
			}
			if (Schema::hasColumn('ranks', 'org_commission'))
			{
				$table->dropColumn('org_commission');
			}
			if (Schema::hasColumn('ranks', 'gen_one_ldr_commission'))
			{
				$table->dropColumn('gen_one_ldr_commission');
			}
			if (Schema::hasColumn('ranks', 'gen_two_ldr_commission'))
			{
				$table->dropColumn('gen_two_ldr_commission');
			}
			if (Schema::hasColumn('ranks', 'ldr_points_self'))
			{
				$table->dropColumn('ldr_points_self');
			}
			if (Schema::hasColumn('ranks', 'ldr_points_fl'))
			{
				$table->dropColumn('ldr_points_fl');
			}
			if (Schema::hasColumn('ranks', 'ldr_points_org'))
			{
				$table->dropColumn('ldr_points_org');
			}
		});
	}
}
