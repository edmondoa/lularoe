<?php 

class RankUserTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 15; $i++) {
			for ($x = 1; $x !== 0; $x = rand(0,5))
			{
				$rankUser = array(
					'user_id' => $i + 2000,
					'rank_id' => $faker->randomDigitNotNull,
					'disabled' => $faker->boolean,
				);
				RankUser::create($rankUser);
			}
		}
	}

}
