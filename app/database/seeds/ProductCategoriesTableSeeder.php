<?php 

class ProductCategoriesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$productCategory = array(
				'name' => $faker->name,
				'disabled' => $faker->boolean,
			);
			ProductCategory::create($productCategory);
		}
	}

}
