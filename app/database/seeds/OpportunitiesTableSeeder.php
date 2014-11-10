<?php 

class OpportunitiesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$opportunity = array(
				'title' => $faker->word,
				'body' => $faker->text,
				'include_form' => $faker->boolean,
				'public' => $faker->boolean,
				'customers' => $faker->boolean,
				'reps' => $faker->boolean,
				'deadline' => $faker->randomDigitNotNull,
			);
			Opportunity::create($opportunity);
		}
	}

}
