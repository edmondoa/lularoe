<?php 

class SalesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 15; $i++) {
			$sale = array(
				'product_id' => $faker->randomDigitNotNull,
				'user_id' => $i + 2000,
				'sponsor_id' => $faker->randomDigitNotNull,
				'quantity' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
			Sale::create($sale);
		}
	}

}
