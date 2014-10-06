<?php 

class UserProductsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$userProducts = array(
				'product_id' => $faker->randomDigitNotNull,
			);
			UserProducts::create($userProducts);
		}
	}

}
