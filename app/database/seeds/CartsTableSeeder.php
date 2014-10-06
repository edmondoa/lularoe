<?php 

class CartsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$cart = array(
				'product_id' => $faker->randomDigitNotNull,
			);
			Cart::create($cart);
		}
	}

}
