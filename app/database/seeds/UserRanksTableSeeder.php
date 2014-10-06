<?php 

class UserRanksTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$userRanks = array(
				'user_id' => $faker->randomDigitNotNull,
				'rank_id' => $faker->randomDigitNotNull,
			);
			UserRanks::create($userRanks);
		}
	}

}
