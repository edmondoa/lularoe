<?php 

class SalesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$sales = array(
				'product_id' => $faker->randomDigitNotNull,
				'user_id' => $faker->randomDigitNotNull,
				'sponsor_id' => $faker->randomDigitNotNull,
				'quantity' => $faker->randomDigitNotNull,
			);
			Sales::create($sales);
		}
	}

}
