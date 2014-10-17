<?php 

class ImagesTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$image = array(
				'type' => $faker->word,
				'url' => $faker->url,
				'disabled' => $faker->word,
			);
			Image::create($image);
		}
	}

}
