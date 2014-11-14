<?php 

class OpportunitiesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 20; $i++) {
			$opportunity = array(
				'title' => $faker->sentence($nbWords = 6),
				'body' => $faker->text,
				'include_form' => $faker->boolean,
				'public' => $faker->boolean,
				'customers' => $faker->boolean,
				'reps' => $faker->boolean,
				'deadline' => $faker->unixTime($max = time() + 2629743, $min = time() - 2629743),
			);
			Opportunity::create($opportunity);
		}
	}

}
