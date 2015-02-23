<?php 

class mediaTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();

		for($i = 1; $i <= 10; $i++) {
			$media = array(
				'type' => $faker->word,
				'url' => $faker->url,
				'user_id' => 2001,
				'disabled' => $faker->boolean,
			);
			Media::create($media);
		}
	}

}
