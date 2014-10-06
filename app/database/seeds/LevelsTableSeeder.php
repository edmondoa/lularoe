<?php 

class LevelsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$levels = array(
				'user_id' => $faker->randomDigitNotNull,
				'ancestor_id' => $faker->randomDigitNotNull,
				'level' => $faker->randomDigitNotNull,
			);
			Levels::create($levels);
		}
	}

}
