<?php 

class ProductCategoriesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{

		$productCategory = array(
			'id' => 1,
			'name' => 'Mobile Plans',
		);
		ProductCategory::create($productCategory);
		
	}

}
