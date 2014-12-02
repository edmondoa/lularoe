<?php 

class CartsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 20; $i++) {
			$cart = array(
				'product_id' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
			Cart::create($cart);
		}
	}

}
