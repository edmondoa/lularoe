<?php 
/*
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE products; 
SET FOREIGN_KEY_CHECKS=1;
*/
class ProductsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		Eloquent::unguard();
		$faker = $this->getFaker();
		for($i = 1; $i <= 30; $i++) {
			$product_name = $faker->firstName('female');
			$sizes = ['XS','S','M','L','XL'];
			$price = $faker->randomFloat(2,12,45);
			foreach($sizes as $key => $size)
			{
				$product = array(
					'name' => $product_name." - ".$size,
					'blurb' => $faker->text,
					'description' => $faker->text,
					'price' => ($price + (3.5 * $key)),
					'points_value' => 20,
					'disabled' => $faker->boolean,
					'retail_price' => $faker->numberBetween($min = 105, $max = 200),
					'rep_price' => $faker->numberBetween($min = 50, $max = 100),
					'cv_price' => $faker->numberBetween($min = 50, $max = 100),
					'quantity' => $faker->numberBetween($min = 1, $max = 100),
					'category_id' => $faker->randomDigitNotNull,
					'sku' => $faker->unique()->randomNumber($min = 10000, $max = 100000),
					'user_id' => 2000 + $i,
				);
				Product::create($product);
			}
		}
	}

}
