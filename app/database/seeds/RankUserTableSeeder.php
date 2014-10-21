<?php 

class RankUserTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$rankUser = array(
				'user_id' => $faker->randomDigitNotNull,
				'rank_id' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
			RankUser::create($rankUser);
		}
	}

}
