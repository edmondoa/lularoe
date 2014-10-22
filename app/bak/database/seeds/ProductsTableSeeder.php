<?php 

class ProductsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 15; $i++) {
			$product = array(
				'name' => $faker->name,
				'blurb' => $faker->text,
				'description' => $faker->text,
				'price' => $faker->randomDigitNotNull,
				'quantity' => $faker->randomDigitNotNull,
				'category_id' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
			);
			Product::create($product);
		}
	}

}
