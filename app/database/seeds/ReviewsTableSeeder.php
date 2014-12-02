<?php 

class ReviewsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 20; $i++) {
			$review = array(
				'product_id' => $faker->randomDigitNotNull,
				'rating' => $faker->randomDigitNotNull,
				'comment' => $faker->text,
				'disabled' => $faker->boolean,
			);
			Review::create($review);
		}
	}

}
