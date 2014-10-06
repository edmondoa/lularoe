<?php 

class MobilePlansTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$mobilePlans = array(
				'name' => $faker->name,
				'blurb' => $faker->text,
				'description' => $faker->text,
			);
			MobilePlans::create($mobilePlans);
		}
	}

}
