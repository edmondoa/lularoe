<?php 

class LevelsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$level = array(
				'user_id' => $faker->randomDigitNotNull,
				'ancestor_id' => $faker->randomDigitNotNull,
				'level' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
			Level::create($level);
		}
	}

}
