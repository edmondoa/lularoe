<?php 

class LevelsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 15; $i++) {
			$level = array(
				'user_id' => $i + 2000,
				'ancestor_id' => $faker->randomDigitNotNull,
				'level' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
			Level::create($level);
		}
	}

}
