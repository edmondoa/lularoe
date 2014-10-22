<?php 

class RanksTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 15; $i++) {
			$rank = array(
				'name' => $faker->name,
				'disabled' => $faker->boolean,
			);
			Rank::create($rank);
		}
	}

}
