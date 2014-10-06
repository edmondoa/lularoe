<?php 

class BonusesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$bonuses = array(
				'user_id' => $faker->randomDigitNotNull,
				'eight_in_eight' => $faker->boolean,
				'twelve_in_twelve' => $faker->boolean,
			);
			Bonuses::create($bonuses);
		}
	}

}
