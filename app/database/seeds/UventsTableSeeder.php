<?php 

class UventsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 100; $i++) {
			$min_time = time() - 2629743; // 1 month ago
			$max_time = time() + 2629743; // 1 month from today
			$start_time = $faker->numberBetween($min = $min_time, $max = $max_time);
			$uvent = array(
				'name' => $faker->name,
				'description' => $faker->text,
				'date_start' => $start_time,
				'date_end' => $faker->numberBetween($min = $start_time, $max = $start_time + 86400),
				'public' => $faker->boolean,
				'customers' => $faker->boolean,
				'reps' => $faker->boolean,
				'editors' => $faker->boolean,
				'admins' => $faker->boolean,
				'disabled' => $faker->boolean,
			);
			Uvent::create($uvent);
		}
	}

}