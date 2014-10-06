<?php 

class ReviewsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$reviews = array(
				'product_id' => $faker->randomDigitNotNull,
				'rating' => $faker->randomDigitNotNull,
				'comment' => $faker->text,
			);
			Reviews::create($reviews);
		}
	}

}
