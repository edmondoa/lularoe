<?php 

class UserProductsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$userProduct = array(
				'product_id' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
			UserProduct::create($userProduct);
		}
	}

}
