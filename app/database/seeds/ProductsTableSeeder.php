<?php 

class ProductsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{

		$product = array(
			'name' => 'Unlimited Talk & Text | 1G Data',
			'price' => 40,
			'category_id' => 1
		);
		Product::create($product);
		
		$product = array(
			'name' => 'Unlimited Talk & Text | 3G Data',
			'price' => 50,
			'category_id' => 1
		);
		Product::create($product);
		
		$product = array(
			'name' => 'Unlimited Talk & Text | 5G Data',
			'price' => 60,
			'category_id' => 1
		);
		Product::create($product);
		
	}

}
