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
<<<<<<< HEAD
				'user_id' => 2001,
=======
				'user_id' => $faker->randomDigitNotNull,
>>>>>>> 0b62f3d62136fa1c154682d2a09ea168fa4567d5
				'disabled' => $faker->boolean,
			);
			Media::create($media);
		}
	}

}
