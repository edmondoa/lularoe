<?php 

class ProductsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();
		$faker->unique(true);
		for($i = 1; $i <= 20; $i++) {
			$product = array(
				'name' => $faker->sentence($nbWords = 6),
				'blurb' => $faker->text,
				'description' => $faker->text,
				'retail_price' => $faker->numberBetween($min = 105, $max = 200),
				'rep_price' => $faker->numberBetween($min = 50, $max = 100),
				'cv_price' => $faker->numberBetween($min = 50, $max = 100),
				'quantity' => $faker->numberBetween($min = 1, $max = 100),
				'category_id' => $faker->randomDigitNotNull,
				'disabled' => $faker->boolean,
				'sku' => $faker->unique()->randomNumber($min = 10000, $max = 100000),
			);
			Product::create($product);
		}
	}

}
