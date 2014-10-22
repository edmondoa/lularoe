<?php 

class UserRanksTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 15; $i++) {
			$userRank = array(
				'user_id' => $faker->randomDigitNotNull,
				'rank_id' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
			UserRank::create($userRank);
		}
	}

}
