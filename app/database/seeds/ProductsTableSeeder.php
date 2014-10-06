<?php 

class ProductsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$products = array(
				'name' => $faker->name,
				'blurb' => $faker->text,
				'description' => $faker->text,
				'price' => $faker->randomDigitNotNull,
				'quantity' => $faker->randomDigitNotNull,
			);
			Products::create($products);
		}
	}

}
