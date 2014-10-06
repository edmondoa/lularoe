<?php 

class RanksTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$ranks = array(
				'name' => $faker->name,
			);
			Ranks::create($ranks);
		}
	}

}
