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
					//'quantity' => $faker->randomDigitNotNull,
					//'category_id' => $faker->randomDigitNotNull,
					'disabled' => $faker->boolean,
				);
				Product::create($product);
			}
		}
	}

}
