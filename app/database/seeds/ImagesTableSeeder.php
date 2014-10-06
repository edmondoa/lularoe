<?php 

class ImagesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$images = array(
				'type' => $faker->word,
				'url' => $faker->url,
			);
			Images::create($images);
		}
	}

}
