<?php 

class TagsTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$tag = array(
				'name' => $faker->name,
				'taggable_type' => $faker->randomDigitNotNull,
				'taggable_id' => $faker->randomDigitNotNull,
			);
			Tag::create($tag);
		}
	}

}
