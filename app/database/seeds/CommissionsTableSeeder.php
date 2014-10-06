<?php 

class CommissionsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$commissions = array(
				'user_id' => $faker->randomDigitNotNull,
				'amount' => $faker->randomDigitNotNull,
				'description' => $faker->text,
			);
			Commissions::create($commissions);
		}
	}

}
